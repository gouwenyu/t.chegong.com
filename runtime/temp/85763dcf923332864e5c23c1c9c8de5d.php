<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:65:"/data/work/public/../application/index/view/car_manage/index.html";i:1529569978;s:61:"/data/work/public/../application/index/view/index/header.html";i:1529545924;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>车府令管控平台</title>
    <link rel="stylesheet" href="__INDEX_CSS__/common.css">
    <link rel="stylesheet" href="__INDEX_CSS__/VerticalMenu.css">
    <link rel="stylesheet" href="__INDEX_CSS__/car_manage.css">
    <link href="http://www.jq22.com/jquery/font-awesome.4.6.0.css" rel="stylesheet" media="screen">

</head>
<body style="background:#001e36;">

<style>
    .common_header_ul li:nth-child(7) a{
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

<!-- <div class="relative " style="margin-top: 10px;"> -->
<div class="clear_fl common_body">
    <div class="left"  style="width: 15%;min-width: 160px;">
        <div class="ver_list" style="margin-top: 7px;">
            <div class="all_title com_bg">全部</div>
            <div class="VerticalMenu">
                <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
                <div>
                    <?php if(count($list)>1): ?>
                    <div class="company">
                        <span><?php echo $user_name[$key]; ?></span>
                    </div>
                    <?php endif; if(is_array($item) || $item instanceof \think\Collection || $item instanceof \think\Paginator): $i = 0; $__LIST__ = $item;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>

                    <div name="xz" <?php if(count($list)<2): ?> style='display:block'<?php endif; ?>>

                    <div>
                        <div class="depart" <?php if(count($list)<2): ?> style='height:50px;line-height:50px;'<?php endif; ?>>
                        <span><?php echo $val['0']['department_name']; ?></span><span class="key_none" style="display: none;width: 1px;overflow: hidden"><?php echo $val['0']['department_id']; ?></span>
                        <i class="fa fa-angle-right fa-lg"></i>
                    </div>
                    <div name="xz1" class="depart_one">
                        <?php if(is_array($val) || $val instanceof \think\Collection || $val instanceof \think\Paginator): $i = 0; $__LIST__ = $val;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                        <div><p><span class="obd_key_none"><?php echo $v['obd_id']; ?></span><span class="car_num"><?php echo $v['plate_num']; ?></span><span>—<?php echo $v['car_name']; ?></span></p></div>
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
<div class="relative right_show_table eight_table left" style="width: 84%; min-width: 840px;">
    <div class="relative" style="width: 100%;">
        <div class="absolute" style="width: 100%;height: 942px;">
            <img src="/static/index/image/jcda/bg10.png" alt="" style="width: 100%;height: 942px;">
        </div>
        <div style="position: absolute;width: 98%;padding: 1.2% 1%" id="car_manage">
            <div class="table table_header" style="width: 100%;">
                <div class="table_td">
                    <p>车牌号</p>
                </div>
                <!--<div class="table_td">-->
                <!--<p>所属部门</p>-->
                <!--</div>-->
                <div class="table_td">
                    <p>加油记录</p>
                </div>
                <div class="table_td">
                    <p>违章记录</p>
                </div>
                <div class="table_td">
                    <p>事故记录</p>
                </div>
                <div class="table_td">
                    <p>保养记录</p>
                </div>
                <div class="table_td">
                    <p>过桥记录</p>
                </div>
                <div class="table_td">
                    <p>过路记录</p>
                </div>
            </div>
            <div class="insert_sibling" style="width: 100%;">
                <?php if(is_array($cost_list) || $cost_list instanceof \think\Collection || $cost_list instanceof \think\Paginator): $k = 0; $__LIST__ = $cost_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?>
                <div class="show_car_mes ">
                    <div class="table table_show" style="width: 100%;">
                        <div class="table_td car_card">
                            <p><span carId ="<?php echo $v['0']['0']['cid']; ?>" ><?php echo $v['plate_num']; ?></span></p>
                        </div>
                        <div class="table_td" style="display: none">
                            <p dep = "<?php echo $v['0']['0']['department_id']; ?>"></p>
                        </div>
                        <div class="table_td">
                            <p class="jy_p  <?php if(!(empty($v['3']['0']['id']) || (($v['3']['0']['id'] instanceof \think\Collection || $v['3']['0']['id'] instanceof \think\Paginator ) && $v['3']['0']['id']->isEmpty()))): ?> jy_span <?php endif; ?>"  <?php if(!(empty($v['3']['0']['id']) || (($v['3']['0']['id'] instanceof \think\Collection || $v['3']['0']['id'] instanceof \think\Paginator ) && $v['3']['0']['id']->isEmpty()))): ?> title="点击查看更多" style="cursor:pointer" <?php endif; ?>>
                            <?php if(!(empty($v['3']['0']['id']) || (($v['3']['0']['id'] instanceof \think\Collection || $v['3']['0']['id'] instanceof \think\Paginator ) && $v['3']['0']['id']->isEmpty()))): ?>
                            <span class="span_div "><span driverId = "<?php echo $v['3']['0']['driver_id']; ?>"><?php echo $v['3']['0']['name']; ?></span> <?php echo $v['3']['0']['add_time']; ?> <?php echo $v['3']['0']['accident_cost']; ?>￥</span>
                            <!-- <span style="" class="jy_span">更多</span> -->
                            <?php else: ?>
                            <span class="span_div">暂无</span>
                            <?php endif; ?>
                            </p>
                        </div>
                        <div class="table_td">
                            <p class="wz_p  <?php if(!(empty($v['3']['0']['id']) || (($v['3']['0']['id'] instanceof \think\Collection || $v['3']['0']['id'] instanceof \think\Paginator ) && $v['3']['0']['id']->isEmpty()))): ?>  wz_span <?php endif; ?>" <?php if(!(empty($v['3']['0']['id']) || (($v['3']['0']['id'] instanceof \think\Collection || $v['3']['0']['id'] instanceof \think\Paginator ) && $v['3']['0']['id']->isEmpty()))): ?> title="点击查看更多" style="cursor:pointer" <?php endif; ?>>
                            <?php if(!(empty($v['0']['0']['id']) || (($v['0']['0']['id'] instanceof \think\Collection || $v['0']['0']['id'] instanceof \think\Paginator ) && $v['0']['0']['id']->isEmpty()))): ?><span class="span_div"><span driverId = "<?php echo $v['0']['0']['driver_id']; ?>"><?php echo $v['0']['0']['name']; ?></span> <?php echo $v['0']['0']['add_time']; ?> <?php echo $v['0']['0']['accident_cost']; ?>￥</span>
                            <!-- <span style="" class="wz_span">更多</span> -->
                            <?php else: ?>
                            <span class="span_div">暂无</span>
                            <?php endif; ?>
                            </p>
                        </div>
                        <div class="table_td">
                            <p class="sg_p  <?php if(!(empty($v['3']['0']['id']) || (($v['3']['0']['id'] instanceof \think\Collection || $v['3']['0']['id'] instanceof \think\Paginator ) && $v['3']['0']['id']->isEmpty()))): ?> sg_span <?php endif; ?>" <?php if(!(empty($v['3']['0']['id']) || (($v['3']['0']['id'] instanceof \think\Collection || $v['3']['0']['id'] instanceof \think\Paginator ) && $v['3']['0']['id']->isEmpty()))): ?> title="点击查看更多" style="cursor: pointer" <?php endif; ?>>
                            <?php if(!(empty($v['1']['0']['id']) || (($v['1']['0']['id'] instanceof \think\Collection || $v['1']['0']['id'] instanceof \think\Paginator ) && $v['1']['0']['id']->isEmpty()))): ?><span class="span_div"><span driverId = "<?php echo $v['1']['0']['driver_id']; ?>"><?php echo $v['1']['0']['name']; ?></span> <?php echo $v['1']['0']['add_time']; ?> <?php echo $v['1']['0']['accident_cost']; ?>￥</span>
                            <!-- <span style="" class="sg_span">更多</span> -->
                            <?php else: ?>
                            <span class="span_div">暂无</span>
                            <?php endif; ?>
                            </p>
                        </div>
                        <div class="table_td">
                            <p class="by_p <?php if(!(empty($v['3']['0']['id']) || (($v['3']['0']['id'] instanceof \think\Collection || $v['3']['0']['id'] instanceof \think\Paginator ) && $v['3']['0']['id']->isEmpty()))): ?>  by_span <?php endif; ?>" <?php if(!(empty($v['3']['0']['id']) || (($v['3']['0']['id'] instanceof \think\Collection || $v['3']['0']['id'] instanceof \think\Paginator ) && $v['3']['0']['id']->isEmpty()))): ?> title="点击查看更多" style="cursor: pointer" <?php endif; ?>>
                            <?php if(!(empty($v['2']['0']['id']) || (($v['2']['0']['id'] instanceof \think\Collection || $v['2']['0']['id'] instanceof \think\Paginator ) && $v['2']['0']['id']->isEmpty()))): ?><span class="span_div"><span driverId = "<?php echo $v['2']['0']['driver_id']; ?>"><?php echo $v['2']['0']['name']; ?></span> <?php echo $v['2']['0']['add_time']; ?> <?php echo $v['2']['0']['accident_cost']; ?>￥</span>
                            <!-- <span style="" class="by_span">更多</span> -->
                            <?php else: ?>
                            <span class="span_div">暂无</span>
                            <?php endif; ?>
                            </p>
                        </div>
                        <div class="table_td">
                            <p class="gl_p  <?php if(!(empty($v['3']['0']['id']) || (($v['3']['0']['id'] instanceof \think\Collection || $v['3']['0']['id'] instanceof \think\Paginator ) && $v['3']['0']['id']->isEmpty()))): ?> gl_span <?php endif; ?>" <?php if(!(empty($v['3']['0']['id']) || (($v['3']['0']['id'] instanceof \think\Collection || $v['3']['0']['id'] instanceof \think\Paginator ) && $v['3']['0']['id']->isEmpty()))): ?> title="点击查看更多" style="cursor: pointer" <?php endif; ?>>
                            <?php if(!(empty($v['5']['0']['id']) || (($v['5']['0']['id'] instanceof \think\Collection || $v['5']['0']['id'] instanceof \think\Paginator ) && $v['5']['0']['id']->isEmpty()))): ?><span class="span_div"><span driverId = "<?php echo $v['0']['0']['driver_id']; ?>"><?php echo $v['5']['0']['name']; ?></span> <?php echo $v['5']['0']['add_time']; ?> <?php echo $v['5']['0']['accident_cost']; ?>￥</span>
                            <!-- <span style="" class="gl_span">更多</span> -->
                            <?php else: ?>
                            <span class="span_div">暂无</span>
                            <?php endif; ?>
                            </p>
                        </div>
                        <div class="table_td">
                            <p class="gq_p  <?php if(!(empty($v['3']['0']['id']) || (($v['3']['0']['id'] instanceof \think\Collection || $v['3']['0']['id'] instanceof \think\Paginator ) && $v['3']['0']['id']->isEmpty()))): ?> gq_span <?php endif; ?>" <?php if(!(empty($v['3']['0']['id']) || (($v['3']['0']['id'] instanceof \think\Collection || $v['3']['0']['id'] instanceof \think\Paginator ) && $v['3']['0']['id']->isEmpty()))): ?> title="点击查看更多" style="cursor: pointer" <?php endif; ?>>
                            <?php if(!(empty($v['4']['0']['id']) || (($v['4']['0']['id'] instanceof \think\Collection || $v['4']['0']['id'] instanceof \think\Paginator ) && $v['4']['0']['id']->isEmpty()))): ?><span class="span_div"><span driverId = "<?php echo $v['0']['0']['driver_id']; ?>"><?php echo $v['4']['0']['name']; ?></span> <?php echo $v['4']['0']['add_time']; ?> <?php echo $v['4']['0']['accident_cost']; ?>￥</span>
                            <!-- <span style="" class="gq_span">更多</span> -->
                            <?php else: ?>
                            <span class="span_div">暂无</span>
                            <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <div class="dt_insert"  style="display: none;width: 100%;"></div>

            <div class="add_car left_add_btn absolute" style="<?php if(count($list)>1): ?>display:none;<?php endif; ?>">
                <div class="relative" style="height: 100%">
                    <div class="absolute" >
                        <img src="/static/index/image/jcda/icon1.png" alt="" style="width: 100%">
                    </div>
                    <div class="absolute btn_txt" style="color: #fff;">添加车辆</div>
                </div>
            </div>
        </div>


    </div>

    <div class="absolute common_tc if_add_car" style="display:none;" >
        <div class=" relative  car_user_mes six_table" style="margin-top: 140px;margin-left: 20px;">
            <div class="table table_header" style="width: 100%">
                <div class="table_td">
                    <p>车牌号</p>
                </div>

                <!--<div class="table_td" style="">-->
                <!--<p>所属部门</p>-->
                <!--</div>-->

                <div class="table_td">
                    <p>添加类型</p>
                </div>
                <div class="table_td">
                    <p ><span class="manage_people">违章</span>人</p>
                </div>


                <div class="table_td">
                    <p ><span class="manage_time">违章</span>时间</p>
                </div>
                <div class="table_td">
                    <p ><span class="manage_money"></span>金额</p>
                </div>
                <div class="table_td">
                    <p><span class="manage_show">违章</span>记录</p>
                </div>

            </div>
            <div class="table add_show" style="width: 100%">
                <div class="table_td">
                    <p><select name="" id="car_num_show">
                        <?php if(is_array($car_list) || $car_list instanceof \think\Collection || $car_list instanceof \think\Paginator): $i = 0; $__LIST__ = $car_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $val['id']; ?>"><?php echo $val['plate_num']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select></p>
                </div>

                <!--<div class="table_td">-->
                <!--<p><select name="" id="depeart_type">-->
                <!--<option value="0">研发部</option>-->
                <!--<option value="1">运营部</option>-->
                <!--<option value="2">保养部</option>-->
                <!--</select></p>-->
                <!--</div>-->

                <div class="table_td">
                    <p><select name="" id="manage_type">
                        <option value="0">违章</option>
                        <option value="1">事故</option>
                        <option value="2">保养</option>
                        <option value="3">加油</option>
                        <option value="4">过路</option>
                        <option value="5">过桥</option>
                    </select></p>
                </div>
                <div class="table_td">
                    <p><select name="" id="driver_show">
                        <?php if(is_array($driver_list) || $driver_list instanceof \think\Collection || $driver_list instanceof \think\Paginator): $i = 0; $__LIST__ = $driver_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $val['id']; ?>"><?php echo $val['name']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select></p>
                </div>


                <div class="table_td">
                    <p id="manage_time"><input type="text" placeholder="请输入时间" class="laydate-icon" onclick="laydate({isdate: true, format: 'YYYY-MM-DD'})" ></p>
                </div>
                <div class="table_td">
                    <p id="manage_money"><input type="text" placeholder="请输入金额"></p>
                </div>
                <div class="table_td">
                    <p id="manage_des"><input type="text" placeholder="请输入"></p>
                </div>
            </div>
        </div>
        <div class="add_btn"><button id="add_car_ok">确认</button><button class="no_btn">取消</button><button id="add_user_reset">重置</button></div>
    </div>
    <!-- 加油记录 -->
    <div id="jy_list" style="">
        <div style="width: 800px;margin:0 auto;">
            <div class="clear_fl"><div style="float: right;border:1px solid #ccc;padding: 5px;width: 20px;height: 20px;text-align: center;border-radius: 50%;font-size: 20px;line-height: 20px;cursor: pointer;color: white;" class="close_window">X</div></div>
            <div style="text-align: center;padding: 20px 10px;font-weight: bold;font-size: 18px; color: white;"> 车牌号 <span style="font-weight: bolder;" class="car_num"> 豫K 12221 </span> 加油记录列表</div>
            <div class="common_ol_title">
                <span>费用</span><span>记录</span><span>时间</span><span>驾驶者</span>
            </div>
            <ol id="jy_ol">
                <!--<li><span>2016-05-01</span><span>地盛南街 闯红灯</span><span>小明</span><span>罚款100</span></li>-->
                <!--<li><span>超速 </span><span> 2017-08-06</span></li>-->
                <!-- <li></li>
                <li></li>
                <li></li>
                <li></li> -->
            </ol>
        </div>
    </div>
    <!-- 违章记录 -->
    <div id="wz_list" style="">
        <div style="width: 800px;margin:0 auto;">
            <div class="clear_fl"><div style="float: right;border:1px solid #ccc;padding: 5px;width: 20px;height: 20px;text-align: center;border-radius: 50%;font-size: 20px;line-height: 20px;cursor: pointer;color: white;" class="close_window">X</div></div>
            <div style="text-align: center;padding: 20px 10px;font-weight: bold;font-size: 18px; color: white;"> 车牌号 <span style="font-weight: bolder;" class="car_num"> 豫K 12221 </span> 的违章记录列表</div>
            <div class="common_ol_title">
                <span>费用</span><span>记录描述</span><span>时间</span><span>驾驶者</span>
            </div>
            <ol id="wz_ol">
                <!--<li><span>2016-05-01</span><span>地盛南街 闯红灯</span><span>小明</span><span>罚款100</span></li>-->
                <!--<li><span>超速 </span><span> 2017-08-06</span></li>-->
                <!-- <li></li>
                <li></li>
                <li></li>
                <li></li> -->
            </ol>
        </div>
    </div>
    <!-- 事故记录 -->
    <div id="sg_list" style="">
        <div style="width: 800px;margin:0 auto;">
            <div class="clear_fl"><div style="float: right;border:1px solid #ccc;padding: 5px;width: 20px;height: 20px;text-align: center;border-radius: 50%;font-size: 20px;line-height: 20px;cursor: pointer;color: white;" class="close_window">X</div></div>
            <div style="text-align: center;padding: 20px 10px;font-weight: bold;font-size: 18px; color: white;"> 车牌号 <span style="font-weight: bolder;" class="car_num"> 豫K1212121 </span> 的事故记录列表</div>
            <div class="common_ol_title">
                <span>费用</span><span>记录描述</span><span>时间</span><span>驾驶者</span>
            </div>
            <ol id="sg_ol">
                <!--<li><span>闯红灯 </span><span> 2016-05-01</span></li>-->
                <!--<li><span>超速 </span><span> 2017-08-06</span></li>-->
                <!-- <li></li>
                <li></li>
                <li></li>
                <li></li> -->
            </ol>
        </div>
    </div>
    <!-- 保养记录 -->
    <div id="by_list" style="">

        <div style="width: 800px;margin:0 auto;">
            <div class="clear_fl"><div style="float: right;border:1px solid #ccc;padding: 5px;width: 20px;height: 20px;text-align: center;border-radius: 50%;font-size: 20px;line-height: 20px;cursor: pointer;color: white;" class="close_window">X</div></div>
            <div style="text-align: center;padding: 20px 10px;font-weight: bold;font-size: 18px;color: white;">车牌号 <span class="car_num"> 豫K1212121</span> 的保养记录列表</div>
            <div class="common_ol_title">
                <span>费用</span><span>记录描述</span><span>时间</span><span>驾驶者</span>
            </div>
            <ol id="by_ol">
                <!--<li><span>洗车</span><span>2017-05-06</span></li>-->
                <!--<li><span>美容</span><span>2017-08-06</span></li>-->
                <!-- <li></li>
                <li></li>
                <li></li>
                <li></li> -->
            </ol>
        </div>

    </div>
    <!-- 过桥记录 -->
    <div id="gq_list" style="">

        <div style="width: 800px;margin:0 auto;">
            <div class="clear_fl"><div style="float: right;border:1px solid #ccc;padding: 5px;width: 20px;height: 20px;text-align: center;border-radius: 50%;font-size: 20px;line-height: 20px;cursor: pointer;color: white;" class="close_window">X</div></div>
            <div style="text-align: center;padding: 20px 10px;font-weight: bold;font-size: 18px;color: white;">车牌号 <span class="car_num"> 豫K1212121</span> 的过桥记录列表</div>
            <div class="common_ol_title">
                <span>费用</span><span>记录描述</span><span>时间</span><span>驾驶者</span>
            </div>
            <ol id="gq_ol">
                无
            </ol>
        </div>

    </div>
    <!-- 过路记录 -->
    <div id="gl_list" style="">
        <div style="width: 800px;margin:0 auto;">
            <div class="clear_fl"><div style="float: right;border:1px solid #ccc;padding: 5px;width: 20px;height: 20px;text-align: center;border-radius: 50%;font-size: 20px;line-height: 20px;cursor: pointer;color: white;" class="close_window">X</div></div>
            <div style="text-align: center;padding: 20px 10px;font-weight: bold;font-size: 18px;color: white;">车牌号 <span class="car_num"> 豫K1212121</span> 的过路记录列表</div>
            <div class="common_ol_title">
                <span>费用</span><span>记录描述</span><span>时间</span><span>驾驶者</span>
            </div>
            <ol id="gl_ol">
                无
            </ol>
        </div>

    </div>
</div>
</div>
<!-- </div> -->
</body>
<script type="text/javascript" src="__INDEX_JS__/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="__INDEX_JS__/common.js"></script>
<script type="text/javascript" src="__INDEX_JS__/laydate.js"></script>
<script type="text/javascript" src="__INDEX_JS__/car_manage.js"></script>

<script type="text/javascript">

</script>
</html>