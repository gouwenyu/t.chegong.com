<?php
/**
 * Created by PhpStorm.
 * User: XD
 * Date: 2017/8/15
 * Time: 22:12
 */

namespace app\push\controller;
use think\Controller;
use think\Db;
use think\Session;
class Reg extends Controller
{
    public function index(){
        if(!empty(session('aid'))){
            $this->redirect('index/index');
        }else {
            return view('index');
        }
    }
    public function reset(){
        if(!empty(session('aid'))){
            $this->redirect('index/index');
        }else{
            return view('reset');
        }
    }
    public function service(){
        if(!empty(session('aid'))){
            $this->redirect('index/index');
        }else{
            return view('service');
        }
    }
    /*
     * 注册接口
     * */
    public function register()
    {
        $mobile = trim(input('post.mobile'));
        $user_pwd = md5(trim(input('post.user_pwd')));
        $sms_code = trim(input('post.sms_code'));
        $session_mobile = input('session.mobile');
        $session_code = input('session.sms_code');
        // 判断手机验证码是否正确
        if(input('post.')){
            if(empty($mobile) || empty($sms_code)){
                $this->make_json_error('非法操作',1);
            }
            if($mobile != $session_mobile || $sms_code != $session_code){
                $this->make_json_error('手机验证码输入错误',2);
            }else{
                if ($this->has_user($mobile)) {
                    $this->make_json_error('该手机号已经注册，请使用其他号码',3);

                }
                $t = date('y-m-d h:i:s');
                $user = db('t_user');
                $id = md5($this->uuid('user'));
                $rst = $user->insert([
                    'id' =>$id,
                    'mobile'=>$mobile,
                    'user_pwd'=>$user_pwd,
                    'create_time'=>$t,
                    'up_time'=>$t,
                    'username'=>"cg_$mobile"
                ]);
                if ($rst) {
                    Session::set('aid',$id);
                    Session::set('name',"cg_$mobile");
                    Session::set('mobile',$mobile);
                    $this->make_json_response('注册成功，请等待审核',0,'index');
                } else {
                    $this->make_json_error('注册失败',4);
                }
            }
        }else{
            $this->make_json_error('非法操作',1);
        }
    }
    //重置密码接口
    public function resetPwd(){
        $mobile = trim(input('post.mobile'));
        $user_pwd = md5(trim(input('post.user_pwd')));
        $sms_code = trim(input('post.sms_code'));
        $session_mobile = input('session.mobile');
        $session_code = input('session.sms_code');
        // 判断手机验证码是否正确
        if(input('post.')){
            if(empty($mobile) || empty($sms_code)){
                $this->make_json_error('非法操作',1);
            }
            if($mobile != $session_mobile || $sms_code != $session_code){
                $this->make_json_error('手机验证码输入错误',2);
            }else{
                if (!$this->has_user($mobile)) {
                    $this->make_json_error('该手机号没有注册,请先注册',3);

                }
                $user = db('t_user');
                $userinfo = $user
                    ->where('mobile',$mobile)
                    ->find();
                $rst = $user
                    ->where('mobile',$mobile)
                    ->update([
                        'user_pwd'=>$user_pwd,
                        'up_time'=>date('y-m-d h:i:s'),
                        ]);
                if ($rst && $user_pwd !=$userinfo['user_pwd']) {
                    Session::set('aid',$userinfo['id']);
                    Session::set('name',$userinfo['username']);
                    Session::set('mobile',$mobile);
                    $this->make_json_response('修改成功',0,'index');
                } else {
                    $this->make_json_error('修改失败,与原密码一致',4);
                }
            }
        }else{
            $this->make_json_error('非法操作',1);
        }
    }
    public function get_sms_k()
    {
        $sms_k = $this->random(10);
        session('sms_k',$sms_k);
        exit(json_encode(['content'=>$sms_k]));
    }
    /*
     * 获取短信验证码接口
     * */
    public function getSmsCode()
    {
        $mobile = trim(input('post.mobile'));
        $sms_k = input('post.sms_k');
        if(empty($mobile)){
            $this->make_json_error('请输入手机号',1);
        }
        if (empty($sms_k) || input('session.sms_k') != $sms_k) {
            $this->make_json_error('获取验证码失败,非法操作',2);
        }
        if ($this->has_user($mobile) && empty(trim(input('post.reset')))) {
            $this->make_json_error('该手机号已经注册，请使用其他号码',3);
        }
        // send sms code
        $sms_code = $this->random(6, 1);;
        $msg = "【车工科技】验证码：{$sms_code}，请及时填写并完成验证。如非本人操作，请忽略。";
        $ret = $this->send($mobile, $msg, 2);
        if ($ret) {
            session('mobile',$mobile);
            session('sms_code',$sms_code);
            exit(json_encode(['error'=>0,'sms_k'=>input('session.sms_k')]));
//            exit(json_encode(['error'=>0,'sms_k'=>input('session.sms_k'),'sms_code'=>$sms_code]));
        } else {
            $this->make_json_error('获取验证码失败,请规范操作',1);
        }
    }
     //验证用户是否存在
    private function has_user($mobile)
    {
        $rst = Db::query("select 1 from t_user where mobile='".$mobile."'");
        return (is_array($rst) && count($rst) > 0);
    }
    /*
     * 短信平台接口
     * */
    private function sendsmsquanlitong($phones, $msg, $ext=''){
//        logx("sendSmsquanlitong phones: {$phones}, msg: {$msg}, ext:{$ext}");
        $sms_code = array(
            '00'=>'批量短信提交成功（批量短信待审批）',
            '01'=>'批量短信提交成功（批量短信跳过审批环节）',
            '02'=>'IP限制',
            '03'=>'单条短信提交成功',
            '04'=>'用户名错误',
            '05'=>'密码错误',
            '06'=>'剩余条数不足',
            '07'=>'信息内容中含有限制词(违禁词)',
            '08'=>'信息内容为黑内容',
            '09'=>'该用户的该内容 受同天内，内容不能重复发 限制',
            '10'=>'批量下限不足',
            '97'=>'短信参数有误',
            '98'=>'防火墙无法处理这种短信',
            '99'=>'短信参数无法解析'
        );
        $mob_Content=iconv("UTF-8","GBK",$msg);
        $mob_Content =  urlencode($mob_Content);
        $ValidTime = date('YmdHis',time());
        if($ext==3){
            $url ="http://221.179.180.158:9007/QxtSms/QxtFirewall?OperID=cgkjbj&OperPass=cgkjbj"
                ."&SendTime=&ValidTime=".$ValidTime."&AppendID=6666&DesMobile="
                .$phones."&Content=".$mob_Content."&ContentType=15";
        }else{
            $url ="http://221.179.180.158:9007/QxtSms/QxtFirewall?OperID=cgkjbj&OperPass=cgkjbj"
                ."&SendTime=&ValidTime=".$ValidTime."&AppendID=8888&DesMobile="
                .$phones."&Content=".$mob_Content."&ContentType=15";
        }
//        logx($url);
        $recontent = file_get_contents($url );
        $re = serialize($recontent);
        $p = xml_parser_create();
        xml_parse_into_struct($p, $recontent, $vals, $index);
        xml_parser_free($p);
        if(in_array($vals[1]['value'],array('00','01','03')) ){
//            logx("sms $phones ok");
            return true;
        }else{
            $msg1 = $sms_code[$vals[1]['value']];
//            logx("sms $phones fail: $msg1");
        }
        return false;
    }
    private function send($phones, $msg, $ext=''){
        return $this->sendsmsquanlitong($phones, $msg, $ext);
    }
}