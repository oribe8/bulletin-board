<?php require 'header.php'; ?>
<?php
//投稿用フォームから投稿が送信された場合の処理
if(isset($_REQUEST['content'])) { //リクエストにcontentの内容が存在する場合true
    $pdo = new PDO('mysql:host=localhost;dbname=keijiban;charset=utf8','staff2','password');
    $sql = $pdo -> prepare('INSERT INTO post VALUES(null,?,?,NOW(),0)'); //postテーブルに、「user_id」「投稿内容」「投稿日時」「0（削除判定フラグ用）」を追加
    $sql -> execute([$_REQUEST['user_id'],htmlspecialchars($_REQUEST['content'])]);
}

//postテーブルに投稿が存在するか確認
$pdo = new PDO('mysql:host=localhost;dbname=keijiban;charset=utf8','staff2','password');
$sql = $pdo -> query('SELECT * FROM post as t1 INNER JOIN hundle as t2 ON t1.user_id=t2.user_id'); //postテーブルとhundleテーブルを連結

//投稿一覧、投稿用フォーム出力
if(isset($_SESSION['user'])) { //userセッションにデータが存在する場合true
    if(!empty($sql->fetchAll())) { //fetchAllでSQLの結果を全て受け取る、今回の場合、$sqlにて実行結果が取得できていればtrueになる（＝投稿が存在している）
        $pdo = new PDO('mysql:host=localhost;dbname=keijiban;charset=utf8','staff2','password');
        $sql = $pdo -> query('SELECT * FROM post as t1 INNER JOIN hundle as t2 ON t1.user_id=t2.user_id'); //postテーブルとhundleテーブルを連結させる
        //投稿一覧出力
        foreach($sql as $row) {
            if($row['delete_flag'] == 0) { //投稿内のdelete_flagが0の場合true
                //投稿内のdelete_flagが0の時の処理（＝削除されていない投稿の場合）
                echo '<div class="board-post">';
                echo '<div class="board-top">';
                echo '<div class="board-top-id">'.$row['post_id'].'</div>'; //postテーブル内のpost_idを出力
                echo '<div class="board-top-name">'.$row['hundle_name'].'</div>'; //hundleテーブル内のニックネームを出力
                echo '<div class="board-top-date">'.$row['post_time'].'</div>'; //postテーブル内の投稿日時を出力
                echo '</div>';
                echo '<div class="board-middle">';
                echo '<p>'.$row['post_content'].'</p>'; //postテーブル内の投稿内容を出力
                echo '</div>';
                echo '<div class="board-bottom">';
                echo '<a href="post-delete.php?delete_post_id='.$row['post_id'].'">削除</a>'; //postテーブル内のpost_idを出力、このリンクを押すとdelete_post_idのパラメータ付きリクエストが送信される
                echo '</div>';
                echo '</div>';
            } else {
                //投稿内のdelete_flagが1の時の処理（＝削除された投稿の場合）
                echo '<div class="board-post">';
                echo '<div class="board-top">';
                echo '<div class="board-top-id">'.$row['post_id'].'</div>'; //postテーブル内のpost_idを出力
                echo '<div class="board-top-name"></div>';
                echo '<div class="board-top-date"></div>';
                echo '</div>';
                echo '<div class="board-middle">';
                echo '<p>削除されました</p>';
                echo '</div>';
                echo '<div class="board-bottom">';
                echo '</div>';
                echo '</div>';
            }
        }
    }
    //投稿用フォーム出力
    echo '<div class="board-form">';
    echo '<form action="bulletin-board.php" method="post">';
    echo '<table>';
    echo '<tr>';
    echo '<th>名前</th>';
    echo '<td><input type="hidden" name="user_id" value="'.$_SESSION['user']['user_id'].'">'.$_SESSION['user']['hundle_name'].'</td>'; //userセッション内のid、ニックネームを出力
    echo '</tr>';
    echo '<tr>';
    echo '<th>内容</th>';
    echo '<td><textarea name="content"></textarea></td>';
    echo '</tr>';
    echo '</table>';
    echo '<input type="submit" value="送信">';
    echo '</form>';
    echo '</div>';
} else {
    $url = "'login.php'"; //ボタンクリック時の遷移先
    echo '<div class="boardresult">';
    echo '<p>無効な操作です。</p>';
    echo '<button onclick="location.href='.$url.'">ログイン画面へ</button>';
    echo '</div>';
}
?>
<?php require 'footer.php'; ?>