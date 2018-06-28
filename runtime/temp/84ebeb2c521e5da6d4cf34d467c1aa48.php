<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:62:"/data/work/public/../application/index/view/use_car/index.html";i:1529480085;s:61:"/data/work/public/../application/index/view/index/header.html";i:1529545924;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>车府令管控平台</title>
    <link rel="stylesheet" href="__INDEX_CSS__/common.css">
    <link rel="stylesheet" href="__INDEX_CSS__/VerticalMenu.css">
    <link rel="stylesheet" href="__INDEX_CSS__/use_car.css">
    <link href="http://www.jq22.com/jquery/font-awesome.4.6.0.css" rel="stylesheet" media="screen">

</head>
<body style="background:#001e36;">

<style>
    .common_header_ul li:nth-child(6) a{
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

<div class="clear_fl reltive common_body" style="">
    <div class="left" style="width: 15%;min-width: 160px;">
        <ul class="jcda_left_ul" style="margin-top: 5px;">
            <li class="li_active  show_all_car"><span>全部</span></li>
            <li class="have_select"><span>已选车辆</span></li>
            <li class="no_select"><span>未选车辆</span></li>
            <div class="VerticalMenu">
                <?php if(is_array($carList) || $carList instanceof \think\Collection || $carList instanceof \think\Paginator): $i = 0; $__LIST__ = $carList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
                <div>
                    <?php if(count($carList)>1): ?>
                    <div class="company">
                        <span><?php echo $user_name[$key]; ?></span>
                    </div>
                    <?php endif; if(is_array($item) || $item instanceof \think\Collection || $item instanceof \think\Paginator): $i = 0; $__LIST__ = $item;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>

                        <div name="xz" <?php if(count($carList)<2): ?> style='display:block'<?php endif; ?>>
                            <div>
                                <div class="depart" <?php if(count($list)<2): ?> style='height:50px;line-height:50px;'<?php endif; ?>>
                                    <span><?php echo $val['0']['department_name']; ?></span><span class="key_none" style="display: none;width: 10px;overflow: hidden"><?php echo $val['0']['department_id']; ?></span><i class="fa fa-angle-right fa-lg"></i>
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
        </ul>
    </div>
    <div class="left relative right_show" style="width: 84%; min-width: 840px;">
        <div class="relative" style="width: 100%">
            <div class="absolute" style="width: 100%;height: 942px;">
                <img src="/static/index/image/jcda/bg10.png" alt="" style="width: 100%;height: 942px;">
            </div>
            <!-- 用车信息 -->
            <div class="right_show_table relative five_table" style="display:;">
                <div class="table table_header" style="width: 100%">

                    <div class="table_td">
                        <p>车牌号</p>
                    </div>
                    <div class="table_td">
                        <p>所属部门</p>
                    </div>
                    <div class="table_td">
                        <p>领取钥匙时间</p>
                    </div>
                    <div class="table_td">
                        <p>归还钥匙时间</p>
                    </div>
                    <div class="table_td">
                        <p>使用者</p>
                    </div>
                </div>
                <div class="insert_sibling" style="width: 100%">
                    <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                    <div class="show_car_mes ">
                        <div class="table table_show">

                            <div class="table_td">
                                <p class="car" car_id="<?php echo $v['id']; ?>"><?php echo $v['plate_num']; ?></p>
                            </div>
                            <div class="table_td" style="text-align: left;">
                                <p de_id="<?php echo $v['department_id']; ?>" style="padding-left:20%;text-align: left;width: 100%;"><span ><?php echo $v['username']; ?>-<?php echo $v['department_name']; ?></span></p>
                            </div>
                            <div class="table_td">
                                <p class="start_time_p"><input placeholder="<?php if(empty($v['use_car_state']) || (($v['use_car_state'] instanceof \think\Collection || $v['use_car_state'] instanceof \think\Paginator ) && $v['use_car_state']->isEmpty())): ?>请选择领取时间<?php else: ?><?php echo $v['create_time']; endif; ?>" class="laydate-icon" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" ></p>
                            </div>
                            <div class="table_td">
                                <p class="end_time_p"> <input placeholder="请选择归还时间" class="laydate-icon" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})"></p>
                            </div>
                            <div class="table_td relative">
                                <?php if($v['use_car_state'] == 1): ?>
                                <p  class="show_user_p absolute"><span class="miid" data_id="<?php echo $v['miid']; ?>"><?php echo $v['name']; ?></span><button class="no_btn">解绑</button></p>
                                <div  class="ok_user_div absolute"  style="display: none;">
                                    <button class="ok_btn ">绑定</button>
                                    <?php else: ?>
                                    <p  class="show_user_p absolute" style="display: none;"> <span class="miid" data_id="<?php echo $v['miid']; ?>"></span><button class="no_btn">解绑</button></p>
                                    <div  class="ok_user_div absolute" >
                                        <button class="ok_btn ">绑定</button>
                                        <?php endif; ?>
                                        <div class="all_user">
                                            <div class="clear_fl " style="">

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                    <div class="dt_insert" style="display: none;" ></div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script type="text/javascript" src="__INDEX_JS__/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="__INDEX_JS__/common.js"></script>
<script type="text/javascript" src="__INDEX_JS__/laydate.js"></script>
<script type="text/javascript" src="__INDEX_JS__/use_car.js"></script>
</html>