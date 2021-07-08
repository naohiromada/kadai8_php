<?php
// 各ページ読み込み時にログインチェック
session_start(); // セッションの開始
include('functions.php'); // 関数ファイル読み込み
check_session_id(); // idチェック関数の実行
// 呼び出し（Housing_support_create.php, Housing_support_read.php, など）
$pdo = connect_to_db(); // 関数実行

// DB接続情報
// $dbn = 'mysql:dbname=gsacf_d08_13;charset=utf8;port=3306;host=localhost';
// $user = 'root';
// $pwd = '';

// // DB接続
// try {
//     $pdo = new PDO($dbn, $user, $pwd);
// } catch (PDOException $e) {
//     echo json_encode(["db error" => "{$e->getMessage()}"]);
//     exit();
// }

// 参照はSELECT文！ -->
$sql = 'SELECT * FROM housing_support_table';
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//  <!--データを表示しやすいようにまとめる  -->
if ($status == false) {
    $error = $stmt->errorInfo();
    exit('sqlError:' . $error[2]);
} else {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $output = "";
    foreach ($result as $record) {
        $output .= "<tr>";
        $output .= "<td>{$record["id"]}</td>";        //  <!--id  --> 
        $output .= "<td>{$record["facility"]}</td>";  //  <!--施設名  -->
        $output .= "<td>{$record["Postal_code"]}</td>";      //  <!--郵便番号  -->
        $output .= "<td>{$record["Prefectures"]}</td>";      //  <!--都道府県  -->
        $output .= "<td>{$record["Addres_1"]}</td>";         //  <!--住所１  -->
        $output .= "<td>{$record["Addres_2"]}</td>";         //  <!--住所２  -->
        $output .= "<td>{$record["Addres_3"]}</td>";         //  <!--住所３  -->
        $output .= "<td>{$record["Tel_no"]}</td>";           //  <!--電話番号  -->
        $output .= "<td>{$record["Fax_no"]}</td>";           //  <!--FAX番号  -->
        // edit deleteリンクを追加
        $output .= "<td>
              <a href='Housing_support_edit.php?id={$record["id"]}'>edit</a>
              </td>";
        $output .= "<td>
              <a href='Housing_support_delete.php?id={$record["id"]}'>delete</a>
              </td>";
        // $output .= "</tr>";
        $output .= "</tr>";
    }
    // $recordの参照を解除する．解除しないと，再度foreachした場合に最初からループしない
    // 今回は以降foreachしないので影響なし
    unset($record);
}
// html部分にデータを追加 -->
// var_dump($sql);
// var_dump($stmt);
// var_dump($status);
// exit();
// $statusにSQLの実行結果が入る（取得したデータではない点に注意） -->


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>居住支援　福祉施設マスターF　登録リスト（一覧画面）</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <fieldset>
        <p>こんにちは<?= $_SESSION['username'] ?>さん</p>
        <legend>居住支援　福祉施設マスターF　登録リスト（一覧画面）</legend>

        <a href="Housing_support_input.php">入力画面</a>
        <a href="Housing_support_logout.php">logout</a>
        <table>
            <thead>
                <tr>
                    <th>id</th>
                    <th>施設名</th>
                    <th>郵便番号</th>
                    <th>都道府県</th>
                    <th>市区郡</th>
                    <th>町村</th>
                    <th>部落番地</th>
                    <th>電話番号</th>
                    <th>FAX番号</th>
                </tr>
            </thead>
            <tbody>
                <!-- ↓に<tr><td>deadline</td><td>todo</td><tr>の形でデータが入る -->
                <?= $output ?>
            </tbody>
        </table>
    </fieldset>
</body>

</html>