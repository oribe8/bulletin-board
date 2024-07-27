<?php require 'header.php'; ?>
<?php
$hundle_name=$email=$password='';
if(!isset($_SESSION['user'])) {
    echo '<h2>新規登録画面</h2>';
} else {
    echo '<h2>編集画面</h2>';
    $hundle_name= $_SESSION['user']['hundle_name'];
    $email = $_SESSION['user']['email'];
    $password = $_SESSION['user']['password'];
}
echo '<form action="user-output.php" method="post" id="userform">';
echo '<table>';
echo '<tr>';
echo '<th>ニックネーム</th>';
echo '<td><input type="text" name="hundle_name" value="'.$hundle_name.'"></td>';
echo '</tr>';
echo '<tr>';
echo '<th>メールアドレス</th>';
echo '<td><input type="email" name="email" value="'.$email.'"></td>';
echo '</tr>';
echo '<tr>';
echo '<th>パスワード</th>';
echo '<td><input type="password" name="password" value="'.$password.'"></td>';
echo '</tr>';
echo '</table>';
echo '<input type="submit" value="送信">';
echo '</form>';
?>
<?php require 'footer.php'; ?>