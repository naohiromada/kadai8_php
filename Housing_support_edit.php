<?php
// 各ページ読み込み時にログインチェック
session_start(); // セッションの開始
include('functions.php'); // 関数ファイル読み込み
check_session_id(); // idチェック関数の実行


// 送信されたidをgetで受け取る
$id = $_GET['id'];
// DB接続&id名でテーブルから検索

// var_dump($id);
// exit();

$pdo = connect_to_db();
$sql = 'SELECT * FROM housing_support_table WHERE id=:id';
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
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>
<!--  -->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DB連携型todoリスト（編集画面）</title>
    <link rel="stylesheet" href="css/style-auberge.css">

</head>

<body>
    <div class="contents">
        <div class="contents-container">
            <form action="Housing_support_update.php" method="POST">
                <fieldset>
                    <legend>居住支援　福祉施設マスターF（編集画面）</legend>
                    <p>こんにちは<?= $_SESSION['username'] ?>さん</p>
                    <a href="Housing_support_read.php">一覧画面</a>
                    <a href="Housing_support_logout.php">logout</a>
                    <!--施設名  -->
                    <li>
                        <label for="facility" class="textfield_label">施設名</label>
                        <input type="text" name="facility" value="<?= $record["facility"]
                                                                    ?>">
                    </li>
                    <!--郵便番号  -->
                    <li>
                        <label for="Postal_code" class="textfield_label">郵便番号</label>
                        <input type="text" name="Postal_code" value="<?= $record["Postal_code"]
                                                                        ?>">
                    </li>
                    <!--都道府県  -->
                    <li>
                        <label for="Prefectures" class="textfield_label">都道府県</label>
                        <input type="text" name="Prefectures" value="<?= $record["Prefectures"]
                                                                        ?>">
                    </li>
                    <!--住所１  -->
                    <li>
                        <label for="Addres_1" class="textfield_label">市区郡</label>
                        <input type="text" name="Addres_1" value="<?= $record["Addres_1"]
                                                                    ?>">
                    </li>
                    <!--住所２  -->
                    <li>
                        <label for="Addres_2" class="textfield_label">町村</label>
                        <input type="text" name="Addres_2" value="<?= $record["Addres_2"]
                                                                    ?>">
                    </li>
                    <!--住所３  -->
                    <li>
                        <label for="Addres_3" class="textfield_label">部落番地</label>
                        <input type="text" name="Addres_3" value="<?= $record["Addres_3"]
                                                                    ?>">
                    </li>
                    <!--電話番号  -->
                    <li>
                        <label for="Tel_no" class="textfield_label">電話番号</label>
                        <input type="text" name="Tel_no" value="<?= $record["Tel_no"]
                                                                ?>">
                    </li>
                    <!--FAX番号  -->
                    <li>
                        <label for="Fax_no" class="textfield_label">FAX番号</label>
                        <input type="text" name="Fax_no" value="<?= $record["Fax_no"]
                                                                ?>">
                    </li>
                    <!-- // idを見えないように送る
                         // input type="hidden"を使用する！
                         // form内に以下を追加 -->
                    <input type="hidden" name="id" value="<?= $record['id'] ?>">
                    <div>
                        <button>更新</button>
                    </div>
                </fieldset>
            </form>
            <footer>
                <div class="footer-container">
                    <p>©G's 福岡dev8 課題8 naohiro.mada</p>
                </div>
            </footer>
        </div>
    </div>
</body>

</html>