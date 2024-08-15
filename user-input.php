<?php require 'header.php'; ?>
<?php
$hundle_name=$email=$password=''; //変数の作成と空の文字列代入を行う
if(!isset($_SESSION['user'])) { //userセッションにデータが存在しない場合trueになる
    echo '<h2>新規登録画面</h2>'; //trueの場合は新規登録画面
} else {
    echo '<h2>編集画面</h2>'; //falseの場合は編集画面
    $hundle_name= $_SESSION['user']['hundle_name'];
    $email = $_SESSION['user']['email'];
    $password = $_SESSION['user']['password'];
}
echo '<form action="user-output.php" method="post" id="userform">';
echo '<table>';
echo '<tr>';
echo '<th>ニックネーム</th>';
echo '<td><input type="text" name="hundle_name" value="'.$hundle_name.'"></td>'; //編集の場合、userセッションに登録されているニックネームを出力
echo '</tr>';
echo '<tr>';
echo '<th>メールアドレス</th>';
echo '<td><input type="email" name="email" value="'.$email.'"></td>'; //編集の場合、userセッションに登録されているメアドを出力
echo '</tr>';
echo '<tr>';
echo '<th>パスワード</th>';
echo '<td><input type="password" name="password" value="'.$password.'"></td>'; //編集の場合、userセッションに登録されているパスワードを出力
echo '</tr>';
echo '</table>';
echo '<input type="submit" value="送信">';
echo '</form>';
?>
<?php require 'footer.php'; ?>