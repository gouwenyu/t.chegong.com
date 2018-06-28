<?php
/**
 * Created by PhpStorm.
 * User: Xd
 * Date: 2017/9/6
 * Time: 21:24
 * 广播消息服务器
 */
//监听所有发送链接信息，只要链接的是9502

$server = new swoole_websocket_server("0.0.0.0",9502);
//监听有没有客户端链接上来
$server->on('open',function ($server,$req){
    var_dump($req);//用户的请求信息
});
//监听有没有客户端发送消息过来
$server->on('message',function ($server,$freq){
    var_dump($freq);//用户发送过来的数据
});
//监听有没有客户端关闭
$server->on('closr',function ($server,$req){
    var_dump($req);
});
//开启服务
$server->start();