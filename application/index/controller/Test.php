<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/20
 * Time: 17:33
 */

namespace app\index\controller;
use think\Db;
use think\cache\driver\Redis;
class Test
{
    public function index()
    {
        return view('index');
    }

    public function test()
    {
        $a = Db::query("SELECT MAX(id) `max_id` FROM `t_driver_info` WHERE `id` LIKE '888%' AND LENGTH(id)=7");
        var_dump($a);
        $b = $a[0]['max_id']+1;
        var_dump($b);
        $num = [1, 3, 5, 67, 2, 88, 9, 4, 97, 32, 45, 56, 18, 7, 53];
        $len = count($num);
        for ($i = 1; $i < $len; $i++) {
            for ($j = 0; $j < $len - $i; $j++) {
                if ($num[$j] < $num[$j + 1]) {
                    $temp = $num[$j + 1];
                    $num[$j + 1] = $num[$j];
                    $num[$j] = $temp;
                }
            }
        }
//        return view('index');
    }

}