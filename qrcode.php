<?php

header("Content-Type:text/html;charset=utf-8");
require './WeChat.class.php';
define('APPID', 'wx1fda99e00e7e2a12');
define('APPSECRET', '45d2980354216f8b8c43ab188f0ef037');
define('TOKEN', 'weixin123');
$wechat = new WeChat(APPID, APPSECRET, TOKEN);

$res = $wechat->getQRCode(42);
var_dump($res);