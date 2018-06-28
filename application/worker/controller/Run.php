<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/12
 * Time: 21:06
 */
use Workerman\Worker;
use GatewayWorker\Register;
use GatewayWorker\BusinessWorker;
use GatewayWorker\Gateway;

class Run
{
    //控制器无需继承Controller
    /**
     * 构造函数
     * @access public
     */
    public function __construct()
    {
        //由于是手动添加，因此需要注册命名空间，方便自动加载，具体代码路径以实际情况为准
        \think\Loader::addNamespace([
            'Workerman' => EXTEND_PATH . 'Workerman/workerman',
            'GatewayWorker' =>EXTEND_PATH . 'Workerman/gateway-worker/src',
        ]);

        //初始化各个GatewayWorker
        //初始化register
        new Register('text://0.0.0.0:1545');

        //初始化 bussinessWorker 进程
        $worker = new BusinessWorker();
        $worker->name = 'YourAppBusinessWorker';
        $worker->count = 4;
        $worker->registerAddress = '127.0.0.1:1545';
        //设置处理业务的类,此处制定Events的命名空间
        $worker->eventHandler = '\app\push\controller\Events';
        // 初始化 gateway 进程
        $gateway = new Gateway("websocket://0.0.0.0:1546");
        $gateway->name = 'YourAppGateway';
        $gateway->count = 4;
        $gateway->lanIp = '127.0.0.1';
        $gateway->startPort = 2900;
        $gateway->registerAddress = '127.0.0.1:1545';

        //运行所有Worker;
        Worker::runAll();
    }

}