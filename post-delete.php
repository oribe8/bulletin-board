<?php require 'header.php'; ?>
<?php
if(isset($_SESSION['user'])) {
    if(isset($_REQUEST['delete_flag'])) {
        $pdo = new PDO('mysql:host=localhost;dbname=keijiban;charset=utf8','staff2','password');
        $sql = $pdo->prepare('SELECT * FROM post WHERE post_id=?');
        $sql -> execute([$_REQUEST['delete_flag']]);
        foreach($sql as $row) {
            $post_user_id = $row['user_id'];
        }
        if($post_user_id == $_SESSION['user']['user_id']) {
            $pdo = new PDO('mysql:host=localhost;dbname=keijiban;charset=utf8','staff2','password');
            $sql = $pdo->prepare('UPDATE post SET delete_flag=1 WHERE post_id=? AND user_id=?');
            $sql -> execute([$_REQUEST['delete_flag'],$_SESSION['user']['user_id']]);
            $url = "'bulletin-board.php'";
            echo '<div class="delete-result">';
            echo '<p>削除完了しました。</p>';
            echo '<button onclick="location.href='.$url.'">掲示板へ</button>';
            echo '</div>';
        } else {
            $url = "'bulletin-board.php'";
            echo '<div class="delete-result">';
            echo '<p>別ユーザーの投稿のため、削除できません。</p>';
            echo '<button onclick="location.href='.$url.'">掲示板へ</button>';
            echo '</div>';
        }
    }
} else {
    $url = "'bulletin-board.php'";
    echo '<div class="delete-result">';
    echo '<p>無効な操作です。</p>';
    echo '<button onclick="location.href='.$url.'">掲示板へ</button>';
    echo '</div>';
}
?>
<?php require 'footer.php'; ?>