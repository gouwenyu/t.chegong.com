<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:64:"/data/work/public/../application/index/view/driver_info/oil.html";i:1529912891;s:61:"/data/work/public/../application/index/view/index/header.html";i:1529920686;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>车府令管控平台</title>
    <link rel="stylesheet" type="text/css" href="__INDEX_CSS__/calendar.css?v=20180625">
    <link rel="stylesheet" href="__INDEX_CSS__/common.css?v=20180625">
    <link rel="stylesheet" href="__INDEX_CSS__/VerticalMenu.css?v=20180625">

    <link rel="stylesheet" href="__INDEX_CSS__/yhtj.css?v=20180625">
    <link href="http://www.jq22.com/jquery/font-awesome.4.6.0.css" rel="stylesheet" media="screen">

    <style>

    </style>

    <script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=0b56e774df10081938cfcad128c7c837"></script>
</head>
<body style="background:#001e36;">
<div style="display: none;" class="alert">
    <div>
        <div class="top"><p>默认时间（今天）内暂无行驶轨迹</p></div>
        <div class="bottom clear_fl">
            <button id="ok" style="left:320px">确定</button>
        </div>
    </div>
</div>

<style>
    .common_header_ul li:nth-child(3) a{
        /*background: url(../image/index/left1.png)!important;*/
        color: #ff4c15;!important;


    }
    .common_log{
        height: 0px ;
        overflow-y: hidden;
        z-index: 222;
        margin-top: 70%;
    }
    .common_log p:first-child{
        margin-top: 15px;
    }
    .common_log p{
        width: 100%;    
        color: white;
        text-align: center;
        cursor: pointer;

    }
    .now_time{
        width:100%;
        color: #fff;
        text-align: center;
    }
/*  .borderr{
            border:1px solid red;
            border:none;
        }*/

</style>
<div class="common_edit_mess">
    <!--修改图片-->
    <div class="xgtp" style="display:none;padding:10px;">
        <p style=""><span style="display: inline-block;">修改图片</span> <i class="iconfont icon_close">&#xe624;</i></p>
        <div style="text-align: center;margin:20px 0;color: white;" >请选择小于2M的图片</div>
        <div style="margin:0 auto;width: 200px;">
            <div id="preview"></div>
            <input type="file" onchange="preview(this)" accept="image/*" placeholder="选择图片"/> <br>
            <div style="display: none"><progress id="progre" max="100" value=""></progress> <span id="span">0%</span></div>
            <div></div>
        </div>
        <p><button class="login_ok">确认</button> <button class="login_no">取消</button></p>
            </div>
    <!--修改密码-->
    <div class="xgmm" style="display: none">
        <p style="padding-top: 30px;"><span>修改密码</span> <i class="iconfont icon_close">&#xe624;</i></p>
        <p><input type="password" placeholder="输入旧密码" id="pwd_o"></p>
        <p><input type="password" placeholder="输入新密码" id="pwd1"></p>
        <p><input type="password" placeholder="确认新密码" id="pwd2"></p>
        <p><button class="login_ok">确认</button> <button class="login_no">取消</button></p>
    </div>
    <!--修改信息-->
    <div class="xgxx" style="display: none">
        <p style="padding-top: 30px;"><span>修改信息</span> <i class="iconfont icon_close">&#xe624;</i></p>
        <p><input type="text" placeholder="输入新名称"></p>
        <p><button class="login_ok">确认</button> <button class="login_no">取消</button></p>
    </div>
</div>
<div class="clear_fl common_body" >
    <div class="left " style="width: 15%;min-width: 160px;">
        <div class="clear_fl common_logo">
            <div class="left left_logo " >
                <img src="http://show.chegong.com/static/index/upload/20171123/0cc76a3f16aa6c4fdffa0066281350c3.png" alt="" style="width: 100%">
            </div>
            
            <div class="left  right_logo " style="">               
                <div class="clear_fl">
                    <div class="left right_name ">
                        <span class="c_names" style=" display: inline-block;"><?php echo \think\Cookie::get('name'); ?></span>
                    </div>
                    <div class="left right_edit">
                        <div class="relative">
                            <div class="absolute ">
                                <i class="iconfont login_m" style="font-size: 20px;">&#xe61d;</i>
                            </div>                           
                            <div style="" class=" absolute common_log">
                                <div class="relative">
                                    <div class="absolute">
                                        <img src="/static/index/image/common/xiala.png" style="width: 100%;overflow-y: hidden;" alt="">
                                    </div>
                                    <div class="absolute" style="width: 100%">
                                        <p class="edit_m">修改信息</p>
                                        <p class="edit_p">修改密码</p>
                                        <p><a href="<?php echo url('login/loginOut'); ?>">退出</a></p>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            
        </div>
        <div class="now_time">2017-12-28 17:17</div>

    </div>
    <div class="common_header left " style="">
        <div class="relative " style="width: 82.5%; min-width:800px;margin:0 auto">
            <div class="absolute">
                 <img src="/static/index/image/index/4.png" style="width: 100%" alt="">
            </div>
           
            <ul class="absolute clear_fl common_header_ul" style="">
                <li style=""><a href="<?php echo url('index/index'); ?>"><span class="index_common_span"></span>首页</a></li>
                <li ><a href="<?php echo url('edit/index'); ?>"><span class="index_common_span"></span>基础档案</a></li>
                <li style=" "><a href="<?php echo url('driver_info/oil'); ?>"><span class="index_common_span"></span>油耗统计</a></li>
                <li style=""><a href="<?php echo url('driver_info/history'); ?>"><span class="index_common_span"></span>历史轨迹</a></li>
                <li style="display: none;"><a href="<?php echo url('driver_info/kpi'); ?>"><span class="index_common_span"></span>KPI考核</a></li>
                <li style="display: none"><a href="<?php echo url('use_car/index'); ?>"><span class="index_common_span"></span>用车管理</a></li>
                <!--<li><a href="<?php echo url('warn_car/index'); ?>"><span class="index_common_span"></span>警示管理</a></li>-->
                <li style="display: none"><a href="<?php echo url('car_manage/index'); ?>"><span class="index_common_span"></span>费用管理</a></li>
                <!-- <li style=""><a href="<?php echo url('driver_info/analysis'); ?>"><span class="index_common_span"></span>驾驶分析</a></li> -->
            </ul>
        </div>
    </div>
</div>
<div class="global_disabled absolute" style="width: 100%;height: 800px;z-index: 999;background:rgba(255,255,255,0);display: none;cursor: wait">

</div>
<div class="clear_fl relative common_body" >
    <div class="left cg_l " >
        <div class="ver_list" style="">
            <div class="all_title com_bg">全部</div>
            <div class="VerticalMenu">
                <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
                <div>
                    <?php if(count($list)>1): ?>
                    <div class="company">
                        <span><?php echo $user_name[$key]; ?></span><span  style="display: none;width: 10px;overflow: hidden"><?php echo $key; ?></span>
                    </div>
                    <?php endif; if(is_array($item) || $item instanceof \think\Collection || $item instanceof \think\Paginator): $i = 0; $__LIST__ = $item;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>

                    <div name="xz" <?php if(count($list)<2): ?> style='display:block'<?php endif; ?>>

                    <div>
                        <div class="depart" <?php if(count($list)<2): ?> style='height:50px;line-height:50px;'<?php endif; ?>>
                        <span><?php echo $val['0']['department_name']; ?></span><span class="key_none" style="display: none;width: 10px;overflow: hidden"><?php echo $val['0']['department_id']; ?></span>
                        <i class="fa fa-angle-right fa-lg"></i>
                    </div>
                    <div name="xz1" class="depart_one">
                        <?php if(is_array($val) || $val instanceof \think\Collection || $val instanceof \think\Paginator): $i = 0; $__LIST__ = $val;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                        <div><p><span class="obd_key_none"><?php echo $v['obd_id']; ?></span><span><?php echo $v['plate_num']; ?>—<?php echo $v['car_name']; ?></span></p></div>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>

        <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
</div>
</div>
<div class="left " style="width: 84%; min-width: 840px">
    <div class="clear_fl" style="height: 80px;width: 100%">
        <div class="ui-datepicker-quick  left" style="width: 85%;  ">
            <div>
                <input class="ui-date-quick-button com_bg" type="button" value="今天" alt="0"  name=""/>
                <input class="ui-date-quick-button" type="button" value="昨天" alt="-1" name=""/>
                <input class="ui-date-quick-button" type="button" value="本周" alt="bz" name=""/>
                <input class="ui-date-quick-button" type="button" value="本月" alt="by" name=""/>
                <input class="ui-date-quick-button" type="button" value="本季度" alt="bjd" name=""/>
                <input class="ui-date-quick-button" type="button" value="半年" alt="-182" name=""/>
                <input class="ui-date-quick-button" type="button" value="一年" alt="-365" name=""/>
            </div>
        </div>
        <div class="left" style="position: relative;width: 10%">
            <div class="zdy_date " style="display: ;">
                自定义日期
            </div>
            <input type="text" class="ui-datepicker-time  " readonly value=""
                   style="display: none;width: 150%"/>
            <div class="ui-datepicker-css  " style="position: absolute;">
                <div class="ui-datepicker-choose  relative">
                    <p>自选日期<a class="ui-close-date">X</a></p>
                    <div class="ui-datepicker-date">
                        <input name="startDate" id="startDate" class="startDate" readonly value="2014-12-20"
                               type="text">
                        ——
                        <input name="endDate" id="endDate" class="endDate" readonly value="2014-12-20"
                               type="text" disabled onchange="datePickers()">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="color:white;" class="right_all_tj clear_fl">
        <div class="left " style="">
            <div class="relative" style="width: 100%;">
                <div class="absolute">
                    <p class=" absolute title_km">总里程</p>
                    <img src="/static/index/image/yhtj/yhtj.png" alt="" width="100%">
                </div>
                <div class="absolute" style="width: 100%">
                    <div class="absolute hxt_bg" >
                        <img src="/static/index/image/yhtj/yuan.png" alt="" width="100%">
                    </div>
                    <div id="hxt" class="absolute"></div>
                </div>
            </div>
            <div style="" class="tj_title_show ">
                <div class="tj_all_km"><p><span id="all_km_total">暂无数据</span></p></div>
                <div id="all_km_show">
                    <p style="width: 100%; text-align: center;margin-top: 10px;">暂无数据</p>
                </div>
            </div>
        </div>
        <div class="left " style="">
            <div class="relative" style="width: 100%;">
                <div class="absolute">
                    <p class=" absolute title_km">总油耗</p>
                    <img src="/static/index/image/yhtj/yhtj.png" alt="" width="100%">
                </div>
                <div class="absolute" style="width: 100%">
                    <div class="absolute hxt_bg" >
                        <img src="/static/index/image/yhtj/yuan.png" alt="" width="100%">
                    </div>
                    <div id="hxt1" class="absolute"></div>
                </div>
            </div>
            <div style="" class="tj_title_show ">
                <div class="tj_all_yh"><p><span id="all_yh_total">暂无数据</span></p></div>
                <div id="all_yh_show">
                    <p style="width: 100%; text-align: center;margin-top: 10px;">暂无数据</p>
                </div>
            </div>
        </div>
        <div class="left " style="">
            <div class="relative" style="width: 100%;">
                <div class="absolute">
                    <p class=" absolute title_km">总油费</p>
                    <img src="/static/index/image/yhtj/yhtj.png" alt="" width="100%">
                </div>
                <div class="absolute" style="width: 100%">
                    <div class="absolute hxt_bg" >
                        <img src="/static/index/image/yhtj/yuan.png" alt="" width="100%">
                    </div>
                    <div id="hxt2" class="absolute"></div>
                </div>
            </div>
            <div style="" class="tj_title_show ">
                <div class="tj_all_yf"><p><span id="all_yf_total">暂无数据</span></p></div>
                <div id="all_yf_show">
                    <p style="width: 100%; text-align: center;margin-top: 10px;">暂无数据</p>
                </div>
            </div>
        </div>

    </div>

</div>
</div>
</body>
<script type="text/javascript" src="__INDEX_JS__/jquery.min.js"></script>
<script type="text/javascript" src="__INDEX_JS__/common.js"></script>
<script src="https://webapi.amap.com/ui/1.0/main.js"></script>
<script src="__INDEX_JS__/jquery-ui-1.9.2.custom.js" type = "text/javascript" language="javascript"></script>
<!--时间为单选时zdy_time-->
<!--<script src="__INDEX_JS__/zdy_time.js" type = "text/javascript"></script>-->
<script src="__INDEX_JS__/calendar.js" type="text/javascript"></script>
<script type="text/javascript" src="__INDEX_JS__/ichart.1.2.min.js"></script>
<script type="text/javascript" src="__INDEX_JS__/yhtj.js"></script>


</html>