<?php

// 関数ファイル読み込み
include("functions.php");
$pdo = connect_to_db();

// 各値をpostで受け取る
$id = $_POST['id'];

// var_dump($id);
// exit();

$facility = $_POST['facility'];
$Postal_code = $_POST['Postal_code'];
$Prefectures = $_POST['Prefectures'];
$Addres_1 = $_POST['Addres_1'];
$Addres_2 = $_POST['Addres_2'];
$Addres_3 = $_POST['Addres_3'];
$Tel_no = $_POST['Tel_no'];
$Fax_no = $_POST['Fax_no'];

// var_dump($id);
// var_dump($todo);
// var_dump($deadline);
// exit();

// idを指定して更新するSQLを作成（UPDATE文）
$sql = "UPDATE housing_support_table SET facility=:facility, Postal_code=:Postal_code,Prefectures=:Prefectures,Addres_1=:Addres_1,Addres_2=:Addres_2,Addres_3=:Addres_3,Tel_no=:Tel_no,Fax_no=:Fax_no 
  WHERE id=:id";

// var_dump($sql);
// exit();


// $sql = 'UPDATE 
// housing_support_table(id, facility, Postal_code, Prefectures, Addres_1, Addres_2, Addres_3, Tel_no, Fax_no) 
// VALUES(NULL, :facility, :Postal_code, :Prefectures, :Addres_1, :Addres_2, :Addres_3, :Tel_no, :Fax_no)';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':facility', $facility, PDO::PARAM_STR);
$stmt->bindValue(':Postal_code', $Postal_code, PDO::PARAM_STR);
$stmt->bindValue(':Prefectures', $Prefectures, PDO::PARAM_STR);
$stmt->bindValue(':Addres_1', $Addres_1, PDO::PARAM_STR);
$stmt->bindValue(':Addres_2', $Addres_2, PDO::PARAM_STR);
$stmt->bindValue(':Addres_3', $Addres_3, PDO::PARAM_STR);
$stmt->bindValue(':Tel_no', $Tel_no, PDO::PARAM_STR);
$stmt->bindValue(':Fax_no', $Fax_no, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute(); // SQLを実行

// SQL
// 各値をpostで受け取る
if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    // 正常に実行された場合は一覧ページファイルに移動し，処理を実行する
    header("Location:Housing_support_read.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> データUPDATE中！</title>
</head>

<body>
    データUPDATE中！
</body>

</html>