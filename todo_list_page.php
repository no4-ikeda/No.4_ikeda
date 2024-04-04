<?php

//データベース接続を読み込む
require('connect.php');
$modal_display_style = "style='display:none'";

//post処理
if (isset($_POST['register'])) {
    $modal_display_style = "style='display:block'";
}

//sql文実行
$sql = "SELECT *FROM ToDoList";
$stmt = $dbh->query($sql);

//結果の取り出し
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

//接続終了
$dbh = null;
?>

<!DOCTYPE html>
<html land="ja">

<head>
    <meta charset="UTF-8">
    <title>To Do List</title>

    <!--CSSの読み込み-->
    <link rel="stylesheet" href="style.css">

    <!--JavaScriptの読み込み-->
    <script src="modal.js"></script>
</head>

<body>
    <div>
        <h1>ToDoリスト</h1>
    </div>
    <div id="addButton">
        <button type="button">
            追加
        </button>
    </div>
    <table>
        <thead class="header">
            <tr>
                <th id="num">番号</th>
                <th id="title">タイトル</th>
                <th id="content">内容</th>
                <th id="create">作成日</th>
                <th id="edit">更新日</th>
                <th id="btn"></th>
            </tr>
        </thead>

        <!--データベース表-->
        <tbody>
            <?php
            foreach ($result as $row) {
            ?>
                <tr>
                    <td><?php echo $row['id'] ?></td>
                    <td><?php echo $row['title'] ?></td>
                    <td><?php echo $row['todo'] ?></td>
                    <td><?php echo $row['cre'] ?></td>
                    <td><?php echo $row['upd'] ?></td>
                    <td>
                        <div>
                            <form method="post">
                                <a href="edit_page.php?id=<?php echo $row['id']; ?>">編集</a>
                                <a href="delete.php?id=<?php echo $row['id']; ?>">削除</a>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!--追加モーダルウィンドウ-->
    <div id="addModal" class="addmodal">
        <div class="addmodal-content">

            <!-- ×表示 -->
            <button class="addclose">&times;</button>

            <!-- 入力フォーム -->
            <form method="post" action="add.php">
                <label for="title">タイトル</label><br>
                <input type="text" id="title" class="text" name="title" placeholder="テキストを入力" required><br>
                <label for="text">内容</label><br>
                <textarea id="text" name="text" placeholder="テキストを入力" required></textarea><br>
                <button type="submit" value="登録">登録</button>
            </form>
        </div>
    </div>
</body>

</html>

<!-- //編集モーダルウィンドウ
<div id="cntModal" class="cntmodal">
    <div class="cntmodal-content">
        //×表示 
        <span class="cntclose">&times;</span>
        //入力フォーム
        <form method="post" action="continue.php">
            <label for="title">タイトル</label><br>
            <input type="text" id="title" class="text" name="title" placeholder="テキストを入力" required><br>
            <label for="text">内容</label><br>
            <textarea id="text" name="text" placeholder="テキストを入力" required></textarea><br>
            <button type="submit" value="登録">登録</button>
        </form>
    </div>   
</div> -->