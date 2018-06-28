<?php

namespace app\push\controller;

use think\worker\Server;

class Worker extends Server
{
// 运行worker

    protected $socket = 'websocket://show.chegong.com:2346';
    protected $static = false;
    protected $processes = 3;

    /**
     * 收到信息
     * @param $connection
     * @param $data
     */
    public function onMessage($connection)
    {
        while($this->static){
            $connection->send(file_get_contents('./MsgTest.php'));
                sleep(3);
        }
    }
    /**
     * 当连接建立时触发的回调函数
     * @param $connection
     */
    public function onConnect($connection)
    {
        $connection->send('连接成功');
    }
    /**
     * 当连接断开时触发的回调函数
     * @param $connection
     */
    public function onClose($connection)
    {
        $connection->send('连接关闭');
    }

    /**
     * 当客户端的连接上发生错误时触发
     * @param $connection
     * @param $code
     * @param $msg
     */
    public function onError($connection, $code, $msg)
    {
        echo "error $code $msg\n";
    }

    /**
     * 每个进程启动
     * @param $worker
     */
//    public function onWorkerStart($worker)
//    {
//
//    }

}
