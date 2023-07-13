<?php

include '../db.php';

// フォームからのデータを取得
$id = $_POST['id'];

// DB接続
try {
  $pdo = new PDO("mysql:host={$host};dbname={$dbname}", $user, $pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("データベースに接続できませんでした: " . $e->getMessage());
}

// データを削除するSQL文
$sqlDelete = 'DELETE FROM `sample` WHERE `id` = ?';
$stmtDelete = $pdo->prepare($sqlDelete);
$result = $stmtDelete->execute([$id]);

// DBの接続を閉じる
$pdo = null;

// 削除結果の確認
if ($result) {
  echo "<p>データを削除しました。</p><a href='../../'>戻る</a>";
} else {
  echo "<p>データの削除に失敗しました。</p><a href='../../'>戻る</a>";
}

?>
