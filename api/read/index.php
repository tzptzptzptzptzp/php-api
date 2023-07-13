<?php

// 文字コード設定
header('Content-Type: application/json; charset=UTF-8');

include '../db.php';

// IDを取得
$id = $_GET['id'];

// DB接続
try {
  $pdo = new PDO("mysql:host={$host};dbname={$dbname}", $user, $pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("データベースに接続できませんでした: " . $e->getMessage());
}

// DBからデータを取得する
$sqlRead = 'SELECT `id`, `username`, `comment`, `postDate` FROM `sample` WHERE `id` = :id';
$stmtRead = $pdo->prepare($sqlRead);
$stmtRead->bindParam(':id', $id);
$stmtRead->execute();
$data = $stmtRead->fetch(PDO::FETCH_ASSOC);

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
