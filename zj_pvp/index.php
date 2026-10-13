<?php
require dirname(__DIR__) . '/zb_system/function/c_system_base.php';
$zbp->Load();

$isLogin = isset($zbp->user) && (int)$zbp->user->ID > 0;
$loginUrl = $zbp->host . 'zb_system/login.php?redirect=' . urlencode($zbp->host . 'zj_pvp/');
?>
<!doctype html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <title>在线中国象棋 PVP</title>
  <link rel="stylesheet" href="./style.css">
</head>
<body>
  <?php if (!$isLogin): ?>
    <main class="entry-wrap">
      <section class="entry-card">
        <h1>在线中国象棋 PVP</h1>
        <p>登录后即可进入实时匹配，两人在线对弈。</p>
        <div class="entry-actions">
          <a class="btn primary" href="<?php echo htmlspecialchars($loginUrl, ENT_QUOTES, 'UTF-8'); ?>">去登录</a>
          <a class="btn ghost" href="<?php echo htmlspecialchars($zbp->host, ENT_QUOTES, 'UTF-8'); ?>">返回首页</a>
        </div>
      </section>
    </main>
  <?php else: ?>
    <main class="immersive">
      <div class="bg-layer"></div>

      <section class="arena pure-ui">
        <div class="board-shell">
          <div class="overlay overlay-top">
            <div id="statusText" class="status">正在连接服务器...（<?php echo htmlspecialchars($zbp->user->StaticName, ENT_QUOTES, 'UTF-8'); ?>）</div>
            <div class="meta-row">
              <div class="meta-chip">对手 <strong id="opponentText">-</strong></div>
              <div class="meta-chip">我方 <strong id="mySideText">-</strong></div>
              <div class="meta-chip">回合 <strong id="turnText">-</strong></div>
              <div class="meta-chip">结果 <strong id="resultText">进行中</strong></div>
            </div>
          </div>

          <div class="board-stage">
            <div class="stage-title">对 局 战 场</div>
            <div id="board" class="board"></div>
          </div>

          <div class="overlay overlay-bottom">
            <div class="actions">
              <button id="readyBtn" class="btn primary">准备</button>
              <button id="cancelBtn" class="btn">取消准备</button>
              <button id="resignBtn" class="btn danger" disabled>认输</button>
            </div>
            <div class="tips">
              选中己方棋子后，再点击目标格落子。所有规则由服务器校验。
            </div>
          </div>
        </div>
      </section>
    </main>

    <script>
      window.XQ_PVP_BOOT = {
        api: './api.php',
        userId: <?php echo (int)$zbp->user->ID; ?>,
        userName: <?php echo json_encode($zbp->user->StaticName, JSON_UNESCAPED_UNICODE); ?>
      };
    </script>
    <script src="./app.js"></script>
  <?php endif; ?>
</body>
</html>
