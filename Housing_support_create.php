<?php
// 各ページ読み込み時にログインチェック
session_start(); // セッションの開始
include('functions.php'); // 関数ファイル読み込み
check_session_id(); // idチェック関数の実行

// 
// データ受け取りのときにまずやること
// var_dump($_POST);
// exit();
// 解説


// POSTで送信された値は$_POSTで受け取る
// 入力チェック（未入力の場合は弾く，commentのみ任意）
if (
  !isset($_POST['facility']) || $_POST['facility'] == ''
  // !isset($_POST['Postal_code']) || $_POST['Postal_code'] == '' ||
  // !isset($_POST['Prefectures']) || $_POST['Prefectures'] == '' ||
  // !isset($_POST['Addres_1']) || $_POST['Addres_1'] == '' ||
  // !isset($_POST['Addres_2']) || $_POST['Addres_2'] == '' ||
  // !isset($_POST['Addres_3']) || $_POST['Addres_3'] == '' ||
  // !isset($_POST['Tel_no']) || $_POST['Tel_no'] == '' ||
  // !isset($_POST['Fax_no']) || $_POST['Fax_no'] == ''
) {
  exit('ParamError');
}
// 解説
// 「ParamError」が表示されたら，必須データが送られていないことがわかる


// データを変数に格納
$facility = $_POST['facility'];
$Postal_code = $_POST['Postal_code'];
$Prefectures = $_POST['Prefectures'];
$Addres_1 = $_POST['Addres_1'];
$Addres_2 = $_POST['Addres_2'];
$Addres_3 = $_POST['Addres_3'];
$Tel_no = $_POST['Tel_no'];
$Fax_no = $_POST['Fax_no'];
// 
// var_dump($facility);
// var_dump($Postal_code);
// var_dump($Prefectures);
// var_dump($Addres_1);
// var_dump($Addres_2);
// var_dump($Addres_3);
// var_dump($Tel_no);
// var_dump($Fax_no);
// exit();

// DB接続情報
$dbn = 'mysql:dbname=gsacf_d08_13;charset=utf8;port=3306;host=localhost';
$user = 'root';
$pwd = '';

// var_dump($dbn);
// var_dump($user);
// var_dump($pwd);
// exit();


// DB接続
try {
  $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}

// var_dump($pdo);
// exit();

// SQL作成&実行
$sql = 'INSERT INTO 
housing_support_table(id, facility, Postal_code, Prefectures, Addres_1, Addres_2, Addres_3, Tel_no, Fax_no) 
VALUES(NULL, :facility, :Postal_code, :Prefectures, :Addres_1, :Addres_2, :Addres_3, :Tel_no, :Fax_no)';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':facility', $facility, PDO::PARAM_STR);
$stmt->bindValue(':Postal_code', $Postal_code, PDO::PARAM_STR);
$stmt->bindValue(':Prefectures', $Prefectures, PDO::PARAM_STR);
$stmt->bindValue(':Addres_1', $Addres_1, PDO::PARAM_STR);
$stmt->bindValue(':Addres_2', $Addres_2, PDO::PARAM_STR);
$stmt->bindValue(':Addres_3', $Addres_3, PDO::PARAM_STR);
$stmt->bindValue(':Tel_no', $Tel_no, PDO::PARAM_STR);
$stmt->bindValue(':Fax_no', $Fax_no, PDO::PARAM_STR);
$status = $stmt->execute(); // SQLを実行

// var_dump($stmt);
// exit();

// 失敗時にエラーを出力し，成功時は登録画面に戻る
if ($status == false) {
  $error = $stmt->errorInfo();
  // データ登録失敗次にエラーを表示
  exit('sqlError:' . $error[2]);
} else {
  // 登録ページへ移動
  header('Location:Housing_support_input.php');
}