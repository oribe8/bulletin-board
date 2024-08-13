<?php require 'header.php'; ?>
<?php
if(isset($_REQUEST['content'])) {
    $pdo = new PDO('mysql:host=localhost;dbname=keijiban;charset=utf8','staff2','password');
    $sql = $pdo -> prepare('INSERT INTO post VALUES(null,?,?,NOW(),0)');
    $sql -> execute([$_REQUEST['user_id'],htmlspecialchars($_REQUEST['content'])]);
}

//postテーブルに投稿が存在するか確認
$pdo = new PDO('mysql:host=localhost;dbname=keijiban;charset=utf8','staff2','password');
$sql = $pdo -> query('SELECT * FROM post as t1 INNER JOIN hundle as t2 ON t1.user_id=t2.user_id');

//投稿、フォーム画面出力
if(isset($_SESSION['user'])) {
    if(!empty($sql->fetchAll())) {
        $pdo = new PDO('mysql:host=localhost;dbname=keijiban;charset=utf8','staff2','password');
        $sql = $pdo -> query('SELECT * FROM post as t1 INNER JOIN hundle as t2 ON t1.user_id=t2.user_id');
        foreach($sql as $row) {
            if($row['delete_flag'] == 0) {
                echo '<div class="board-post">';
                echo '<div class="board-top">';
                echo '<div class="board-top-id">'.$row['post_id'].'</div>';
                echo '<div class="board-top-name">'.$row['hundle_name'].'</div>';
                echo '<div class="board-top-date">'.$row['post_time'].'</div>';
                echo '</div>';
                echo '<div class="board-middle">';
                echo '<p>'.$row['post_content'].'</p>';
                echo '</div>';
                echo '<div class="board-bottom">';
                echo '<a href="post-delete.php?delete_flag='.$row['post_id'].'">削除</a>';
                echo '</div>';
                echo '</div>';
            } else {
                echo '<div class="board-post">';
                echo '<div class="board-top">';
                echo '<div class="board-top-id">'.$row['post_id'].'</div>';
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
    //フォーム画面出力
    echo '<div class="board-form">';
    echo '<form action="bulletin-board.php" method="post">';
    echo '<table>';
    echo '<tr>';
    echo '<th>名前</th>';
    echo '<td><input type="hidden" name="user_id" value="'.$_SESSION['user']['user_id'].'">'.$_SESSION['user']['hundle_name'].'</td>';
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
    $url = "'login.php'";
    echo '<div class="boardresult">';
    echo '<p>無効な操作です。</p>';
    echo '<button onclick="location.href='.$url.'">ログイン画面へ</button>';
    echo '</div>';
}
?>
<?php require 'footer.php'; ?>