<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/31
 * Time: 10:03
 */

namespace app\index\controller;

class Excel
{
    public function test() {
        $name='测试导出';
        $header=['表头A','表头B'];
        $data=[
            ['嘿嘿','heihei'],
            ['哈哈','haha']
        ];
        excelExport($name,$header,$data);
    }
}