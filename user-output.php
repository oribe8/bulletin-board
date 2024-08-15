<?php require 'header.php'; ?>
<?php
$pdo = new PDO('mysql:host=localhost;dbname=keijiban;charset=utf8','staff2','password');

//入力されたログインIDに重複がないか確認、$sqlにて実行結果が取得されていれば重複ありと判断
if(isset($_SESSION['user'])) { //userセッションにデータが存在している場合trueになる
    //編集画面用の処理
    $id = $_SESSION['user']['user_id']; //$idにuserセッション内のuser_idを代入
    $sql = $pdo -> prepare('SELECT * FROM user AS t1 INNER JOIN hundle AS t2 ON t1.user_id = t2.user_id WHERE t1.user_id!=? AND t2.hundle_name=?'); //userテーブルとhundleテーブルを連結し、「入力されたuser_id以外で、かつ入力されたニックネーム」に該当するデータを検索
    $sql -> execute([$id,htmlspecialchars($_REQUEST['hundle_name'])]);
} else {
    //新規画面用の処理
    $sql = $pdo -> prepare('SELECT * FROM hundle WHERE hundle_name=?'); //入力されたニックネームがhundleテーブルに存在するか確認
    $sql -> execute([htmlspecialchars($_REQUEST['hundle_name'])]);
}
if(empty($sql->fetchAll())) { //emptyは値が空の時にtrueを返す、今回は$sqlの実行結果がない場合にtrueとなる
    if(isset($_SESSION['user'])) { //userセッションにデータが存在する場合はtrueになる
        //編集画面用の処理
        $url = "'bulletin-board.php'"; //ボタンクリック時の遷移先
        $sql = $pdo->prepare('UPDATE user SET email = ?,password = ? WHERE user_id=?'); //入力された内容を元に、userテーブル内のメアド、パスワードを更新
        $sql -> execute([htmlspecialchars($_REQUEST['email']),htmlspecialchars($_REQUEST['password']),$id]);
        foreach($sql as $row) { //userセッション内のメアド、パスワードを更新
            $_SESSION['user'] = [
                'email' => $row['email'],
                'password' => $row['password']
            ];
        }
        $sql = $pdo->prepare('UPDATE hundle SET hundle_name =? WHERE user_id=?'); //入力された内容を元に、userテーブル内のニックネームを更新
        $sql -> execute([htmlspecialchars($_REQUEST['hundle_name']),$id]);
        foreach($sql as $row) { //userセッション内のニックネームを更新
            $_SESSION['user'] = [
                'hundle_name' => $row['hundle_name']
            ];
        }
        echo '<div class="userresult">';
        echo '<p>更新完了しました。</p>';
        echo '<button onclick="location.href='.$url.'">掲示板へ</button>';
        echo '</div>';
    } else {
        //新規登録画面用の処理
        $url = "'login.php'"; //ボタンクリック時の遷移先
        $sql = $pdo->prepare('INSERT INTO user VALUES(null,?,?)'); //入力された内容を元に、userテーブルへメアド、パスワードを追加
        $sql -> execute([htmlspecialchars($_REQUEST['email']),htmlspecialchars($_REQUEST['password'])]);
        $sql = $pdo->prepare('INSERT INTO hundle VALUES(null,?)'); //入力された内容を元に、hundleテーブルへニックネームを追加
        $sql -> execute([htmlspecialchars($_REQUEST['hundle_name'])]);
        echo '<div class="userresult">';
        echo '<p>新規登録完了しました。</p>';
        echo '<p>ログインをお願いします。</p>';
        echo '<button onclick="location.href='.$url.'">ログイン画面へ</button>';
        echo '</div>';
    }
} else {
    //入力されたログインIDが既存と重複していた際の処理
    $url = "'user-input.php'"; //ボタンクリック時の遷移先
    echo '<div class="userresult">';
    echo '<p>ログインIDが重複しています。</p>';
    echo '<button onclick="location.href='.$url.'">前の画面へ</button>';
    echo '</div>';
}
?>
<?php require 'footer.php'; ?>