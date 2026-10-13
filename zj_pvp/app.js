(function () {
  const boot = window.XQ_PVP_BOOT || {};
  if (!boot.api) return;
  const POLL_INTERVAL_MS = 800;
  const WATCH_TIMEOUT_MS = 12000;

  function createInitialBoard() {
    return [
      ["bR", "bH", "bE", "bA", "bK", "bA", "bE", "bH", "bR"],
      ["", "", "", "", "", "", "", "", ""],
      ["", "bC", "", "", "", "", "", "bC", ""],
      ["bP", "", "bP", "", "bP", "", "bP", "", "bP"],
      ["", "", "", "", "", "", "", "", ""],
      ["", "", "", "", "", "", "", "", ""],
      ["rP", "", "rP", "", "rP", "", "rP", "", "rP"],
      ["", "rC", "", "", "", "", "", "rC", ""],
      ["", "", "", "", "", "", "", "", ""],
      ["rR", "rH", "rE", "rA", "rK", "rA", "rE", "rH", "rR"]
    ];
  }

  const state = {
    mySide: null,
    gameId: null,
    board: createInitialBoard(),
    turn: null,
    status: "idle",
    resultText: "进行中",
    opponent: "-",
    selected: null,
    pollTimer: null,
    busy: false,
    refreshing: false,
    lastRefreshAt: 0,
    moveCount: 0,
    watchActive: false
  };

  const ui = {
    statusText: document.getElementById("statusText"),
    opponentText: document.getElementById("opponentText"),
    mySideText: document.getElementById("mySideText"),
    turnText: document.getElementById("turnText"),
    resultText: document.getElementById("resultText"),
    readyBtn: document.getElementById("readyBtn"),
    cancelBtn: document.getElementById("cancelBtn"),
    resignBtn: document.getElementById("resignBtn"),
    board: document.getElementById("board")
  };

  const PIECE_TEXT = {
    R: { r: "车", b: "车" },
    H: { r: "马", b: "马" },
    E: { r: "相", b: "象" },
    A: { r: "仕", b: "士" },
    K: { r: "帅", b: "将" },
    C: { r: "炮", b: "炮" },
    P: { r: "兵", b: "卒" }
  };

  function setStatus(msg) {
    ui.statusText.textContent = msg;
  }

  function sideLabel(side) {
    return side === "r" ? "红方" : side === "b" ? "黑方" : "-";
  }

  function pieceLabel(piece) {
    if (!piece || piece.length < 2) return "";
    const side = piece.charAt(0);
    const type = piece.charAt(1);
    return (PIECE_TEXT[type] && PIECE_TEXT[type][side]) || "?";
  }

  function toBoardCoord(displayX, displayY) {
    if (state.mySide === "b") {
      return { x: 8 - displayX, y: 9 - displayY };
    }
    return { x: displayX, y: displayY };
  }

  function toDisplayCoord(boardX, boardY) {
    if (state.mySide === "b") {
      return { x: 8 - boardX, y: 9 - boardY };
    }
    return { x: boardX, y: boardY };
  }

  async function api(action, payload) {
    const res = await fetch(boot.api, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ action, payload: payload || {} })
    });
    const data = await res.json();
    if (!res.ok || !data.ok) {
      throw new Error(data.message || "请求失败");
    }
    return data;
  }

  function updateButtons() {
    ui.readyBtn.disabled = state.status === "playing" || state.status === "waiting";
    ui.cancelBtn.disabled = state.status !== "waiting";
    ui.resignBtn.disabled = state.status !== "playing";
  }

  function drawBoardGrid() {
    ui.board.innerHTML = "";

    const lineLayer = document.createElement("div");
    lineLayer.className = "board-lines";
    lineLayer.innerHTML = [
      '<svg viewBox="0 0 900 1000" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">',
      '<rect x="0" y="0" width="900" height="1000" fill="none"/>',
      '<g stroke="var(--board-line)" stroke-width="2">',
      '<line x1="50" y1="50" x2="850" y2="50"/>',
      '<line x1="50" y1="150" x2="850" y2="150"/>',
      '<line x1="50" y1="250" x2="850" y2="250"/>',
      '<line x1="50" y1="350" x2="850" y2="350"/>',
      '<line x1="50" y1="450" x2="850" y2="450"/>',
      '<line x1="50" y1="550" x2="850" y2="550"/>',
      '<line x1="50" y1="650" x2="850" y2="650"/>',
      '<line x1="50" y1="750" x2="850" y2="750"/>',
      '<line x1="50" y1="850" x2="850" y2="850"/>',
      '<line x1="50" y1="950" x2="850" y2="950"/>',
      '<line x1="50" y1="50" x2="50" y2="950"/>',
      '<line x1="150" y1="50" x2="150" y2="450"/>',
      '<line x1="150" y1="550" x2="150" y2="950"/>',
      '<line x1="250" y1="50" x2="250" y2="450"/>',
      '<line x1="250" y1="550" x2="250" y2="950"/>',
      '<line x1="350" y1="50" x2="350" y2="450"/>',
      '<line x1="350" y1="550" x2="350" y2="950"/>',
      '<line x1="450" y1="50" x2="450" y2="950"/>',
      '<line x1="550" y1="50" x2="550" y2="450"/>',
      '<line x1="550" y1="550" x2="550" y2="950"/>',
      '<line x1="650" y1="50" x2="650" y2="450"/>',
      '<line x1="650" y1="550" x2="650" y2="950"/>',
      '<line x1="750" y1="50" x2="750" y2="450"/>',
      '<line x1="750" y1="550" x2="750" y2="950"/>',
      '<line x1="850" y1="50" x2="850" y2="950"/>',
      '<line x1="350" y1="50" x2="550" y2="250"/>',
      '<line x1="550" y1="50" x2="350" y2="250"/>',
      '<line x1="350" y1="750" x2="550" y2="950"/>',
      '<line x1="550" y1="750" x2="350" y2="950"/>',
      "</g>",
      '<text x="450" y="515" text-anchor="middle" fill="#7a4d1f" font-size="42" font-family="KaiTi">楚 河　　　　汉 界</text>',
      "</svg>"
    ].join("");
    ui.board.appendChild(lineLayer);

    const gridLayer = document.createElement("div");
    gridLayer.className = "board-grid";

    for (let dy = 0; dy < 10; dy += 1) {
      for (let dx = 0; dx < 9; dx += 1) {
        const cell = document.createElement("div");
        cell.className = "board-cell";
        cell.style.left = `${(dx / 9) * 100}%`;
        cell.style.top = `${(dy / 10) * 100}%`;
        cell.style.width = `${100 / 9}%`;
        cell.style.height = `${100 / 10}%`;
        cell.dataset.dx = String(dx);
        cell.dataset.dy = String(dy);
        cell.addEventListener("click", onCellClick);
        gridLayer.appendChild(cell);
      }
    }

    ui.board.appendChild(gridLayer);
  }

  function canOperate() {
    return state.status === "playing" && state.turn === state.mySide;
  }

  function sleep(ms) {
    return new Promise((resolve) => setTimeout(resolve, ms));
  }

  function syncSoon() {
    const now = Date.now();
    if (state.refreshing) return;
    if (now - state.lastRefreshAt < 250) return;
    refreshStatus();
  }

  function onCellClick(e) {
    if (state.busy) return;
    if (!state.board || !canOperate()) {
      syncSoon();
      return;
    }

    const cell = e.currentTarget;
    const displayX = Number(cell.dataset.dx);
    const displayY = Number(cell.dataset.dy);
    const pos = toBoardCoord(displayX, displayY);
    const piece = state.board[pos.y][pos.x];

    if (!state.selected) {
      if (piece && piece.charAt(0) === state.mySide) {
        state.selected = { x: pos.x, y: pos.y };
        renderBoard();
      }
      return;
    }

    if (piece && piece.charAt(0) === state.mySide) {
      state.selected = { x: pos.x, y: pos.y };
      renderBoard();
      return;
    }

    makeMove(state.selected, { x: pos.x, y: pos.y });
  }

  function markCells() {
    const cells = ui.board.querySelectorAll(".board-cell");
    cells.forEach((cell) => {
      cell.classList.remove("selectable", "selected", "target");
      if (canOperate()) cell.classList.add("selectable");
    });

    if (!state.selected) return;
    const d = toDisplayCoord(state.selected.x, state.selected.y);
    const selector = `.board-cell[data-dx="${d.x}"][data-dy="${d.y}"]`;
    const selectedCell = ui.board.querySelector(selector);
    if (selectedCell) selectedCell.classList.add("selected");
  }

  function renderBoard() {
    drawBoardGrid();
    if (!state.board) return;

    const grid = ui.board.querySelector(".board-grid");
    for (let y = 0; y < 10; y += 1) {
      for (let x = 0; x < 9; x += 1) {
        const piece = state.board[y][x];
        if (!piece) continue;
        const d = toDisplayCoord(x, y);
        const selector = `.board-cell[data-dx="${d.x}"][data-dy="${d.y}"]`;
        const cell = grid.querySelector(selector);
        if (!cell) continue;

        const pieceNode = document.createElement("button");
        pieceNode.type = "button";
        pieceNode.className = `piece ${piece.charAt(0) === "r" ? "red" : "black"}`;
        pieceNode.textContent = pieceLabel(piece);
        if (piece.charAt(0) === state.mySide) pieceNode.classList.add("owned");
        if (state.selected && state.selected.x === x && state.selected.y === y) {
          pieceNode.classList.add("selected");
        }
        pieceNode.addEventListener("click", function (ev) {
          ev.stopPropagation();
          if (state.busy) return;
          if (!canOperate()) {
            syncSoon();
            return;
          }
          if (piece.charAt(0) === state.mySide) {
            state.selected = { x, y };
            renderBoard();
            return;
          }
          if (state.selected) {
            makeMove(state.selected, { x, y });
          }
        });
        cell.appendChild(pieceNode);
      }
    }
    markCells();
  }

  function applyGameState(data) {
    state.gameId = data.game_id || null;
    state.mySide = data.my_side || null;
    state.turn = data.turn || null;
    state.board = data.board || createInitialBoard();
    state.moveCount = Number(data.move_count || 0);
    state.opponent = data.opponent_name || "-";
    state.status = data.status === "playing" ? "playing" : data.status === "waiting" ? "waiting" : "idle";
    if (data.status === "finished") state.status = "idle";

    ui.opponentText.textContent = state.opponent;
    ui.mySideText.textContent = sideLabel(state.mySide);
    ui.turnText.textContent = sideLabel(state.turn);

    if (data.status === "finished") {
      if (data.winner_side) {
        const winText = data.winner_side === state.mySide ? "你赢了" : "你输了";
        ui.resultText.textContent = `${winText}（${data.finish_reason || "结束"}）`;
      } else {
        ui.resultText.textContent = "已结束";
      }
    } else {
      ui.resultText.textContent = "进行中";
    }

    if (state.status === "playing") {
      if (state.turn === state.mySide) {
        setStatus("已匹配成功，轮到你走棋。");
      } else {
        setStatus("已匹配成功，等待对手走棋。");
      }
    } else if (state.status === "waiting") {
      setStatus("已准备，正在等待另一位玩家...");
    } else {
      setStatus("点击“准备”开始匹配。");
    }

    updateButtons();
    renderBoard();

    if (state.status === "playing" && state.gameId) {
      ensureRealtimeWatcher();
    } else {
      stopRealtimeWatcher();
    }
  }

  async function refreshStatus() {
    if (state.refreshing) return;
    state.refreshing = true;
    state.lastRefreshAt = Date.now();
    try {
      const data = await api("status", {});
      if (data.mode === "matched") {
        applyGameState(data.game);
      } else if (data.mode === "waiting") {
        state.status = "waiting";
        if (!state.board) state.board = createInitialBoard();
        state.moveCount = 0;
        state.selected = null;
        setStatus("已准备，正在等待另一位玩家...");
        updateButtons();
        renderBoard();
        stopRealtimeWatcher();
      } else {
        state.status = "idle";
        state.gameId = null;
        state.turn = null;
        state.mySide = null;
        state.opponent = "-";
        state.board = createInitialBoard();
        state.moveCount = 0;
        state.selected = null;
        ui.opponentText.textContent = "-";
        ui.mySideText.textContent = "-";
        ui.turnText.textContent = "-";
        ui.resultText.textContent = "进行中";
        setStatus("点击“准备”开始匹配。");
        updateButtons();
        renderBoard();
        stopRealtimeWatcher();
      }
    } catch (err) {
      setStatus(`状态更新失败：${err.message}`);
    } finally {
      state.refreshing = false;
    }
  }

  function stopRealtimeWatcher() {
    state.watchActive = false;
  }

  async function ensureRealtimeWatcher() {
    if (state.watchActive) return;
    if (!(state.status === "playing" && state.gameId)) return;
    state.watchActive = true;
    const lockedGameId = state.gameId;

    while (state.watchActive && state.status === "playing" && state.gameId === lockedGameId) {
      try {
        const data = await api("wait_update", {
          game_id: state.gameId,
          known_move_count: state.moveCount,
          known_turn: state.turn,
          timeout_ms: WATCH_TIMEOUT_MS
        });
        if (data.changed && data.game) {
          applyGameState(data.game);
          continue;
        }
      } catch (err) {
        await sleep(500);
      }
    }
    state.watchActive = false;
  }

  async function makeMove(from, to) {
    if (!state.gameId) return;
    state.busy = true;
    try {
      const data = await api("move", {
        game_id: state.gameId,
        from_x: from.x,
        from_y: from.y,
        to_x: to.x,
        to_y: to.y
      });
      state.selected = null;
      applyGameState(data.game);
    } catch (err) {
      setStatus(`落子失败：${err.message}`);
      if (String(err.message || "").indexOf("还没轮到你走棋") !== -1) {
        syncSoon();
      }
      state.selected = null;
      renderBoard();
    } finally {
      state.busy = false;
    }
  }

  async function onReady() {
    try {
      const data = await api("ready", {});
      if (data.mode === "matched") {
        applyGameState(data.game);
      } else {
        state.status = "waiting";
        updateButtons();
        setStatus("匹配中，请稍候...");
      }
    } catch (err) {
      setStatus(`准备失败：${err.message}`);
    }
  }

  async function onCancelReady() {
    try {
      await api("cancel_ready", {});
      state.status = "idle";
      updateButtons();
      setStatus("已取消准备。");
    } catch (err) {
      setStatus(`取消失败：${err.message}`);
    }
  }

  async function onResign() {
    if (!state.gameId) return;
    if (!window.confirm("确认认输吗？")) return;
    try {
      const data = await api("resign", { game_id: state.gameId });
      applyGameState(data.game);
    } catch (err) {
      setStatus(`认输失败：${err.message}`);
    }
  }

  function startPolling() {
    if (state.pollTimer) clearInterval(state.pollTimer);
    state.pollTimer = setInterval(() => {
      if (state.status === "playing") return;
      refreshStatus();
    }, POLL_INTERVAL_MS);
  }

  ui.readyBtn.addEventListener("click", onReady);
  ui.cancelBtn.addEventListener("click", onCancelReady);
  ui.resignBtn.addEventListener("click", onResign);

  renderBoard();
  updateButtons();
  refreshStatus();
  startPolling();
})();
