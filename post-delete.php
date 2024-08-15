<?php require 'header.php'; ?>
<?php
if(isset($_SESSION['user'])) { //userセッションにデータが存在する場合true
    if(isset($_REQUEST['delete_post_id'])) { //リクエストにdelete_post_idのデータが存在する場合true
        $pdo = new PDO('mysql:host=localhost;dbname=keijiban;charset=utf8','staff2','password');
        $sql = $pdo->prepare('SELECT * FROM post WHERE post_id=?'); //取得したdelete_post_idの値を元に、該当の投稿データを取得
        $sql -> execute([$_REQUEST['delete_post_id']]);
        foreach($sql as $row) {
            $post_user_id = $row['user_id']; //投稿データ内のuser_idを代入
        }
        if($post_user_id == $_SESSION['user']['user_id']) { //対象の投稿データ内のuser_idと、userセッション内のuser_idが合致すればtrue（=対象となる投稿を削除するユーザーが、その投稿自体を行ったユーザーと同一なのかどうかを見ている）
            $pdo = new PDO('mysql:host=localhost;dbname=keijiban;charset=utf8','staff2','password');
            $sql = $pdo->prepare('UPDATE post SET delete_flag=1 WHERE post_id=? AND user_id=?'); //リクエスト内のdelete_post_idと、userセッション内のuser_idに合致する投稿があれば、delete_flagを1に変更する
            $sql -> execute([$_REQUEST['delete_post_id'],$_SESSION['user']['user_id']]);
            $url = "'bulletin-board.php'"; //ボタンクリック時の遷移先
            echo '<div class="delete-result">';
            echo '<p>削除完了しました。</p>';
            echo '<button onclick="location.href='.$url.'">掲示板へ</button>';
            echo '</div>';
        } else {
            $url = "'bulletin-board.php'"; //ボタンクリック時の遷移先
            echo '<div class="delete-result">';
            echo '<p>別ユーザーの投稿のため、削除できません。</p>';
            echo '<button onclick="location.href='.$url.'">掲示板へ</button>';
            echo '</div>';
        }
    }
} else {
    $url = "'bulletin-board.php'"; //ボタンクリック時の遷移先
    echo '<div class="delete-result">';
    echo '<p>無効な操作です。</p>';
    echo '<button onclick="location.href='.$url.'">掲示板へ</button>';
    echo '</div>';
}
?>
<?php require 'footer.php'; ?>