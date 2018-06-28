<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/19
 * Time: 15:24
 */

namespace app\common\controller;

use think\Controller;

class Check extends Controller
{
    protected $sid;

    public function _initialize()
    {
        $act = $this->request->param('act');
        if ($act == '1' || $act == '2') {
            $token = empty($this->request->param('token'))?$this->app_json_error('无验证,请重新验证','2'):$this->request->param('token');
            $user = db('chegong_merchant')
                ->table('t_user')
                ->field('id')
                ->where('token'.$act, $token)
                ->find();                
            if (empty($user)) {
                $this->app_json_error('身份验证过期,请重新验证');
            }else{
                $rst = db('t_auth')
                    ->field('user_id')
                    ->where('parent_id', $user['id'])
                    ->select();
                if (!empty($rst)) {
                    foreach ($rst as $item) {
                        $child[] = $item['user_id'];
                    }
                    $children = implode(',', $child);                    
                    $this->sid = $children;
                } else {
                    $this->sid = $user['id'];
                }
                session('uid', $user['id']);
            }
        } else {
            if (!empty(session('aid'))) {
                $this->sid = session('aid');
                return;
            } else {
                $this->redirect('Login/index');
            }
        }

//        $res['position'] = Db::query("
//                select x.*,ifnull(d.name,'') name from(
//                select z.*,ifnull(e.error_code,'') error_code from(
//                select ifnull(c.plate_num,'') plate_num,ifnull(c.obd_id,'') obd_id,a.user_id,a.longitude,a.latitude,a.date,ifnull(a.address,'') address from chegong_merchant.t_car_info c
//                left join chegongbao.t_map_position_last a on(c.obd_id=a.obd_id and c.merchant_id in('c9e1942e6c8b0c325093d5cda7b31336','e4d2391df0879844d3df12d8e663314a','73fac6e5d0bec91227dfc2594cb33c9e','928977752799530200f01b570423f974','647ecdf1e9255ed9ab79fff5875c17d4','5c8b6562ec40bc378e482d99712a5398','03504027b1dcd92bcd155ff3a8fb9444','4fc2f6970c577097313e60a12a45baab','316c54ea33b408b7ba650e82d5ad11b5','220','1e67399374e7f0b2535fce73df138bcd','13a9e941ec98d2e2fe921ab3b715dbd5','f5c82d7c28506df13285e9f9b704de80')) where a.source=1 and a.obd_id<>'' and a.longitude<>'0') z
//                left join chegong_merchant.t_obd_err_code e on (z.obd_id = e.obd_id)) x
//                left join chegong_merchant.t_driver_info d on(x.user_id=d.id);
//            ");
//        if ($act == '1' || $act == '2') {
//            $token = input('post.token');
//            $user = db('chegong_merchant')
//                ->table('t_user')
//                ->field('id')
//                ->where('token', $token)
//                ->find();
//            if (empty($user)) {
//                $this->make_json_error('身份验证过期,请重新验证');
//            }
//            session('aid', $user['id']);
//        }
    }

    public function post_amap($x, $y)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://restapi.amap.com/v3/assistant/coordinate/convert?locations=$x,$y&coordsys=gps&output=json&key=47e9fd264b9f80d8ecc368e616af3e57");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $rst = curl_exec($ch);
        curl_close($ch);
        return json_decode($rst);
    }

    public function post_amaps($data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://restapi.amap.com/v3/assistant/coordinate/convert?locations=$data&coordsys=gps&output=json&key=47e9fd264b9f80d8ecc368e616af3e57");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $rst = curl_exec($ch);
        curl_close($ch);
        return json_decode($rst);
    }
}