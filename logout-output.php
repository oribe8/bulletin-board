<?php require 'header.php'; ?>
<h2>ログアウト画面</h2>
<?php
if(isset($_SESSION['user'])) {
    unset($_SESSION['user']);
    $url = "'login.php'";
    echo '<div class="logoutresult">';
    echo '<p>ログアウトしました。</p>';
    echo '<button onclick="location.href='.$url.'">ログイン画面へ</button>';
    echo '</div>';
} else {
    $url = "'login.php'";
    echo '<div class="logoutresult">';
    echo '<p>ログアウト済みです。</p>';
    echo '<button onclick="location.href='.$url.'">ログイン画面へ</button>';
    echo '</div>';
}
?>
<?php require 'footer.php'; ?>