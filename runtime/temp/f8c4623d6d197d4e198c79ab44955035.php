<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:58:"/data/work/public/../application/index/view/reg/reset.html";i:1511170101;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>修改密码</title>
	<style type="text/css">
	*{
		margin:0;
		padding:0;
	}
	.left{
		float: left;
	}
	.clear_fl:after{
		display: block;
		content: '';
		clear: both;
	}
	.reg>div{
		margin-bottom: 20px;
	}
		.reg div input{
			margin-left: 50px;
			height: 56px;
			width: 300px;
			line-height: 54px;
			margin-top: 7px;
			outline: none;
			border:none;
			background: rgb(11,43,102);
			font-size: 16px;
			color: #56b0ea;
		}
		a:link,a:visited,a:hover,a:active{
			color: white;
			list-style-type: none;
			text-decoration: none;
		}
	


		#sign_input button{
			border:none;
			padding:0 10px;
			height: 40px;
			background: none;
			color: white;
			outline: none;
			width: 86px;
			height: 70px;
			line-height: 70px;
			font-size: 16px;
			text-align: center;
			width: 130px;
			cursor: pointer;

		}

		.ok_up{
			border:none;
			width: 353px;
			height: 56px;
			font-size: 18px;
			padding:10px;
			/*font-weight: bold;*/
			color: white;
			/*border-radius: 10px;*/
			cursor: pointer;
			background: #00c1de;

		}
		
	</style>
</head>
<body style="">
	<div style="position: relative;width:1920px;height: 1080px;">
		<div style="position: absolute;width:1920px;height: 1080px;">
			<img src="__INDEX_IMG__/login/reg.png" alt="" style="width:100%;height: 1076px;">
		</div>	
		<div style="position: absolute;margin-left: 1100px;margin-top: 300px;" class="reg">
			<div style="background: url(__INDEX_IMG__/login/phone.png);height: 70px;width: 360px;">
				<input id="get_phone" type="text" placeholder="请输入手机号码" maxlength="13">
			</div>
			<div id="sign_input" style="width: 360px;position: relative;" class="clear_fl">				
				<div id="yzm" style="background: url(__INDEX_IMG__/login/sr_yzm.png);height: 70px;width: 219px;" class="left">
					<input type="text" placeholder="请输入验证码" style="width: 160px;">
				</div>
				<div class="left" style="background: url(__INDEX_IMG__/login/get_yzm.png);height: 70px;width: 131px;margin-left: 10px;">
					<button  id="btn_get_code">获取验证码</button>
				</div>
			</div>
			<div style="background: url(__INDEX_IMG__/login/pwd.png);height: 70px;width: 360px;">
                <input id="pwd" type="password" placeholder="请输入密码">
            </div>
			<div style="width: 100%;text-align: center;margin-top: 12%;">
				<button class="ok_up" id="ok_up">确&nbsp;认&nbsp;修&nbsp;改</button>
			</div>
            <input id="sms_k" type="hidden" value="">
		</div>
	</div>
</body>
<script type="text/javascript" src="__INDEX_JS__/jquery.min.js"></script>
<script type="text/javascript">
    var g_sms_timer_ct = 60;
    var g_sms_timer = 0;
    // 加载sms_k
    $.post("get_sms_k",function(d){
        d = eval('('+d+')');
        $("#sms_k").val(d.content);
    });
    $("#btn_get_code").click(function(){
        var jDomMobile = $('#get_phone');
        var mobile = jDomMobile.val();
        var sms_k = $("#sms_k").val();
        var re = /^1[3578]{1}[0-9]{9}$/;
        if(!re.test(mobile)){
            alert("手机号格式不正确");
            return false;
        }
        jDomMobile.attr("disabled","disabled");
        $(this).attr("disabled",'disabled');
        var param = {mobile:mobile,sms_k:sms_k,reset:1};
        $.post("getSmsCode/",param,function(d){
            d = eval('('+d+')');
            if(d && d.error == 0){
                $("#sms_k").val(d.sms_k);
                g_sms_timer_ct = 60;
                $("#btn_get_code").text(g_sms_timer_ct);
                g_sms_timer = setInterval(function(){
                    g_sms_timer_ct--;
                    if(g_sms_timer_ct <= 0){
                        clearInterval(g_sms_timer);
                        $("#btn_get_code").text("重新获取");
                        jDomMobile.removeAttr("disabled");
                        $("#btn_get_code").removeAttr("disabled");
                    }else{
                        $("#btn_get_code").text(g_sms_timer_ct);
                    }
                },1000);
            }else if(d && d.error >0){
                alert(d.msg);
                clearInterval(g_sms_timer);
                $("#btn_get_code").text("获取验证码");
                jDomMobile.removeAttr("disabled");
                $("#btn_get_code").removeAttr("disabled");
            }
        });
    });
    $('.ok_up').click(function(){
        var mobile = $('#get_phone');
        var mobile_reg = /^1[3578]{1}[0-9]{9}$/;
        if(!mobile_reg.test(mobile.val())){
            alert("请输入正确的电话号码");
            return false;
        }
        var data = {};
        if($('#yzm input').val() == ""){
            alert("请输入验证码");
            return false;
        }
        if($('#yzm input').val().length<6){
            alert("验证码格式不正确");
            return false;
        }
        if($('#pwd').val() == ""){
            alert("请输入密码");
            return false;
        }
        if($('#pwd').val().length<6){
            alert("密码不能少于六位");
            return false;
        }
        var url = "resetpwd";
        data.mobile = mobile.val();
        data.user_pwd = $('#pwd').val();
        data.sms_code = $('#yzm input').val();
        $.post(url,data,function(d){
            if(d.error == 0){
                window.location.href = d.url;
            }else{
                alert(d.msg);
            }
        },"json");
    });
</script>
</html>