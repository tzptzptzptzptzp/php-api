<?php

// 文字コード設定
header('Content-Type: application/json; charset=UTF-8');

include 'db.php';

// DB接続
try {
  $pdo = new PDO("mysql:host={$host};dbname={$dbname}", $user, $pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("データベースに接続できませんでした: " . $e->getMessage());
}

// DBからデータを取得する
$sql = 'SELECT `id`, `username`, `comment`, `postDate` FROM `sample`;';
$stmt = $pdo->query($sql);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// データが存在しない場合はエラーレスポンスを返す
if (!$data) {
  http_response_code(404);
  echo json_encode(['error' => 'データが見つかりません']);
  exit;
}

// DBの接続を閉じる
$pdo = null;

// JSONで出力する
echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>
