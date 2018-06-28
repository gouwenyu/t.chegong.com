<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:64:"/data/work/public/../application/index/view/driver_info/kpi.html";i:1529568166;s:61:"/data/work/public/../application/index/view/index/header.html";i:1529545924;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>车府令管控平台</title>
    <link rel="stylesheet" href="__INDEX_CSS__/common.css">
    <link rel="stylesheet" href="__INDEX_CSS__/VerticalMenu.css">
    <link rel="stylesheet" type="text/css" href="__INDEX_CSS__/calendar.css">
    <link rel="stylesheet" href="__INDEX_CSS__/kpi.css">
</head>
<body style="background:#001e36;">

<style>
    .common_header_ul li:nth-child(5) a{
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
                <li style=""><a href="<?php echo url('driver_info/kpi'); ?>"><span class="index_common_span"></span>KPI考核</a></li>
                <li style=""><a href="<?php echo url('use_car/index'); ?>"><span class="index_common_span"></span>用车管理</a></li>
                <!--<li><a href="<?php echo url('warn_car/index'); ?>"><span class="index_common_span"></span>警示管理</a></li>-->
                <li style=""><a href="<?php echo url('car_manage/index'); ?>"><span class="index_common_span"></span>费用管理</a></li>
                <!-- <li style=""><a href="<?php echo url('driver_info/analysis'); ?>"><span class="index_common_span"></span>驾驶分析</a></li> -->
            </ul>
        </div>
    </div>
</div>


    <div class="clear_fl relative common_body" style="">
        <div class="left" style="width: 15%;min-width: 160px;">
            <div class="ver_list" style="margin-top: 5px;">
                <div class="all_title com_bg">全部</div>
                <div class="VerticalMenu">

                    <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>
                    <div>
                        <?php if(count($list)>1): ?>
                        <div class="company">
                            <span><?php echo $val['0']['username']; ?></span><span  style="display: none;width: 10px;overflow: hidden"><?php echo $key; ?></span>
                        </div>
                        <?php endif; ?>
                        <div name="xz1" class="depart_one" <?php if(count($list)<2): ?> style='display:block'<?php endif; ?>>
                            <?php if(is_array($val) || $val instanceof \think\Collection || $val instanceof \think\Paginator): $i = 0; $__LIST__ = $val;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                            <div><p><span class="key_none"><?php echo $v['id']; ?></span><span><?php echo $v['name']; ?></span></p></div>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                    </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
        </div>
        <div class="left" style="width: 84%; min-width: 840px;">
            <div class="clear_fl" style="height: 70px;width:100%;">
                <div class="ui-datepicker-quick  left" style="width:80%;">
                    <div style="width:100%;">
                        <input class="ui-date-quick-button com_bg" type="button" value="今天" alt="0"  name=""/>
                        <input class="ui-date-quick-button" type="button" value="一周" alt="-6" name=""/>
                        <input class="ui-date-quick-button" type="button" value="半月" alt="-14" name=""/>
                        <input class="ui-date-quick-button" type="button" value="一月" alt="-29" name=""/>
                    </div>
                </div>
                <div class="left" style="position: relative;width: 16%">
                    <div class="zdy_date " style="display: ;">
                        自定义日期
                    </div>
                    <input type="text" class="ui-datepicker-time  " readonly value=""  style="display: none;width: 120%" />
                    <div class="ui-datepicker-css  " style="position: absolute;">
                        <div class="ui-datepicker-choose  relative">
                            <p>自选日期<a class="ui-close-date">X</a></p>
                            <div class="ui-datepicker-date">
                                <input name="startDate" id="startDate" class="startDate" readonly value="2014-12-20" type="text">
                                ——
                                <input name="endDate" id="endDate" class="endDate" readonly  value="2014-12-20" type="text" disabled onchange="datePickers()">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear_fl" style="margin-left:12px ;">
                <div class="left" style="width: 33%">
                    <div class="kpi_left_top relative" style="width: 100%">
                        <div class="absolute" style="width: 100%">
                            <img src="/static/index/image/kpi/top.png" alt="" style="width: 100%">
                        </div>
                        <div class="absolute" style="width: 100%">
                            <div class="kpi_title">行驶时间</div>
                            <div id="bt"></div>
                            <div class="clear_fl ">
                                <div class="left">
                                    <p class="bt_txt">怠速时长</p>
                                    <p class="ds_time">00:00:00</p>
                                </div>
                                <div class="left">
                                    <p class="bt_txt">行驶时长</p>
                                    <p class="xs_time">00:00:00</p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="kpi_left_bottom relative" style="">
                    <div class="absolute " style="width: 100%">
                        <img src="/static/index/image/kpi/bottom.png" alt="" style="width: 100%">
                    </div>
                    <div class="absolute" style="width: 100%">
                        <div class="xs_data">行驶数据</div>
                        <div id="xs_data_show">
                            <p style="text-align: center;padding-top: 10px;color:white;">暂无数据</p>
                        </div>
                    </div>
                        
                    </div>
                </div>
                <div class="left" style="width: 33%">
                    <div id="sg" class="kpi_left_top left_common_bg relative" style="width: 100%">
                        <div class="absolute" style="width: 100%">
                            <img src="/static/index/image/kpi/top.png" alt="" style="width: 100%">
                        </div>
                        <div class="absolute" style="width: 100%">
                             <div class="kpi_title">事故</div>
                            <div>
                                <div class="table">
                                    <div class="table_td"><p>事故次数</p></div>
                                    <div class="table_td"><p id="p_sg_num"><?php echo $num['1']; ?>次</p></div>
                                </div>
                                <div class="table">
                                    <div class="table_td"><p>最近事故</p></div>
                                    <div class="table_td"><p id="p_sg_time"><?php echo $time['1']; ?></p></div>
                                </div>
                            </div>
                            <div class="show_detail">详细信息</div>
                            <ul id="show_sg_more">
                                <?php if(is_array($driver_cost1) || $driver_cost1 instanceof \think\Collection || $driver_cost1 instanceof \think\Paginator): $k = 0; $__LIST__ = $driver_cost1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($k % 2 );++$k;if(is_array($val['1']) || $val['1'] instanceof \think\Collection || $val['1'] instanceof \think\Paginator): $k = 0; $__LIST__ = $val['1'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;if(!(empty($v['id']) || (($v['id'] instanceof \think\Collection || $v['id'] instanceof \think\Paginator ) && $v['id']->isEmpty()))): ?>
                                <li style="margin-left: 44px;">司机<<?php echo $v['name']; ?>>在<?php echo $v['add_time']; ?>当天发生事故<br>金额: <?php echo $v['accident_cost']; ?>￥  描述: <?php echo $v['car_describe']; ?></li>
                                <?php endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                        </div>                       
                    </div>
                    <div id="wz" class="kpi_left_bottom left_common_bg relative" style="width: 100%">
                        <div class="absolute" style="width: 100%">
                             <img src="/static/index/image/kpi/bottom.png" alt="" style="width: 100%">
                        </div>
                        <div class="absolute" style="width: 100%">
                            <div class="xs_data">违章</div>
                        <div>
                            <div class="table">
                                <div class="table_td"><p>违章次数</p></div>
                                <div class="table_td"><p id="p_wz_num"><?php echo $num['0']; ?>次</p></div>
                            </div>
                            <div class="table">
                                <div class="table_td"><p>最近违章</p></div>
                                <div class="table_td"><p id="p_wz_time"><?php echo $time['0']; ?></p></div>
                            </div>
                        </div>
                        <div class="show_detail">详细信息</div>
                        <ul id="show_wz_more">
                            <?php if(is_array($driver_cost0) || $driver_cost0 instanceof \think\Collection || $driver_cost0 instanceof \think\Paginator): $k = 0; $__LIST__ = $driver_cost0;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($k % 2 );++$k;if(is_array($val['0']) || $val['0'] instanceof \think\Collection || $val['0'] instanceof \think\Paginator): $i = 0; $__LIST__ = $val['0'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;if(!(empty($v['id']) || (($v['id'] instanceof \think\Collection || $v['id'] instanceof \think\Paginator ) && $v['id']->isEmpty()))): ?>
                            <li style="margin-left: 44px;">司机<<?php echo $v['name']; ?>>在<?php echo $v['add_time']; ?>当天违章<br>金额: <?php echo $v['accident_cost']; ?>￥  描述: <?php echo $v['car_describe']; ?></li>
                            <?php endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                        </div>
                        
                    </div>
                </div>
                <div class="left" style="width: 33%">
                    <div class="relative kpi_left_top" >
                        <div class="absolute" style="width: 100%">
                            <img src="/static/index/image/kpi/top.png" alt="" style="width: 100%">
                        </div>
                        <div class="absolute" style="width: 100%">
                            <div class="kpi_left_top yhtj_right_top absolute">
                                <p class="kpi_title">里程占比</p>
                            </div>
                            <div class="" style="margin-top: 10%">
                                <div id="hxt" class="absolute"></div>
                                <div class="absolute hxt_bg"></div>
                            </div>
                        </div>
                    </div>
                    <div class="relative kpi_left_bottom">
                        <div class="absolute " style="width: 100%">
                            <img src="/static/index/image/kpi/bottom.png" alt="" style="width: 100%">
                        </div>
                        <div class="absolute" style="width: 100%">
                            <div class="xs_data"><p>行程数据</p></div>
                            <div id="" class="xs_data_show" style="width: 100%">
                                <p style="width: 100%; text-align: center;padding-top: 10px;color:white;">暂无数据</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>  
</body>

<script type="text/javascript" src="__INDEX_JS__/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="__INDEX_JS__/common.js"></script>
<script type="text/javascript" src="__INDEX_JS__/ichart.1.2.min.js"></script>
<script src="__INDEX_JS__/jquery-ui-1.9.2.custom.js" type = "text/javascript" language="javascript"></script>
<script src="__INDEX_JS__/calendar.js" type = "text/javascript"></script>
<script type="text/javascript" src="__INDEX_JS__/kpi.js"></script>


</html>