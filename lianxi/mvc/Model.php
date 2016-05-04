<?php
/**
 * Created by PhpStorm.
 * User: zzw
 * Date: 16-4-11
 * Time: 上午11:03
 */
class Model {
    private $database = array(
        "a"    =>    "hello world",
        "b"    =>    "ok well done",
        "c"    =>    "good bye",
    );

    //@TODO connect the database

    //run the query and get the result
    public function getResult($name){
        if( empty($name) ) {
            return FALSE;
        }

        if( in_array($name, array_keys( $this->database ) ) ) {
            return $this->database[$name];
        }
    }

    public function getLinks() {
        $links = "<a href='#'>Link A</a>&nbsp;&nbsp;";
        $links.= "<a href='#'>Link B</a>&nbsp;&nbsp;";
        $links.= "<a href='#'>Link C</a>&nbsp;&nbsp;";

        return $links;
    }
}