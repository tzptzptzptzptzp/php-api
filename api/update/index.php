<?php

include '../db.php';

// フォームからのデータを取得
$id = $_POST['id'];
$newUsername = $_POST['new_username'];
$newComment = $_POST['new_comment'];

// DB接続
try {
  $pdo = new PDO("mysql:host={$host};dbname={$dbname}", $user, $pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("データベースに接続できませんでした: " . $e->getMessage());
}

// 既存のデータを取得する
$sqlSelect = 'SELECT `username`, `comment` FROM `sample` WHERE `id` = ?';
$stmtSelect = $pdo->prepare($sqlSelect);
$stmtSelect->execute([$id]);
$existingData = $stmtSelect->fetch(PDO::FETCH_ASSOC);

// 入力がある場合は新しい値として使用し、入力がない場合は既存の値をそのまま使用する
$newUsername = !empty($newUsername) ? $newUsername : $existingData['username'];
$newComment = !empty($newComment) ? $newComment : $existingData['comment'];

// データの更新
$sqlUpdate = 'UPDATE `sample` SET `username` = ?, `comment` = ? WHERE `id` = ?';
$stmtUpdate = $pdo->prepare($sqlUpdate);
$result = $stmtUpdate->execute([$newUsername, $newComment, $id]);

// DBの接続を閉じる
$pdo = null;

// 更新結果の確認
if ($result) {
  echo "<p>データを更新しました。</p><a href='../../'>戻る</a>";
} else {
  echo "<p>データの更新に失敗しました。</p><a href='../../'>戻る</a>";
}

?>
