<?php
/**
 * Created by PhpStorm.
 * User: zzw
 * Date: 16-4-11
 * Time: 上午11:25
 */
class Model {
    private $data = array(
        "a"    =>    "hello world",
        "b"    =>    "ok well done",
        "c"    =>    "good bye",
    );
    function getResult($name) {
        if(!empty($name) && array_key_exists($name,$this->data)) {
            return $this->data[$name];
        } else {
            return false;
        }
    }
    public function getLinks() {
        $links = "<a href='#'>Link A</a>&nbsp;&nbsp;";
        $links.= "<a href='#'>Link B</a>&nbsp;&nbsp;";
        $links.= "<a href='#'>Link C</a>&nbsp;&nbsp;";

        return $links;
    }
}