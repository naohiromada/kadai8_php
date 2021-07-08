<?php
// 各ページ読み込み時にログインチェック
session_start(); // セッションの開始
include('functions.php'); // 関数ファイル読み込み
check_session_id(); // idチェック関数の実行

// 

// 関数ファイル読み込み
include("functions.php");
$pdo = connect_to_db();

// 送信されたidをgetで受け取る
$id = $_GET['id'];
// DB接続&id名でテーブルから検索

// var_dump($id);
// exit();

// idを指定して更新するSQLを作成 -> 実行の処理
$sql = 'DELETE FROM housing_support_table WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// var_dump($sql);
// exit();

// fetch()で1レコード取得できる．
if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    // 一覧画面にリダイレクト
    header('Location:Housing_support_read.php');
    exit();
}