<?php
/**
 * Created by PhpStorm.
 * User: zzw
 * Date: 16-4-11
 * Time: 上午11:02
 */
include 'Model.php';
include 'View.php';

class Controller {
    private $model     = '';
    private $view      = '';

    public function Controller() {
        $this->model   =    new Model();
        $this->view    =    new View();
    }

    public function doAction( $method = 'defaultMethod', $params = array() ) {
        if( empty($method) ){
            $this->defaultMethod();
        } else if( method_exists($this, $method) ) {
            call_user_func(array($this, $method), $params);//该函数允许用户调用直接写的函数并传入一定的参数
        } else {
            $this->nonexisting_method();
        }
    }

    public function link_page($name = '') {
        $links = $this->model->getLinks();
        $this->view->display($links);

        $result = $this->model->getResult($name);
        $this->view->display($result);
    }

    public function defaultMethod() {
        $this->br();
        echo "This is the default method. ";
    }

    public function nonexisting_method(){
        $this->br();
        echo "This is the noexisting method. ";
    }

    public function br(){
        echo "<br />";
    }
}


$controller = new Controller();
$controller->doAction('link_page', 'b');
$controller->doAction();//当没有传方法名的时候