    <?php
    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/db/example_database.php';

    use \IMSGlobal\LTI;

    $launch = LTI\LTI_Message_Launch::new(new Example_Database())
        ->validate();
    //
    // $launch gets jwt which includes id_token and jwt
    // In detail, you can inspect data by IDE such as PhpStorm
    //

    $redirect_url = "/tgle_main.php?launch_id=".$launch->get_launch_id();

    header("Location:".$redirect_url);
    exit();
    ?>
