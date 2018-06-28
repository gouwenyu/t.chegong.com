<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:60:"/data/work/public/../application/index/view/index/index.html";i:1529922084;s:61:"/data/work/public/../application/index/view/index/header.html";i:1529920686;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>车府令管控平台</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
	<link rel="stylesheet" href="__INDEX_CSS__/common.css?v=20180625">
	<link rel="stylesheet" href="__INDEX_CSS__/VerticalMenu.css?v=20180625">
	<link rel="stylesheet" href="__INDEX_CSS__/index.css?v=20180625">
	<link rel="stylesheet" href="__INDEX_CSS__/gd_map.css?v=20180625">
	<link rel="stylesheet" href="__INDEX_CSS__/lunbo.css?v=20180625">
	<link href="http://www.jq22.com/jquery/font-awesome.4.6.0.css" rel="stylesheet" media="screen">
	<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=0b56e774df10081938cfcad128c7c837&plugin=AMap.CitySearch"></script>
	<style>
		.amap-maptype-label{
			margin-left: 0;
		}
		.borderr{
			border:1px solid red;
			/*border:none;*/
		}
	</style>
</head>
<body style="background:#001e36;" class="" >

<style>
    .common_header_ul li:nth-child(1) a{
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
<span style="display: none;" id="uid"><?php echo \think\Session::get('uid'); ?></span>
<span style="display: none;" id="adress"><?php echo \think\Cookie::get('wz'); ?></span>
<div class="clear_fl relative common_body" >
	<div class="left  cg_l" style="">
		<div class="ver_list" >
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
						<span><?php echo $val['0']['department_name']; ?></span>
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
<div class="yhtj_right_bottom relative" style="">
	<!-- <div class="absolute hxt_bg"></div> -->
	<img src="/static/index/image/index/31.png" class="hxt_bg absolute" alt="" >
	<div id="hxt" class="absolute"></div>
</div>

</div>
<div class="left  cg_m  c_height" style="">
	<div class="relative" style="height: 100%">
		<div id="container" class="absolute" ></div>
	</div>
</div>
<div class="left  cg_r relative c_height" >
	<div class="absolute" style="width: 100%;height: 100%">
		<img src="/static/index/image/index/5.png" alt="" style="width: 100%;height: 100%">
	</div>
	<div class="absolute" style="width: 100%">
		<div style="display: none">
			<div class="index_right_top relative">
				<canvas id="annular_tj_canvas" class="absolute" width="102" style=""></canvas>
				<!--<div style="" id="use_car_lv"><?php if($utilization['error'] == 0): ?><?php echo $utilization['msg']; ?>%<?php else: ?><?php echo $utilization['msg']; endif; ?></div>-->
				<div style="" id="use_car_lv"></div>
			</div>
			<div class="relative c_canvas" style="">车辆使用率</div>
			<div class="index_right_top relative">
				<canvas id="annular_tj_canvas1" class="absolute" width="102" style=""></canvas>
				<!--<div style="" id='user_use_lv'><?php if($attendance['error'] == 0): ?><?php echo $attendance['msg']; ?>%<?php else: ?><?php echo $attendance['msg']; endif; ?></div>-->
				<div style="" id='user_use_lv'></div>
			</div>
			<div class="relative c_canvas" style="">司机出勤率</div>
			<div class="index_right_top relative">
				<canvas id="annular_tj_canvas2" class="absolute" width="102" style=""></canvas>
				<div style="" id='car_gz_lv'><?php if($failure['error'] == 0): ?><?php echo $failure['msg']; ?>%<?php else: ?><?php echo $failure['msg']; endif; ?></div>
			</div>
			<div class="relative c_canvas" style="">车辆故障率</div>
		</div>
		<ul class="index_bottom_ul" style="margin-top: 18px;text-align: center;">
			<!--<li>-->
			<!--<a href="<?php echo url('warn_car/index'); ?>#long_park">-->
			<!--<p class="tj">1</p>-->
			<!--<p>停车超时</p>-->
			<!--</a>-->
			<!--</li>-->
			<!--<li>-->
			<!--<a href="<?php echo url('warn_car/index'); ?>#over_speed">-->
			<!--<p class="tj">3</p>-->
			<!--<p>超速行驶</p>-->
			<!--</a>-->
			<!--</li>-->
			<!--<li>-->
			<!--<a href="<?php echo url('warn_car/index'); ?>#danger_driver">-->
			<!--<p class="tj">2</p>-->
			<!--<p>危险驾驶</p>-->
			<!--</a>-->
			<!--</li>-->
			<li>
				<!--<a href="<?php echo url('warn_car/index'); ?>#long_park">-->
				<p class="park_num tj">0</p>
				<p>停泊车辆</p>
				<!--</a>-->
			</li>
			<li>
				<!--<a href="<?php echo url('warn_car/index'); ?>#over_speed">-->
				<p class="run_num tj">0</p>
				<p>运动车辆</p>
				<!--</a>-->
			</li>
			<li>
				<!--<a href="<?php echo url('warn_car/index'); ?>">-->
				<p class="gz_num tj">0</p>
				<p>故障车辆</p>
				<!--</a>-->
			</li>
			<!--<li id="testwin">-->
			<!--<a href="<?php echo url('warn_car/index'); ?>#oil_warn">-->
			<!--<p class="tj">2</p>-->
			<!--<p>油量报警</p>-->
			<!--</a>-->
			<!--</li>-->
			<li>
				<!--<a href="<?php echo url('warn_car/index'); ?>#license_expired">-->
				<!--<p class="tj"><?php if($license_num > 0): ?><?php echo $license_num; else: ?>无<?php endif; ?></p>-->
				<p class="tj">0</p>
				<p>驾照过期</p>
				<!--</a>-->
			</li>
		</ul>
	</div>

</div>
</div>
<!-- <div class="clear_fl relative " style="width:100%;min-width: 1024px;height: 160px;"> -->
<div class="clear_fl relative common_body"  style="display: none">
	<!--轮播图-->
	<!--<div class="left" >-->
	<!--<div class="" style="width: 380px;height: 154px;margin-top: 0px;overflow: hidden;">-->
	<!--<div class=" lunbo relative">-->
	<!--<ul class="lunbo-ul clear_fl">-->
	<!--<?php if(count($list)>1): ?>-->
	<!--<?php else: ?>-->
	<!--<?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>-->
	<!--<?php if(is_array($item) || $item instanceof \think\Collection || $item instanceof \think\Paginator): $i = 0; $__LIST__ = $item;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>-->
	<!--<?php if(is_array($val) || $val instanceof \think\Collection || $val instanceof \think\Paginator): $k = 0; $__LIST__ = $val;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?>-->
	<!--<?php if($k%3==1): ?><li><div class="lbt_title"><?php echo $v['department_name']; ?></div><div class="clear_fl"><?php endif; ?>-->
	<!--<div class="left" >-->
	<!--<div ><span style="color: white; margin-right: 10px;"><?php echo $v['plate_num']; ?></span></div>-->
	<!--<div ><?php echo $v['owner']; ?></div>-->
	<!--<div ><span id="<?php echo $v['obd_id']; ?>"style="color: #00D40E;">正常</span></div>-->
	<!--</div>-->
	<!--<?php if($k%3==0): ?></div></li><?php endif; ?>-->
	<!--<?php endforeach; endif; else: echo "" ;endif; ?>-->
	<!--<?php if(count($val)%3!=0): ?></li><?php endif; ?>-->
	<!--<?php endforeach; endif; else: echo "" ;endif; ?>-->
	<!--<?php endforeach; endif; else: echo "" ;endif; ?>-->
	<!--<?php endif; ?>-->
	<!--</ul>-->
	<!--</div>-->
	<!--</div>-->
	<!--</div>-->
	<div class="left" style="width: 80%;height: 160px; ">
		<div style="width:100%;text-align: center;color: white;font-size: 18px;" ><span class="span2">平均油耗</span></div>
		<div id="zzt"></div>
	</div>
	<div class="left relative" style="width: 20%;margin-top: 20px;">
		<div class="absolute" style="right: 0px">
			<div style="position: absolute;right: 10%;color: #fff;top: 2%">正常</div>
			<img src="__INDEX_IMG__/5.png" alt="" width="100%" >
		</div>
	</div>
</div>
</body>
<script>
	//	接口路径
	var underwayUrl = '<?php echo url("Index/underway"); ?>';
	var utilizationUrl='<?php echo url("Index/utilization"); ?>';
	var attendanceUrl='<?php echo url("Index/attendance"); ?>';
	var failureUrl='<?php echo url("Index/failure"); ?>';
	var gas_station = '<?php echo url("Index/gas_station"); ?>';

	//图片路径
	var imgUrl= '__INDEX_IMG__';
</script>
<script type="text/javascript" src="__INDEX_JS__/jquery.min.js"></script>
<script type="text/javascript" src="__INDEX_JS__/common.js"></script>
<script type="text/javascript" src="__INDEX_JS__/ichart.1.2.min.js"></script>
<!--<?php echo $oil_list; ?>-->
<script type='text/javascript'>
	function bg_color() {
		var r = Math.floor(Math.random() * 170+60);
		var g = Math.floor(Math.random() * 150+60);
		var b = Math.floor(Math.random() * 170+60);
		return 'rgb(' + r + ',' + g + ',' + b + ')';
	}
	var data = [<?php echo $oil_list; ?>];
</script>
<script type="text/javascript" src="__INDEX_JS__/index.js"></script>
<!--<script src="__INDEX_JS__/socketio.js"></script>-->
<script type="text/javascript">


	//	车辆故障编码
	// (function(){
	// 	$.ajax({
	// 		url:'__INDEX__/gzdate.json',
	// 		type:'get',
	// 		timeout:0,
	// 		dataType:'json',
	// 		success:function(data){
	// 			var gzmsg = eval(data);
	// 			gz_date(gzmsg);
	// 		}
	// 	});
	// })();

	function gz_date(gz){
		gz_get = gz;
	}
	function gz_getDate(){
		return gz_get;

	}
	//	gz_getDate();
</script>
<script type="text/javascript" src="__INDEX_JS__/main_map.js"></script>
<script type="text/javascript" src="__INDEX_JS__/lunbo.js"></script>
<script>
	$(function() {
		$(".lunbo-ul").responsiveSlides({
			auto: true,
			pager: true,
			nav: true,
			speed: 500
		});
	});
</script>
</html>