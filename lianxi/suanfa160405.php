<?php
/**
 * Created by PhpStorm.
 * User: zzw
 * Date: 16-4-5
 * Time: 下午2:51
 */
header("Content-type: text/html; charset=utf-8");
//冒泡排序
/*
 * 在要排序的一组数中，对当前还未排好的序列，从前往后对相邻的两个数依次进行比较和调整，让较大的数往下沉，较小的往上冒。
 * 即，每当两相邻的数比较后发现它们的排序与排序要求相反时，就将它们互换。
 */
function bubble_sort($arr) {
    $flag = false;
    $n=count($arr);
    if($n <= 1) return $arr;
    for($i=0;$i<$n-1;$i++){
        for($j=$i+1;$j<$n;$j++) {
            if($arr[$j]<$arr[$i]) {
                $temp = $arr[$i];//将第一个值赋给一个变量
                $arr[$i] = $arr[$j];//将第一个值的该变成第二个的值
                $arr[$j] = $temp;//将第二个值变成那个变量的值
                $flag = true;
            }
        }
        if(!$flag) continue;//加这个判断运行时间会比较快
    }
    return $arr;
}
$arr = bubble_sort(array(1,3,5,2,7,3,7,10));
//$endtime =microtime();
//$thistime = $endtime-$starttime;
//var_dump($thistime);
var_dump($arr);
function bubbleSort($arr)
{
    $len=count($arr);
    //该层循环控制 需要冒泡的轮数
    for($i=1;$i<$len;$i++)
    { //该层循环用来控制每轮 冒出一个数 需要比较的次数
        for($k=0;$k<$len-$i;$k++)
        {
            if($arr[$k]>$arr[$k+1])
            {
                $tmp=$arr[$k+1];
                $arr[$k+1]=$arr[$k];
                $arr[$k]=$tmp;
            }
        }
    }
    return $arr;
}
//归并排序
function Merge(&$arr, $left, $mid, $right) {
    $i = $left;
    $j = $mid + 1;
    $k = 0;
    $temp = array();
    while ($i <= $mid && $j <= $right)
    {
        if ($arr[$i] <= $arr[$j])
            $temp[$k++] = $arr[$i++];
        else
            $temp[$k++] = $arr[$j++];
    }
    while ($i <= $mid)
        $temp[$k++] = $arr[$i++];
    while ($j <= $right)
        $temp[$k++] = $arr[$j++];
    for ($i = $left, $j = 0; $i <= $right; $i++, $j++)
        $arr[$i] = $temp[$j];
}

function MergeSort(&$arr, $left, $right)
{
    if ($left < $right)
    {
        $mid = floor(($left + $right) / 2);
        MergeSort($arr, $left, $mid);
        MergeSort($arr, $mid + 1, $right);
        Merge($arr, $left, $mid, $right);
    }
}
//二分查找递归
function bin_search_recursive($arr,$low,$high,$value) {
    if($low>$high)
        return false;
    else {
        $mid=floor(($low+$high)/2);
        if($value==$arr[$mid])
            return $mid;
        elseif($value<$arr[$mid])
            return bin_search($arr,$low,$mid-1,$value);
        else
            return bin_search($arr,$mid+1,$high,$value);
    }
}
//二分查找非递归
function bin_search_no_recursive($arr,$low,$high,$value) {
    while($low<=$high) {
        $mid=floor(($low+$high)/2);
        if($value==$arr[$mid])
            return $mid;
        elseif($value<$arr[$mid])
            $high=$mid-1;
        else
            $low=$mid+1;
    }
    return false;
}
//快速排序
/*
 * 选择一个基准元素，通常选择第一个元素或者最后一个元素。
 * 通过一趟扫描，将待排序列分成两部分，一部分比基准元素小，一部分大于等于基准元素。
 * 此时基准元素在其排好序后的正确位置，然后再用同样的方法递归地排序划分的两部分。
 *
 */
function quick_sort($arr) {
    $n=count($arr);
    if($n<=1)
        return $arr;
    $key = $arr[0];
    $left_arr=array();
    $right_arr=array();
    for($i=1;$i<$n;$i++) {
        if($arr[$i]<=$key)
            $left_arr[]=$arr[$i];
        else
            $right_arr[]=$arr[$i];
    }
    $left_arr=quick_sort($left_arr);//左递归
    $right_arr=quick_sort($right_arr);//右递归
    return array_merge($left_arr,array($key),$right_arr);//将三个数组合并
}
function quickSort($arr) {
    //先判断是否需要继续进行
    $length = count($arr);
    if($length <= 1) {
        return $arr;
    }
    //选择第一个元素作为基准
    $base_num = $arr[0];
    //遍历除了标尺外的所有元素，按照大小关系放入两个数组内
    //初始化两个数组
    $left_array = array();  //小于基准的
    $right_array = array();  //大于基准的
    for($i=1; $i<$length; $i++) {
        if($base_num > $arr[$i]) {
            //放入左边数组
            $left_array[] = $arr[$i];
        } else {
            //放入右边
            $right_array[] = $arr[$i];
        }
    }
    //再分别对左边和右边的数组进行相同的排序处理方式递归调用这个函数
    $left_array = quick_sort($left_array);
    $right_array = quick_sort($right_array);
    //合并
    return array_merge($left_array, array($base_num), $right_array);
}
//选择排序
/*
 * 在要排序的一组数中，选出最小的一个数与第一个位置的数交换。
 * 然后在剩下的数当中再找最小的与第二个位置的数交换，如此循环到倒数第二个数和最后一个数比较为止。
 */
function select_sort($arr) {
    $n=count($arr);
    for($i=0;$i<$n;$i++) {
        $k=$i;
        for($j=$i+1;$j<$n;$j++) {
            if($arr[$j]<$arr[$k])
                $k=$j;//将数组下表赋值给中间值
        }
        if($k!=$i) {
            $temp=$arr[$i];
            $arr[$i]=$arr[$k];
            $arr[$k]=$temp;
        }
    }
    return $arr;
}
function selectSort($arr) {
//双重循环完成，外层控制轮数，内层控制比较次数
    $len=count($arr);
    for($i=0; $i<$len-1; $i++) {
        //先假设最小的值的位置
        $p = $i;

        for($j=$i+1; $j<$len; $j++) {
            //$arr[$p] 是当前已知的最小值
            if($arr[$p] > $arr[$j]) {
                //比较，发现更小的,记录下最小值的位置；并且在下次比较时采用已知的最小值进行比较。
                $p = $j;//对数组下标重新赋值
            }
        }
        //已经确定了当前的最小值的位置，保存到$p中。如果发现最小值的位置与当前假设的位置$i不同，则位置互换即可。
        if($p != $i) {
            $tmp = $arr[$p];
            $arr[$p] = $arr[$i];
            $arr[$i] = $tmp;
        }
    }
    //返回最终结果
    return $arr;
}
//插入排序
/*
 * 在要排序的一组数中，假设前面的数已经是排好顺序的，现在要把第n个数插到前面的有序数中，使得这n个数也是排好顺序的。
 * 如此反复循环，直到全部排好顺序。
 */
function insert_Sort($arr) {
    $n=count($arr);
    for($i=1;$i<$n;$i++) {
        $tmp=$arr[$i];
        $j=$i-1;
        while($arr[$j]>$tmp) {
            $arr[$j+1]=$arr[$j];
            $arr[$j]=$tmp;
            $j--;
            if($j<0)
                break;
        }
    }
    return $arr;
}
function insertSort($arr) {
    $len=count($arr);
    for($i=1; $i<$len; $i++) {
        $tmp = $arr[$i];
        //内层循环控制，比较并插入
        for($j=$i-1;$j>=0;$j--) {
            if($tmp < $arr[$j]) {
                //发现插入的元素要小，交换位置，将后边的元素与前面的元素互换
                $arr[$j+1] = $arr[$j];
                $arr[$j] = $tmp;
            } else {
                //如果碰到不需要移动的元素，由于是已经排序好是数组，则前面的就不需要再次比较了。
                break;
            }
        }
    }
    return $arr;
}
//$starttime = microtime();

echo "<hr/>";
/*
 * 对二维数组进行排序
 */
$users = array(
    array('name' => 'tom', 'age' => 20),
    array('name' => 'anny', 'age' => 18),
    array('name' => 'jack', 'age' => 22)
);
$ages = array();
foreach ($users as $user) {
    $ages[] = $user['age'];
}

array_multisort($ages, SORT_ASC, $users);
var_dump($users);
echo "<hr/>";
function array_sort($arr,$keys,$type='asc'){
    $key_value = $new_array = array();
    foreach ($arr as $k=>$v){
        $key_value[$k] = $v[$keys];//将数组中的指定的键名重新组成一个数组
    }
    if($type == 'asc'){
        asort($key_value);//保持索引不变 从低到高排序
    }else{
        arsort($key_value);//保持索引不变 从高到低排序
    }
    reset($key_value);//reset() 函数将内部指针指向数组中的第一个元素，并输出
    foreach ($key_value as $k=>$v){
        $new_array[$k] = $arr[$k];
    }
    return $new_array;
}
$array = array(
    array('name'=>'手机','brand'=>'诺基亚','price'=>1050),
    array('name'=>'笔记本电脑','brand'=>'lenovo','price'=>4300),
    array('name'=>'剃须刀','brand'=>'飞利浦','price'=>3100),
    array('name'=>'跑步机','brand'=>'三和松石','price'=>4900),
    array('name'=>'手表','brand'=>'卡西欧','price'=>960),
    array('name'=>'液晶电视','brand'=>'索尼','price'=>6299),
    array('name'=>'激光打印机','brand'=>'惠普','price'=>1200)
);

$ShoppingList = array_sort($array,'price','desc');
var_dump($ShoppingList);
echo "<hr/>";
