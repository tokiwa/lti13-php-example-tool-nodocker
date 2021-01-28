<?php
require_once __DIR__ . '/../vendor/autoload.php';

//
//// IMS J comment  Y.Tokiwa 2021.1.13
//// HTTP_X_FORWARDED_PROTO が定義されていないとエラーとなる。
// define("TOOL_HOST", ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?: $_SERVER['REQUEST_SCHEME']) . '://' . $_SERVER['HTTP_HOST']);
//
define("TOOL_HOST", ( isset($_SERVER['HTTP_X_FORWARDED_PROTO']) ? $_SERVER['HTTP_X_FORWARDED_PROTO'] : $_SERVER['REQUEST_SCHEME']) . '://' . $_SERVER['HTTP_HOST']);
use \IMSGlobal\LTI;

$_SESSION['iss'] = [];
$reg_configs = array_diff(scandir(__DIR__ . '/configs'), array('..', '.', '.DS_Store'));
foreach ($reg_configs as $key => $reg_config) {
    $_SESSION['iss'] = array_merge($_SESSION['iss'], json_decode(file_get_contents(__DIR__ . "/configs/$reg_config"), true));
}
class Example_Database implements LTI\Database {
    public function find_registration_by_issuer($iss) {
        if (empty($_SESSION['iss']) || empty($_SESSION['iss'][$iss])) {
            return false;
        }
        return LTI\LTI_Registration::new()
            // IMS J comment  Y.Tokiwa 2021.1.13
                //$_SESSIONで定義されていないとエラーとなる。
                //定義されていない場合には null とする。
                //
            ->set_auth_login_url($_SESSION['iss'][$iss]['auth_login_url'] ?? null)
            ->set_auth_token_url($_SESSION['iss'][$iss]['auth_token_url'] ?? null)
            ->set_auth_server($_SESSION['iss'][$iss]['auth_server'] ?? null)
            ->set_client_id($_SESSION['iss'][$iss]['client_id'] ?? null)
            ->set_key_set_url($_SESSION['iss'][$iss]['key_set_url'] ?? null)
            ->set_kid($_SESSION['iss'][$iss]['kid'] ?? null)
            ->set_issuer($iss)
            ->set_tool_private_key($this->private_key($iss));
    }

    public function find_deployment($iss, $deployment_id) {
        if (!in_array($deployment_id, $_SESSION['iss'][$iss]['deployment'])) {
            return false;
        }
        return LTI\LTI_Deployment::new()
            ->set_deployment_id($deployment_id);
    }

    private function private_key($iss) {
        return file_get_contents(__DIR__ . $_SESSION['iss'][$iss]['private_key_file']);
    }
}
?>