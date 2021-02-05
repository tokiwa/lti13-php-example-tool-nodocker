<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ページタイトル</title>
    <!--CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <!--JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <!--自作CSS -->
    <style type="text/css"><!--
        /*ここに調整CSS記述*/
        --></style>
</head>

<body>
<div class="container">
    <div class="jumbotron">
        <h1>TGLE</h1>
        <p>Tools for Group Learning Environment</p>
    </div>
</div>

<?php
$user_id = "17X3113";
$mysqli = new mysqli('localhost', 'tgleuser', 'tglepass', 'tgle');

if ($mysqli->connect_error) {
    die("connect_error - " . $mysqli->connect_error);
} else {
    $mysqli->set_charset("utf8");
    $sql = 'select user_id,seat,grp from seats where user_id = "' . $user_id . '" order by updated_at desc limit 1 ';
    $result = $mysqli->query($sql) or die("*tgle error* " . $sql);
    $rows = $result->fetch_array(MYSQLI_ASSOC);

    echo "<h2>user: " . $rows['user_id'] . "</h2>";
    echo "<h2>group: " . $rows['grp'] . "</h2>";

    $result->free();
}
$mysqli->close();
?>



<!--　▲ ジャンボトロン　 -->
</body>
</html>
