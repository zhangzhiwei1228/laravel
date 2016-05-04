<?php
/**
 * Created by PhpStorm.
 * User: zzw
 * Date: 16-3-21
 * Time: 下午7:19
 */
//连接RabbitMQ
$conn_args = array( 'host'=>'localhost' , 'port'=> '5672', 'login'=>'guest' ,

    'password'=> 'guest','vhost' =>'/');
$conn = new AMQPConnection($conn_args);
$conn->connect();
//创建exchange名称和类型
$channel = new AMQPChannel($conn);
$ex = new AMQPExchange($channel);
$ex->setName('test_exchange_post');
$ex->setType(AMQP_EX_TYPE_DIRECT);
$ex->setFlags(AMQP_DURABLE | AMQP_AUTODELETE);
$ex->declare();
//创建queue名称，使用exchange，绑定routingkey
$q = new AMQPQueue($channel);
$q->setName('test_queue_name');
$q->setFlags(AMQP_DURABLE | AMQP_AUTODELETE);
$q->declare();
$q->bind('test_exchange_post', 'test_routing_key');
//消息发布
$channel->startTransaction();
$message = json_encode(array('Hello World!','DIRECT'));
$ex->publish($message, 'test_routing_key');
$channel->commitTransaction();
$conn->disconnect();