<?php require 'header.php'; ?>
<h2>ログアウト画面</h2>
<?php
if(isset($_SESSION['user'])) { //userセッションにデータが存在している場合true
    //userセッションが存在している時の処理
    unset($_SESSION['user']); //userセッションのデータを削除
    $url = "'login.php'"; //ボタンクリック時の遷移先
    echo '<div class="logoutresult">';
    echo '<p>ログアウトしました。</p>';
    echo '<button onclick="location.href='.$url.'">ログイン画面へ</button>';
    echo '</div>';
} else {
    //userセッションが存在していなかった時の処理
    $url = "'login.php'"; //ボタンクリック時の遷移先
    echo '<div class="logoutresult">';
    echo '<p>ログアウト済みです。</p>';
    echo '<button onclick="location.href='.$url.'">ログイン画面へ</button>';
    echo '</div>';
}
?>
<?php require 'footer.php'; ?>