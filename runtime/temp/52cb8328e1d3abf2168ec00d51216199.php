<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:58:"/data/work/public/../application/index/view/reg/index.html";i:1528789157;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>注册界面</title>
    <style type="text/css">
        *{
            margin:0;
            padding:0;
        }
        body{
            background: #03102E;
        }
        .login{
            position: absolute;
            z-index: 99;
            color:#fff;
        }
        .login_input,.reg_input{
            outline: none;
            border:none;
            background: rgb(11,43,102);
            color: #56b0ea;
        }
        .ok_up{
            border:none;
            width: 100%;
            color: white;
            cursor: pointer;
            background: #00c1de;
        }
        #btn_get_code{
            color: #fff;
            text-align: center;
            outline: none;
            border:none;
            background: none;
        }
        @media screen and (max-width: 1920px) and (min-width: 1600px) {
            .login{
                margin-top: 17%;
                width:19%;
                min-width: 192px;
                /*border:1px solid #fff;*/
                right: 24%;
            }
            .login_input{
                width: 85%;
                margin-left: 24%;
                margin-top: 11%;
                font-size: 18px;
            }
            .ok_up{
                font-size: 16px;
                padding:10px;

            }
            .reg_input{
                width: 80%;
                margin-left: 10%;
                margin-top: 11%;
                font-size: 18px;
            }
            #btn_get_code{
                width: 34%;
                font-size: 18px;
                margin-top: 6%;
            }
        }
        @media screen and (max-width: 1600px) and (min-width: 1440px) {
            .login{
                margin-top: 16.5%;
                width:19%;
                min-width: 192px;
                /*border:1px solid #fff;*/
                right: 24%;
            }
            .login_input{
                width: 85%;
                margin-left: 20%;
                margin-top: 8%;
                font-size: 18px;
            }
            .ok_up{
                font-size: 16px;
                padding:10px;

            }
            .reg_input{
                width: 80%;
                margin-left: 10%;
                margin-top: 11%;
                font-size: 16px;
            }
            #btn_get_code{
                width: 34%;
                font-size: 16px;
                margin-top: 4.5%;
            }
        }
        @media screen and (max-width: 1440px) and (min-width: 1024px) {
            .login{
                margin-top: 16.5%;
                width:19%;
                min-width: 192px;
                /*border:1px solid #fff;*/
                right: 24%;
            }
            .login_input{
                width: 80%;
                margin-left: 20%;
                margin-top: 8%;
                font-size: 15px;
            }
            .ok_up{
                font-size: 16px;
                padding:5px;
            }

            .reg_input{
                width: 80%;
                margin-left: 10%;
                margin-top: 11%;
                font-size: 16px;
            }

            #btn_get_code{
                width: 34%;
                font-size: 16px;
                margin-top: 4.5%;
            }

        }
        @media screen and (max-width:1024px) {
            .login{
                margin-top: 170px;
                width:185px;
                margin-left:588px;
            }
            .login_input{
                width: 80%;
                margin-left: 26px;
                margin-top: 10px;

                font-size: 14px;
            }

            .ok_up{
                font-size: 14px;
                padding:5px;
            }

            .reg_input{
                width: 80%;
                margin-left: 10px;
                margin-top: 10px;
                font-size: 14px;
            }

            #btn_get_code{
                width: 34%;
                font-size: 12px;
                margin-left: 3px;
                margin-top: 8px;
            }
        }
        .left{
            float: left;
        }
        .clear_fl:after{
            display: block;
            content: '';
            clear: both;
        }
        a:link,a:visited,a:hover,a:active{
            color: white;
            list-style-type: none;
            text-decoration: none;
        }
        .ok_up:hover{
            /*background: rgba(126,184,233,0.8);*/
        }

        body::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>
<body style="">
<div style="position: relative;">
    <div style="position: absolute;top: 0">
        <img src="__INDEX_IMG__/login/login.png" alt="" style="width:100%;min-width:1024px;height: 100%; background: url(login/login.png) no-repeat center; background-size: cover;">
    </div>
    <div style="" class="login">
        <div style="position: relative; " >
            <div style="position: absolute;">
                <img src="__INDEX_IMG__/login/phone.png" alt="" style="width:100%;height: 100%;">
            </div>
            <div style="position: absolute;" id="get_phone">
                <input class="login_input" style=""  type="text" placeholder="请输入手机号码" maxlength="13">
            </div>
        </div>
        <div style="position: relative;margin-top: 25% " >
            <div  class="clear_fl">
                <div  class="left reg" style="position: relative;width: 60%">
                    <div style="position: absolute;">
                        <img src="__INDEX_IMG__/login/sr_yzm.png" alt="" style="width:100%;height: 100%;">
                    </div>
                    <div style="position: absolute;" id="yzm" >
                        <input type="text" placeholder="请输入验证码" class="reg_input">
                    </div>
                </div>
                <div class="left reg_btn" style="margin-left: 64%;width: 40%" >
                    <div style="position: absolute;">
                        <img src="__INDEX_IMG__/login/get_yzm.png" alt="" style="width:100%;height: 100%">
                    </div>
                    <div style="position: absolute;width: 100%" >
                        <button   id="btn_get_code">验证码</button>
                    </div>
                </div>
            </div>
        </div>
        <div style="position: relative;margin-top: 50%">
            <div style="position: absolute;">
                <img src="__INDEX_IMG__/login/pwd.png" alt="" style="width:100%;height: 100%; ">
            </div>
            <div style="position: absolute;">
                <input id="pwd" class="login_input" type="password" placeholder="请输入密码" >
            </div>
        </div>
        <div style="position: relative;width: 100%;margin-top: 80%">
            <button class="ok_up">注&nbsp;册</button>


        </div>
        <div style="margin-top: 6%;text-align: center;color: #ccc;font-size: 14px;">注册即表示我同意 <a href="<?php echo url('reg/service'); ?>"><span style="color: #fff;font-size: 15px;">服务条款</span></a> 内容</div>
        <input type="hidden" name="sms_k" id="sms_k" value=''>
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
        var jDomMobile = $('#get_phone input');
        var mobile = jDomMobile.val();
        var sms_k = $("#sms_k").val();



        var re = /^1[3578]{1}[0-9]{9}$/;
        if(!re.test(mobile)){
            alert("手机号格式不正确");
            return false;
        }
        jDomMobile.attr("disabled","disabled");
        $(this).attr("disabled",'disabled');
        var param = {mobile:mobile,sms_k:sms_k};
        $.post("getSmsCode",param,function(d){
            d = eval('('+d+')');
            console.log(param);
            console.log(d);
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
        var mobile = $('#get_phone input');
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
        var url = "register";
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