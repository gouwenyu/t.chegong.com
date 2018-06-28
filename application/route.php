<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]' => [
        ':id' => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
    //WEB
    'pushStart/' => 'index/pushs/push',//推送服务
    'test'=>'index/test/test',

    //APP
    'appLogin/' => ['index/AppLogin/login', ['method' => 'post']],//登录
    'AppAutoLogin/' => ['index/AppAuto/autoLogin', ['method' => 'post']],
    'appPositionList/' => ['index/App/positionList', ['method' => 'post']],//实时
    'appUnderway/' => ['index/App/underway', ['method' => 'post']],//窗体
    'appTripList/' => ['index/App/tripList', ['method' => 'post']],//轨迹列表
    'appScreen/' => ['index/App/screenList', ['method' => 'post']],//筛选
    'appCurrentList/' => ['index/App/currentList', ['method' => 'post']],//轨迹
    'appCost/' => ['index/App/costList', ['method' => 'post']],//费用
    'appKpi/' => ['index/App/kpiList', ['method' => 'post']],//KPI
    'appAnalysis/' => ['index/App/analysisList', ['method' => 'post']],//驾驶分析
    'appOil/' => ['index/App/oilList', ['method' => 'post']],//油耗统计
];