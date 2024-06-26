<?php
session_start();

//エラーメッセージのリセット
$flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : [];
unset($_SESSION['flash']);

//データベース接続クラスのファイル読み込み
require('connect.php');

//クラスの生成
$class = new connector();
$dbh = $class->connect();

//モーダルウィンドウの非表示
$modal_display_style = "style='display:none'";

//post処理
if (isset($_POST['register'])) {
  $modal_display_style = "style='display:block'";
}

//表に出力するデータベースを取ってくるsql文の実行
$query = "SELECT *FROM ToDoList";
$stmt = $dbh->query($query);

//結果の取り出し
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

//エスケープ処理
function escape($s)
{
  return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

//接続終了
$dbh = null;
?>

<!DOCTYPE html>
<html lang="ja">

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
  <?php echo isset($flash['title']) ? $flash['title'] : null ?></br>
  <?php echo isset($flash['content']) ? $flash['content'] : null ?>
  <div class="width">
    <button type="button" id="addButton">
      追加
    </button>

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
            <td><?php echo escape($row['id']) ?></td>
            <td><?php echo escape($row['title']) ?></td>
            <td><?php echo escape($row['content']) ?></td>
            <td><?php echo escape($row['createdAt']) ?></td>
            <td><?php echo escape($row['updatedAt']) ?></td>
            <td>
              <div>
                <form method="post">
                  <a href="edit_page.php?id=<?php echo $row['id']; ?>" class="edit">編集</a></br>
                  <a href="delete_page.php?id=<?php echo $row['id']; ?>" class="delete">削除</a>
                </form>
              </div>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <!--追加モーダルウィンドウ-->
  <div id="addModal" class="addmodal">
    <div class="addmodal-content">

      <!-- ×表示 -->
      <button class="addclose">&times;</button>

      <!-- 入力フォーム -->
      <form method="post" action="add.php">
        <label for="title">タイトル</label><br>
        <input type="text" id="title" class="title" name="title" maxlength="30" placeholder="テキストを入力(３０文字未満)" required><br>
        <label for="content">内容</label><br>
        <textarea id="content" class="content" name="content" maxlength="65535" placeholder="テキストを入力(２００文字以内)" required></textarea><br>
        <button type="submit">登録</button>
      </form>
    </div>
  </div>
</body>

</html>