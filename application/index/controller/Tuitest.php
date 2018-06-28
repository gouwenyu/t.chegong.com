<?php
/**
 * Created by PhpStorm.
 * User: xd
 * Date: 2017/6/26
 * Time: 15:56
 */

namespace app\index\controller;
use think\Db;

class Tuitest
{

    public function push(){
//        do {
            $rst = Db::query('SELECT
                user_id,
                in_time ha,
                start_longitude,
                start_latitude,
                end_longitude,
                end_latitude,
                start_place,
                end_place,
                current_start_time,
                current_end_time,
                current_mileage
            FROM chegongbao.app_rundata_cdr_n t WHERE t.source=1 ORDER BY t.in_time DESC LIMIT 17');
//            foreach ($rst as $key=>$v){
//                foreach ($v as $k=>$val){
//                    if($k =='ha') {
//                        $a=substr($val,11);
//                        $a = explode(':',$a);
////                        var_dump($a);die;
//                        $rst[$key]['ha'] = "hehe";
//                    }
//                    if($k =='current_start_time') {
//                        $rst[$key]['current_start_time'] = substr($val, 11);
//                    }
//                    if($k =='current_end_time') {
//                        $rst[$key]['current_end_time'] = substr($val, 11);
//                    }
//                }
//            }
//            var_dump($rst);die;
            sleep(5);
            $this->sendmsg($rst);
//        }while(true);
    }

    public function sendmsg($data){
        $data =json_encode($data);
        // 指明给谁推送，为空表示向所有在线用户推送
        $to_uid = "100";
        // 推送的url地址，使用自己的服务器地址
        $push_api_url = "show.chegong.com:2121/";
        $post_data = array(
            "type" => "publish",
            "content" =>$data,
            "to" => $to_uid,
        );
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $push_api_url );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data );
        curl_setopt ($ch, CURLOPT_HTTPHEADER, array("Expect:"));
        $return = curl_exec ( $ch );
        curl_close ( $ch );
        var_export($return);
    }
    public function index2222(){
        ignore_user_abort();
        set_time_limit(0);
        $interval = 1;
        $stop = 1;
        do {
            file_put_contents('./phppush.php',' Current time: '.time().' stop: '.$stop);
            $stop;
            sleep ($interval);
        }while(true);

    }



}