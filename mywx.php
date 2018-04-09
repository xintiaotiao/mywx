<?php
/**
  * wechat php test
  */

//define your token
//define("TOKEN", "weixin123");
$access_token = "8_m0Rdx3ZetJBe0tyA4NTfr9iald_0nqqY2LYBlG5JuDMf08V1fRl--7N5OrI5Ff2we41v2IKsh7k_fs5Y3J91y-0cL7M8Px7VQFA0J0muLpFH0RBRybhozNZtpRkE4-NhKhwivgMb-jo3JKzCCFYdACAHKD";
$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();
$wechatObj->responseMsg();

class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $MsgType = $postObj->MsgType;
                $time = time();
                //定义一个数组用来存储被动回复的模板内容，不包含位置、关注和被关注等
                $resposeTpl = array(
                        'text' => '<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[%s]]></MsgType><Content><![CDATA[%s]]></Content></xml>',//文本回复XML模板
                        'image' => '<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[image]]></MsgType><Image><MediaId><![CDATA[%s]]></MediaId></Image></xml>',//图片回复XML模板
                        'music' => '<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[%s]]></MsgType><Music><Title><![CDATA[%s]]></Title><Description><![CDATA[%s]]></Description><MusicUrl><![CDATA[%s]]></MusicUrl><HQMusicUrl><![CDATA[%s]]></HQMusicUrl></Music></xml>',//音乐模板
                        'news' => '<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[%s]]></MsgType><ArticleCount>%s</ArticleCount><Articles>%s</Articles></xml>',// 新闻主体
                        'news_item' => '<item><Title><![CDATA[%s]]></Title><Description><![CDATA[%s]]></Description><PicUrl><![CDATA[%s]]></PicUrl><Url><![CDATA[%s]]></Url></item>'//某个新闻模板                           
                    );
                switch ($MsgType) {
                               case 'text':
                                   if(!empty( $keyword ))
                                    {
                                        //测试阶段，回复内容主要为text，主要开发内容
                                        
                                        if($keyword == '?' || $keyword == '？')
                                           {
                                                $msgType = "text";
                                                $contentStr = "本测试号具有以下文本回复功能\r\n\r\n1、输入1可以看小说。\r\n2、输入2可以看图片。\r\n3、输入3可以听音乐。\r\n4、另外，还可以插入图片、语言、位置等。\r\n\r\n温馨提示：如果无聊，可以随意输入文字，便可以和机器人聊天哦！\r\n".date('Y-m-d H:i:s',time());
                                                $resultStr = sprintf($resposeTpl[$msgType], $fromUsername, $toUsername, $time, $msgType, $contentStr);
                                                echo $resultStr;
                                           }elseif($keyword == '1'){
                                                $msgType = "text";
                                                $contentStr = "微信公众平台开发概述

    微信公众平台是运营者通过公众号为微信用户提供资讯和服务的平台，而公众平台开发接口则是提供服务的基础，开发者在公众平台网站中创建公众号、获取接口权限后，可以通过阅读本接口文档来帮助开发。

    为了识别用户，每个用户针对每个公众号会产生一个安全的OpenID，如果需要在多公众号、移动应用之间做用户共通，则需前往微信开放平台，将这些公众号和应用绑定到一个开放平台账号下，绑定后，一个用户虽然对多个公众号和应用有多个不同的OpenID，但他对所有这些同一开放平台账号下的公众号和应用，只有一个UnionID，可以在用户管理-获取用户基本信息（UnionID机制）文档了解详情。\r\n".date('Y-m-d H:i:s',time());
                                                 $resultStr = sprintf($resposeTpl[$msgType], $fromUsername, $toUsername, $time, $msgType, $contentStr);
                                                echo $resultStr;
                                           }elseif($keyword == '2'){
                                                $msgType = "news";
                                                $count =4;
                                                for($i=1;$i<=$count;$i++){
                                                    $title = "图片欣赏".$i;
                                                    $description ="自定义图片集".$i;
                                                    $picUrl = "http://1.xintiaotiao.applinzi.com/images/".$i.".jpg";
                                                    $url = "http://www.xintiaotiao.top";
                                                    $str .=sprintf($resposeTpl['news_item'],$title,$description,$picUrl,$url);
                                                }
                                                $resultStr = sprintf($resposeTpl[$msgType], $fromUsername, $toUsername, $time, $msgType , $count,$str);
                                                echo $resultStr;
                                           }elseif($keyword == '3'){
                                                $msgType = "music";
                                                $title = "追光者";
                                                $des = "一首很好听的都市音乐，分享给大家！";
                                                $url = "http://1.xintiaotiao.applinzi.com/music/zhuiguangzhe.mp3";
                                                $hurl = "http://1.xintiaotiao.applinzi.com/music/zhuiguangzhe.mp3";
                                                $title1 = "凉凉";
                                                $des1 = "一首很好听的古典音乐，分享给大家！";
                                                $hurl1 = "http://1.xintiaotiao.applinzi.com/music/liangliang.mp3";
                                                $url1 = "http://1.xintiaotiao.applinzi.com/music/liangliang.mp3";
                                                
                                                $resultStr = sprintf($resposeTpl[$msgType], $fromUsername, $toUsername, $time, $msgType , $title1,$des1,$url1,$hurl1);
                                                echo $resultStr;
                                           }else{
                                                $msgType = "text";
                                                //图灵机器人api接口，需要key注册后可获得
                                                $url = "http://openapi.tuling123.com/openapi/api?key=466457e62e5143e9b54711d4bcbad0d0&info={$keyword}";
                                                //可以模拟get请求，如果是post，就要用curl模拟了
                                                $str = file_get_contents($url);
                                                $json = json_decode($str);
                                                $contentStr = $json -> text ."\r\n".date('Y-m-d H:i:s',time());
                                                $resultStr = sprintf($resposeTpl[$msgType], $fromUsername, $toUsername, $time, $msgType, $contentStr);
                                                echo $resultStr;
                                           }
                                       
                                    }else{
                                        echo "请输入内容...";
                                    }
                                   break;
                                case 'location':
                                   if(true)
                                    {
                                        $msgType = "text";
                                        $label = $postObj->Label;
                                        $locationX = $postObj->Location_X;
                                        $locationY = $postObj->Location_Y;
                                        //实现数据坐标的数据库写入操作
                                        // $connect =mysql_connect('w.rdc.sae.sina.com.cn','5001kw3zmm','054i15wkwijk13z13mi3m5l4ll1ij0452yy2m4jl');
                                        // mysql_query("use app_xintiaotiao");
                                        // mysql_query("set names utf8");
                                        // $sql ="insert into location (from_user,locationX,locationY,time) values (".$fromUsername.",".$locationX.",".$locationY.",".$time.")";
                                        // mysql_query($sql);
                                        $contentStr = "你所在的当前地址为：" .$label. "\r\n".'经度：'.$locationX.'——纬度：'.$locationY."\r\n".date('Y-m-d H:i:s',time());
                                        $resultStr = sprintf($resposeTpl[$msgType], $fromUsername, $toUsername, $time, $msgType, $contentStr);
                                        echo $resultStr;
                                    }else{
                                        echo "请输入内容...";
                                    }
                                   break;
                                case 'event':
                                   if($postObj->Event == 'subscribe')
                                    {
                                        $msgType = "text";
                                        $contentStr = "本测试号具有以下文本回复功能\r\n\r\n1、输入1可以看小说。\r\n2、输入2可以看图片。\r\n3、输入3可以听音乐。\r\n4、另外，还可以插入图片、语言、位置等。\r\n\r\n温馨提示：如果无聊，可以随意输入文字，便可以和机器人聊天哦！\r\n".date('Y-m-d H:i:s',time());
                                        $resultStr = sprintf($resposeTpl[$msgType], $fromUsername, $toUsername, $time, $msgType, $contentStr);
                                        echo $resultStr;
                                    }elseif($postObj->Event == 'unsubscribe'){
                                        $msgType = "text";
                                        $contentStr = "好遗憾，不小心失去了你，我会想你的！\r\n".date('Y-m-d H:i:s',time());
                                        $resultStr = sprintf($resposeTpl[$msgType], $fromUsername, $toUsername, $time, $msgType, $contentStr);
                                        echo $resultStr;
                                    }elseif($postObj->Event == 'click'){
                                        if($postObj->EventKey == 'help'){
                                            $msgType = "text";
                                            $contentStr = "本测试号具有以下文本回复功能\r\n\r\n1、输入1可以看小说。\r\n2、输入2可以看图片。\r\n3、输入3可以听音乐。\r\n4、另外，还可以插入图片、语言、位置等。\r\n\r\n温馨提示：如果无聊，可以随意输入文字，便可以和机器人聊天哦！\r\n".date('Y-m-d H:i:s',time());
                                            $resultStr = sprintf($resposeTpl[$msgType], $fromUsername, $toUsername, $time, $msgType, $contentStr);
                                            echo $resultStr;
                                        } 
                                    }
                                   break;
                               case 'image':
                                   if(true)
                                    {
                                        $msgType = "text";
                                        $contentStr = "你这图片内容少儿不宜啊，所以咱不予理睬`0`！\r\n".date('Y-m-d H:i:s',time());
                                        $resultStr = sprintf($resposeTpl[$msgType], $fromUsername, $toUsername, $time, $msgType, $contentStr);
                                        echo $resultStr;
                                    }else{
                                        echo "请输入内容...";
                                    }
                                   break;
                                case 'voice':
                                   if(true)
                                    {
                                        $msgType = "text";
                                        $contentStr = "不好意思，你的普通话也恁不标准了，听不懂呢``！\r\n".date('Y-m-d H:i:s',time());
                                        $resultStr = sprintf($resposeTpl[$msgType], $fromUsername, $toUsername, $time, $msgType, $contentStr);
                                        echo $resultStr;
                                    }else{
                                        echo "请输入内容...";
                                    }
                                   break;
                               
                               default:
                                   # code...
                                   break;
                           }           
				

        }else {
        	echo "";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
    private function _requestPost($url, $data, $ssl=true) {
        // curl完成
        $curl = curl_init();

        //设置curl选项
        curl_setopt($curl, CURLOPT_URL, $url);//URL
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '
Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0 FirePHP/0.7.4';
        curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);//user_agent，请求代理信息
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);//referer头，请求来源
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);//设置超时时间
        //SSL相关
        if ($ssl) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//禁用后cURL将终止从服务端进行验证
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//检查服务器SSL证书中是否存在一个公用名(common name)。
        }
        // 处理post相关选项
        curl_setopt($curl, CURLOPT_POST, true);// 是否为POST请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);// 处理请求数据
        // 处理响应结果
        curl_setopt($curl, CURLOPT_HEADER, false);//是否处理响应头
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);//curl_exec()是否返回响应结果

        // 发出请求
        $response = curl_exec($curl);
        if (false === $response) {
            echo '<br>', curl_error($curl), '<br>';
            return false;
        }
        curl_close($curl);
        return $response;
    }   
}

?>