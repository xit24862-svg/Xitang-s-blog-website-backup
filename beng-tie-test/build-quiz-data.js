const fs = require("fs");
const path = require("path");

const cwd = process.cwd();
const fullFile = fs
  .readdirSync(cwd)
  .find((name) => /^allinall.*50.*\.txt$/i.test(name));

if (!fullFile) {
  throw new Error("Cannot find full question bank txt file (contains 50 in filename).");
}

const fullText = fs.readFileSync(path.join(cwd, fullFile), "utf8");
const fullLines = fullText.split(/\r?\n/).map((line) => line.trimEnd());
const SELECTED_QUESTION_IDS = [
  1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12,
  13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24,
  25, 26, 27, 28, 29, 30, 33, 34, 41, 42, 49, 50
];
const SELECTED_QUESTION_SET = new Set(SELECTED_QUESTION_IDS);

function findSectionIndex(lines, marker) {
  const idx = lines.findIndex((line) => line.trim() === marker);
  if (idx < 0) {
    throw new Error(`Section marker not found: ${marker}`);
  }
  return idx;
}

const sectionArchetypeStart = findSectionIndex(fullLines, "【15类人格原型】");
const sectionAnswerGuide = findSectionIndex(fullLines, "【作答说明】");
const sectionJudgeTip = findSectionIndex(fullLines, "【结果判读建议】");
const sectionResultExplain = findSectionIndex(fullLines, "【15类结果解释】");
const sectionUsage = findSectionIndex(fullLines, "【使用建议】");

const archetypes = [];
const archetypeMap = {};

for (let i = sectionArchetypeStart + 1; i < sectionAnswerGuide; i += 1) {
  const line = fullLines[i].trim();
  if (!line) {
    continue;
  }
  const match = line.match(/^([A-Z]{1,3})\s+(\S+)\s*[:：]\s*(.+)$/);
  if (!match) {
    continue;
  }
  const [, code, name, title] = match;
  const item = { code, name, title, shortDescription: "" };
  archetypes.push(item);
  archetypeMap[code] = item;
}

const allQuestions = [];
for (let i = 0; i < fullLines.length; i += 1) {
  const qMatch = fullLines[i].trim().match(/^(\d+)\.\s*(.+)$/);
  if (!qMatch) {
    continue;
  }
  const id = Number(qMatch[1]);
  const text = qMatch[2];

  let weightLine = "";
  let cursor = i + 1;
  while (cursor < fullLines.length) {
    const line = fullLines[cursor].trim();
    if (line) {
      weightLine = line;
      break;
    }
    cursor += 1;
  }

  const tokenMatches = weightLine.match(/[A-Z]{1,3}[+-]\d+/g) || [];
  if (!tokenMatches.length) {
    continue;
  }

  const weights = {};
  tokenMatches.forEach((token) => {
    const match = token.match(/^([A-Z]{1,3})([+-]\d+)$/);
    if (!match) {
      return;
    }
    const [, code, weight] = match;
    weights[code] = Number(weight);
  });

  allQuestions.push({ id, text, weights });
}

const missingQuestionIds = SELECTED_QUESTION_IDS.filter(
  (id) => !allQuestions.some((q) => q.id === id)
);
if (missingQuestionIds.length) {
  throw new Error(`Selected question IDs missing: ${missingQuestionIds.join(", ")}`);
}

const questions = allQuestions.filter((q) => SELECTED_QUESTION_SET.has(q.id));
questions.sort((a, b) => a.id - b.id);

for (let i = sectionResultExplain + 1; i < sectionUsage; i += 1) {
  const line = fullLines[i].trim();
  if (!line) {
    continue;
  }
  const match = line.match(/^([A-Z]{1,3})\s+(.+?)——(.+)$/);
  if (!match) {
    continue;
  }
  const [, code, , shortDescription] = match;
  if (archetypeMap[code]) {
    archetypeMap[code].shortDescription = shortDescription;
  }
}

const interpretationTips = [];
for (let i = sectionJudgeTip + 1; i < sectionResultExplain; i += 1) {
  const line = fullLines[i].trim();
  if (line.startsWith("- ")) {
    interpretationTips.push(line.slice(2).trim());
  }
}

const detailFile = "allinall.txt";
const detailText = fs.readFileSync(path.join(cwd, detailFile), "utf8");
const detailLines = detailText
  .split(/\r?\n/)
  .map((line) => line.trim())
  .filter(Boolean);

const nameToCode = {};
const titleToCode = {};
archetypes.forEach((item) => {
  nameToCode[item.name] = item.code;
  titleToCode[item.title] = item.code;
});

const longByCode = {};
for (let i = 0; i < detailLines.length; ) {
  const line = detailLines[i];
  let code = null;
  let subtitle = null;
  let description = null;

  if (nameToCode[line]) {
    code = nameToCode[line];
    subtitle = detailLines[i + 1] || "";
    description = detailLines[i + 2] || "";
    i += 3;
  } else if (titleToCode[line]) {
    code = titleToCode[line];
    subtitle = line;
    description = detailLines[i + 1] || "";
    i += 2;
  } else {
    i += 1;
    continue;
  }

  if (!code) {
    continue;
  }

  const expectedTitle = archetypeMap[code]?.title;
  if (expectedTitle && subtitle !== expectedTitle) {
    // Keep parsed description if format drifts, but do not overwrite title from source-of-truth.
  }
  if (description) {
    longByCode[code] = description;
  }
}

const imageByCode = {
  BE: "photos/be.png",
  CY: "photos/cyy.png",
  DH: "photos/dh.png",
  FJ: "photos/fj.png",
  FX: "photos/fx.png",
  HH: "photos/huahuo.png",
  HHH: "photos/hh.png",
  HQ: "photos/hq.png",
  JL: "photos/jl.png",
  JY: "photos/jy.png",
  KL: "photos/kvdl.png",
  NK: "photos/nkex.png",
  R: "photos/r.png",
  SJ: "photos/sj.png",
  XD: "photos/xd.png"
};

const data = {
  meta: {
    title: `allinall人格原型测试（${questions.length}题·精简版）`,
    scale: [
      { value: 1, label: "非常不同意" },
      { value: 2, label: "比较不同意" },
      { value: 3, label: "不确定 / 一般" },
      { value: 4, label: "比较同意" },
      { value: 5, label: "非常同意" }
    ],
    scoringNote:
      "每题得分会乘以该题对各人格的权重（支持负权重扣分），总分最高为主人格，第二高为副人格。"
  },
  interpretationTips,
  archetypes: archetypes.map((item) => ({
    ...item,
    longDescription: longByCode[item.code] || item.shortDescription || "",
    image: imageByCode[item.code] || null
  })),
  questions
};

if (data.questions.length !== SELECTED_QUESTION_IDS.length) {
  throw new Error(`Expected ${SELECTED_QUESTION_IDS.length} questions, got ${data.questions.length}.`);
}

const missingShort = data.archetypes.filter((item) => !item.shortDescription);
if (missingShort.length) {
  throw new Error(`Missing short descriptions for: ${missingShort.map((x) => x.code).join(", ")}`);
}

const output = `window.BENGTIE_TEST_DATA = ${JSON.stringify(data, null, 2)};\n`;
fs.writeFileSync(path.join(cwd, "quiz-data.js"), output, "utf8");

const missingLong = data.archetypes.filter((item) => !item.longDescription);
console.log(`Generated quiz-data.js from ${fullFile}`);
console.log(`Archetypes: ${data.archetypes.length}, Questions: ${data.questions.length}`);
if (missingLong.length) {
  console.log(`Missing longDescription for: ${missingLong.map((x) => x.code).join(", ")}`);
}
