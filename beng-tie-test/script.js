(function () {
  const data = window.BENGTIE_TEST_DATA;
  if (!data || !Array.isArray(data.questions) || !Array.isArray(data.archetypes)) {
    return;
  }

  const quizCard = document.getElementById("quizCard");
  const resultCard = document.getElementById("resultCard");

  const progressText = document.getElementById("progressText");
  const questionTitle = document.getElementById("questionTitle");
  const optionsForm = document.getElementById("optionsForm");
  const prevBtn = document.getElementById("prevBtn");
  const nextBtn = document.getElementById("nextBtn");

  const resultBadge = document.getElementById("resultBadge");
  const resultTitle = document.getElementById("resultTitle");
  const resultSub = document.getElementById("resultSub");
  const resultDesc = document.getElementById("resultDesc");
  const resultImage = document.getElementById("resultImage");
  const resultImageHint = document.getElementById("resultImageHint");
  const scoreBars = document.getElementById("scoreBars");
  const evidenceList = document.getElementById("evidenceList");
  const tipsList = document.getElementById("tipsList");
  const retryBtn = document.getElementById("retryBtn");

  const archetypes = data.archetypes;
  const questions = data.questions;
  const scale = data.meta?.scale || [
    { value: 1, label: "非常不同意" },
    { value: 2, label: "比较不同意" },
    { value: 3, label: "不确定 / 一般" },
    { value: 4, label: "比较同意" },
    { value: 5, label: "非常同意" }
  ];

  const archetypeByCode = new Map(archetypes.map((item) => [item.code, item]));
  const answers = new Array(questions.length).fill(null);
  let currentIndex = 0;

  function escapeHtml(text) {
    return String(text)
      .replaceAll("&", "&amp;")
      .replaceAll("<", "&lt;")
      .replaceAll(">", "&gt;")
      .replaceAll('"', "&quot;");
  }

  function renderQuestion() {
    const total = questions.length;
    const question = questions[currentIndex];
    const saved = answers[currentIndex];

    progressText.textContent = `第 ${currentIndex + 1} / ${total} 题`;
    questionTitle.textContent = question.text;

    optionsForm.innerHTML = scale
      .map(({ value, label }) => {
        const checked = saved === value ? "checked" : "";
        return `
          <label class="opt">
            <input type="radio" name="score" value="${value}" ${checked}>
            <span class="opt-title">${value} 分 · ${escapeHtml(label)}</span>
            <div class="opt-sub">按你平时更稳定、更常见的状态作答</div>
          </label>
        `;
      })
      .join("");

    prevBtn.disabled = currentIndex === 0;
    nextBtn.textContent = currentIndex === total - 1 ? "查看结果" : "下一题";
  }

  function getCurrentSelectedValue() {
    const selected = optionsForm.querySelector('input[name="score"]:checked');
    return selected ? Number(selected.value) : null;
  }

  function readAndStoreCurrentAnswer() {
    const value = getCurrentSelectedValue();
    if (value == null) {
      return false;
    }
    answers[currentIndex] = value;
    return true;
  }

  function ensureAllAnswered() {
    const firstMissing = answers.findIndex((value) => value == null);
    if (firstMissing >= 0) {
      currentIndex = firstMissing;
      renderQuestion();
      return false;
    }
    return true;
  }

  function scoreToLabel(score) {
    return score > 0 ? `+${score}` : `${score}`;
  }

  function renderBars(sortedScores) {
    const topList = sortedScores.slice(0, 8);
    const max = Math.max(...topList.map((item) => item.score));
    const min = Math.min(...topList.map((item) => item.score));
    const range = max - min || 1;

    scoreBars.innerHTML = topList
      .map((item) => {
        const percent = ((item.score - min) / range) * 100;
        const archetype = archetypeByCode.get(item.code);
        const title = archetype ? archetype.title : "人格原型";
        return `
          <div class="bar-item">
            <div class="bar-head">
              <span>${item.code} · ${escapeHtml(title)}</span>
              <strong>${scoreToLabel(item.score)}</strong>
            </div>
            <div class="bar-track">
              <div class="bar-fill" style="width: ${percent.toFixed(2)}%"></div>
            </div>
          </div>
        `;
      })
      .join("");
  }

  function renderEvidence(primaryCode, contributions) {
    let list = contributions
      .filter((row) => row.score > 0)
      .sort((a, b) => b.score - a.score)
      .slice(0, 6);

    if (!list.length) {
      list = contributions
        .slice()
        .sort((a, b) => Math.abs(b.score) - Math.abs(a.score))
        .slice(0, 6);
    }

    if (!list.length) {
      evidenceList.innerHTML = "<li>暂无可展示依据。</li>";
      return;
    }

    evidenceList.innerHTML = list
      .map((item) => {
        const weight = item.weight > 0 ? `+${item.weight}` : `${item.weight}`;
        return `<li>第${item.questionId}题：${escapeHtml(item.question)}（你的作答 ${item.answer} 分 × 权重 ${weight} = ${scoreToLabel(item.score)}）</li>`;
      })
      .join("");

    if (!archetypeByCode.has(primaryCode)) {
      evidenceList.innerHTML += "<li>提示：主人格编码未匹配到完整词条。</li>";
    }
  }

  function renderTips(gapPercent) {
    const dynamicTip =
      gapPercent >= 8
        ? "第一名明显领先第二名（≥8%），当前主导人格较稳定。"
        : "第一名和第二名差距小于8%，你更接近双主型人格。";

    const tips = [dynamicTip, ...(data.interpretationTips || [])];
    tipsList.innerHTML = tips.map((tip) => `<li>${escapeHtml(tip)}</li>`).join("");
  }

  function renderResultImage(primary) {
    resultImage.classList.add("hidden");
    resultImageHint.classList.add("hidden");
    resultImageHint.textContent = "";
    resultImage.removeAttribute("src");
    resultImage.alt = "";

    if (!primary.image) {
      resultImageHint.textContent = `当前原型（${primary.code}）暂无配图。`;
      resultImageHint.classList.remove("hidden");
      return;
    }

    resultImage.onload = function () {
      resultImage.classList.remove("hidden");
    };
    resultImage.onerror = function () {
      resultImageHint.textContent = `已计算出结果，但配图加载失败：${primary.image}`;
      resultImageHint.classList.remove("hidden");
      resultImage.classList.add("hidden");
    };

    resultImage.src = primary.image;
    resultImage.alt = "人格结果图";
  }

  function showResult() {
    if (!ensureAllAnswered()) {
      alert("你还有未作答题目，我已经跳到第一道未答题。");
      return;
    }

    const scores = Object.fromEntries(archetypes.map((item) => [item.code, 0]));
    const contributionByCode = Object.fromEntries(archetypes.map((item) => [item.code, []]));

    questions.forEach((question, idx) => {
      const answer = answers[idx];
      Object.entries(question.weights).forEach(([code, weight]) => {
        const score = answer * weight;
        if (scores[code] == null) {
          scores[code] = 0;
          contributionByCode[code] = [];
        }
        scores[code] += score;
        contributionByCode[code].push({
          questionId: question.id,
          question: question.text,
          answer,
          weight,
          score
        });
      });
    });

    const sorted = Object.entries(scores)
      .map(([code, score]) => ({ code, score }))
      .sort((a, b) => b.score - a.score);

    const primary = archetypeByCode.get(sorted[0].code);
    const secondary = archetypeByCode.get(sorted[1].code);
    const topScore = sorted[0].score;
    const secondScore = sorted[1].score;
    const gapPercent = (Math.abs(topScore - secondScore) / Math.max(Math.abs(topScore), 1)) * 100;

    resultBadge.textContent = gapPercent >= 8 ? "主导人格较稳定" : "双主型倾向";
    resultTitle.textContent = primary.title;
    resultSub.textContent = `主人格 ${primary.code}（${topScore} 分）｜副人格 ${secondary.code}（${secondScore} 分）`;
    resultDesc.textContent = primary.longDescription || primary.shortDescription || "暂无描述。";

    renderResultImage(primary);
    renderBars(sorted);
    renderEvidence(primary.code, contributionByCode[primary.code] || []);
    renderTips(gapPercent);

    quizCard.classList.add("hidden");
    resultCard.classList.remove("hidden");
    window.scrollTo({ top: 0, behavior: "smooth" });
  }

  function resetQuiz() {
    for (let i = 0; i < answers.length; i += 1) {
      answers[i] = null;
    }
    currentIndex = 0;
    resultCard.classList.add("hidden");
    quizCard.classList.remove("hidden");
    renderQuestion();
  }

  optionsForm.addEventListener("change", () => {
    readAndStoreCurrentAnswer();
  });

  prevBtn.addEventListener("click", () => {
    readAndStoreCurrentAnswer();
    if (currentIndex > 0) {
      currentIndex -= 1;
      renderQuestion();
    }
  });

  nextBtn.addEventListener("click", () => {
    const ok = readAndStoreCurrentAnswer();
    if (!ok) {
      alert("请先选择一个分值。");
      return;
    }

    if (currentIndex === questions.length - 1) {
      showResult();
      return;
    }

    currentIndex += 1;
    renderQuestion();
  });

  retryBtn.addEventListener("click", resetQuiz);

  renderQuestion();
})();
