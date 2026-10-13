const O = (label, type, reason, effects) => ({ label, type, reason, effects });

const secondaryMap = {
  care: "sensitive",
  independent: "partner",
  clingy: "sensitive",
  rational: "career",
  sensitive: "care",
  career: "dominant",
  princess: "care",
  partner: "care",
  dominant: "career",
  avoidant: "independent"
};

const sceneTypeMap = [
  { warm: "care", steady: "partner", spark: "dominant", mind: "rational", free: "independent" },
  { warm: "sensitive", steady: "partner", spark: "dominant", mind: "rational", free: "avoidant" },
  { warm: "care", steady: "career", spark: "career", mind: "rational", free: "independent" },
  { warm: "clingy", steady: "partner", spark: "dominant", mind: "rational", free: "avoidant" },
  { warm: "princess", steady: "partner", spark: "dominant", mind: "rational", free: "independent" }
];

function resolveSceneIndex(questionIndex) {
  return Math.min(Math.floor(questionIndex / 7), sceneTypeMap.length - 1);
}

function resolveTypeFromLegacy(legacyType, questionIndex) {
  const sceneMap = sceneTypeMap[resolveSceneIndex(questionIndex)];
  return sceneMap[legacyType] || "partner";
}

function resolveEffectsFromLegacy(rawEffects, questionIndex) {
  const merged = {};
  rawEffects.forEach(([legacyType, weight]) => {
    const type = resolveTypeFromLegacy(legacyType, questionIndex);
    merged[type] = (merged[type] || 0) + weight;
  });
  return Object.entries(merged);
}

function defaultEffects(type) {
  const secondary = secondaryMap[type];
  return secondary ? [[type, 2], [secondary, 1]] : [[type, 2]];
}

const quizData = [
  {
    q: "1. TA 连续 6 小时不回消息，你第一反应是？",
    options: [
      O("先担心 TA 出事，问一句“你还好吗”", "warm", "你更看重彼此情绪是否被接住。"),
      O("直接电话打过去：现在就说清楚", "spark", "你偏好即时反馈和强执行沟通。"),
      O("不催，先看 TA 后续解释是否自洽", "mind", "你优先判断逻辑一致性和可信度。"),
      O("你也不追，先去过自己的生活", "free", "你把边界和自我节奏放在前面。"),
      O("晚上固定时间统一沟通，不临时拉扯", "steady", "你偏好可预期、可复用的关系规则。")
    ]
  },
  {
    q: "2. 约会被临时取消，你最能接受哪种处理？",
    options: [
      O("先道歉并给情绪安抚，再补偿安排", "warm", "你更吃被重视和被照顾的感觉。"),
      O("立刻给替代方案，不浪费这周进度", "spark", "你要的是推进，而不是口头安慰。"),
      O("把原因讲透，避免下次重复踩坑", "mind", "你更看重问题复盘能力。"),
      O("取消就取消，别用愧疚绑定彼此", "free", "你需要关系里有松弛和自由度。"),
      O("设定规则：临时取消超过一次就降优先级", "steady", "你偏好稳定机制来降低内耗。")
    ]
  },
  {
    q: "3. TA 说“我就这脾气”，你会怎么判断？",
    options: [
      O("先理解 TA 的情绪来源，再谈边界", "warm", "你倾向先共情再处理冲突。"),
      O("直接回：脾气不是伤人的免死金牌", "spark", "你拒绝模糊地带，偏好硬边界。"),
      O("看 TA 是否能给出可执行的改法", "mind", "你重视可验证的改进路径。"),
      O("不改就拉开距离，不在烂局里耗", "free", "你重视退出权和自我保护。"),
      O("给观察期，按结果决定关系去留", "steady", "你习惯用阶段性评估做决定。")
    ]
  },
  {
    q: "4. 发现 TA 和前任持续联系，你底线是？",
    options: [
      O("可联系，但要让你有安全感", "warm", "你在意的是被优先对待。"),
      O("要么彻底断，要么关系降级", "spark", "你更看重明确立场和决断速度。"),
      O("重点看内容：事务沟通还是情感回流", "mind", "你倾向根据事实分层判断。"),
      O("你不查岗，但暧昧就直接出局", "free", "你要自由，也要求清晰边界。"),
      O("先定公开规则，所有人按同一套执行", "steady", "你偏好长期稳定的边界协议。")
    ]
  },
  {
    q: "5. 你表达需求，TA 回“你事真多”，你会？",
    options: [
      O("先说清你的感受，不攻击对方", "warm", "你希望关系先保留善意与连接。"),
      O("马上指出：这是贬低，不是沟通", "spark", "你对不尊重容忍度很低。"),
      O("追问：哪条需求不合理，逐条拆开", "mind", "你偏好问题被精确化处理。"),
      O("不解释太多，先撤出这场对话", "free", "你重视不被情绪裹挟。"),
      O("记录模式，若反复出现就重评关系", "steady", "你看重长期行为而非一次态度。")
    ]
  },
  {
    q: "6. 关系确定后多久公开，你更偏向？",
    options: [
      O("尽快公开，给彼此确定感", "warm", "你把公开视作情感承诺。"),
      O("立即公开，不搞暧昧缓冲期", "spark", "你偏好清晰身份和高效推进。"),
      O("先统一边界和节奏，再公开", "mind", "你更看重共识完整度。"),
      O("不爱公开展示，私下稳定就行", "free", "你把亲密定义权留在两人之间。"),
      O("按阶段推进：稳定后再公开", "steady", "你偏好可控节奏和风险管理。")
    ]
  },
  {
    q: "7. 你会不会查伴侣手机？",
    options: [
      O("不查，但希望 TA 主动给你安心", "warm", "你需要的是被照顾而不是监控权。"),
      O("有异常就查，关系不能靠盲信", "spark", "你更偏向结果导向的风险处理。"),
      O("不查设备，只查行为逻辑是否一致", "mind", "你依赖理性证据而非情绪冲动。"),
      O("坚决不查，边界破了关系也会坏", "free", "你把个人边界放在核心位置。"),
      O("双方约定透明规则，谁都别越界", "steady", "你偏好制度化信任。")
    ]
  },
  {
    q: "8. 你状态很差时，TA 还在讲道理，你会？",
    options: [
      O("先要拥抱和安抚，再讲逻辑", "warm", "你把情绪承接作为亲密基础。"),
      O("直接打断：先解决当下，不要上课", "spark", "你追求沟通效率和场景匹配。"),
      O("接受讲道理，但希望结构清楚", "mind", "你对理性沟通容忍度高。"),
      O("先独处回血，拒绝被继续消耗", "free", "你优先维护自己的心理边界。"),
      O("约定流程：先安抚 10 分钟再讨论", "steady", "你偏好可复制的修复机制。")
    ]
  },
  {
    q: "9. TA 事业冲刺 3 个月几乎没空，你会？",
    options: [
      O("支持，但希望每天有固定情感回应", "warm", "你要被放在心上，而不是被忽略。"),
      O("可以忙，但里程碑要同步给你", "spark", "你偏好目标透明和阶段推进。"),
      O("先谈清楚期限、优先级和补偿方案", "mind", "你重视结构化协商。"),
      O("彼此各忙各的，别强行捆绑", "free", "你接受低黏度但高边界的关系。"),
      O("建立稳定联络节奏，按计划执行", "steady", "你看重长期可持续。")
    ]
  },
  {
    q: "10. 同居后家务长期失衡，你会怎么做？",
    options: [
      O("先沟通感受，希望对方主动分担", "warm", "你重视被体谅与被看见。"),
      O("直接列清单和时限，不做就重罚", "spark", "你偏好强执行和硬约束。"),
      O("按工时和能力重新分配最公平", "mind", "你追求规则上的理性公平。"),
      O("无法磨合就分开住，别硬耗", "free", "你重视关系中的可退场性。"),
      O("固定轮值制度，按周复盘", "steady", "你偏好长期稳定的家务系统。")
    ]
  },
  {
    q: "11. TA 用玩笑戳你痛点，你最可能？",
    options: [
      O("先说“这让我难受”，给对方改正机会", "warm", "你希望在关系里被温柔对待。"),
      O("当场制止：再来一次就别谈了", "spark", "你对冒犯的阈值很低。"),
      O("让 TA 明确区分幽默和冒犯边界", "mind", "你倾向定义问题再处理。"),
      O("不解释，直接减少见面频率", "free", "你用距离来保护边界。"),
      O("记录重复次数，触线就执行后果", "steady", "你偏好稳定可执行的惩戒。")
    ]
  },
  {
    q: "12. 异地半年，你能接受的联系频率是？",
    options: [
      O("每天都要有情感连接，不然会慌", "warm", "你需要高频确认亲密感。"),
      O("短平快高质量，重点同步目标进度", "spark", "你追求效率和结果导向。"),
      O("频率可低，但每次必须有深度", "mind", "你更看重沟通质量。"),
      O("不设硬频率，彼此舒服最重要", "free", "你偏好弹性关系节奏。"),
      O("固定时段固定习惯，长期最稳", "steady", "你偏好可预期的连接机制。")
    ]
  },
  {
    q: "13. 节日仪式感你怎么看？",
    options: [
      O("仪式感是“我被你重视”的证据", "warm", "你通过细节确认爱意。"),
      O("形式不重要，关键是行动兑现", "spark", "你偏好实质成果而非包装。"),
      O("愿意做，但要双方价值一致", "mind", "你在意意义是否成立。"),
      O("反感被节日绑架，想过就过", "free", "你希望关系不被外部模板定义。"),
      O("保留固定仪式，长期维护关系", "steady", "你看重稳定、可持续的亲密投入。")
    ]
  },
  {
    q: "14. 你聊结婚，TA 说“再等等两三年”，你会？",
    options: [
      O("先理解 TA 的顾虑，再给安全感", "warm", "你倾向先稳住关系情绪。"),
      O("要明确时间表，不给就止损", "spark", "你拒绝无期限等待。"),
      O("拆解卡点：钱、家庭、价值观分别解决", "mind", "你偏好系统化推进承诺。"),
      O("不急着进制度，关系好比证更重要", "free", "你对制度承诺依赖较低。"),
      O("阶段目标化：一年内达到哪些条件", "steady", "你偏好稳步推进到可落地。")
    ]
  },
  {
    q: "15. 你失业时，希望伴侣最先做什么？",
    options: [
      O("情绪兜底，先让你不崩", "warm", "你把情绪安全放在生存优先级。"),
      O("立刻拉你做计划，简历今天就改", "spark", "你偏好行动拉动恢复。"),
      O("帮你分析赛道与机会，不盲投", "mind", "你看重决策质量。"),
      O("给空间，不把你当失败者管理", "free", "你重视尊严和自主性。"),
      O("短期预算+求职节奏双控", "steady", "你偏好稳态恢复方案。")
    ]
  },
  {
    q: "16. 你升职加薪后，伴侣最理想反应是？",
    options: [
      O("真心替你开心并表达骄傲", "warm", "你重视被伴侣情感性认可。"),
      O("一起设更高目标，继续冲", "spark", "你期待关系形成成长飞轮。"),
      O("和你讨论下一步策略与风险", "mind", "你更看重理性协同。"),
      O("庆祝一下就好，不必上价值", "free", "你喜欢轻松不过度绑定。"),
      O("把新增收入纳入长期规划", "steady", "你偏好把好消息变成长期收益。")
    ]
  },
  {
    q: "17. 你理解的“边界感”最像哪一句？",
    options: [
      O("亲密但不窒息，彼此都能被照顾", "warm", "你追求有温度的边界。"),
      O("说到做到，踩线就承担后果", "spark", "你偏好高压清晰边界。"),
      O("边界必须可定义、可复述、可执行", "mind", "你重视边界的逻辑可操作性。"),
      O("我有随时撤回的权利", "free", "你强调自主权和退出权。"),
      O("边界是长期契约，不是临时心情", "steady", "你偏好边界稳定不漂移。")
    ]
  },
  {
    q: "18. 你认为西塘是个什么样的人：",
    options: [
      O(
        "A:牛逼",
        "spark",
        "你倾向给“强势能打”的人设加分，关系里偏好行动力和掌控感。",
        [["spark", 2], ["steady", 1]]
      ),
      O(
        "B:牛逼",
        "warm",
        "你更像“情感站队”型，重视认同感与忠诚表达。",
        [["warm", 2], ["steady", 1]]
      ),
      O(
        "C:是个几把",
        "mind",
        "你偏向质疑权威标签，重视独立判断与真实表达。",
        [["mind", 2], ["free", 1]]
      )
    ]
  },
  {
    q: "19. TA 在社交平台和人暧昧互动，你会？",
    options: [
      O("先表达受伤感受，给修复机会", "warm", "你优先关系修复而非立刻对抗。"),
      O("直接摊牌：现在删，不删就散", "spark", "你偏好高压止损。"),
      O("先取证再对话，避免无效争吵", "mind", "你依赖事实证据推进决策。"),
      O("你不争，只降级关系投入", "free", "你更倾向通过撤回资源自保。"),
      O("制定公开边界，再看执行表现", "steady", "你偏好规则化治理风险。")
    ]
  },
  {
    q: "20. 吵完架 TA 直接关机失联，你会？",
    options: [
      O("发一句“我在这，等你回来聊”", "warm", "你优先维护连接不断裂。"),
      O("设置最后期限，超时直接处理", "spark", "你拒绝被失联策略拿捏。"),
      O("记录触发点，待冷静后复盘机制", "mind", "你重视冲突系统优化。"),
      O("不追，先把生活切回自己", "free", "你不让关系吞没自我。"),
      O("约定“冷静窗口”与回归时点", "steady", "你偏好可预测的冲突流程。")
    ]
  },
  {
    q: "21. 恋爱中的钱，你更认同哪种？",
    options: [
      O("愿意多付出，让对方感到被爱", "warm", "你把付出看作情感表达。"),
      O("投入要有回报，关系也讲效率", "spark", "你偏好资源投入产出比。"),
      O("按收入比例分担最合理", "mind", "你追求结构公平。"),
      O("AA 或轮流都行，别被钱绑架", "free", "你重视财务独立和轻负担。"),
      O("共同账户+个人账户并行最稳", "steady", "你偏好长期财务系统。")
    ]
  },
  {
    q: "22. 你想要孩子，TA 坚决不要，你会？",
    options: [
      O("先深聊情绪和恐惧，不急下结论", "warm", "你先处理情感底层冲突。"),
      O("这是硬条件，不一致就分开", "spark", "你偏好快速识别不可调和项。"),
      O("列出时间窗和成本，做决策模型", "mind", "你通过理性框架处理重大分歧。"),
      O("尊重彼此选择，不互相改造", "free", "你反对强迫同化。"),
      O("给阶段窗口，窗口后必须定案", "steady", "你偏好有期限的决策机制。")
    ]
  },
  {
    q: "23. 你情绪崩溃时，最怕 TA 怎么做？",
    options: [
      O("冷冷一句“你太敏感了”", "warm", "你对情绪否定极度敏感。"),
      O("空话安慰但什么都不做", "spark", "你对“只说不做”容忍度极低。"),
      O("讲一堆却抓不到重点", "mind", "你讨厌低质量沟通。"),
      O("借机黏你、控制你行程", "free", "你警惕情绪被控制化利用。"),
      O("态度反复，今天哄明天翻旧账", "steady", "你最怕关系不可预测。")
    ]
  },
  {
    q: "24. TA 长期迟到 20 分钟，你会？",
    options: [
      O("告诉 TA 你会觉得不被重视", "warm", "你将准时理解为情感尊重。"),
      O("超过 10 分钟直接走人", "spark", "你偏好立刻执行边界。"),
      O("统计迟到场景，找根因再改", "mind", "你倾向数据化解决问题。"),
      O("不再等，按你时间线走", "free", "你拒绝把时间主权交出去。"),
      O("统一约定迟到惩罚规则", "steady", "你偏好可持续约束机制。")
    ]
  },
  {
    q: "25. TA 在朋友面前让你下不来台，你会？",
    options: [
      O("私下说感受，希望 TA 以后护着你", "warm", "你希望伴侣成为你的同盟。"),
      O("当场纠正，绝不让羞辱成立", "spark", "你重视即时止损和自尊防线。"),
      O("区分玩笑与贬低，再处理", "mind", "你倾向先定性再定责。"),
      O("以后减少这类局，不参与内耗社交", "free", "你偏向主动选择环境。"),
      O("明确“公开场合守则”并执行", "steady", "你偏好长期可执行的关系规范。")
    ]
  },
  {
    q: "26. 你看到 TA 向朋友吐槽你，你会？",
    options: [
      O("希望 TA 先来找你讲，而不是对外发泄", "warm", "你看重被优先沟通。"),
      O("直接对线：有问题当面讲", "spark", "你偏好正面交锋解决。"),
      O("先看吐槽事实是否成立", "mind", "你愿意就事论事做校准。"),
      O("允许吐槽，但你也保留距离权", "free", "你重视双方情绪出口与边界。"),
      O("约定“先内后外”的沟通顺序", "steady", "你偏好固定流程降低误伤。")
    ]
  },
  {
    q: "27. TA 开始强势安排你的生活，你会？",
    options: [
      O("感谢关心，但希望先征询你感受", "warm", "你要的是被爱，不是被管。"),
      O("明确拒绝：别越权管理我", "spark", "你对控制行为零容忍。"),
      O("讨论“建议”与“控制”的定义边界", "mind", "你倾向概念先行。"),
      O("直接收回私人空间和时间表", "free", "你通过行动重建主权。"),
      O("设权限：哪些可建议，哪些禁区", "steady", "你偏好规则化授权。")
    ]
  },
  {
    q: "28. 你提出“我想独处一天”，希望 TA 怎么回应？",
    options: [
      O("理解并关心你是否需要帮助", "warm", "你希望独处和被爱同时存在。"),
      O("尊重并配合，不要反复确认", "spark", "你偏好干脆执行你的请求。"),
      O("确认边界含义，避免误读成冷暴力", "mind", "你重视语义清晰。"),
      O("完全尊重，不追问不过问", "free", "你把独处权视作核心边界。"),
      O("约定独处结束后的回连时间", "steady", "你偏好自由中的稳定连接。")
    ]
  },
  {
    q: "29. 如果对方提出“开放式关系”，你会？",
    options: [
      O("很难接受，你需要排他性安全感", "warm", "你把专属感作为亲密核心。"),
      O("不能接受，立刻明确退出", "spark", "你偏好快速处理底线冲突。"),
      O("先讨论动机和规则，再决定", "mind", "你先评估可行性与代价。"),
      O("理论上可谈，但必须高度自愿", "free", "你更重视关系形式自主权。"),
      O("默认不接受，除非长期机制成熟", "steady", "你偏向低风险长期结构。")
    ]
  },
  {
    q: "30. TA 说“我爱你，但给不了承诺”，你会？",
    options: [
      O("希望 TA 至少给情绪和时间上的确定", "warm", "你需要被持续选择的证据。"),
      O("爱不等于免责，不承诺就不继续", "spark", "你对口头爱意不买单。"),
      O("追问承诺障碍是能力问题还是意愿问题", "mind", "你偏好判断根因再决策。"),
      O("接受阶段性关系，但保留退出权", "free", "你反对被单边绑定。"),
      O("给期限，到点必须给结论", "steady", "你偏好时间边界和可执行性。")
    ]
  },
  {
    q: "31. 未来定居城市冲突，你更可能？",
    options: [
      O("优先谁更需要情感支持就迁就谁", "warm", "你会把关系照护放在第一位。"),
      O("谁机会更大就去谁的城市", "spark", "你偏好效率最大化决策。"),
      O("按职业、家庭、成本做综合评分", "mind", "你用模型做关键人生决策。"),
      O("先异地试运行，不急着一刀切", "free", "你偏好保留机动性。"),
      O("设过渡期和里程碑，逐步迁移", "steady", "你偏好分阶段降低风险。")
    ]
  },
  {
    q: "32. TA 在朋友圈频繁和某人互动，你会？",
    options: [
      O("希望 TA 主动给你安心说明", "warm", "你需要被优先照顾情绪。"),
      O("直接问清关系性质，不玩猜测", "spark", "你偏好正面、快速厘清。"),
      O("先看互动内容是否越界再判断", "mind", "你倾向事实优先。"),
      O("你不查社媒，但会看现实投入变化", "free", "你更看重真实生活而非线上噪音。"),
      O("事先定义线上边界，长期执行", "steady", "你偏好规则先行。")
    ]
  },
  {
    q: "33. 你高烧卧床时，伴侣怎么做最加分？",
    options: [
      O("全程照顾并安抚你情绪", "warm", "你最吃“我在”的陪伴价值。"),
      O("迅速安排就医和药物，不拖延", "spark", "你看重关键时刻的执行力。"),
      O("判断病情并做正确决策", "mind", "你重视理性能力在危机中的表现。"),
      O("尊重你想静养，不强行黏着", "free", "你重视照顾中的边界感。"),
      O("建立复查和恢复计划，持续跟进", "steady", "你偏好连续、稳定的照护。")
    ]
  },
  {
    q: "34. 你最怕关系最后变成什么？",
    options: [
      O("彼此客气，却没有温度", "warm", "你最怕情感连接被掏空。"),
      O("互相拖着，谁都不做决定", "spark", "你最怕低效消耗型关系。"),
      O("每天聊天，但永远聊不到核心", "mind", "你最怕长期浅层沟通。"),
      O("彼此捆绑，失去各自人生", "free", "你最怕失去自我空间。"),
      O("承诺反复变动，未来一直不确定", "steady", "你最怕关系结构不稳定。")
    ]
  },
  {
    q: "35. 如果必须给这段关系下最后定义，你选：",
    options: [
      O("“我要被爱、被懂、被坚定选择。”", "warm", "你把情感确认当作核心目标。"),
      O("“我要一起打仗，不要一起内耗。”", "spark", "你偏好并肩行动的关系。"),
      O("“我要能深聊，且彼此真诚清醒。”", "mind", "你把精神同频放在第一位。"),
      O("“我要亲密，也要完整地做自己。”", "free", "你追求亲密与自由并存。"),
      O("“我要可长期经营、可兑现的未来。”", "steady", "你把长期稳定看作底层价值。")
    ]
  }
];

const typeMap = {
  care: {
    name: "温柔照顾型",
    desc: "细心，会照顾情绪和生活细节，喜欢关心你吃没吃、累不累。相处时会有明显的被爱感和被惦记感。",
    tip: "注意点：有时会因为太操心，变成“管得多”。"
  },
  independent: {
    name: "独立自持型",
    desc: "有边界，有自己的节奏，不会把全部重心都放在恋爱上。相处通常轻松、不黏人、成熟。",
    tip: "注意点：不主动时，容易被误解成冷淡。"
  },
  clingy: {
    name: "黏人依赖型",
    desc: "喜欢频繁聊天、分享日常，希望被及时回应。恋爱氛围浓，参与感强。",
    tip: "注意点：安全感不足时，容易敏感、患得患失。"
  },
  rational: {
    name: "理性分析型",
    desc: "讲逻辑，遇事先分析问题，不太冲动。很多矛盾都能讲清楚、拆开处理。",
    tip: "注意点：安慰人时可能显得“不够有情绪温度”。"
  },
  sensitive: {
    name: "感性细腻型",
    desc: "很在意细节、语气、态度，对情绪变化敏感。共情强、浪漫、理解力高。",
    tip: "注意点：容易想太多，也容易因为小细节受伤。"
  },
  career: {
    name: "事业目标型",
    desc: "重视学业、工作、成长，有计划、有追求。会让人觉得她优秀，也有未来感。",
    tip: "注意点：忙起来时，恋爱优先级可能下降。"
  },
  princess: {
    name: "仪式感公主型",
    desc: "重视节日、惊喜、偏爱、被哄的感觉。恋爱体验感强，氛围感很足。",
    tip: "注意点：如果对方太木，容易经常失望。"
  },
  partner: {
    name: "朋友伙伴型",
    desc: "把伴侣当队友，喜欢一起做事、一起成长、一起玩。整体相处舒服自然，偏长期。",
    tip: "注意点：有时太像朋友，激情感可能弱一点。"
  },
  dominant: {
    name: "强势主导型",
    desc: "有主见，行动力强，很多事情喜欢自己定。相处中会给人可靠、推进快的感觉。",
    tip: "注意点：控制欲一强，就容易让对方有压力。"
  },
  avoidant: {
    name: "回避疏离型",
    desc: "不喜欢冲突，不擅长表达脆弱，情绪上来会先躲。平时看起来安静、不折腾。",
    tip: "注意点：真到关键矛盾时，容易冷处理。"
  }
};

const imageSlugMap = {
  care: "gentle_care",
  independent: "independent_self",
  clingy: "clingy_attach",
  rational: "rational_logic",
  sensitive: "sensitive_heart",
  career: "career_focus",
  princess: "princess_ritual",
  partner: "partner_friend",
  dominant: "dominant_lead",
  avoidant: "avoidant_distance"
};

const quizCard = document.getElementById("quizCard");
const quizForm = document.getElementById("quizForm");
const progressText = document.getElementById("progressText");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const resultCard = document.getElementById("resultCard");
const resultTitle = document.getElementById("resultTitle");
const resultDesc = document.getElementById("resultDesc");
const resultTip = document.getElementById("resultTip");
const resultMethod = document.getElementById("resultMethod");
const resultBadge = document.getElementById("resultBadge");
const resultImage = document.getElementById("resultImage");
const resultImageHint = document.getElementById("resultImageHint");
const scoreBars = document.getElementById("scoreBars");
const keyEvidence = document.getElementById("keyEvidence");
const allEvidenceList = document.getElementById("allEvidenceList");
const retryBtn = document.getElementById("retryBtn");

let currentIndex = 0;
let answers = Array(quizData.length).fill(-1);

renderCurrentQuestion();
updateNavState();

prevBtn.addEventListener("click", () => {
  saveCurrentSelection();
  if (currentIndex > 0) {
    currentIndex -= 1;
    renderCurrentQuestion();
    updateNavState();
  }
});

nextBtn.addEventListener("click", () => {
  const selected = document.querySelector(`input[name="q${currentIndex}"]:checked`);
  if (!selected) {
    alert("先选一个选项，再继续。");
    return;
  }

  answers[currentIndex] = Number(selected.value);

  if (currentIndex === quizData.length - 1) {
    showResult();
    return;
  }

  currentIndex += 1;
  renderCurrentQuestion();
  updateNavState();
});

retryBtn.addEventListener("click", () => {
  answers = Array(quizData.length).fill(-1);
  currentIndex = 0;
  resultCard.classList.add("hidden");
  quizCard.classList.remove("hidden");
  renderCurrentQuestion();
  updateNavState();
  window.scrollTo({ top: 0, behavior: "smooth" });
});

function renderCurrentQuestion() {
  const item = quizData[currentIndex];
  const selected = answers[currentIndex];

  const optionsHtml = item.options.map((option, optIdx) => `
    <label class="opt">
      <input type="radio" name="q${currentIndex}" value="${optIdx}" ${selected === optIdx ? "checked" : ""}>
      ${option.label}
    </label>
  `).join("");

  progressText.textContent = `第 ${currentIndex + 1} / ${quizData.length} 题`;
  quizForm.innerHTML = `
    <article class="question">
      <h3>${item.q}</h3>
      <div class="options">${optionsHtml}</div>
    </article>
  `;
}

function updateNavState() {
  prevBtn.disabled = currentIndex === 0;
  nextBtn.textContent = currentIndex === quizData.length - 1 ? "查看结果" : "下一题";
}

function saveCurrentSelection() {
  const selected = document.querySelector(`input[name="q${currentIndex}"]:checked`);
  if (selected) {
    answers[currentIndex] = Number(selected.value);
  }
}

function showResult() {
  const scores = {
    care: 0,
    independent: 0,
    clingy: 0,
    rational: 0,
    sensitive: 0,
    career: 0,
    princess: 0,
    partner: 0,
    dominant: 0,
    avoidant: 0
  };
  const records = [];

  answers.forEach((answerIdx, idx) => {
    if (answerIdx < 0) return;

    const question = quizData[idx];
    const option = question.options[answerIdx];
    const resolvedType = resolveTypeFromLegacy(option.type, idx);
    const effects = option.effects
      ? resolveEffectsFromLegacy(option.effects, idx)
      : defaultEffects(resolvedType);

    effects.forEach(([type, weight]) => {
      scores[type] += weight;
    });

    records.push({
      question: question.q,
      label: option.label,
      reason: option.reason,
      effects
    });
  });

  const sorted = Object.entries(scores).sort((a, b) => b[1] - a[1]);
  const [topType, topScore] = sorted[0];
  const [secondType] = sorted[1];
  const totalScore = sorted.reduce((sum, [, score]) => sum + score, 0);
  const secondScore = sorted[1][1];
  const profile = buildProfile(topType, secondType, topScore, secondScore, totalScore);

  resultTitle.textContent = `你的高匹配伴侣类型：${profile.name}`;
  resultDesc.textContent = profile.desc;
  resultTip.textContent = profile.tip;
  resultMethod.textContent = "计分依据：每题按选项加权（主倾向 +2，关联倾向 +1）；第 18 题按自定义权重。先按题目场景把答案映射到 10 类型，再做总分统计。图片按“类型语义键”命名自动匹配（共 10 张）。";
  resultBadge.textContent = `${profile.bandLabel} · 图片键 ${profile.imageKey}`;
  loadResultImage(profile.imageKey, profile.name);

  scoreBars.innerHTML = sorted.map(([type, score]) => {
    const percent = totalScore ? Math.round((score / totalScore) * 100) : 0;
    return `
      <div class="bar-item">
        <div class="bar-head">
          <span>${typeMap[type].name}</span>
          <span>${percent}%（${score}分）</span>
        </div>
        <div class="bar-track">
          <div class="bar-fill" style="width:${percent}%"></div>
        </div>
      </div>
    `;
  }).join("");

  const topEvidence = records
    .map((item) => {
      const impact = getWeightForType(item.effects, topType);
      return { ...item, impact };
    })
    .sort((a, b) => b.impact - a.impact)
    .slice(0, 8);

  keyEvidence.innerHTML = topEvidence.map((item) => `
    <li><strong>${item.question}</strong> 你选了「${item.label}」。依据：${item.reason}（计分：${formatEffects(item.effects)}）</li>
  `).join("");

  allEvidenceList.innerHTML = records.map((item, idx) => `
    <li>第 ${idx + 1} 题：你选了「${item.label}」。依据：${item.reason}（计分：${formatEffects(item.effects)}）</li>
  `).join("");

  quizCard.classList.add("hidden");
  resultCard.classList.remove("hidden");
  resultCard.scrollIntoView({ behavior: "smooth", block: "start" });
}

function getWeightForType(effects, type) {
  const found = effects.find(([t]) => t === type);
  return found ? found[1] : 0;
}

function formatEffects(effects) {
  return effects
    .map(([type, weight]) => `${typeMap[type].name}+${weight}`)
    .join("，");
}

function getResultImageCandidates(duoKey) {
  return [
    `assets/result/${duoKey}.png`,
    `assets/result/${duoKey}.jpg`,
    `assets/result/${duoKey}.jpeg`
  ];
}

function loadResultImage(duoKey, profileName) {
  const candidates = getResultImageCandidates(duoKey);
  let idx = 0;

  resultImage.classList.remove("hidden");
  resultImageHint.classList.add("hidden");
  resultImageHint.textContent = "";
  resultImage.alt = `${profileName}结果图`;

  const tryLoad = () => {
    if (idx >= candidates.length) {
      resultImage.classList.add("hidden");
      resultImageHint.textContent = `未找到组合图：assets/result/${duoKey}.(png|jpg|jpeg)。请按 README 里的语义文件名放图。`;
      resultImageHint.classList.remove("hidden");
      return;
    }
    resultImage.src = candidates[idx];
    idx += 1;
  };

  resultImage.onload = () => {
    resultImage.classList.remove("hidden");
    resultImageHint.classList.add("hidden");
  };

  resultImage.onerror = () => {
    tryLoad();
  };

  tryLoad();
}

function buildProfile(topType, secondType, topScore, secondScore, totalScore) {
  const dominance = totalScore ? topScore / totalScore : 0;
  const gap = topScore - secondScore;
  const top = typeMap[topType];
  const second = typeMap[secondType];

  let bandLabel = "均衡层";
  let bandDesc = `你的次倾向是「${second.name}」，说明你在关系里还有第二需求模块在起作用。`;

  if (dominance >= 0.26 || gap >= 6) {
    bandLabel = "主导层";
    bandDesc = `你的主类型优势明显，次倾向为「${second.name}」。择偶时你会优先筛掉不符合主类型的人。`;
  }

  const desc = `${top.desc} ${bandDesc}`;
  const tip = `${top.tip} 次倾向参考：${second.name}。`;

  return {
    name: top.name,
    bandLabel,
    imageKey: buildTypeImageKey(topType),
    desc,
    tip
  };
}

function buildTypeImageKey(type) {
  return imageSlugMap[type];
}
