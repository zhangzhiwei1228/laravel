<?php
/**
 * Created by PhpStorm.
 * User: zzw
 * Date: 16-3-21
 * Time: 下午7:20
 */
$conn_args = array( 'host'=>'localhost' , 'port'=> '5672', 'login'=>'guest' , 'password'=> 'guest','vhost' =>'/');
$conn = new AMQPConnection($conn_args);
$conn->connect();
//设置queue名称，使用exchange，绑定routingkey
$channel = new AMQPChannel($conn);
$q = new AMQPQueue($channel);
$q->setName('test_queue_name');
$q->setFlags(AMQP_DURABLE | AMQP_AUTODELETE);
$q->declare();
$q->bind('test_exchange_post', 'test_routing_key');
//消息获取
$messages = $q->get(AMQP_AUTOACK) ;
if ($messages){
    var_dump(json_decode($messages->getBody(), true ));
}
$conn->disconnect();