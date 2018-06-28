<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/5
 * Time: 19:52
 */

namespace app\index\controller;
import('getui.IGt', EXTEND_PATH, '.Push.php');

class Getui
{
    private $host = 'http://sdk.open.api.igexin.com/apiex.htm';
    //测试
    private $appkey = 'RRH6TPWzOS6FUJPnkKjGJ9';
    private $appid = '7RYSV6VvTc6dHzPX3TETF5';
    private $mastersecret = 'aW7aQDRHA5A6qRyXgVQoI2';

    public function pushToAndroidApp($title, $content, $message)
    {
        $igt = new IGeTui($this->host, $this->appkey, $this->mastersecret);
        //$igt = new IGeTui('',APPKEY,MASTERSECRET);//此方式可通过获取服务端地址列表判断最快域名后进行消息推送，每10分钟检查一次最快域名
        //消息模版：
        // 1.TransmissionTemplate:透传功能模板
        // 2.LinkTemplate:通知打开链接功能模板
        // 3.NotificationTemplate：通知透传功能模板
        // 4.NotyPopLoadTemplate：通知弹框下载功能模板
        //$template = IGtNotyPopLoadTemplateDemo();
        //$template = IGtLinkTemplateDemo();
        //$template = IGtNotificationTemplateDemo();
        //$template = IGtTransmissionTemplateDemo();

        $template = new \IGtTransmissionTemplate();
        $template->set_appId($this->appid);                   //应用appid
        $template->set_appkey($this->appkey);                 //应用appkey
        $template->set_transmissionType(2);            //透传消息类型
        $template->set_transmissionContent(json_encode($message));//透传内容

        //个推信息体
        //基于应用消息体
        $message = new \IGtAppMessage();
        $message->set_isOffline(true);
        $message->set_offlineExpireTime(3600 * 12 * 1000);//离线时间单位为毫秒，例，两个小时离线为3600*1000*2
        $message->set_data($template);
        $message->set_PushNetWorkType(0);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送
        $message->set_speed(1000);// 设置群推接口的推送速度，单位为条/秒，例如填写100，则为100条/秒。仅对指定应用群推接口有效。
        $message->set_appIdList(array($this->appid));
        $message->set_phoneTypeList(array('ANDROID'));
//        $message->set_provinceList(array('浙江','上海','北京'));
//        $message->set_tagList(array('开心'));
        $res = $igt->pushMessageToApp($message);
        return $res;

    }

    public function test(){
    }

    function pushMessageToApp()
    {
        $igt = new IGeTui(HOST, APPKEY, MASTERSECRET);
        //定义透传模板，设置透传内容，和收到消息是否立即启动启用
        $template = IGtNotificationTemplateDemo();
        //$template = IGtLinkTemplateDemo();
        // 定义"AppMessage"类型消息对象，设置消息内容模板、发送的目标App列表、是否支持离线发送、以及离线消息有效期(单位毫秒)
        $message = new IGtAppMessage();
        $message->set_isOffline(true);
        $message->set_offlineExpireTime(10 * 60 * 1000);//离线时间单位为毫秒，例，两个小时离线为3600*1000*2
        $message->set_data($template);

        $appIdList = array(APPID);
        $phoneTypeList = array('ANDROID');
        $provinceList = array('浙江');
        $tagList = array('haha');
        //用户属性
        //$age = array("0000", "0010");


        //$cdt = new AppConditions();
        // $cdt->addCondition(AppConditions::PHONE_TYPE, $phoneTypeList);
        // $cdt->addCondition(AppConditions::REGION, $provinceList);
        //$cdt->addCondition(AppConditions::TAG, $tagList);
        //$cdt->addCondition("age", $age);

        $message->set_appIdList($appIdList);
        //$message->set_conditions($cdt->getCondition());

        $rep = $igt->pushMessageToApp($message, "任务组名");

        var_dump($rep);
        echo("<br><br>");
    }

    function IGtNotificationTemplateDemo()
    {
        $template = new IGtNotificationTemplate();
        $template->set_appId(APPID);                   //应用appid
        $template->set_appkey(APPKEY);                 //应用appkey
        $template->set_transmissionType(1);            //透传消息类型
        $template->set_transmissionContent("测试离线");//透传内容
        $template->set_title("个推");                  //通知栏标题
        $template->set_text("个推最新版点击下载");     //通知栏内容
        $template->set_logo("");                       //通知栏logo
        $template->set_logoURL("");                    //通知栏logo链接
        $template->set_isRing(true);                   //是否响铃
        $template->set_isVibrate(true);                //是否震动
        $template->set_isClearable(true);              //通知栏是否可清除

        return $template;
    }


}