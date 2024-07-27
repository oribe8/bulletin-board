<?php require 'header.php'; ?>
<h2>ログイン画面</h2>
<?php
$pdo = new PDO('mysql:host=localhost;dbname=keijiban;charset=utf8','staff2','password');
$sqlStr = 'SELECT t1.*,t2.hundle_name FROM user AS t1';
$sqlStr .= ' INNER JOIN hundle AS t2';
$sqlStr .= ' ON t1.user_id = t2.user_id';
$sqlStr .= ' WHERE t1.email = ? AND t1.password = ?';
$sql = $pdo -> prepare($sqlStr);
$sql -> execute([$_REQUEST['email'],$_REQUEST['password']]);
foreach ($sql as $row) {
    $_SESSION['user'] = [
        'user_id' => $row['user_id'],
        'hundle_name' => $row['hundle_name'],
        'email' => $row['email'],
        'password' => $row['password']
    ];
}
if(isset($_SESSION['user'])) {
    $url = "'bulletin-board.php'";
    echo '<div class="loginresult">';
    echo '<p>ログイン成功しました。</p>';
    echo '<p>こんにちは、'.$_SESSION['user']['hundle_name'].'さん。</p>';
    echo '<button onclick="location.href='.$url.'">掲示板へ</button>';
    echo '</div>';
} else {
    $url = "'login.php'";
    echo '<div class="loginresult">';
    echo '<p>ログイン失敗しました。</p>';
    echo '<button onclick="location.href='.$url.'">ログイン画面へ</button>';
    echo '</div>';
}
?>
<?php require 'footer.php'; ?>