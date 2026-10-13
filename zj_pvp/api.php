<?php
require dirname(__DIR__) . '/zb_system/function/c_system_base.php';
$zbp->Load();

header('Content-Type: application/json; charset=utf-8');

function respond($ok, $data = array(), $status = 200)
{
    http_response_code($status);
    echo json_encode(array_merge(array('ok' => $ok), $data), JSON_UNESCAPED_UNICODE);
    exit;
}

function bind_stmt_params($stmt, $types, &$params)
{
    if ($types === '') {
        return true;
    }
    $refs = array();
    $refs[] = $types;
    foreach ($params as $k => &$v) {
        $refs[] = &$v;
    }
    return call_user_func_array(array($stmt, 'bind_param'), $refs);
}

function exec_stmt($db, $sql, $types = '', $params = array())
{
    $stmt = $db->prepare($sql);
    if (!$stmt) {
        return array(false, null, $db->error);
    }
    if ($types !== '') {
        bind_stmt_params($stmt, $types, $params);
    }
    if (!$stmt->execute()) {
        $err = $stmt->error;
        $stmt->close();
        return array(false, null, $err);
    }
    return array(true, $stmt, '');
}

function initial_board()
{
    return array(
        array('bR', 'bH', 'bE', 'bA', 'bK', 'bA', 'bE', 'bH', 'bR'),
        array('', '', '', '', '', '', '', '', ''),
        array('', 'bC', '', '', '', '', '', 'bC', ''),
        array('bP', '', 'bP', '', 'bP', '', 'bP', '', 'bP'),
        array('', '', '', '', '', '', '', '', ''),
        array('', '', '', '', '', '', '', '', ''),
        array('rP', '', 'rP', '', 'rP', '', 'rP', '', 'rP'),
        array('', 'rC', '', '', '', '', '', 'rC', ''),
        array('', '', '', '', '', '', '', '', ''),
        array('rR', 'rH', 'rE', 'rA', 'rK', 'rA', 'rE', 'rH', 'rR')
    );
}

function normalize_board($board)
{
    $new = array();
    for ($y = 0; $y < 10; $y++) {
        $row = array();
        for ($x = 0; $x < 9; $x++) {
            $v = '';
            if (is_array($board) && isset($board[$y]) && is_array($board[$y]) && isset($board[$y][$x])) {
                $v = (string)$board[$y][$x];
            }
            $row[] = $v;
        }
        $new[] = $row;
    }
    return $new;
}

function decode_board($json)
{
    $arr = json_decode($json, true);
    if (!is_array($arr)) {
        return initial_board();
    }
    return normalize_board($arr);
}

function inside($x, $y)
{
    return $x >= 0 && $x <= 8 && $y >= 0 && $y <= 9;
}

function is_side($piece, $side)
{
    return is_string($piece) && strlen($piece) >= 2 && $piece[0] === $side;
}

function other_side($side)
{
    return $side === 'r' ? 'b' : 'r';
}

function in_palace($side, $x, $y)
{
    if ($x < 3 || $x > 5) {
        return false;
    }
    if ($side === 'r') {
        return $y >= 7 && $y <= 9;
    }
    return $y >= 0 && $y <= 2;
}

function count_between_straight($board, $fx, $fy, $tx, $ty)
{
    if ($fx === $tx) {
        $step = $ty > $fy ? 1 : -1;
        $count = 0;
        for ($y = $fy + $step; $y !== $ty; $y += $step) {
            if ($board[$y][$fx] !== '') {
                $count++;
            }
        }
        return $count;
    }
    if ($fy === $ty) {
        $step = $tx > $fx ? 1 : -1;
        $count = 0;
        for ($x = $fx + $step; $x !== $tx; $x += $step) {
            if ($board[$fy][$x] !== '') {
                $count++;
            }
        }
        return $count;
    }
    return -1;
}

function kings_facing($board)
{
    $rk = null;
    $bk = null;
    for ($y = 0; $y < 10; $y++) {
        for ($x = 0; $x < 9; $x++) {
            if ($board[$y][$x] === 'rK') {
                $rk = array('x' => $x, 'y' => $y);
            } elseif ($board[$y][$x] === 'bK') {
                $bk = array('x' => $x, 'y' => $y);
            }
        }
    }
    if (!$rk || !$bk) {
        return false;
    }
    if ($rk['x'] !== $bk['x']) {
        return false;
    }
    $x = $rk['x'];
    $from = min($rk['y'], $bk['y']) + 1;
    $to = max($rk['y'], $bk['y']);
    for ($y = $from; $y < $to; $y++) {
        if ($board[$y][$x] !== '') {
            return false;
        }
    }
    return true;
}

function find_king($board, $side)
{
    $target = $side . 'K';
    for ($y = 0; $y < 10; $y++) {
        for ($x = 0; $x < 9; $x++) {
            if ($board[$y][$x] === $target) {
                return array('x' => $x, 'y' => $y);
            }
        }
    }
    return null;
}

function can_piece_move_basic($board, $piece, $fx, $fy, $tx, $ty, $capture)
{
    if (!inside($fx, $fy) || !inside($tx, $ty) || ($fx === $tx && $fy === $ty)) {
        return false;
    }

    $side = $piece[0];
    $type = $piece[1];
    $dx = $tx - $fx;
    $dy = $ty - $fy;
    $adx = abs($dx);
    $ady = abs($dy);
    $target = $board[$ty][$tx];

    switch ($type) {
        case 'R':
            if (!($fx === $tx || $fy === $ty)) {
                return false;
            }
            return count_between_straight($board, $fx, $fy, $tx, $ty) === 0;
        case 'H':
            if (!(($adx === 2 && $ady === 1) || ($adx === 1 && $ady === 2))) {
                return false;
            }
            if ($adx === 2) {
                $blockX = $fx + ($dx > 0 ? 1 : -1);
                $blockY = $fy;
            } else {
                $blockX = $fx;
                $blockY = $fy + ($dy > 0 ? 1 : -1);
            }
            return $board[$blockY][$blockX] === '';
        case 'E':
            if (!($adx === 2 && $ady === 2)) {
                return false;
            }
            if ($side === 'r' && $ty < 5) {
                return false;
            }
            if ($side === 'b' && $ty > 4) {
                return false;
            }
            return $board[$fy + ($dy / 2)][$fx + ($dx / 2)] === '';
        case 'A':
            if (!($adx === 1 && $ady === 1)) {
                return false;
            }
            return in_palace($side, $tx, $ty);
        case 'K':
            if ($capture && $target !== '' && $target[1] === 'K' && $fx === $tx) {
                return count_between_straight($board, $fx, $fy, $tx, $ty) === 0;
            }
            if (!(($adx === 1 && $ady === 0) || ($adx === 0 && $ady === 1))) {
                return false;
            }
            return in_palace($side, $tx, $ty);
        case 'C':
            if (!($fx === $tx || $fy === $ty)) {
                return false;
            }
            $between = count_between_straight($board, $fx, $fy, $tx, $ty);
            if ($between < 0) {
                return false;
            }
            if ($capture) {
                return $between === 1;
            }
            return $between === 0;
        case 'P':
            $forward = ($side === 'r') ? -1 : 1;
            if ($dx === 0 && $dy === $forward) {
                return true;
            }
            $crossed = ($side === 'r') ? ($fy <= 4) : ($fy >= 5);
            if ($crossed && $dy === 0 && $adx === 1) {
                return true;
            }
            return false;
        default:
            return false;
    }
}

function can_piece_attack_square($board, $piece, $fx, $fy, $tx, $ty)
{
    $target = $board[$ty][$tx];
    if ($target === '') {
        $board[$ty][$tx] = other_side($piece[0]) . 'X';
    }
    $ok = can_piece_move_basic($board, $piece, $fx, $fy, $tx, $ty, true);
    if ($target === '') {
        $board[$ty][$tx] = '';
    }
    return $ok;
}

function is_in_check($board, $side)
{
    $king = find_king($board, $side);
    if (!$king) {
        return true;
    }
    if (kings_facing($board)) {
        return true;
    }
    $opp = other_side($side);
    for ($y = 0; $y < 10; $y++) {
        for ($x = 0; $x < 9; $x++) {
            $piece = $board[$y][$x];
            if ($piece === '' || $piece[0] !== $opp) {
                continue;
            }
            if (can_piece_attack_square($board, $piece, $x, $y, $king['x'], $king['y'])) {
                return true;
            }
        }
    }
    return false;
}

function validate_and_apply_move($board, $side, $fx, $fy, $tx, $ty)
{
    if (!inside($fx, $fy) || !inside($tx, $ty)) {
        return array(false, '坐标越界', null, null);
    }
    if ($fx === $tx && $fy === $ty) {
        return array(false, '起点和终点不能相同', null, null);
    }

    $piece = $board[$fy][$fx];
    if ($piece === '' || $piece[0] !== $side) {
        return array(false, '请选择己方棋子', null, null);
    }
    $target = $board[$ty][$tx];
    if ($target !== '' && $target[0] === $side) {
        return array(false, '不能吃掉己方棋子', null, null);
    }

    $capture = $target !== '';
    if (!can_piece_move_basic($board, $piece, $fx, $fy, $tx, $ty, $capture)) {
        return array(false, '该走法不合法', null, null);
    }

    $next = $board;
    $next[$fy][$fx] = '';
    $next[$ty][$tx] = $piece;

    if (kings_facing($next)) {
        return array(false, '将帅不能照面', null, null);
    }

    if (is_in_check($next, $side)) {
        return array(false, '不能让己方将/帅处于被将军状态', null, null);
    }

    return array(true, '', $next, $target);
}

function game_payload($row, $uid)
{
    $mySide = ((int)$row['red_user_id'] === (int)$uid) ? 'r' : 'b';
    $opponentName = ($mySide === 'r') ? $row['black_name'] : $row['red_name'];
    $board = decode_board($row['board_json']);
    return array(
        'game_id' => (int)$row['id'],
        'status' => $row['status'],
        'my_side' => $mySide,
        'opponent_name' => (string)$opponentName,
        'turn' => $row['turn'],
        'winner_side' => $row['winner_side'],
        'winner_user_id' => $row['winner_user_id'] !== null ? (int)$row['winner_user_id'] : null,
        'finish_reason' => $row['finish_reason'],
        'move_count' => (int)$row['move_count'],
        'last_move' => $row['last_move_json'] ? json_decode($row['last_move_json'], true) : null,
        'board' => $board
    );
}

function fetch_active_game($db, $tableGames, $uid, $forUpdate)
{
    $sql = "SELECT * FROM `{$tableGames}` WHERE `status`='playing' AND (`red_user_id`=? OR `black_user_id`=?) ORDER BY `id` DESC LIMIT 1";
    if ($forUpdate) {
        $sql .= " FOR UPDATE";
    }
    $params = array($uid, $uid);
    list($ok, $stmt, $err) = exec_stmt($db, $sql, 'ii', $params);
    if (!$ok) {
        return array(false, $err, null);
    }
    $res = $stmt->get_result();
    $row = $res ? $res->fetch_assoc() : null;
    $stmt->close();
    return array(true, '', $row);
}

function fetch_game_for_user($db, $tableGames, $uid, $gameId, $forUpdate)
{
    $sql = "SELECT * FROM `{$tableGames}` WHERE `id`=? AND (`red_user_id`=? OR `black_user_id`=?) LIMIT 1";
    if ($forUpdate) {
        $sql .= " FOR UPDATE";
    }
    $params = array($gameId, $uid, $uid);
    list($ok, $stmt, $err) = exec_stmt($db, $sql, 'iii', $params);
    if (!$ok) {
        return array(false, $err, null);
    }
    $res = $stmt->get_result();
    $row = $res ? $res->fetch_assoc() : null;
    $stmt->close();
    return array(true, '', $row);
}

if (!isset($zbp->user) || (int)$zbp->user->ID <= 0) {
    respond(false, array('message' => '请先登录'), 401);
}

$uid = (int)$zbp->user->ID;
$uname = (string)$zbp->user->StaticName;

// Release PHP session lock early so long-poll requests won't block move requests
// from the same browser session.
if (function_exists('session_status') && session_status() === PHP_SESSION_ACTIVE) {
    @session_write_close();
}

$raw = file_get_contents('php://input');
$json = json_decode($raw, true);
$action = '';
$payload = array();
if (is_array($json)) {
    $action = isset($json['action']) ? (string)$json['action'] : '';
    $payload = isset($json['payload']) && is_array($json['payload']) ? $json['payload'] : array();
}

if ($action === '') {
    $action = isset($_POST['action']) ? (string)$_POST['action'] : '';
}
if ($action === '') {
    respond(false, array('message' => '缺少 action 参数'), 400);
}

$config = require dirname(__DIR__) . '/zb_users/c_option.php';
if (!isset($config['ZC_DATABASE_TYPE']) || $config['ZC_DATABASE_TYPE'] !== 'mysqli') {
    respond(false, array('message' => '当前仅支持 mysqli 数据库配置'), 500);
}

$db = @new mysqli(
    $config['ZC_MYSQL_SERVER'],
    $config['ZC_MYSQL_USERNAME'],
    $config['ZC_MYSQL_PASSWORD'],
    $config['ZC_MYSQL_NAME'],
    (int)$config['ZC_MYSQL_PORT']
);
if ($db->connect_errno) {
    respond(false, array('message' => '数据库连接失败: ' . $db->connect_error), 500);
}
$db->set_charset(isset($config['ZC_MYSQL_CHARSET']) ? $config['ZC_MYSQL_CHARSET'] : 'utf8mb4');

$prefix = isset($config['ZC_MYSQL_PRE']) ? $config['ZC_MYSQL_PRE'] : 'zbp_';
$tableQueue = $prefix . 'xq_ready_queue';
$tableGames = $prefix . 'xq_games';
$tableMoves = $prefix . 'xq_moves';

$sqlCreateQueue = "CREATE TABLE IF NOT EXISTS `{$tableQueue}` (
  `user_id` INT UNSIGNED NOT NULL,
  `nickname` VARCHAR(64) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  KEY `idx_updated_at` (`updated_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

$sqlCreateGames = "CREATE TABLE IF NOT EXISTS `{$tableGames}` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `red_user_id` INT UNSIGNED NOT NULL,
  `black_user_id` INT UNSIGNED NOT NULL,
  `red_name` VARCHAR(64) NOT NULL,
  `black_name` VARCHAR(64) NOT NULL,
  `board_json` MEDIUMTEXT NOT NULL,
  `turn` CHAR(1) NOT NULL DEFAULT 'r',
  `status` VARCHAR(16) NOT NULL DEFAULT 'playing',
  `winner_side` CHAR(1) DEFAULT NULL,
  `winner_user_id` INT UNSIGNED DEFAULT NULL,
  `finish_reason` VARCHAR(32) DEFAULT NULL,
  `move_count` INT UNSIGNED NOT NULL DEFAULT 0,
  `last_move_json` TEXT DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_red_uid` (`red_user_id`),
  KEY `idx_black_uid` (`black_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

$sqlCreateMoves = "CREATE TABLE IF NOT EXISTS `{$tableMoves}` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `game_id` BIGINT UNSIGNED NOT NULL,
  `move_no` INT UNSIGNED NOT NULL,
  `side` CHAR(1) NOT NULL,
  `from_x` TINYINT UNSIGNED NOT NULL,
  `from_y` TINYINT UNSIGNED NOT NULL,
  `to_x` TINYINT UNSIGNED NOT NULL,
  `to_y` TINYINT UNSIGNED NOT NULL,
  `piece` VARCHAR(4) NOT NULL,
  `captured` VARCHAR(4) DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_game_id` (`game_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if (!$db->query($sqlCreateQueue) || !$db->query($sqlCreateGames) || !$db->query($sqlCreateMoves)) {
    respond(false, array('message' => '初始化数据表失败: ' . $db->error), 500);
}

$db->query("DELETE FROM `{$tableQueue}` WHERE `updated_at` < DATE_SUB(NOW(), INTERVAL 5 MINUTE)");

try {
    if ($action === 'status') {
        list($ok, $err, $activeGame) = fetch_active_game($db, $tableGames, $uid, false);
        if (!$ok) {
            respond(false, array('message' => '获取状态失败: ' . $err), 500);
        }
        if ($activeGame) {
            respond(true, array(
                'mode' => 'matched',
                'game' => game_payload($activeGame, $uid)
            ));
        }

        $params = array($uid);
        list($ok2, $stmt2, $err2) = exec_stmt($db, "SELECT `user_id` FROM `{$tableQueue}` WHERE `user_id`=? LIMIT 1", 'i', $params);
        if (!$ok2) {
            respond(false, array('message' => '获取队列状态失败: ' . $err2), 500);
        }
        $resCheck = $stmt2->get_result();
        $inQueue = ($resCheck && $resCheck->fetch_assoc()) ? true : false;
        $stmt2->close();

        if ($inQueue) {
            respond(true, array('mode' => 'waiting'));
        }
        respond(true, array('mode' => 'idle'));
    }

    if ($action === 'wait_update') {
        $gameId = isset($payload['game_id']) ? (int)$payload['game_id'] : 0;
        $knownMoveCount = isset($payload['known_move_count']) ? (int)$payload['known_move_count'] : -1;
        $knownTurn = isset($payload['known_turn']) ? (string)$payload['known_turn'] : '';
        $timeoutMs = isset($payload['timeout_ms']) ? (int)$payload['timeout_ms'] : 10000;
        if ($timeoutMs < 1000) {
            $timeoutMs = 1000;
        }
        if ($timeoutMs > 15000) {
            $timeoutMs = 15000;
        }
        if ($gameId <= 0) {
            respond(false, array('message' => '缺少 game_id'), 400);
        }

        $deadline = microtime(true) + ($timeoutMs / 1000.0);
        while (true) {
            list($ok, $err, $gameRow) = fetch_game_for_user($db, $tableGames, $uid, $gameId, false);
            if (!$ok || !$gameRow) {
                respond(false, array('message' => '对局不存在或无权限'), 403);
            }

            $moveCount = (int)$gameRow['move_count'];
            $turn = (string)$gameRow['turn'];
            $isChanged = ($moveCount !== $knownMoveCount);
            if (!$isChanged && $knownTurn !== '' && $knownTurn !== $turn) {
                $isChanged = true;
            }
            if (!$isChanged && $gameRow['status'] !== 'playing') {
                $isChanged = true;
            }

            if ($isChanged) {
                respond(true, array(
                    'changed' => true,
                    'game' => game_payload($gameRow, $uid)
                ));
            }

            if (microtime(true) >= $deadline) {
                respond(true, array('changed' => false));
            }
            usleep(200000);
        }
    }

    if ($action === 'ready') {
        $db->begin_transaction();

        list($ok, $err, $activeGame) = fetch_active_game($db, $tableGames, $uid, true);
        if (!$ok) {
            $db->rollback();
            respond(false, array('message' => '匹配失败: ' . $err), 500);
        }
        if ($activeGame) {
            $db->commit();
            respond(true, array('mode' => 'matched', 'game' => game_payload($activeGame, $uid)));
        }

        $params = array($uid, $uname);
        list($ok1, $stmt1, $err1) = exec_stmt(
            $db,
            "INSERT INTO `{$tableQueue}` (`user_id`,`nickname`,`created_at`,`updated_at`) VALUES (?, ?, NOW(), NOW())
             ON DUPLICATE KEY UPDATE `nickname`=VALUES(`nickname`), `updated_at`=NOW()",
            'is',
            $params
        );
        if (!$ok1) {
            $db->rollback();
            respond(false, array('message' => '加入队列失败: ' . $err1), 500);
        }
        $stmt1->close();

        $params2 = array($uid);
        list($ok2, $stmt2, $err2) = exec_stmt(
            $db,
            "SELECT `user_id`,`nickname` FROM `{$tableQueue}` WHERE `user_id`<>? ORDER BY `created_at` ASC LIMIT 1 FOR UPDATE",
            'i',
            $params2
        );
        if (!$ok2) {
            $db->rollback();
            respond(false, array('message' => '匹配失败: ' . $err2), 500);
        }
        $res2 = $stmt2->get_result();
        $opponent = $res2 ? $res2->fetch_assoc() : null;
        $stmt2->close();

        if (!$opponent) {
            $db->commit();
            respond(true, array('mode' => 'waiting'));
        }

        $opUid = (int)$opponent['user_id'];
        $opName = (string)$opponent['nickname'];

        $redUid = $uid;
        $redName = $uname;
        $blackUid = $opUid;
        $blackName = $opName;
        if (random_int(0, 1) === 1) {
            $redUid = $opUid;
            $redName = $opName;
            $blackUid = $uid;
            $blackName = $uname;
        }

        $boardJson = json_encode(initial_board(), JSON_UNESCAPED_UNICODE);
        $params3 = array($redUid, $blackUid, $redName, $blackName, $boardJson);
        list($ok3, $stmt3, $err3) = exec_stmt(
            $db,
            "INSERT INTO `{$tableGames}` (`red_user_id`,`black_user_id`,`red_name`,`black_name`,`board_json`,`turn`,`status`,`move_count`,`created_at`,`updated_at`)
             VALUES (?, ?, ?, ?, ?, 'r', 'playing', 0, NOW(), NOW())",
            'iisss',
            $params3
        );
        if (!$ok3) {
            $db->rollback();
            respond(false, array('message' => '创建对局失败: ' . $err3), 500);
        }
        $gameId = (int)$db->insert_id;
        $stmt3->close();

        $params4 = array($uid, $opUid);
        list($ok4, $stmt4, $err4) = exec_stmt(
            $db,
            "DELETE FROM `{$tableQueue}` WHERE `user_id` IN (?, ?)",
            'ii',
            $params4
        );
        if (!$ok4) {
            $db->rollback();
            respond(false, array('message' => '清理队列失败: ' . $err4), 500);
        }
        $stmt4->close();

        $db->commit();

        list($ok5, $err5, $row5) = fetch_game_for_user($db, $tableGames, $uid, $gameId, false);
        if (!$ok5 || !$row5) {
            respond(false, array('message' => '读取新对局失败'), 500);
        }
        respond(true, array('mode' => 'matched', 'game' => game_payload($row5, $uid)));
    }

    if ($action === 'cancel_ready') {
        $params = array($uid);
        list($ok, $stmt, $err) = exec_stmt($db, "DELETE FROM `{$tableQueue}` WHERE `user_id`=?", 'i', $params);
        if (!$ok) {
            respond(false, array('message' => '取消准备失败: ' . $err), 500);
        }
        $stmt->close();
        respond(true, array('mode' => 'idle'));
    }

    if ($action === 'move') {
        $gameId = isset($payload['game_id']) ? (int)$payload['game_id'] : 0;
        $fx = isset($payload['from_x']) ? (int)$payload['from_x'] : -1;
        $fy = isset($payload['from_y']) ? (int)$payload['from_y'] : -1;
        $tx = isset($payload['to_x']) ? (int)$payload['to_x'] : -1;
        $ty = isset($payload['to_y']) ? (int)$payload['to_y'] : -1;
        if ($gameId <= 0) {
            respond(false, array('message' => '缺少 game_id'), 400);
        }

        $db->begin_transaction();
        list($ok, $err, $gameRow) = fetch_game_for_user($db, $tableGames, $uid, $gameId, true);
        if (!$ok || !$gameRow) {
            $db->rollback();
            respond(false, array('message' => '对局不存在或无权限'), 403);
        }
        if ($gameRow['status'] !== 'playing') {
            $db->rollback();
            respond(false, array('message' => '对局已结束'), 400);
        }

        $mySide = ((int)$gameRow['red_user_id'] === $uid) ? 'r' : 'b';
        if ($gameRow['turn'] !== $mySide) {
            $db->rollback();
            respond(false, array('message' => '还没轮到你走棋'), 400);
        }

        $board = decode_board($gameRow['board_json']);
        $piece = $board[$fy][$fx] ?? '';
        list($pass, $msg, $nextBoard, $captured) = validate_and_apply_move($board, $mySide, $fx, $fy, $tx, $ty);
        if (!$pass) {
            $db->rollback();
            respond(false, array('message' => $msg), 400);
        }

        $opp = other_side($mySide);
        $oppKing = find_king($nextBoard, $opp);
        $newStatus = 'playing';
        $winnerSide = null;
        $winnerUid = null;
        $finishReason = null;
        $newTurn = $opp;
        if (!$oppKing) {
            $newStatus = 'finished';
            $winnerSide = $mySide;
            $winnerUid = $uid;
            $finishReason = 'capture_king';
            $newTurn = $mySide;
        }

        $moveNo = ((int)$gameRow['move_count']) + 1;
        $lastMove = array(
            'move_no' => $moveNo,
            'side' => $mySide,
            'from_x' => $fx,
            'from_y' => $fy,
            'to_x' => $tx,
            'to_y' => $ty,
            'piece' => $piece,
            'captured' => $captured ? $captured : null
        );
        $nextJson = json_encode($nextBoard, JSON_UNESCAPED_UNICODE);
        $lastMoveJson = json_encode($lastMove, JSON_UNESCAPED_UNICODE);

        $paramsU = array(
            $nextJson,
            $newTurn,
            $newStatus,
            $winnerSide,
            $winnerUid,
            $finishReason,
            $moveNo,
            $lastMoveJson,
            $gameId
        );
        list($okU, $stmtU, $errU) = exec_stmt(
            $db,
            "UPDATE `{$tableGames}`
             SET `board_json`=?, `turn`=?, `status`=?, `winner_side`=?, `winner_user_id`=?, `finish_reason`=?, `move_count`=?, `last_move_json`=?, `updated_at`=NOW()
             WHERE `id`=?",
            'ssssisisi',
            $paramsU
        );
        if (!$okU) {
            $db->rollback();
            respond(false, array('message' => '更新对局失败: ' . $errU), 500);
        }
        $stmtU->close();

        $capturedVal = $captured ? $captured : null;
        $paramsM = array($gameId, $moveNo, $mySide, $fx, $fy, $tx, $ty, $piece, $capturedVal);
        list($okM, $stmtM, $errM) = exec_stmt(
            $db,
            "INSERT INTO `{$tableMoves}` (`game_id`,`move_no`,`side`,`from_x`,`from_y`,`to_x`,`to_y`,`piece`,`captured`,`created_at`)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())",
            'iisiiiiss',
            $paramsM
        );
        if (!$okM) {
            $db->rollback();
            respond(false, array('message' => '记录走子失败: ' . $errM), 500);
        }
        $stmtM->close();

        $db->commit();

        list($okG, $errG, $newGame) = fetch_game_for_user($db, $tableGames, $uid, $gameId, false);
        if (!$okG || !$newGame) {
            respond(false, array('message' => '读取新对局状态失败'), 500);
        }
        respond(true, array('game' => game_payload($newGame, $uid)));
    }

    if ($action === 'resign') {
        $gameId = isset($payload['game_id']) ? (int)$payload['game_id'] : 0;
        if ($gameId <= 0) {
            respond(false, array('message' => '缺少 game_id'), 400);
        }

        $db->begin_transaction();
        list($ok, $err, $gameRow) = fetch_game_for_user($db, $tableGames, $uid, $gameId, true);
        if (!$ok || !$gameRow) {
            $db->rollback();
            respond(false, array('message' => '对局不存在或无权限'), 403);
        }
        if ($gameRow['status'] !== 'playing') {
            $db->rollback();
            respond(false, array('message' => '对局已结束'), 400);
        }

        $mySide = ((int)$gameRow['red_user_id'] === $uid) ? 'r' : 'b';
        $winnerSide = other_side($mySide);
        $winnerUid = ((int)$gameRow['red_user_id'] === $uid) ? (int)$gameRow['black_user_id'] : (int)$gameRow['red_user_id'];

        $params = array($winnerSide, $winnerUid, $gameId);
        list($okU, $stmtU, $errU) = exec_stmt(
            $db,
            "UPDATE `{$tableGames}`
             SET `status`='finished', `winner_side`=?, `winner_user_id`=?, `finish_reason`='resign', `updated_at`=NOW()
             WHERE `id`=?",
            'sii',
            $params
        );
        if (!$okU) {
            $db->rollback();
            respond(false, array('message' => '认输失败: ' . $errU), 500);
        }
        $stmtU->close();
        $db->commit();

        list($okG, $errG, $newGame) = fetch_game_for_user($db, $tableGames, $uid, $gameId, false);
        if (!$okG || !$newGame) {
            respond(false, array('message' => '读取对局失败'), 500);
        }
        respond(true, array('game' => game_payload($newGame, $uid)));
    }

    respond(false, array('message' => '未知 action: ' . $action), 400);
} catch (Throwable $e) {
    @$db->rollback();
    respond(false, array('message' => '服务器异常: ' . $e->getMessage()), 500);
}
