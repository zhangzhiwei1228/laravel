<?php
/**
 * Created by PhpStorm.
 * User: zzw
 * Date: 16-4-11
 * Time: 下午3:29
 */
//冒泡排序
function bubble_sort($arr) {
    $len = count($arr);
    if($len <= 1) return $arr;
    $flag = false;
    for($i = 0; $i<$len-1;$i++) {
        for($j = $i+1;$j<$len;$j++) {
            if($arr[$j] < $arr[$i]){
                $temp = $arr[$i];
                $arr[$i] = $arr[$j];
                $arr[$j] = $temp;
                $flag = true;
            }
        }
        if(!$flag) continue;
    }
    return $arr;
}
//快速排序
function quick_sort($arr) {
    $len = count($arr);
    if($len <= 1) return $arr;
    $key = $arr[0];
    $left_array = array();
    $right_array = array();
    for($i=1;$i<$len;$i++) {
        if($arr[$i] <= $key)
            $left_array[] = $arr[$i];
        else
            $right_array[] = $arr[$i];
    }
    $left_array = quick_sort($left_array);
    $right_array = quick_sort($right_array);
    return array_merge($left_array,array($key),$right_array);

}
$arr = bubble_sort(array(2,5,7,9,1,3,10));
var_dump($arr);
$arr = quick_sort(array(1,3,5,2,7,3,7,10));
var_dump($arr);

