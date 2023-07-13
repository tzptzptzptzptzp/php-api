<?php

include '../db.php';

// フォームからのデータを取得
$username = $_POST['username'];
$comment = $_POST['comment'];
$postDate = date('Y-m-d H:i:s'); // 現在の日時

// DB接続
try {
  $pdo = new PDO("mysql:host={$host};dbname={$dbname}", $user, $pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("データベースに接続できませんでした: " . $e->getMessage());
}

// データを挿入するSQL文
$sqlInsert = 'INSERT INTO `sample` (`username`, `comment`, `postDate`) VALUES (?, ?, ?)';
$stmtInsert = $pdo->prepare($sqlInsert);
$result = $stmtInsert->execute([$username, $comment, $postDate]);

// DBの接続を閉じる
$pdo = null;

// 挿入結果の確認
if ($result) {
  echo "<p>データを作成しました。</p><a href='../../'>戻る</a>";
} else {
  echo "<p>データの作成に失敗しました。</p><a href='../../'>戻る</a>";
}

?>
