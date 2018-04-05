<?php
header("Content-Type:text/html;charset=utf-8");
require './WeChat.class.php';
define('APPID', 'wx1fda99e00e7e2a12');
define('APPSECRET', '45d2980354216f8b8c43ab188f0ef037');
define('TOKEN', 'weixin123');
$wechat = new WeChat(APPID, APPSECRET, TOKEN);

$access_token = "8_m0Rdx3ZetJBe0tyA4NTfr9iald_0nqqY2LYBlG5JuDMf08V1fRl--7N5OrI5Ff2we41v2IKsh7k_fs5Y3J91y-0cL7M8Px7VQFA0J0muLpFH0RBRybhozNZtpRkE4-NhKhwivgMb-jo3JKzCCFYdACAHKD";
$url ="https://api.weixin.qq.com/cgi-bin/menu/addconditional?access_token=$access_token";
$data = '{
     "button":[
     {    
          "type":"click",
          "name":"今日歌曲",
          "key":"V1001_TODAY_MUSIC"
      },
      {
           "name":"菜单",
           "sub_button":[
           {    
               "type":"view",
               "name":"搜索",
               "url":"http://www.soso.com/"
            },
            {
                 "type":"miniprogram",
                 "name":"wxa",
                 "url":"http://mp.weixin.qq.com",
                 "appid":"wx286b93c14bbf93aa",
                 "pagepath":"pages/lunar/index"
             },
            {
               "type":"click",
               "name":"赞一下我们",
               "key":"V1001_GOOD"
            }]
       }]
 }';
 $bool = $wechat ->_requestPost($url, $data, $ssl=true);
var_dump($bool);
