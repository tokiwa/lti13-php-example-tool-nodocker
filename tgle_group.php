<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TGLE</title>
    <!--    Bootstrap begin-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
    <!--    Bootstrap end-->
</head>

<body>
<div class="container">
    <div class="jumbotron">
        <h1 class="text-center">TGLE</h1>
        <p class="text-center">Tools for Group Learning Environment</p>
    </div>

    <?php
    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/db/example_database.php';
    use \IMSGlobal\LTI;
    $launch = LTI\LTI_Message_Launch::from_cache($_REQUEST['launch_id'], new Example_Database());

    $user_id = $launch->get_launch_data()['https://purl.imsglobal.org/spec/lti/claim/ext']['user_username'];
    $course_id = $launch->get_launch_data()['https://purl.imsglobal.org/spec/lti/claim/context']['label'];

// Database search for latest group and seat position
    $mysqli = new mysqli('localhost', 'tgleuser', 'tglepass', 'tgle');

    if ($mysqli->connect_error) {
        die("connect_error - " . $mysqli->connect_error);
    } else {
        $mysqli->set_charset("utf8");
        $sql = 'select user_id,seat,grp from seats where user_id = "' . $user_id . '" order by updated_at desc limit 1 ';
        $result = $mysqli->query($sql) or die("*tgle error* " . $sql);
        $rows = $result->fetch_array(MYSQLI_ASSOC);

// View data by Bootstrap
        echo "<h2 class='text-center'> course_id: " . $course_id . "</h2>";
        echo "<h2 class='text-center'> user_id: " . $rows['user_id'] . "</h2>";
        echo "<h2 class='text-center'> group: " . $rows['grp'] . "</h2>";
        echo "<h2 class='text-center'> seat: " . $rows['seat'] . "</h2>";

// Release Database
        $result->free();
    }
    $mysqli->close();
    ?>
    <p style="line-height : 20px;">　</p>
    <h3 class='text-center'><a href="tgle_instructor.php?launch_id=<?= $launch->get_launch_id(); ?>"> TOPに戻る </a>
    </h3>
</div>

</body>
</html>
