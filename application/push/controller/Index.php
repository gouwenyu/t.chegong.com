<?php
/**
 * Created by PhpStorm.
 * User: XD
 * Date: 2017/8/2
 * Time: 10:08
 */

namespace app\push\controller;
use app\push\model\User;
use app\common\controller\Check as check;
class Index extends check
{
    public function index()
    {
        $user = new User();
        $id = $this->sid;
        $car_list = $user->car_list($id);
        $oil = $user->oil($id);
        $license_list = $user->license_list($id);
        $utilization =$user->utilization($id,1);
        $attendance =$user->attendance($id,1);
        $failure =$user->failure($id,1);
        $list =[];
        foreach ($car_list as  $v){
            $list[$v['department_id']][] = $v;
        }
        $oil_list = '';
        foreach ($oil as $v){
            if(!empty($v['value'])){
                $oil_list .= "{name: '".$v['name']."',value:".$v['value'].".toFixed(2),color:bg_color()},";
            }
        }
        $oil_list = "
        <script type='text/javascript'>
            function bg_color() {
                var r = Math.floor(Math.random() * 256);
                var g = Math.floor(Math.random() * 256);
                var b = Math.floor(Math.random() * 256);
                return 'rgb(' + r + ',' + g + ',' + b + ')';
            }
            var data = [".$oil_list."];
        </script>";
        $socket = "<script type='text/javascript'>
            var socket = io('http://show.chegong.com:2120');
            uid = $id; 
            socket.on('connect',function(){
                socket.emit('login', uid);
            });
            </script>";
        /*
         * socket.on('new_msg',function(msg){
            $('#msg').html(msg);
        });
        socket.on('update_online_count',function(online_stat){
            console.log(online_stat);
        });
         * */
        $this->assign('utilization',$utilization);
        $this->assign('attendance',$attendance);
        $this->assign('failure',$failure);
        $this->assign('list',$list);
        $this->assign('oil_list',$oil_list);
        $this->assign('socket',$socket);
        $this->assign('license_num',count($license_list));
        return $this->fetch('index');
    }
    //车辆使用率
    public function utilization ($type='') {
        $id = $this->sid;
        $user = new User();
        $user->utilization($id,$type);
    }
    //司机出勤率
    public function attendance ($type='') {
        $id = $this->sid;
        $user = new User();
        $user->attendance($id,$type);
    }
    //车辆故障率
    public function failure ($type='')
    {
        $id = $this->sid;
        $user = new User();
        $user->failure($id, $type);
    }
    public function underway(){
        if(empty($this->sid)){
            exit($this->make_json_error('请登录','1','login/index'));
        }else{
            $oid = input('post.oid');
            $user = new User();
            $user->underway($oid);
        }
    }
}