<?php
/**
 * Created by PhpStorm.
 * User: XD
 * Date: 2017/7/19
 * Time: 14:14
 */

namespace app\push\controller;

use think\Db;

class Obderror
{
    public function obderror(){
//        header("Access-Control-Allow-Origin: *");
//        header("Connection: Keep-Alive");
        $user_id = input('post.user_id');
        $obd_id = md5(input('post.obd_id'));
        $err = input('post.err');
        if(!empty($user_id)&&!empty($obd_id)&&!empty($err)){
            $res = Db::table('t_obd_err_code')
                ->field('id')
                ->where(['obd_id'=>$obd_id])
//                ->where(['user_id'=>$user_id,'obd_id'=>$obd_id])
                ->find();
            if(empty($res)){
                $data = ['id'=>md5($user_id.$obd_id),'user_id'=>$user_id,'obd_id'=>$obd_id,'error_code'=>$err,'date'=>date('y-m-d h:i:s')];
                $rst = Db::table('t_obd_err_code')
                    ->insert($data);
                if($rst){
                    echo json_encode( 'insert_success');
                }
            }else{
                $rst = Db::table('t_obd_err_code')
                    ->where(['id'=>$res['id']])
                    ->update(['error_code'=>$err,'date'=>date('y-m-d h:i:s')]);
                if($rst){
                    echo json_encode('up_success');
                }
            }
        }else{
            echo json_encode('error');
        }
    }
}