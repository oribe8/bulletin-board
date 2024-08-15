<?php require 'header.php'; ?>
<h2>ログイン画面</h2>
<?php
$pdo = new PDO('mysql:host=localhost;dbname=keijiban;charset=utf8','staff2','password');
$sqlStr = 'SELECT t1.*,t2.hundle_name FROM user AS t1'; //「INNER JOIN ... ON」は内部結合の文章、userテーブルとhundleテーブルを連結させている
$sqlStr .= ' INNER JOIN hundle AS t2';
$sqlStr .= ' ON t1.user_id = t2.user_id';
$sqlStr .= ' WHERE t1.email = ? AND t1.password = ?'; //入力されたメアド、パスワードと合致するデータを取り出す
$sql = $pdo -> prepare($sqlStr);
$sql -> execute([htmlspecialchars($_REQUEST['email']),htmlspecialchars($_REQUEST['password'])]);
foreach ($sql as $row) { //$sqlにて実行結果が取得できていれば、userセッションにデータを登録していく
    $_SESSION['user'] = [
        'user_id' => $row['user_id'],
        'hundle_name' => $row['hundle_name'],
        'email' => $row['email'],
        'password' => $row['password']
    ];
}
if(isset($_SESSION['user'])) { //userセッションに値が代入されていて、nullでない場合にtrueになる
    $url = "'bulletin-board.php'"; //ボタンクリック時の遷移先
    echo '<div class="loginresult">';
    echo '<p>ログイン成功しました。</p>';
    echo '<p>こんにちは、'.$_SESSION['user']['hundle_name'].'さん。</p>';
    echo '<button onclick="location.href='.$url.'">掲示板へ</button>';
    echo '</div>';
} else {
    $url = "'login.php'"; //ボタンクリック時の遷移先
    echo '<div class="loginresult">';
    echo '<p>ログイン失敗しました。</p>';
    echo '<button onclick="location.href='.$url.'">ログイン画面へ</button>';
    echo '</div>';
}
?>
<?php require 'footer.php'; ?>