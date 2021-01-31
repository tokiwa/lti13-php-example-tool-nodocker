<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../db/example_database.php';

use \IMSGlobal\LTI;
$launch = LTI\LTI_Message_Launch::new(new Example_Database())
    ->validate();

?>

<h1>LTI13 Works!</h1>


<?php
//LTI 1.3 Core
echo "[Data by LTI 1.3 Core]"."<br>";
echo "jwt/sub(=user_id): ".$launch->get_launch_data()['sub']."<br>";
echo "jwt/name: ".$launch->get_launch_data()['name']."<br>";
echo "jwt/email: ".$launch->get_launch_data()['email']."<br>";
echo "jwt/version: ". $launch->get_launch_data()['https://purl.imsglobal.org/spec/lti/claim/version']."<br>";
echo "jwt/context/id: ". $launch->get_launch_data()['https://purl.imsglobal.org/spec/lti/claim/context']['id']."<br>";
echo "jwt/context/title: ". $launch->get_launch_data()['https://purl.imsglobal.org/spec/lti/claim/context']['title']."<br>";

echo "<hr>";
echo "[Data by LTI 1.3 Core - Moodle extension]"."<br>";
echo "jwt/loginid: ". $launch->get_launch_data()['https://purl.imsglobal.org/spec/lti/claim/ext']['user_username']."<br>";
echo "jwt/lms: ". $launch->get_launch_data()['https://purl.imsglobal.org/spec/lti/claim/ext']['lms']."<br>";

//NRPS
$members = $launch->get_nrps()->get_members();
echo "<hr>";
echo "[Userlist by Name Role Provisioning Service]"."<br>";
foreach($members as $member){
echo "user_id/roles/name/email : ".$member['user_id']." / ".$member['roles'][0]." / ".$member['name']." / ".$member['email']."<br>";
}

//$launch->get_launch_id();

echo "<hr>";
?>

<!--<link href="static/breakout.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Gugi" rel="stylesheet"><?php
/*
if ($launch->is_deep_link_launch()) {
    */?>
    <div class="dl-config">
        <h1>Pick a Difficulty</h1>
        <ul>
            <li><a href="<?/*= TOOL_HOST */?>/configure.php?diff=easy&launch_id=<?/*= $launch->get_launch_id(); */?>">Easy</a></li>
            <li><a href="<?/*= TOOL_HOST */?>/configure.php?diff=normal&launch_id=<?/*= $launch->get_launch_id(); */?>">Normal</a></li>
            <li><a href="<?/*= TOOL_HOST */?>/configure.php?diff=hard&launch_id=<?/*= $launch->get_launch_id(); */?>">Hard</a></li>
        </ul>
    </div>
    <?php
/*    die;
}
*/?>

<div id="game-screen">
    <div style="position:absolute;width:1000px;margin-left:-500px;left:50%; display:block">
        <div id="scoreboard" style="position:absolute; right:0; width:200px; height:486px">
            <h2 style="margin-left:12px;">Scoreboard</h2>
            <table id="leadertable" style="margin-left:12px;">
            </table>
        </div>
        <canvas id="breakoutbg" width="800" height="500" style="position:absolute;left:0;border:0;">
        </canvas>
        <canvas id="breakout" width="800" height="500" style="position:absolute;left:0;">
        </canvas>
    </div>
</div>
<script>
    // Set game difficulty if it has been set in deep linking
    //
    // IMS J comment  Y.Tokiwa 2021.1.13
    // launch->get_launch_data() の戻り値がないとゲームの背景だけが表示され、その後のゲームに至らない。
    //    var curr_diff = "<?/*//= $launch->get_launch_data()['https://purl.imsglobal.org/spec/lti/claim/custom']['difficulty'] ?: 'normal'; */?>//";
    //　?: -> ??　とし、戻り値がnullでも対応できるようにする。
    var curr_diff = "<?/*= $launch->get_launch_data()['https://purl.imsglobal.org/spec/lti/claim/custom']['difficulty'] ?? 'normal'; */?>";
    var curr_user_name = "<?/*= $launch->get_launch_data()['name']; */?>";
    var launch_id = "<?/*= $launch->get_launch_id(); */?>";
</script>
<script type="text/javascript" src="static/breakout.js" charset="utf-8"></script>-->