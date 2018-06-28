<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:60:"/data/work/public/../application/index/view/login/login.html";i:1529664779;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>车工云管控 — 登录</title>
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
        .login div input{
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
        @media screen and (max-width: 1920px) and (min-width: 1600px) {
            .login{
                margin-top: 18%;
                width:19%;
                min-width: 192px;
                /*border:1px solid #fff;*/
                right: 24%;
            }
            .login div input{
                width: 85%;
                margin-left: 24%;
                margin-top: 12%;
                font-size: 18px;
            }
            .ok_up{
                font-size: 16px;
                padding:10px;

            }
            .get_check{
                font-size: 18px;
            }
            .get_check span{
                margin-top: -10%;
            }
        }
        @media screen and (max-width: 1600px) and (min-width: 1440px) {
            .login{
                margin-top: 18%;
                width:19%;
                min-width: 192px;
                /*border:1px solid #fff;*/
                right: 24%;
            }
            .login div input{
                width: 85%;
                margin-left: 20%;
                margin-top: 8%;
                font-size: 18px;
            }
            .ok_up{
                font-size: 16px;
                padding:10px;

            }
            .get_check{
                font-size: 16px;
            }
            .get_check span{
                margin-top: -16%;
            }
        }
        @media screen and (max-width: 1440px) and (min-width: 1024px) {
            .login{
                margin-top: 18%;
                width:19%;
                min-width: 192px;
                /*border:1px solid #fff;*/
                right: 24%;
            }
            .login div input{
                width: 80%;
                margin-left: 20%;
                margin-top: 8%;
                font-size: 15px;
            }
            .ok_up{
                font-size: 16px;
                padding:5px;
            }
            .get_check{
                font-size: 14px;
            }
            .get_check span{
                margin-top: -10%;
            }
        }
        @media screen and (max-width:1024px) {
            .login{
                margin-top: 180px;
                width:185px;
                margin-left:588px;
            }
            .login div input{
                width: 80%;
                margin-left: 26px;
                margin-top: 10px;

                font-size: 14px;
            }
            .ok_up{
                font-size: 14px;
                padding:5px;
            }
            .get_check{
                font-size: 12px;
            }
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
<body onload="pageload()">
<div style="position: relative;">
    <div style="position: absolute;top: 0">
        <img src="__INDEX_IMG__/login/login.png" alt="" style="width:100%;min-width:1024px;height: 100%; background: url(__INDEX_IMG__/login/login.png) no-repeat center; background-size: cover;">
    </div>
    <div style="" class="login">
        <div style="position: relative;background: rgb(11,43,102) " >
            <div style="position: absolute;">
                <img src="__INDEX_IMG__/login/phone.png" alt="" style="width:100%;height: 100%;">
            </div>
            <div style="position: absolute;">
                <input style="" id="get_phone" type="text" placeholder="请输入手机号码" >
            </div>
        </div>
        <div style="position: relative;margin-top: 30%">
            <div style="position: absolute;">
                <img src="__INDEX_IMG__/login/pwd.png" alt="" style="width:100%;height: 100%; ">
            </div>
            <div style="position: absolute;">
                <input id="pwd" type="password" placeholder="请输入密码">
            </div>
        </div>
        <div style="position: relative;margin-top: 55%" class="get_check">
            <p style="position: absolute;color: white;">
                <input type="checkbox" id="save_pwd" style="height: 16px;width:16px;margin-left: 2px;" checked><span style="display: inline-block;position: absolute;width: 200px;margin-left: 6px;;">记住密码</span>
            </p>

            <p style="position: absolute;right: 0;color: white;padding-right: 6px;cursor: pointer;"><a href="<?php echo url('Reg/reset'); ?>">忘记密码</a></p>
        </div>
        <div style="position: relative;width: 100%;margin-top: 70%">
            <button class="ok_up">登&nbsp;&nbsp;&nbsp;&nbsp;录</button>

            <div style="width: 100%;text-align: center;margin-top: 2%;"><div class="">
                <a href="<?php echo url('Reg/index'); ?>">去注册</a>
            </div>
            </div>


        </div>
    </div>
</div>
</body>
<script type="text/javascript" src="__INDEX_JS__/jquery.min.js"></script>
<script type="text/javascript">
    function pageload(){
        var get_local_name = localStorage.getItem("local_name");
        var get_local_pwd = localStorage.getItem('local_pwd');
//        console.log(get_local_name)

        //判断，如果输入的值等于存储的值
        if(get_local_name){
            $('#get_phone').val(get_local_name);
        }
        if(get_local_pwd){
            $('#pwd').val(get_local_pwd);
        }
    }

    $('.ok_up').click(function(){
        login_up();
    });
    $("body").keydown(function() {
        if (event.keyCode == "13") {
            login_up();
        }
    });
    function  login_up(){
//        alert('p')
        var get_name = $('#get_phone').val();
        var get_pwd = $('#pwd').val();
        localStorage.setItem("local_name",get_name);
        if($('#save_pwd').prop("checked")){
            localStorage.setItem("local_pwd",get_pwd);
//            console.log(get_pwd)
        }else{
            localStorage.removeItem("local_pwd");
        }

        var mobile = $('#get_phone');
//        var mobile_reg = /^1[3578]{1}[0-9]{9}$/;
//        if(!mobile_reg.test(mobile.val())){
//            alert("请输入正确的电话号码");
//            return false;
//        }
        var data = {};
        if($('#pwd').val() == ""){
            alert("请输入密码");
            return false;
        }
        if($('#pwd').val().length<6){
            alert("密码不能少于六位");
            return false;
        }
        var url = "login";
        if(mobile.val()=='tjyz'){
            data.mobile = 'tjyz-cg'
        }else{
            data.mobile = mobile.val();
        }
        data.source = 'auto';

        data.password = $('#pwd').val();


        $.post(url,data,function(d){

            if(d.error == 0){
                window.location.href = d.url;
            }else{
                alert(d.msg);
            }

        },"json");
    }

</script>
</html>