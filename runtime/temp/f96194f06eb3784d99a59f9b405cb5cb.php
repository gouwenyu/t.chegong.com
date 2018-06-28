<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:59:"/data/work/public/../application/index/view/edit/index.html";i:1529913172;s:61:"/data/work/public/../application/index/view/index/header.html";i:1529920686;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>车府令管控平台</title>
	<link rel="stylesheet" href="__INDEX_CSS__/common.css?v=2018625">
	<link rel="stylesheet" href="__INDEX_CSS__/jcda.css?v=2018625">
</head>
<body style="background:#001e36;">
<div style="display: none;" class="alert">
	<div>
		<div class="top"><p>确 认 删 除 操 作</p></div>
		<div class="bottom clear_fl">
			<button id="ok">删 除</button>
			<button id="no">取 消</button>
		</div>
	</div>
</div>


<style>
    .common_header_ul li:nth-child(2) a{
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

<div class="clear_fl relative common_body" style=" ">
	<div class="left " style="width: 15%;min-width: 160px;">
		<div class="all_title1">基础档案</div>
		<ul class="jcda_left_ul" style="">
			<li class="li_active"><span>车辆基本信息</span></li>
			<li><span>驾驶员</span></li>
			<li><span>部门管理</span></li>
			<li><span>车辆详细信息</span></li>
		</ul>
	</div>
	<div class="left relative right_show" style="width: 84%; min-width: 840px;">
		<div class="relative" style="width: 100%">
			<div class="absolute right_height" style="width: 100%;">
				<img src="/static/index/image/jcda/bg10.png" alt="" style="width: 100%;height: 100%">
			</div>
			<!-- 车辆基本信息 -->
			<div class="right_show_table relative base_header_mes" style="">
				<div class="table  table_header table_c">
					<div class="table_td">
						<p>编辑</p>
					</div>
					<div class="table_td">
						<p>部门</p>
					</div>
					<div class="table_td">
						<p>所有者</p>
					</div>
					<div class="table_td">
						<p>盒子编号</p>
					</div>
					<div class="table_td">
						<p>发动机号码</p>
					</div>
					<div class="table_td">
						<p>车架号</p>
					</div>
					<div class="table_td">
						<p>车牌照</p>
					</div>
					<div class="table_td">
						<p>车辆登记日期</p>
					</div>
					<div class="table_td">
						<p>车辆别名</p>
					</div>
					<div class="table_td">
						<p>年检</p>
					</div>
					<div class="table_td">
						<p>车险</p>
					</div>
					<!--<div class="table_td">-->
					<!--<p>车辆限速</p>-->
					<!--</div>-->
					<div class="table_td">
						<p>使用性质</p>
					</div>
					<div class="table_td">
						<p>备注</p>
					</div>
				</div>
				<div class="jcda_content" >
					<?php if(is_array($car_list) || $car_list instanceof \think\Collection || $car_list instanceof \think\Paginator): $i = 0; $__LIST__ = $car_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
					<div class="show_car_mes ">
						<div class="table table_show" car_id ="<?php echo $v['id']; ?>" >
							<div class="table_td">
								<p><span class="jcda_edit">修改</span><span class="jcda_remove" style="margin-left: 5px;">删除</span></p>
							</div>
							<div class="table_td">
								<p ><?php echo $v['department_name']; ?></p><span style="display: none;"><?php echo $v['department_id']; ?></span>
							</div>
							<div class="table_td">
								<p><?php echo $v['owner']; ?> </p>
							</div>
							<div class="table_td">
								<p title="<?php echo $v['obd_mac']; ?>"><?php echo $v['obd_mac']; ?></p>
							</div>
							<div class="table_td">
								<p title="<?php echo $v['engine_num']; ?>"><?php echo $v['engine_num']; ?></p>
							</div>
							<div class="table_td">
								<p title="<?php echo $v['vin']; ?>"><?php echo $v['vin']; ?></p>
							</div>
							<div class="table_td">
								<p><?php echo $v['plate_num']; ?></p>
							</div>
							<div class="table_td">
								<p><?php echo $v['car_reg']; ?></p>
							</div>
							<div class="table_td">
								<?php if(empty($v['car_name']) || (($v['car_name'] instanceof \think\Collection || $v['car_name'] instanceof \think\Paginator ) && $v['car_name']->isEmpty())): ?><p style="color: yellowgreen">未设置</p><?php else: ?><p><?php echo $v['car_name']; ?></p><?php endif; ?>
							</div>
							<div class="table_td">
								<p><?php echo $v['inspection']; ?></p>
							</div>
							<div class="table_td">
								<p><?php echo $v['insurance']; ?></p>
							</div>
							<!--<div class="table_td">-->
							<!--<p><?php echo $v['speed']; ?></p>-->
							<!--</div>-->
							<div class="table_td">
								<p><?php if(empty($v['use_type']) || (($v['use_type'] instanceof \think\Collection || $v['use_type'] instanceof \think\Paginator ) && $v['use_type']->isEmpty())): ?>非营运<?php else: ?>营运<?php endif; ?></p>
							</div>
							<div class="table_td">
								<p><?php echo $v['remarks']; ?></p>
							</div>
						</div>
					</div>

					<?php endforeach; endif; else: echo "" ;endif; ?>
				</div>
				<div class="add_car left_add_btn absolute"
					 style="<?php if(count($list)>1): ?>display:none<?php endif; ?>">
					<div class="relative" style="height: 100%">
						<div class="absolute" style="right: 0">
							<img src="/static/index/image/jcda/icon1.png" alt="" style="width: 100%">
						</div>
						<div class="absolute btn_txt" style="right: 10%;color: #fff;">添加车辆</div>
					</div>

				</div>
			</div>

			<!-- 驾驶员 -->
			<div class="right_show_table relative car_user_mes" style="display: none;">

				<div class="table table_header">
					<div class="table_td">
						<p>编辑</p>
					</div>
					<div class="table_td">
						<p>工号</p>
					</div>
					<div class="table_td">
						<p>姓名</p>
					</div>
					<div class="table_td">
						<p>驾照类型</p>
					</div>
					<div class="table_td">
						<p>手机号</p>
					</div>
					<div class="table_td">
						<p>身份证号</p>
					</div>
					<div class="table_td">
						<p>住址信息</p>
					</div>
					<div class="table_td">
						<p>入职日期</p>
					</div>
					<div class="table_td">
						<p>发证日期</p>
					</div>
					<div class="table_td">
						<p>有效日期</p>
					</div>
				</div>
				<div class="jcda_content">
					<?php if(is_array($driver_list) || $driver_list instanceof \think\Collection || $driver_list instanceof \think\Paginator): $i = 0; $__LIST__ = $driver_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
					<div class="show_user_mes">
						<div class="table table_show" driver_id="<?php echo $v['id']; ?>">
							<div class="table_td">
								<p><span class="jcda_edit">修改</span><span class="jcda_remove" style="margin-left: 5px;">删除</span></p>
							</div>
							<div class="table_td">
								<p><?php echo $v['job_num']; ?></p>
							</div>
							<div class="table_td">
								<div class="p_div" style=""><span class="pd_name"><?php echo $v['username']; ?></span>-<?php echo $v['name']; ?></div>
							</div>
							<div class="table_td  license">
								<p><?php echo $v['license_type']; ?></p>
							</div>
							<div class="table_td">
								<p><?php echo $v['mobile']; ?></p>
							</div>
							<div class="table_td">
								<p><?php echo $v['card_id']; ?></p>
							</div>
							<div class="table_td">
								<p><?php echo $v['address']; ?></p>
							</div>
							<div class="table_td">
								<p><?php echo $v['enty_data']; ?></p>
							</div>
							<div class="table_td">
								<p><?php echo $v['license_first']; ?></p>
							</div>
							<div class="table_td">
								<p><?php echo $v['license_end']; ?></p>
							</div>
						</div>
					</div>

					<?php endforeach; endif; else: echo "" ;endif; ?>
				</div>
				<div class="add_user  left_add_btn absolute"
					 style="<?php if(count($list)>1): ?>display:none<?php endif; ?>">
					<div class="relative" style="height: 100%">
						<div class="absolute" style="right: 0">
							<img src="/static/index/image/jcda/icon2.png" alt="" style="width: 100%">
						</div>
						<div class="absolute btn_txt" style="right: 10%;color: #fff;">添加驾驶员</div>
					</div>
				</div>
			</div>
			<!--部门管理-->
			<div class="right_show_table relative base_header_mes" style="color:white;display:none;">
				<div style="width: 700px;margin:0 auto;margin-top: 50px;">
					<div id="null_dep" style="display: none">
						<div style="width: 280px;margin:0 auto;">
							<img src="__INDEX_IMG__/jcda/no_dep.png" alt="" style="width: 280px; opacity: 0.6;"></div>
						<div style="text-align: center">尚未添加部门</div>
					</div>
					<div style="text-align: center;" id="not_null_dep" class="clear_fl">
						<div>部门</div>
						<div>操作</div>
					</div>
					<ul class="had_depart">
						<?php if(is_array($department_list) || $department_list instanceof \think\Collection || $department_list instanceof \think\Paginator): $i = 0; $__LIST__ = $department_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
						<li><span id="<?php echo $v['id']; ?>" class="had_dep_name" style="text-align: left"><?php echo $v['username']; ?>-<?php echo $v['department_name']; ?></span><span
								class="dep_input_del">删除</span><span class="dep_input_edit">修改</span></li>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
					<div id="add_dep_input" style="display: none;width: 330px;margin:0 auto;margin-top: 20px;">
						<input type="text" placeholder="请输入部门信息">
						<div><button id="dep_ok">确认</button><button id="dep_qx">取消</button></div>
					</div>
					<div id="add_dep_no" style="<?php if(count($list)>1): ?>display:none<?php endif; ?>">添加部门</div>
				</div>
			</div>
			<!-- 车辆详细信息 -->
			<div class="right_show_table relative  car_book_mes" style="display:none">
				<div class="table table_header">
					<div class="table_td"><p>品牌</p></div>
					<div class="table_td"><p>车型</p></div>
					<div class="table_td"><p>年款</p></div>
					<div class="table_td"><p>排放标准</p></div>
					<div class="table_td"><p>排量</p></div>
					<div class="table_td"><p>车辆类型</p></div>
					<div class="table_td"><p>车油品标号</p></div>
					<div class="table_td"><p>气缸容积</p></div>
					<div class="table_td"><p>最大马力(PS)</p></div>
					<div class="table_td"><p>最大功率(kW)</p></div>
					<div class="table_td"><p>驱动方式</p></div>
					<div class="table_td"><p>燃料类型</p></div>
					<div class="table_td"><p>变速器</p></div>
					<!--<div class="table_td"><p>查看延保<i onclick="iShowDetail()">?</i></p></div>-->
				</div>
				<div class="jcda_content" >
					<div class="show_car_book_mes ">
						<?php if(is_array($info) || $info instanceof \think\Collection || $info instanceof \think\Paginator): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;if(!(empty($v['id']) || (($v['id'] instanceof \think\Collection || $v['id'] instanceof \think\Paginator ) && $v['id']->isEmpty()))): ?>
						<div class="table table_show">
							<div class="table_td"><p><?php echo $v['plate_num']; ?></p></div>
							<div class="table_td"><p><?php echo $v['brand']; ?>-<?php echo $v['models']; ?></p></div>
							<div class="table_td"><p><?php echo $v['year']; ?></p></div>
							<div class="table_td"><p><?php echo $v['emission_standard']; ?></p></div>
							<div class="table_td"><p><?php echo $v['displacement']; ?></p></div>
							<div class="table_td"><p><?php echo $v['vehicle_type']; ?></p></div>
							<div class="table_td"><p><?php echo $v['fuel_grade']; ?></p></div>
							<div class="table_td"><p><?php echo $v['cylinder_volume']; ?></p></div>
							<div class="table_td"><p><?php echo $v['cylinder_volume']; ?></p></div>
							<div class="table_td"><p><?php echo $v['power_kw']; ?></p></div>
							<div class="table_td"><p><?php echo $v['transmission_description']; ?></p></div>
							<div class="table_td"><p><?php echo $v['fuel_type']; ?></p></div>
							<div class="table_td"><p><?php echo $v['drive_mode']; ?></p></div>
							<!--<div class="table_td"><p class="p_yb_btn" >查看</p></div>-->
						</div>
						<?php endif; endforeach; endif; else: echo "" ;endif; ?>
					</div>
				</div>
			</div>
		</div>
		<!-- 添加车辆 -->
		<div class="absolute common_tc if_add_car" style="display:none  ;">
			<div class=" relative base_header_mes" style="margin-top: 140px;">
				<div class="table table_header">
					<div class="table_td">
						<p>部门</p>
					</div>
					<div class="table_td">
						<p>所有者</p>
					</div>
					<div class="table_td">
						<p>盒子编号</p>
					</div>
					<div class="table_td">
						<p>发动机号码</p>
					</div>
					<div class="table_td">
						<p>车架号</p>
					</div>
					<div class="table_td">
						<p>车牌照</p>
					</div>
					<div class="table_td">
						<p>车辆登记日期</p>
					</div>
					<div class="table_td">
						<p>车辆别名</p>
					</div>
					<div class="table_td">
						<p>年检</p>
					</div>
					<div class="table_td">
						<p>车险</p>
					</div>
					<!--<div class="table_td">-->
					<!--<p>车辆限速</p>-->
					<!--</div>-->
					<div class="table_td">
						<p>使用性质</p>
					</div>
					<div class="table_td">
						<p>备注</p>
					</div>
				</div>
				<div class="table table_show add_show">
					<div class="table_td">
						<p>
							<select id="department_id">
								<?php if(is_array($department_list) || $department_list instanceof \think\Collection || $department_list instanceof \think\Paginator): $i = 0; $__LIST__ = $department_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
								<option value="<?php echo $v['id']; ?>"><?php echo $v['department_name']; ?></option>
								<?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
						</p>
					</div>
					<div class="table_td">
						<p><input name="owner" type="text" placeholder="所有者"></p>
					</div>
					<div class="table_td">
						<p ><input name="obd_id" type="text" placeholder="OBD盒子编号"></p>
					</div>
					<div class="table_td">
						<p><input name="engine_num" type="text" placeholder="发动机号码"></p>
					</div>
					<div class="table_td">
						<p><input name="vin" type="text" placeholder="车架号"></p>
					</div>
					<div class="table_td">
						<p><input name="plate_num" type="text" placeholder="车牌照"></p>
					</div>
					<div class="table_td">
						<p><input name="car_reg" type="text" placeholder="车辆登记日期" class="laydate-icon" onclick="laydate({isdate: true, format: 'YYYY-MM-DD'})"></p>
					</div>
					<div class="table_td">
						<p ><input name="car_name" type="text" placeholder="车辆别名"></p>
					</div>
					<div class="table_td">
						<p><input name="inspection" type="text" placeholder="年检"  class="laydate-icon" onclick="laydate({isdate: true, format: 'YYYY-MM-DD'})"></p>
					</div>
					<div class="table_td">
						<p><input name="insurance" type="text" placeholder="车险"  class="laydate-icon" onclick="laydate({isdate: true, format: 'YYYY-MM-DD'})"></p>
					</div>
					<!--<div class="table_td">-->
					<!--<p ><input name="speed" type="text" placeholder="车辆限速"></p>-->
					<!--</div>-->
					<div class="table_td ">
						<p><input name="use_type" type="text" placeholder="使用性质"></p>
						<div style="display: none" id="use_type">
							<div ><span style="display: none">0</span>非营运</div>
							<div><span style="display: none">1</span>营运</div>
						</div>

					</div>
					<div class="table_td">
						<p><input name="remarks" type="text" placeholder="备注"></p>
					</div>
					<!--<input name="car_id" type="hidden" value="">-->
				</div>
			</div>
			<div class="add_btn"><button id="add_car_ok">确认</button><button class="no_btn">取消</button><button id="add_car_reset">重置</button></div>
		</div>
		<!-- 添加驾驶员按钮实现 -->
		<div class="absolute common_tc if_add_user" style="display:none;">
			<div class=" relative  car_user_mes" style="margin-top: 140px;">
				<div class="table table_header">
					<div class="table_td">
						<p>工号</p>
					</div>
					<div class="table_td">
						<p>姓名</p>
					</div>
					<div class="table_td">
						<p>驾照类型</p>
					</div>
					<div class="table_td">
						<p>手机号</p>
					</div>
					<div class="table_td">
						<p>身份证号</p>
					</div>
					<div class="table_td">
						<p>住址信息</p>
					</div>
					<div class="table_td">
						<p>入职日期</p>
					</div>
					<div class="table_td">
						<p>发证日期</p>
					</div>
					<div class="table_td">
						<p>有效日期</p>
					</div>
				</div>
				<div class="table add_show">
					<div class="table_td">
						<p><input name="job_num" type="text" placeholder="请输入工号"></p>
					</div>
					<div class="table_td">
						<p><input name="dname" type="text" placeholder="请输入姓名"></p>
					</div>
					<div class="table_td">
						<p >
							<select id="license_type">
								<option value='A1'>A1</option>
								<option value='A2'>A2</option>
								<option value='A3'>A3</option>
								<option value='B1'>B1</option>
								<option value='B2'>B2</option>
								<option value='C1'>C1</option>
								<option value='C2'>C2</option>
								<option value='C3'>C3</option>
								<option value='C4'>C4</option>
								<option value='D'> D</option>
								<option value='E'> E</option>
								<option value='F'> F</option>
								<option value='M'> M</option>
								<option value='N'> N</option>
								<option value='P'> P</option>
							</select>
						</p>
					</div>
					<div class="table_td">
						<p><input name="mobile" type="text" placeholder="请输入手机号"></p>
					</div>
					<div class="table_td">
						<p><input name="card_id" type="text" placeholder="请输入身份证号"></p>
					</div>
					<div class="table_td">
						<p><input name="address" type="text" placeholder="住址信息"></p>
					</div>
					<div class="table_td">
						<p><input name="enty_data" type="text" placeholder="入职日期" class="laydate-icon" onclick="laydate({isdate: true, format: 'YYYY-MM-DD'})"></p>
					</div>
					<div class="table_td">
						<p><input name="license_first" type="text" placeholder="发证日期" class="laydate-icon" onclick="laydate({isdate: true, format: 'YYYY-MM-DD'})"></p>
					</div>
					<div class="table_td">
						<p><input name="license_end" type="text" placeholder="有效日期" class="laydate-icon" onclick="laydate({isdate: true, format: 'YYYY-MM-DD'})"></p>
					</div>
				</div>
			</div>
			<div class="add_btn"><button id="add_user_ok">确认</button><button class="no_btn">取消</button><button id="add_user_reset">重置</button></div>
		</div>

		<!--查看延保信息-->
		<div class="absolute common_tc if_ck_yb" style="display:none; color: white;">
			<div class="clear_fl">
				<div style="float: right;border:1px solid #ccc;padding: 5px;width: 20px;height: 20px;text-align: center;border-radius: 50%;font-size: 20px;line-height: 20px;cursor: pointer;color: white;" class="close_window no_btn">X</div>
			</div>
			<div style="width:500px;height:600px;margin:0 auto;border:1px solid white; text-align: center;margin-top:10px;">
				<div style="margin:30px 10px;font-size: 18px;">
					<div>检测结果</div>
					<div style="margin-top: 20px;border:1px solid white;border-radius: 5px;margin:20px auto;padding:10px;width:200px;">可以延保</div>
				</div>
				<div style="font-size: 16px;text-align: left;margin-left: 10%;">
					<div class="clear_fl" style="margin:20px;">
						<div class="left" style="width: 40%;">是否改装</div>
						<div class="left" style="width: 30%;">否</div>
						<div class="left yb_show_detail" style="width: 30%; cursor: pointer;display: none;">查看详情</div>

					</div>
					<div style="display: none"></div>
					<div class="clear_fl" style="margin:20px;">
						<div class="left" style="width: 40%;">使用时长</div>
						<div class="left" style="width: 30%;"> < 2万小时</div>
						<div class="left yb_show_detail" style="width: 30%; cursor: pointer;display: none;">查看详情</div>

					</div>
					<div style="display: none"></div>
					<div class="clear_fl" style="margin:20px;">
						<div class="left" style="width: 40%;">是否出现重大交通事故</div>
						<div class="left" style="width: 30%;">2</div>
						<div class="left yb_show_detail" style="width: 30%; cursor: pointer;">查看详情</div>
					</div>
					<div style="margin:20px; height: 60px;display: none">
						<ol style="margin-left:20px;">
							<li>2017-06-30 京港澳高速河北路段出现重大交通事故</li>
						</ol>

					</div>
					<div class="clear_fl" style="margin:20px;">
						<div class="left" style="width: 40%;">行驶里程</div>
						<div class="left" style="width: 30%;">2w KM</div>
						<div class="left yb_show_detail" style="width: 30%; cursor: pointer; display: none;">查看详情</div>

					</div>
					<div style="display: none"></div>
					<div class="clear_fl" style="margin:20px;">
						<div class="left" style="width: 40%;">行驶系统</div>
						<div class="left" style="width: 30%;">通过</div>
						<div class="left yb_show_detail" style="width: 30%; cursor: pointer; display: none;">查看详情</div>

					</div>
					<div style="display: none"></div>
					<div class="clear_fl" style="margin:20px;">
						<div class="left" style="width: 40%;">离合器情况</div>
						<div class="left" style="width: 30%;">通过</div>
						<div class="left yb_show_detail" style="width: 30%; cursor: pointer;display: none;">查看详情</div>

					</div>
					<div style="display: none"></div>
					<div class="clear_fl" style="margin:20px;">
						<div class="left" style="width: 40%;">变速器</div>
						<div class="left" style="width: 30%;">通过</div>
						<div class="left yb_show_detail" style="width: 30%; cursor: pointer;display: none;">查看详情</div>

					</div>
					<div style="display: none"></div>
					<div class="clear_fl" style="margin:20px;">
						<div class="left" style="width: 40%;">制动系统</div>
						<div class="left" style="width: 30%;">通过</div>
						<div class="left yb_show_detail" style="width: 30%; cursor: pointer;display: none;">查看详情</div>

					</div>
					<div style="display: none"></div>
					<div class="clear_fl" style="margin:20px;">
						<div class="left" style="width: 40%;">外观</div>
						<div class="left" style="width: 30%;">通过</div>
						<div class="left yb_show_detail" style="width: 30%; cursor: pointer;display: none;">查看详情</div>


						<div style="display: none"></div>
					</div>
				</div>

			</div>
		</div>
		<!--查看延保详细-->
		<div class="absolute common_tc if_i_show_detail" style="display:none;color: white">
			<div class="clear_fl">
				<div style="float: right;border:1px solid #ccc;padding: 5px;width: 20px;height: 20px;text-align: center;border-radius: 50%;font-size: 20px;line-height: 20px;cursor: pointer;color: white;" class="close_window">X</div>
			</div>
			<div style="width:500px;height:600px;margin:0 auto;border:1px solid white; text-align: center;margin-top:40px;">
				<div style="margin:30px 10px;font-size: 18px;">评判标准</div>
				<div style="font-size: 16px;text-align: left;margin-left: 10%;">
					<div class="clear_fl" style="margin:20px;">
						<div class="left" style="width: 50%;">1、是否改装</div>
						<div class="left" style="width: 50%;">2、使用时长</div>
					</div>
					<div class="clear_fl" style="margin:20px;">
						<div class="left" style="width: 50%;">3、是否出现重大交通事故</div>
						<div class="left" style="width: 50%;">4、行驶里程</div>
					</div>
					<div class="clear_fl" style="margin:20px;">
						<div class="left" style="width: 50%;">5、转向系统</div>
						<div class="left" style="width: 50%;">6、离合器情况</div>
					</div>
					<div class="clear_fl" style="margin:20px;">
						<div class="left" style="width: 50%;">7、变速器</div>
						<div class="left" style="width: 50%;">8、制动系统</div>
					</div>
					<div class="clear_fl" style="margin:20px;">
						<div class="left" style="width: 50%;">9、外观</div>
						<div class="left" style="width: 50%;"></div>

					</div>
				</div>

			</div>
		</div>
	</div>
</div>
<div class="hidden_input" style="display: none;">
	<input type="text">
	<input type="text">
	<input type="text">
	<input type="text">
	<input type="text">
	<input type="text">
	<input type="text">
	<input type="text">
	<input type="text">
	<input type="text">
	<input type="text">
	<input type="text">
	<input type="text">
</div>
<div class="hidden_input_user" style="display:none;">
	<input type="text">
	<input type="text">
	<input type="text" class="license">
	<input type="text" >
	<input type="text">
	<input type="text">
	<input type="text">
	<input type="text">
	<input type="text">
</div>

<input type="hidden" id="hide_input">
</body>
<script type="text/javascript" src="__INDEX_JS__/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="__INDEX_JS__/common.js"></script>
<script type="text/javascript" src="__INDEX_JS__/laydate.js"></script>
<script type="text/javascript" src="__INDEX_JS__/jcda.js"></script>

</html>