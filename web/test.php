<?php
//現在実行しているスクリプトのファイル名です。
echo '[PHP_SELF] : '.$_SERVER['PHP_SELF']."<br/>\n";
//現在のスクリプトが実行されているサーバの IP アドレスです。
echo '[SERVER_ADDR] : '.$_SERVER['SERVER_ADDR']."<br/>\n";

if ( isset($_SERVER['HTTP_X_FORWARDED_PORT']) === true )
    {
    echo '[HTTP_X_FORWARDED_PROTO] : ' . $_SERVER['HTTP_X_FORWARDED_PROTO'] . "<br/>\n";
    }
else
    {
        echo '[HTTP_X_FORWARDED_PROTO] is not set' . "<br/>\n";
    }
echo '[REQUEST_SCHEME] : '.$_SERVER['REQUEST_SCHEME']."<br/>\n";
echo '[HTTP_HOST] : '.$_SERVER['HTTP_HOST']."<br/>\n";
?>
