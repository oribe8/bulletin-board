<?php require 'header.php'; ?>
<?php
$pdo = new PDO('mysql:host=localhost;dbname=keijiban;charset=utf8','staff2','password');

//ログインIDに重複がないか確認
if(isset($_SESSION['user'])) {
    $id = $_SESSION['user']['user_id'];
    $sql = $pdo -> prepare('SELECT * FROM user AS t1 INNER JOIN hundle AS t2 ON t1.user_id = t2.user_id WHERE t1.user_id!=? AND t2.hundle_name=?');
    $sql -> execute([$id,$_REQUEST['hundle_name']]);
} else {
    $sql = $pdo -> prepare('SELECT * FROM hundle WHERE hundle_name=?');
    $sql -> execute([$_REQUEST['hundle_name']]);
}
if(empty($sql->fetchAll())) {
    if(isset($_SESSION['user'])) {
        $sql = $pdo->prepare('UPDATE user SET email = ?,password = ? WHERE user_id=?');
        $sql -> execute([$_REQUEST['email'],$_REQUEST['password'],$id]);
        foreach($sql as $row) {
            $_SESSION['user'] = [
                'email' => $row['email'],
                'password' => $row['password']
            ];
        }
        $sql = $pdo->prepare('UPDATE hundle SET hundle_name =? WHERE user_id=?');
        $sql -> execute([$_REQUEST['hundle_name'],$id]);
        foreach($sql as $row) {
            $_SESSION['user'] = [
                'hundle_name' => $row['hundle_name']
            ];
        }
        echo '<div class="userresult">';
        echo '<p>更新完了しました。</p>';
        echo '<button>掲示板へ</button>';
        echo '</div>';
    } else {
        $url = "'login.php'";
        $sql = $pdo->prepare('INSERT INTO user VALUES(null,?,?)');
        $sql -> execute([$_REQUEST['email'],$_REQUEST['password']]);
        $sql = $pdo->prepare('INSERT INTO hundle VALUES(null,?)');
        $sql -> execute([$_REQUEST['hundle_name']]);
        echo '<div class="userresult">';
        echo '<p>新規登録完了しました。</p>';
        echo '<p>ログインをお願いします。</p>';
        echo '<button onclick="location.href='.$url.'">ログイン画面へ</button>';
        echo '</div>';
    }
} else {
    $url = "'user-input.php'";
    echo '<div class="userresult">';
    echo '<p>ログインIDが重複しています。</p>';
    echo '<button onclick="location.href='.$url.'">前の画面へ</button>';
    echo '</div>';
}
?>
<?php require 'footer.php'; ?>