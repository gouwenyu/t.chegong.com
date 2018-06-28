<?php
/**
 * Created by PhpStorm.
 * User: XD
 * Date: 2017/8/20
 * Time: 20:53
 */
/* 标准键盘布局
             ┌──┐   ┌──┬──┬──┬──┐ ┌──┬──┬──┬──┐ ┌──┬──┬──┬──┐ ┌──┬──┬──┐
            │Esc │   │ F1 │ F2 │ F3 │ F4 │ │ F5 │ F6 │ F7 │ F8 │ │ F9 │F10 │F11 │F12 │ │P/S │S L │P/B │     ┌┐    ┌┐    ┌┐
           └──┘   └──┴──┴──┴──┘ └──┴──┴──┴──┘ └──┴──┴──┴──┘ └──┴──┴──┘     └┘    └┘    └┘
          ┌──┬──┬──┬──┬──┬──┬──┬──┬──┬──┬──┬──┬──┬─────┐  ┌──┬──┬──┐ ┌──┬──┬──┬──┐
         │~ ` │! 1 │@ 2 │# 3 │$ 4 │% 5 │^ 6 │& 7 │* 8 │( 9 │) 0 │_ - │+ = │ BacSpace │  │Ins │Hom │PUp │ │N L │ /  │ *  │ -  │
        ├──┴─┬┴─┬┴─┬┴─┬┴─┬┴─┬┴─┬┴─┬┴─┬┴─┬┴─┬┴─┬┴─┬───┤  ├──┼──┼──┤ ├──┼──┼──┼──┤
       │   Tab  │ Q  │ W  │ E  │ R  │ T  │ Y  │ U  │ I  │ O  │ P  │{ [ │} ] │ | \  │  │Del │End │PDn │ │ 7  │ 8  │ 9  │    │
      ├────┴┬─┴┬─┴┬─┴┬─┴┬─┴┬─┴┬─┴┬─┴┬─┴┬─┴┬─┴┬─┴───┤  └──┴──┴──┘ ├──┼──┼──┤ +  │
     │ Caps     │ A  │ S  │ D  │ F  │ G  │ H  │ J  │ K  │ L  │: ; │" ' │  Enter   │                       │ 4  │ 5  │ 6  │    │
    ├─────┴─┬┴─┬┴─┬┴─┬┴─┬┴─┬┴─┬┴─┬┴─┬┴─┬┴─┬┴─────┤       ┌──┐        ├──┼──┼──┼──┤
   │  Shift       │ Z  │ X  │ C  │ V  │ B  │ N  │ M  │< , │> . │? / │   Shift    │       │ ↑ │        │ 1  │ 2  │ 3  │    │
  ├────┬──┴┬─┴┬─┴──┴──┴──┴──┴──┴─┬┴──┼──┴┬──┬──┤ ┌──┼──┼──┐  ├──┴──┼──┤ E││
 │  Ctrl  │  Win │ Alt│               Space                │  Alt │  Win │    │Ctrl│ │ ← │ ↓ │ → │  │    0     │ .  │←┘│
└────┴───┴──┴──────────────────┴───┴───┴──┴──┘ └──┴──┴──┘  └─────┴──┴──┘
*/

namespace app\index\controller;

use app\common\controller\Check as check;
use think\Db;
class UseCar extends check
{
    public function index(){
        $id = $this->sid;
        $list = Db::query("
        select f.*,u.username from(
        select q.*,e.name from(
        select z.*,d.department_name from(
        select a.plate_num,a.id,a.department_id,a.merchant_id,b.id miid,b.driver_id,b.use_car_state,b.create_time,b.up_time from  t_car_info a left join (
        select c.id,c.merchant_id,c.driver_id,c.car_id,c.use_car_state,c.create_time,c.up_time from t_mileage_center c,(
        select max(xx.add_time) as mtime ,xx.car_id from t_mileage_center xx where merchant_id in($id) group by xx.car_id) t 
        where c.car_id = t.car_id and c.add_time = t.mtime and c.merchant_id in($id)) b 
        on (a.id = b.car_id) where a.merchant_id in($id)) z 
        left join t_department_info d 
        on (z.department_id = d.id and z.merchant_id = d.merchant_id)) q
        left join t_driver_info e 
        on (q.driver_id = e.id and q.merchant_id = e.merchant_id)) f 
        left join t_user u 
        on(f.merchant_id=u.id);
        ");
        $car_list = Db::query("
        select a.*,`b`.`department_name`,`u`.`username` 
        from `t_car_info` `a` 
        left join `t_department_info` `b` on `a`.`department_id`=b.id and a.merchant_id = b.merchant_id 
        left join `t_user` `u` on `a`.`merchant_id`=`u`.`id` where  `a`.`merchant_id` in($id) order by `b`.`id`,`a`.`create_time`
        ");
        $clist =[];
        $username =[];
        foreach ($car_list as $item){
            $clist[$item['merchant_id']][$item['department_id']][] = $item;
            $username[$item['merchant_id']] = $item['username'];
        }
        $this->assign('list',$list);
        $this->assign('user_name',$username);
        $this->assign('carList',$clist);
        return view('index');
    }

    public function useInfo(){
        $merchant_id = $this->sid;
        $id = input('post.id');
        $mileage = Db('t_mileage_center');
        $res = $mileage->where('id',$id)->find();
        if (!empty($res)) {
            if(!empty($res['create_time'])){
                $up_time= input('post.end_time');
                if($res['create_time']>=$up_time){
                    $this->make_json_error('归还失败，归还时间小于领取时间');
                }
                if($res['use_car_state']===0){
                    $this->make_json_error('归还失败，已经归还,请刷新');
                }
                $modify_time = date('Y-m-d H:i:s');
                $rst = Db::execute("
                  update `t_mileage_center` set `up_time`='$up_time',`modify_time`='$modify_time',`use_car_state`=0 where `id` = '$id' and `merchant_id` in ($merchant_id);
                ");
                if (!empty($rst)) {
                    $this->make_json_response('归还成功');
                } else {
                    $this->make_json_error('归还失败，请规范操作');
                }
            }else{
                $this->make_json_error('请勿非法操作用车信息',2);
            }
        }else{
            $info['driver_id'] = input('post.driver');
            $info['car_id'] = input('post.car');
            $info['create_time'] = input('post.start_time');
            if(!empty($merchant_id) && !empty($info['driver_id']) && !empty($info['car_id'])) {
                $info['id'] = md5($this->uuid('mileage'));
                $merchant_id = db('t_car_info')->field('merchant_id')->where('id',$info['car_id'])->find();
                $info['merchant_id'] = $merchant_id['merchant_id'];
                $time_ = date('Y-m-d H:i:s');
                $info['add_time'] = $time_;
                $info['modify_time'] = $time_;
                $info['use_car_state'] = 1;
                $rst = $mileage->insert($info);
                if (!empty($rst)) {
                    exit(json_encode(['msg'=>'领取成功','error'=>0,'id'=>$info['id']]));
                } else {
                    $this->make_json_error('领取失败，请规范操作');
                }
            }else{
                $this->make_json_error('请勿非法操作',3);
            }
        }
    }
    public function bind(){
        $merchantId = $this->sid;
        $car_id = input('carId');
        $merchant_id = db('t_car_info')->field('merchant_id')->where('id',$car_id)->find()['merchant_id'];
        if(strpos($merchantId,$merchant_id) === false){     //使用绝对等于
            //不包含
            $this->make_json_error('请勿非法操作');
        }
        $driver_list = Db::query("
        select a.id,a.name,b.use_car_state from t_driver_info a left join (
        select c.id,c.merchant_id,c.driver_id,c.car_id,c.use_car_state,c.create_time,c.up_time from t_mileage_center c,(
        select max(xx.add_time) as mtime ,xx.driver_id from t_mileage_center xx where merchant_id='$merchant_id' group by xx.driver_id) t 
        where c.driver_id = t.driver_id and c.add_time = t.mtime and c.merchant_id='$merchant_id') b 
        on (a.id=b.driver_id and a.merchant_id=b.merchant_id ) where a.merchant_id='$merchant_id' order by a.create_time
        ");
        if(!empty($driver_list)){
            foreach ($driver_list as $k=>$v){
                if ($v['use_car_state'] == 1){
                    unset($driver_list[$k]);
                }
            }
            $this->make_json_response($driver_list);
        }else{
            $this->make_json_response($driver_list);
        }
    }
}