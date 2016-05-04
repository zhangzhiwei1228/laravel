<?php
/**
 * Created by PhpStorm.
 * User: zzw
 * Date: 16-4-11
 * Time: 上午11:25
 */
include 'Model.php';
include 'View.php';
class controller {
    private $model = '';
    private $view = '';
    public function __construct() {
        $this->model = new Model();
        $this->view = new View();
    }
    public function doActive($method = 'defaultMethod',$params = array()) {
        if(empty($method)) {
            $this->defaultMethod();
        } elseif(method_exists($this,$method)) {
            call_user_func(array($this,$method),$params);
        } else {
            $this->NoExitsMethod();
        }
    }
    public function link_page($name='a') {
        $links = $this->model->getLinks();
        $this->view->display($links);

        $result = $this->model->getResult($name);
        $this->view->display($result);
    }

    public function defaultMethod() {
        echo "This is the default method";
    }
    public function NoExitsMethod() {
        echo "No Exits Method";
    }
}
$controller = new Controller();
$controller->doActive('link_page','b');
$controller->doActive();