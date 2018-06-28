<?php
/**
 * Created by PhpStorm.
 * User: XD
 * Date: 2017/8/2
 * Time: 10:04
 */

namespace app\push\controller;
use app\common\controller\Check as check;
use app\push\model\User;

class Edit extends check
{
    public function index(){
        $id = $this->sid;
        $user = new User();
        $car_list = $user->car_list($id);
        $car_info = $user->car_info($id);
        $driver_list = $user->driver_list($id);
        $department_list = $user->department_list($id);
//        $list =[];
//        foreach ($car_list as  $v){
//            $list[$v['department_id']][] = $v;
//            $list[$v['department_id']]['department_name'] = $v['department_name'];
//        }
        $this->assign('car_list',$car_list);
        $this->assign('info',$car_info);
        $this->assign('department_list',$department_list);
        $this->assign('driver_list',$driver_list);
        return view('index');
    }
    //车辆信息接口
    public function carInfo(){
        $carinfo = db('t_car_info');
        $car['merchant_id'] = $this->sid;
        $car['id'] = trim(input('id'));
        $car['obd_mac'] = trim(input('obd_id'));
        $car['obd_id'] = md5($car['obd_mac']);
        $car['vin'] = trim(input('vin'));
        $car['owner'] = trim(input('owner'));
        $car['engine_num'] = trim(input('engine_num'));
        $car['use_type'] = trim(input('use_type'));
        $car['plate_num'] = trim(input('plate_num'));
        $car['car_reg'] = trim(input('car_reg'));
        $car['department_id'] = trim(input('department_id'));
        $car['car_name'] = trim(input('car_name'));
        $car['inspection'] = trim(input('inspection'));
        $car['insurance'] = trim(input('insurance'));
        $car['speed'] = trim(input('speed'));
        $car['remarks'] = trim(input('remarks'));
        $time = date("Y-m-d h:i:s",time());
        $car['up_time'] = $time;
        $rst = $carinfo
            ->where('id',$car['id'])
            ->find();
        if($rst){
            $this->upCar($car);
        }else{
            $car['id'] = md5($this->uuid('car'));
            $car['create_time'] = $time;
            $this->addCarinfo($car);
        }
    }

    private function addCarinfo($car=''){
        $carinfo = db('t_car_info');
        $rst = $carinfo ->insert($car);
        if($rst){
            $ch = curl_init ();
            curl_setopt($ch,CURLOPT_URL,'http://101.200.150.50:8088/chegongbao-web/vin/queryVin.do?' );
            curl_setopt($ch,CURLOPT_POST,1 );
            curl_setopt($ch,CURLOPT_HEADER,0 );
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1 );
            curl_setopt($ch,CURLOPT_POSTFIELDS,'code='.$car['vin']);
            curl_exec($ch);
            curl_close($ch);
            exit(json_encode(['error'=>0,'msg'=>'添加成功','car_id'=>$car['id']]));
        }else{
            exit(json_encode(['error'=>1,'msg'=>'添加失败,请填写完整']));
        }
    }
    private function upCar($car=''){
        $carinfo = db('t_car_info');
        $rst = $carinfo
            ->where('id',$car['id'])
            ->update($car);
        if($rst){
            exit(json_encode(['error'=>0,'msg'=>'修改成功']));
        }else{
            exit(json_encode(['error'=>1,'msg'=>'修改失败']));
        }
    }
    public function delCar(){
        $carinfo = db('t_car_info');
        $id = input('post.id');
        if(!empty($id)){
                db('t_mileage_center')
                ->where(['car_id'=>$id,'merchant_id'=>$this->sid])
                ->delete();
            $res = $carinfo
                ->where(['id'=>$id,'merchant_id'=>$this->sid])
                ->delete();
            if($res){
                exit(json_encode(['error'=>0,'msg'=>'删除成功']));
            }else{
                exit(json_encode(['error'=>1,'msg'=>'数据不存在，请刷新重试']));
            }
        }else{
            exit(json_encode(['error'=>2,'msg'=>'非法操作']));
        }
    }

    //驾驶员信息接口
    public function driverInfo(){
        $driverinfo = db('t_driver_info');
        $driver['merchant_id'] = $this->sid;
        $driver['id'] = input('id');
        $driver['job_num'] = intval(input('job_num'));
        $driver['name'] = input('dname');
        $driver['card_id'] = input('card_id');
        $driver['mobile'] = input('mobile');
        $driver['address'] = input('address');
        $driver['enty_data'] = input('enty_data');
        $driver['license_type'] = input('license_type');
        $driver['license_first'] = input('license_first');
        $driver['license_end'] = input('license_end');
        $time = date("Y-m-d h:i:s",time());
        $driver['up_time'] = $time;
        $rst = $driverinfo
            ->where('id',$driver['id'])
            ->find();
        if($rst){
            $this->upDriver($driver);
        }else{
            $driver['id'] = md5($this->uuid('driver'));
            $driver['create_time'] = $time;
            $this->addDriverinfo($driver);
        }
    }

    private function addDriverinfo($driver=''){
        $driverinfo = db('t_driver_info');
        $rst = $driverinfo ->insert($driver);
        if($rst){
            exit(json_encode(['error'=>0,'msg'=>'添加成功','driver_id'=>$driver['id']]));
        }else{
            exit(json_encode(['error'=>1,'msg'=>'添加失败']));
        }
    }
    private function upDriver($driver=''){
        $driverinfo = db('t_driver_info');
        $rst = $driverinfo
            ->where('id',$driver['id'])
            ->update($driver);
        if($rst){
            exit(json_encode(['error'=>0,'msg'=>'修改成功']));
        }else{
            exit(json_encode(['error'=>1,'msg'=>'修改失败']));
        }
    }

    public function delDriver(){
        $driverinfo = db('t_driver_info');
        $id = input('post.id');
        if(!empty($id)){
            $res = $driverinfo
                ->delete(['id'=>$id,'merchant_id'=>$this->sid]);
            if($res){
                exit(json_encode(['error'=>0,'msg'=>'删除成功']));
            }else{
                exit(json_encode(['error'=>1,'msg'=>'数据不存在，请刷新重试']));
            }
        }else{
            exit(json_encode(['error'=>2,'msg'=>'非法操作']));
        }
    }
    public function departInfo(){
        $depart_id = input('post.id');
        $name = input('post.name');
        $departInfo = db('t_department_info');
        $time = date("Y-m-d h:i:s",time());
        $depart = [
            'id' => $depart_id,
            'merchant_id' => $this->sid,
            'department_name' => $name,
            'up_time' => $time
        ];
        $rst = $departInfo
            ->where('id',$depart['id'])
            ->find();
        if($rst){
            $this->upDepart($depart);
        }else{
            $depart['id'] = md5($this->uuid('department'));
            $depart['create_time'] = $time;
            $this->addDepart($depart);
        }
    }
    private function addDepart($depart=''){
        $departInfo = db('t_department_info');
        $rst = $departInfo ->insert($depart);
        if($rst){
            exit(json_encode(['error'=>0,'msg'=>'添加成功','depart_id'=>$depart['id']]));
        }else{
            exit(json_encode(['error'=>1,'msg'=>'添加失败']));
        }
    }
    private function upDepart($depart=''){
        $departInfo = db('t_department_info');
        $rst = $departInfo
            ->where('id',$depart['id'])
            ->update($depart);
        if($rst){
            exit(json_encode(['error'=>0,'msg'=>'修改成功']));
        }else{
            exit(json_encode(['error'=>1,'msg'=>'修改失败']));
        }
    }
    public function delDepart(){
        $driverinfo = db('t_department_info');
        $id = input('post.id');
        if(!empty($id)){
            $res = $driverinfo
                ->delete(['id'=>$id,'merchant_id'=>$this->sid]);
            if($res){
                exit(json_encode(['error'=>0,'msg'=>'删除成功']));
            }else{
                exit(json_encode(['error'=>1,'msg'=>'数据不存在，请刷新重试']));
            }
        }else{
            exit(json_encode(['error'=>2,'msg'=>'非法操作']));
        }
    }
}