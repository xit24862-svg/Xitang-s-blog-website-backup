(() => {
  const CONFIG = {
    canvasWidth: 1280,
    canvasHeight: 720,
    pixelScale: 4,
    trackSamples: 900,
    baseStartLead: 155,
    bgmPath: "./assets/audio/bgm.mp3",
    bgmVolume: 0.45,
    queueSize: 6,
    letterPool: ["A", "S", "D", "F", "J", "K", "L", "Q", "W", "E", "I", "O", "P"],
    feedbackDuration: 0.52,
    bumpDuration: 0.2,
    missLockDuration: 0.28,
    countdownSeconds: 3,
    difficulties: {
      easy: {
        label: "简单",
        thiefSpeed: 58,
        policeStep: 36,
        catchDistance: 26,
        loseLeadDistance: 280,
        loseLeadDuration: 5.2,
        accelerationPerSecond: 1.6,
        desc: "恐龙较慢，危险线更宽，失败判定更晚。"
      },
      normal: {
        label: "普通",
        thiefSpeed: 70,
        policeStep: 31,
        catchDistance: 23,
        loseLeadDistance: 230,
        loseLeadDuration: 3.8,
        accelerationPerSecond: 2.6,
        desc: "默认平衡档，需要稳定跟上窗口节奏。"
      },
      hard: {
        label: "困难",
        thiefSpeed: 82,
        policeStep: 28,
        catchDistance: 20,
        loseLeadDistance: 190,
        loseLeadDuration: 2.7,
        accelerationPerSecond: 4.3,
        desc: "恐龙更快且后程提速明显，必须连续正确输入。"
      }
    }
  };

  const canvas = document.getElementById("gameCanvas");
  const ctx = canvas.getContext("2d");

  const ui = {
    difficultyLabel: document.getElementById("difficultyLabel"),
    soundLabel: document.getElementById("soundLabel"),
    phaseText: document.getElementById("phaseText"),
    statusText: document.getElementById("statusText"),
    leadValue: document.getElementById("leadValue"),
    comboValue: document.getElementById("comboValue"),
    hitValue: document.getElementById("hitValue"),
    difficultyDesc: document.getElementById("difficultyDesc"),
    feedbackBadge: document.getElementById("feedbackBadge"),
    promptLetter: document.getElementById("promptLetter"),
    sequencePreview: document.getElementById("sequencePreview"),
    touchControls: document.getElementById("touchControls"),
    currentLetterBox: document.getElementById("currentLetterBox"),
    trackPromptWindow: document.getElementById("trackPromptWindow"),
    menuOverlay: document.getElementById("menuOverlay"),
    dangerFill: document.getElementById("dangerFill"),
    dangerText: document.getElementById("dangerText"),
    dangerOverlay: document.getElementById("dangerOverlay"),
    countdownOverlay: document.getElementById("countdownOverlay"),
    stageWrap: document.getElementById("stageWrap"),
    soundButton: document.getElementById("soundButton"),
    startButton: document.getElementById("startButton"),
    restartButton: document.getElementById("restartButton"),
    menuButton: document.getElementById("menuButton"),
    resultOverlay: document.getElementById("resultOverlay"),
    resultTag: document.getElementById("resultTag"),
    resultTitle: document.getElementById("resultTitle"),
    resultSummary: document.getElementById("resultSummary"),
    resultHits: document.getElementById("resultHits"),
    resultCombo: document.getElementById("resultCombo"),
    resultDifficulty: document.getElementById("resultDifficulty")
  };

  const state = {
    phase: "menu",
    selectedDifficulty: "normal",
    soundEnabled: true,
    lastTimestamp: 0,
    elapsed: 0,
    countdownLeft: 0,
    queue: [],
    policeProgress: 0,
    thiefProgress: CONFIG.baseStartLead,
    trackPoints: [],
    lapLength: 1,
    lead: CONFIG.baseStartLead,
    overLeadTime: 0,
    feedbackText: "READY",
    feedbackKind: "",
    feedbackTimer: 0,
    missLockTimer: 0,
    shakeTimer: 0,
    policeBumpTimer: 0,
    thiefBumpTimer: 0,
    hits: 0,
    combo: 0,
    bestCombo: 0
  };

  const audio = {
    context: null,
    masterGain: null,
    bgm: null,
    ensure() {
      if (this.context) return;
      const AudioCtx = window.AudioContext || window.webkitAudioContext;
      if (!AudioCtx) return;
      this.context = new AudioCtx();
      this.masterGain = this.context.createGain();
      this.masterGain.gain.value = 0.08;
      this.masterGain.connect(this.context.destination);
    },
    ensureBgm() {
      if (this.bgm) return this.bgm;
      this.bgm = new Audio(CONFIG.bgmPath);
      this.bgm.loop = true;
      this.bgm.preload = "auto";
      this.bgm.volume = CONFIG.bgmVolume;
      this.bgm.addEventListener("error", () => {
        console.warn(`BGM load failed: ${CONFIG.bgmPath}`);
      });
      return this.bgm;
    },
    unlock() {
      this.ensure();
      if (this.context && this.context.state === "suspended") {
        this.context.resume();
      }
    },
    playBgm() {
      if (!state.soundEnabled) return;
      const bgm = this.ensureBgm();
      if (!bgm) return;
      bgm.volume = CONFIG.bgmVolume;
      const playPromise = bgm.play();
      if (playPromise && typeof playPromise.catch === "function") {
        playPromise.catch(() => {
          console.warn("BGM playback was blocked or failed.");
        });
      }
    },
    stopBgm() {
      if (!this.bgm) return;
      this.bgm.pause();
      this.bgm.currentTime = 0;
    },
    pauseBgm() {
      if (!this.bgm) return;
      this.bgm.pause();
    },
    playTone(type, frequency, duration, when = 0, volume = 0.3) {
      if (!state.soundEnabled) return;
      this.ensure();
      if (!this.context || !this.masterGain) return;

      const start = this.context.currentTime + when;
      const osc = this.context.createOscillator();
      const gain = this.context.createGain();
      osc.type = type;
      osc.frequency.setValueAtTime(frequency, start);
      gain.gain.setValueAtTime(0.0001, start);
      gain.gain.exponentialRampToValueAtTime(volume, start + 0.01);
      gain.gain.exponentialRampToValueAtTime(0.0001, start + duration);
      osc.connect(gain);
      gain.connect(this.masterGain);
      osc.start(start);
      osc.stop(start + duration + 0.03);
    },
    button() {
      this.playTone("square", 540, 0.08, 0, 0.2);
    },
    hit() {
      this.playTone("square", 660, 0.08, 0, 0.24);
      this.playTone("triangle", 880, 0.12, 0.05, 0.16);
    },
    miss() {
      this.playTone("sawtooth", 230, 0.12, 0, 0.22);
      this.playTone("square", 180, 0.15, 0.05, 0.12);
    },
    win() {
      this.playTone("triangle", 523, 0.12, 0, 0.18);
      this.playTone("triangle", 659, 0.12, 0.1, 0.18);
      this.playTone("triangle", 784, 0.22, 0.2, 0.2);
    },
    lose() {
      this.playTone("square", 260, 0.15, 0, 0.2);
      this.playTone("square", 196, 0.18, 0.12, 0.18);
      this.playTone("square", 140, 0.28, 0.26, 0.18);
    },
    countdown() {
      this.playTone("square", 700, 0.08, 0, 0.12);
    }
  };

  function currentDifficulty() {
    return CONFIG.difficulties[state.selectedDifficulty];
  }

  function focusGameArea() {
    if (!ui.stageWrap) return;
    ui.stageWrap.focus({ preventScroll: true });
  }

  function randomLetter(exclude) {
    let letter = CONFIG.letterPool[Math.floor(Math.random() * CONFIG.letterPool.length)];
    if (exclude && CONFIG.letterPool.length > 1) {
      while (letter === exclude) {
        letter = CONFIG.letterPool[Math.floor(Math.random() * CONFIG.letterPool.length)];
      }
    }
    return letter;
  }

  function buildInitialQueue() {
    const queue = [];
    for (let i = 0; i < CONFIG.queueSize; i += 1) {
      queue.push(randomLetter(queue[queue.length - 1]));
    }
    return queue;
  }

  function refillQueueAfterHit() {
    state.queue.shift();
    state.queue.push(randomLetter(state.queue[state.queue.length - 1]));
  }

  function createTrack() {
    const centerX = 640;
    const centerY = 360;
    const radiusX = 360;
    const radiusY = 190;
    const points = [];
    let cumulative = 0;
    let prevX = centerX + radiusX;
    let prevY = centerY;

    points.push({ x: prevX, y: prevY, cumulativeLength: 0 });

    for (let i = 1; i <= CONFIG.trackSamples; i += 1) {
      const t = (Math.PI * 2 * i) / CONFIG.trackSamples;
      const x = centerX + radiusX * Math.cos(t);
      const y = centerY + radiusY * Math.sin(t);
      cumulative += Math.hypot(x - prevX, y - prevY);
      points.push({ x, y, cumulativeLength: cumulative });
      prevX = x;
      prevY = y;
    }

    state.trackPoints = points;
    state.lapLength = cumulative;
  }

  function resetRun(phase = "menu") {
    state.phase = phase;
    state.elapsed = 0;
    state.countdownLeft = CONFIG.countdownSeconds;
    state.queue = buildInitialQueue();
    state.policeProgress = 0;
    state.thiefProgress = CONFIG.baseStartLead;
    state.lead = CONFIG.baseStartLead;
    state.overLeadTime = 0;
    state.feedbackText = phase === "menu" ? "READY" : "GO";
    state.feedbackKind = "";
    state.feedbackTimer = 0;
    state.missLockTimer = 0;
    state.shakeTimer = 0;
    state.policeBumpTimer = 0;
    state.thiefBumpTimer = 0;
    state.hits = 0;
    state.combo = 0;
    state.bestCombo = 0;

    ui.resultOverlay.classList.add("hidden");
    ui.countdownOverlay.classList.toggle("hidden", phase !== "countdown");
    ui.menuOverlay.classList.toggle("hidden", phase !== "menu");
    renderSequenceWindow();
    updateUI();
  }

  function startGame() {
    audio.unlock();
    audio.button();
    audio.playBgm();
    resetRun("countdown");
    ui.countdownOverlay.textContent = String(CONFIG.countdownSeconds);
    focusGameArea();
  }

  function returnToMenu() {
    audio.button();
    resetRun("menu");
    audio.playBgm();
    focusGameArea();
  }

  function finishGame(win) {
    state.phase = win ? "win" : "lose";
    state.feedbackText = win ? "PERFECT" : "MISS OUT";
    state.feedbackKind = win ? "win" : "lose";
    state.feedbackTimer = 1.2;

    if (win) {
      audio.win();
      ui.resultTag.textContent = "WIN";
      ui.resultTitle.textContent = "咱鸡儿抓到恐龙";
      ui.resultSummary.textContent = "你成功盯住了窗口最左侧高亮字母，抓捕完成。";
    } else {
      audio.lose();
      ui.resultTag.textContent = "LOSE";
      ui.resultTitle.textContent = "恐龙逃脱了";
      ui.resultSummary.textContent = "危险时间被拖满了，再试一次，把底部字母窗口盯得更紧。";
    }

    ui.resultHits.textContent = String(state.hits);
    ui.resultCombo.textContent = String(state.bestCombo);
    ui.resultDifficulty.textContent = currentDifficulty().label;
    ui.resultOverlay.classList.remove("hidden");
    updateUI();
  }

  function setFeedback(kind, text) {
    state.feedbackKind = kind;
    state.feedbackText = text;
    state.feedbackTimer = CONFIG.feedbackDuration;
  }

  function updateGame(dt) {
    if (state.feedbackTimer > 0) state.feedbackTimer = Math.max(0, state.feedbackTimer - dt);
    if (state.missLockTimer > 0) state.missLockTimer = Math.max(0, state.missLockTimer - dt);
    if (state.shakeTimer > 0) state.shakeTimer = Math.max(0, state.shakeTimer - dt);
    if (state.policeBumpTimer > 0) state.policeBumpTimer = Math.max(0, state.policeBumpTimer - dt);
    if (state.thiefBumpTimer > 0) state.thiefBumpTimer = Math.max(0, state.thiefBumpTimer - dt);

    if (state.phase === "countdown") {
      state.countdownLeft -= dt;
      const displayValue = Math.max(1, Math.ceil(state.countdownLeft));
      ui.countdownOverlay.textContent = displayValue > 0 ? String(displayValue) : "GO";
      if (Math.abs(state.countdownLeft - Math.round(state.countdownLeft)) < dt) {
        audio.countdown();
      }
      if (state.countdownLeft <= 0) {
        state.phase = "playing";
        ui.countdownOverlay.classList.add("hidden");
        setFeedback("hit", "GO");
        focusGameArea();
      }
    }

    if (state.phase !== "playing") {
      updateUI();
      return;
    }

    state.elapsed += dt;
    const difficulty = currentDifficulty();
    const thiefSpeed = difficulty.thiefSpeed + difficulty.accelerationPerSecond * state.elapsed;
    state.thiefProgress += thiefSpeed * dt;

    state.lead = Math.max(0, state.thiefProgress - state.policeProgress);
    if (state.lead > difficulty.loseLeadDistance) {
      state.overLeadTime += dt;
    } else {
      state.overLeadTime = Math.max(0, state.overLeadTime - dt * 1.2);
    }

    if (state.lead <= difficulty.catchDistance) {
      finishGame(true);
      return;
    }

    if (state.overLeadTime >= difficulty.loseLeadDuration) {
      finishGame(false);
      return;
    }

    updateUI();
  }

  function normalizeKey(event) {
    if (event.code && event.code.startsWith("Key")) {
      return event.code.slice(3).toUpperCase();
    }
    if (!event.key || event.key.length !== 1) return null;
    const key = event.key.toUpperCase();
    return /^[A-Z]$/.test(key) ? key : null;
  }

  function handleInput(event) {
    if (state.phase !== "playing") return;
    const key = normalizeKey(event);
    if (!key) return;
    event.preventDefault();
    processInput(key);
  }

  function processInput(key) {
    if (state.phase !== "playing") return;
    if (state.missLockTimer > 0) return;

    const difficulty = currentDifficulty();
    const expected = state.queue[0];

    if (key === expected) {
      state.policeProgress += difficulty.policeStep;
      refillQueueAfterHit();
      state.hits += 1;
      state.combo += 1;
      state.bestCombo = Math.max(state.bestCombo, state.combo);
      state.policeBumpTimer = CONFIG.bumpDuration;
      state.shakeTimer = 0.12;
      setFeedback("hit", state.combo >= 6 ? "PERFECT" : state.combo >= 3 ? "GOOD" : "HIT");
      audio.hit();
    } else {
      state.combo = 0;
      state.missLockTimer = CONFIG.missLockDuration;
      state.thiefBumpTimer = CONFIG.bumpDuration;
      state.shakeTimer = 0.18;
      setFeedback("miss", "MISS");
      audio.miss();
    }

    state.lead = Math.max(0, state.thiefProgress - state.policeProgress);
    if (state.lead <= difficulty.catchDistance) {
      finishGame(true);
      return;
    }

    renderSequenceWindow();
    updateUI();
  }

  function getTouchLetters() {
    return state.queue.filter((letter, index) => state.queue.indexOf(letter) === index);
  }

  function renderTouchControls() {
    const fragment = document.createDocumentFragment();
    const touchLetters = getTouchLetters();

    touchLetters.forEach((letter) => {
      const button = document.createElement("button");
      button.type = "button";
      button.className = "touch-key";
      button.textContent = letter;
      button.dataset.key = letter;
      button.addEventListener("pointerdown", () => {
        audio.unlock();
        button.classList.add("is-pressed");
      });
      button.addEventListener("pointerup", () => {
        button.classList.remove("is-pressed");
      });
      button.addEventListener("pointercancel", () => {
        button.classList.remove("is-pressed");
      });
      button.addEventListener("pointerleave", () => {
        button.classList.remove("is-pressed");
      });
      button.addEventListener("click", () => {
        processInput(letter);
      });
      fragment.appendChild(button);
    });

    ui.touchControls.replaceChildren(fragment);
  }

  function renderSequenceWindow() {
    ui.promptLetter.textContent = state.queue[0] || "";
    const fragment = document.createDocumentFragment();

    state.queue.forEach((letter, index) => {
      const token = document.createElement("div");
      token.className = "sequence-token";
      if (index === 0) token.classList.add("current");
      else if (index < 4) token.classList.add("upcoming");
      else token.classList.add("tail");
      token.textContent = letter;
      fragment.appendChild(token);
    });

    ui.sequencePreview.replaceChildren(fragment);
    renderTouchControls();

    const upcoming = new Set(state.queue.slice(1, 4));
    ui.touchControls.querySelectorAll(".touch-key").forEach((button) => {
      const key = button.dataset.key;
      button.classList.toggle("current", key === state.queue[0]);
      button.classList.toggle("upcoming", upcoming.has(key));
    });
  }

  function updateFeedbackUI() {
    ui.feedbackBadge.textContent = state.feedbackText;
    ui.feedbackBadge.className = "feedback-badge";
    ui.currentLetterBox.classList.remove("hit", "miss");

    if (state.phase === "win") {
      ui.feedbackBadge.classList.add("win");
      return;
    }
    if (state.phase === "lose") {
      ui.feedbackBadge.classList.add("lose");
      return;
    }
    if (state.feedbackTimer <= 0) {
      ui.feedbackBadge.textContent = "READY";
      return;
    }
    if (state.feedbackKind === "hit") {
      ui.feedbackBadge.classList.add("hit");
      ui.currentLetterBox.classList.add("hit");
    } else if (state.feedbackKind === "miss") {
      ui.feedbackBadge.classList.add("miss");
      ui.currentLetterBox.classList.add("miss");
    }
  }

  function updateUI() {
    const difficulty = currentDifficulty();
    const dangerRatio = Math.min(state.overLeadTime / difficulty.loseLeadDuration, 1);
    const dangerActive = state.phase === "playing" && dangerRatio > 0.15;

    ui.leadValue.textContent = String(Math.round(state.lead));
    ui.comboValue.textContent = String(state.combo);
    ui.hitValue.textContent = String(state.hits);
    ui.dangerFill.style.width = `${dangerRatio * 100}%`;
    ui.dangerText.textContent = dangerActive
      ? `危险 ${Math.max(0, difficulty.loseLeadDuration - state.overLeadTime).toFixed(1)}s`
      : state.phase === "menu"
        ? "等待开局"
        : "安全";

    ui.difficultyLabel.textContent = difficulty.label;
    ui.difficultyDesc.textContent = difficulty.desc;
    ui.resultDifficulty.textContent = difficulty.label;

    if (state.phase === "menu") {
      ui.phaseText.textContent = "主菜单";
      ui.statusText.textContent = "开始前先看底部字母窗口，菜单和难度都在游戏内部。";
    } else if (state.phase === "countdown") {
      ui.phaseText.textContent = "准备中";
      ui.statusText.textContent = "倒计时结束后，立刻按底部窗口最左高亮字母。";
    } else if (state.phase === "playing") {
      ui.phaseText.textContent = dangerActive ? "危险追击" : "追击中";
      ui.statusText.textContent = state.feedbackKind === "miss" && state.feedbackTimer > 0
        ? "MISS，窗口没有推进，恐龙趁机拉开。"
        : "盯住底部字母窗口，按最左高亮字母。";
    } else if (state.phase === "win") {
      ui.phaseText.textContent = "胜利";
      ui.statusText.textContent = "追击成功，咱鸡儿完成抓捕。";
    } else if (state.phase === "lose") {
      ui.phaseText.textContent = "失败";
      ui.statusText.textContent = "恐龙脱离控制范围。";
    }

    ui.menuOverlay.classList.toggle("hidden", state.phase !== "menu");
    document.body.classList.toggle("danger", dangerActive);
    ui.dangerOverlay.classList.toggle("active", dangerActive);
    ui.stageWrap.classList.toggle("shake", state.shakeTimer > 0);
    updateFeedbackUI();
  }

  function setDifficulty(key) {
    state.selectedDifficulty = key;
    document.querySelectorAll(".difficulty-button").forEach((button) => {
      button.classList.toggle("is-active", button.dataset.difficulty === key);
    });
    ui.difficultyLabel.textContent = currentDifficulty().label;
    ui.difficultyDesc.textContent = currentDifficulty().desc;
    audio.button();
    if (state.phase === "menu" && state.soundEnabled) {
      audio.playBgm();
    }
    updateUI();
  }

  function toggleSound() {
    audio.unlock();
    state.soundEnabled = !state.soundEnabled;
    ui.soundButton.textContent = `音效：${state.soundEnabled ? "开启" : "关闭"}`;
    ui.soundLabel.textContent = state.soundEnabled ? "开启" : "关闭";
    if (state.soundEnabled) {
      audio.button();
      if (state.phase !== "menu") {
        audio.playBgm();
      }
    } else {
      audio.pauseBgm();
    }
  }

  function getTrackPosition(progress) {
    const lapPos = ((progress % state.lapLength) + state.lapLength) % state.lapLength;
    const points = state.trackPoints;

    for (let i = 1; i < points.length; i += 1) {
      const prev = points[i - 1];
      const next = points[i];
      if (lapPos <= next.cumulativeLength) {
        const segmentLength = next.cumulativeLength - prev.cumulativeLength || 1;
        const ratio = (lapPos - prev.cumulativeLength) / segmentLength;
        return {
          x: prev.x + (next.x - prev.x) * ratio,
          y: prev.y + (next.y - prev.y) * ratio
        };
      }
    }

    return { x: points[0].x, y: points[0].y };
  }

  function drawPixelArt(centerX, centerY, rows, colors, scale) {
    const width = rows[0].length;
    const height = rows.length;
    const startX = Math.round(centerX - (width * scale) / 2);
    const startY = Math.round(centerY - (height * scale) / 2);

    for (let row = 0; row < height; row += 1) {
      for (let col = 0; col < width; col += 1) {
        const code = rows[row][col];
        if (code === ".") continue;
        ctx.fillStyle = colors[code];
        ctx.fillRect(startX + col * scale, startY + row * scale, scale, scale);
      }
    }
  }

  function drawBackground() {
    ctx.clearRect(0, 0, CONFIG.canvasWidth, CONFIG.canvasHeight);

    const sky = ctx.createLinearGradient(0, 0, 0, 250);
    sky.addColorStop(0, "#6a8cf2");
    sky.addColorStop(1, "#a1c6ff");
    ctx.fillStyle = sky;
    ctx.fillRect(0, 0, CONFIG.canvasWidth, 250);

    ctx.fillStyle = "#d0e7ff";
    ctx.fillRect(0, 192, CONFIG.canvasWidth, 10);
    ctx.fillRect(0, 212, CONFIG.canvasWidth, 8);

    ctx.fillStyle = "#4868bb";
    for (let i = 0; i < 9; i += 1) {
      ctx.fillRect(40 + i * 140, 76 + (i % 2) * 10, 72, 26);
    }

    ctx.fillStyle = "#44733b";
    ctx.fillRect(0, 250, CONFIG.canvasWidth, CONFIG.canvasHeight - 250);

    for (let i = 0; i < 240; i += 1) {
      const x = (i * 59) % CONFIG.canvasWidth;
      const y = 250 + ((i * 37) % 420);
      ctx.fillStyle = i % 2 === 0 ? "#4e8545" : "#3b6d36";
      ctx.fillRect(x, y, 8, 8);
    }

    ctx.fillStyle = "#162a14";
    ctx.fillRect(0, 598, CONFIG.canvasWidth, 122);
  }

  function drawEllipse(cx, cy, rx, ry, fill) {
    ctx.beginPath();
    ctx.ellipse(cx, cy, rx, ry, 0, 0, Math.PI * 2);
    if (fill) ctx.fill();
    else ctx.stroke();
  }

  function drawTrack() {
    const cx = 640;
    const cy = 360;
    const outerRx = 382;
    const outerRy = 206;
    const innerRx = 282;
    const innerRy = 128;

    ctx.fillStyle = "#d7e9a4";
    drawEllipse(cx, cy, outerRx + 26, outerRy + 20, true);
    ctx.fillStyle = "#b85a4d";
    drawEllipse(cx, cy, outerRx, outerRy, true);
    ctx.fillStyle = "#93463d";
    drawEllipse(cx, cy, outerRx - 24, outerRy - 20, true);
    ctx.fillStyle = "#88b86a";
    drawEllipse(cx, cy, innerRx, innerRy, true);
    ctx.fillStyle = "#6ea659";
    drawEllipse(cx, cy, innerRx - 30, innerRy - 22, true);

    ctx.strokeStyle = "#fff4d0";
    ctx.lineWidth = 5;
    drawEllipse(cx, cy, outerRx - 12, outerRy - 10, false);
    drawEllipse(cx, cy, innerRx + 10, innerRy + 8, false);

    ctx.setLineDash([18, 18]);
    ctx.strokeStyle = "rgba(255, 241, 184, 0.9)";
    drawEllipse(cx, cy, (outerRx + innerRx) / 2, (outerRy + innerRy) / 2, false);
    ctx.setLineDash([]);

    ctx.fillStyle = "#ffffff";
    ctx.fillRect(cx - 5, cy - outerRy + 8, 10, 34);
    ctx.fillRect(cx - 30, cy - outerRy + 8, 18, 12);
    ctx.fillRect(cx + 12, cy - outerRy + 8, 18, 12);
  }

  function drawLaneMarkers() {
    ctx.fillStyle = "rgba(255, 241, 184, 0.45)";
    for (let i = 0; i < 28; i += 1) {
      const point = getTrackPosition((state.lapLength / 28) * i);
      ctx.fillRect(point.x - 2, point.y - 2, 4, 4);
    }
  }

  function drawRunner(progress, type) {
    const pos = getTrackPosition(progress);
    const bob = Math.sin(state.elapsed * 14 + (type === "police" ? 0 : 1.8)) * 2;
    const bump = type === "police" ? state.policeBumpTimer * 24 : state.thiefBumpTimer * 18;
    const scale = type === "police" && state.policeBumpTimer > 0 ? 1.08 : 1;

    ctx.fillStyle = "rgba(0, 0, 0, 0.22)";
    ctx.beginPath();
    ctx.ellipse(pos.x, pos.y + 24, 20 + scale, 8 + scale, 0, 0, Math.PI * 2);
    ctx.fill();

    ctx.save();
    ctx.translate(pos.x + bump, pos.y + bob - 10);
    ctx.scale(scale, scale);
    if (type === "police") {
      drawPoliceSprite();
    } else {
      drawDinoSprite();
    }
    ctx.restore();
  }

  function drawPoliceSprite() {
    const rows = [
      "..NNNNNN....",
      "..NBBBBBN...",
      ".NNBYYYYBN..",
      ".NSSSSSSSN..",
      ".NSSSSSSSN..",
      ".NNSSSSNN...",
      "..BDDDDDB...",
      ".BBDDDDDBB..",
      ".BB.DDDD.B..",
      ".B..DDDD..B.",
      ".W..W..W..W.",
      "W...W..W...W"
    ];
    const colors = {
      N: "#1f2d49",
      B: "#3572e5",
      Y: "#f6d56f",
      S: "#f2c28b",
      D: "#2d57a4",
      W: "#593d26"
    };
    drawPixelArt(0, 0, rows, colors, CONFIG.pixelScale);
  }

  function drawDinoSprite() {
    const rows = [
      "...GGGG.....",
      "..GGGGGG....",
      ".GGGGGGGG...",
      ".GGGHHGGG...",
      ".GGGGGGGGG..",
      ".GGGGGGG....",
      ".GGGGGGGG...",
      ".GGGGGGGGG..",
      "..GGG.GGG...",
      "..GG..GGG...",
      ".BB...BB....",
      ".BB...BB...."
    ];
    const colors = {
      G: "#58bc5d",
      H: "#dcffd8",
      B: "#5a3c24"
    };
    drawPixelArt(0, 0, rows, colors, CONFIG.pixelScale);
  }

  function drawCenterEffect() {
    if (state.feedbackTimer <= 0 || state.phase === "menu") return;
    ctx.save();
    ctx.textAlign = "center";
    ctx.font = "bold 52px Courier New";
    ctx.fillStyle = state.feedbackKind === "miss" ? "#ffd6d6" : "#fff0a8";
    ctx.fillText(state.feedbackText, CONFIG.canvasWidth / 2, 188);
    ctx.restore();
  }

  function render() {
    drawBackground();
    drawTrack();
    drawLaneMarkers();
    drawRunner(state.thiefProgress, "thief");
    drawRunner(state.policeProgress, "police");
    drawCenterEffect();
  }

  function loop(timestamp) {
    if (!state.lastTimestamp) state.lastTimestamp = timestamp;
    const dt = Math.min((timestamp - state.lastTimestamp) / 1000, 0.033);
    state.lastTimestamp = timestamp;
    updateGame(dt);
    render();
    requestAnimationFrame(loop);
  }

  document.querySelectorAll(".difficulty-button").forEach((button) => {
    button.addEventListener("click", () => setDifficulty(button.dataset.difficulty));
  });

  ui.startButton.addEventListener("click", startGame);
  ui.restartButton.addEventListener("click", startGame);
  ui.menuButton.addEventListener("click", returnToMenu);
  ui.soundButton.addEventListener("click", toggleSound);
  ui.stageWrap.addEventListener("pointerdown", focusGameArea);
  ui.stageWrap.addEventListener("click", focusGameArea);
  window.addEventListener("keydown", handleInput);
  document.addEventListener("keydown", handleInput, true);
  window.addEventListener("pointerdown", () => {
    audio.unlock();
    focusGameArea();
    if (state.phase === "menu" && state.soundEnabled) {
      audio.playBgm();
    }
  });

  createTrack();
  setDifficulty("normal");
  resetRun("menu");
  focusGameArea();
  requestAnimationFrame(loop);
})();
