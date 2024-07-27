<?php require 'header.php'; ?>
<?php
// セッション情報削除
unset($_SESSION['user']);
?>
<h2>ログイン画面</h2>
<form action="login-output.php" method="post" id="loginform">
    <table>
        <tr>
            <th>メールアドレス</th>
            <td><input type="email" name="email"></td>
        </tr>
        <tr>
            <th>パスワード</th>
            <td><input type="password" name="password"></td>
        </tr>
    </table>
    <input type="submit" value="送信">
</form>
<?php require 'footer.php'; ?>