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

namespace app\push\controller;

use app\common\controller\Check as check;
use think\Db;
class UseCar extends check
{
    public function index(){
        $id = $this->sid;
        $list = Db::query("
        select q.*,e.name from(
        select z.*,d.department_name from(
        select a.plate_num,a.id,a.department_id,a.merchant_id,b.id miid,b.driver_id,b.use_car_state,b.create_time,b.up_time from  t_car_info a left join (
        select c.id,c.merchant_id,c.driver_id,c.car_id,c.use_car_state,c.create_time,c.up_time from t_mileage_center c,(
        select max(xx.add_time) as mtime ,xx.car_id from t_mileage_center xx where merchant_id ='$id' group by xx.car_id) t 
        where c.car_id = t.car_id and c.add_time = t.mtime and c.merchant_id ='$id') b 
        on (a.id = b.car_id) where a.merchant_id = '$id') z 
        left join t_department_info d 
        on (z.department_id = d.id and z.merchant_id = d.merchant_id)) q
        left join t_driver_info e 
        on (q.driver_id = e.id and q.merchant_id = e.merchant_id);
        ");
        $car_list = Db::query("
        select a.*,b.department_name from  t_car_info a left join t_department_info b 
        on (a.department_id = b.id and a.merchant_id = b.merchant_id) where a.merchant_id='$id'");
        $clist =[];
        foreach ($car_list as  $v){
            $clist[$v['department_id']][] = $v;
        }
        $this->assign('list',$list);
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
                $info['up_time'] = input('post.end_time');
                if($res['create_time']>=$info['up_time']){
                    $this->make_json_error('归还失败，归还时间小于领取时间');
                }
                if($res['use_car_state']===0){
                    $this->make_json_error('归还失败，已经归还,请刷新');
                }
                $info['modify_time'] = date('Y-m-d H:i:s');
                $info['use_car_state'] = 0;
                $rst = $mileage
                    ->where('id',$id)
                    ->where('merchant_id',$merchant_id)
                    ->update($info);
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
                $info['merchant_id'] = $merchant_id;
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
        $id = $this->sid;
        $driver_list = Db::query("
        select a.id,a.name,b.use_car_state from t_driver_info a left join (
        select c.id,c.merchant_id,c.driver_id,c.car_id,c.use_car_state,c.create_time,c.up_time from t_mileage_center c,(
        select max(xx.add_time) as mtime ,xx.driver_id from t_mileage_center xx where merchant_id ='$id' group by xx.driver_id) t 
        where c.driver_id = t.driver_id and c.add_time = t.mtime and c.merchant_id ='$id') b 
        on (a.id=b.driver_id and a.merchant_id=b.merchant_id ) where a.merchant_id='$id' order by a.create_time
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