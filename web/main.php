<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../db/example_database.php';

use \IMSGlobal\LTI;
$launch = LTI\LTI_Message_Launch::new(new Example_Database())
    ->validate();


//Heading1
echo "<h1>LTI13 Works!</h1>";

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
echo "[Roster by LTI Advantage Name Role Provisioning Service]"."<br>";
echo "user_id/roles/name/email"."<br>";
foreach($members as $member){
echo $member['user_id']." / ".$member['roles'][0]." / ".$member['name']." / ".$member['email']."<br>";
}

//$launch->get_launch_id();

echo "<hr>";

// store "loginid,sub" in login.log csv file

$fp = fopen("login.log","a");
$log = $launch->get_launch_data()['sub'].",".$launch->get_launch_data()['https://purl.imsglobal.org/spec/lti/claim/ext']['user_username']."\n";
fwrite($fp,$log);
fclose($fp);

// Instructor can get a list of loginid-user_id
if(strpos($launch->get_launch_data()['https://purl.imsglobal.org/spec/lti/claim/roles'][0],"Instructor") !== false){
echo "<a href='login.log'>download login.log</a>";
}

?>