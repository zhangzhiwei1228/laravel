<?php
/**
 * Created by PhpStorm.
 * User: zzw
 * Date: 16-4-6
 * Time: 下午2:39
 */
ini_set('display_errors', '1');
ini_set('error_reporting', E_ALL | E_STRICT);
$cars=array("a"=>"Volvo","b"=>"BMW","c"=>"Toyota");
ksort($cars);
var_dump($cars);
$num = 10;
function multiply(){
    $num = $num * 10;//会报错没有设置变量$num
}
multiply();
//引用的差别
//PHP 的引用允许你用两个变量来指向同一个内容
$a="ABC";
$b =&$a;
echo $a;//这里输出:ABC
echo $b;//这里输出:ABC
$b="EFG";
echo $a;//这里$a的值变为EFG 所以输出EFG echo $b;//这里输出EFG
//函数的传址调用 只能传入变量，如果传入数值，因为找不到传入值内存地址，所以会报错
function test(&$a){
    $a=$a+100;
}
$b=1;
echo $b;//输出１
test($b);
echo $b;
echo "<hr/>";
//这里$b传递给函数的其实是$b的变量内容所处的内存地址，通过在函数里改变$a的值　
//就可以改变$b的值了 echo "<br>"; echo $b;//输出101
function &test1(){
    static $b=0;//申明一个静态变量,每次调用不会改变它本身的数值，会每次都调用上次的数值
    $b=$b+1;
    echo $b."<br/>";
    return $b;
}
$a=test1();//这条语句会输出　$b的值　为１
echo $a,"<br/>";
$a=5; $a=test1();//这条语句会输出　$b的值　为2
echo $a,"<br/>";
echo "<hr/>";
/*
 * $a=test()方式调用函数，只是将函数的值赋给$a而已，　而$a做任何改变，都不会影响到函数中的$b，
 * 而通过$a=&test()方式调用函数呢, 他的作用是　将return $b中的　$b变量的内存地址与$a变量的内存地址　
 * 指向了同一个地方 即产生了相当于这样的效果($a=&b;)
 * 所以改变$a的值　也同时改变了$b的值　所以在执行了 $a=&test(); $a=5; 以后，$b的值变为了5
 */
$a=&test1();//这条语句会输出　$b的值　为3
echo $a,"<br/>";
$a=5;//此处相当于 $a = &$b
echo "<hr/>";

$a=test1();//这条语句会输出　$b的值　为6
echo $a,"<br/>";
echo "<hr/>";
function MaxValue($val1, $val2, $val3,$type=false) {
    if($type)
        return ( $val1 < $val2 ? $val1 : $val2 ) < $val3 ? ( $val1 < $val2 ? $val1 : $val2 ) : $val3;
    else
        return ( $val1 > $val2 ? $val1 : $val2 ) > $val3 ? ( $val1 > $val2 ? $val1 : $val2 ) : $val3;
}
echo MaxValue(1,2,4,true);
echo "<hr/>";
$a="Hello World!";
$b=$a;
print("/$b=$b<br>");
print('$a=$a<br>');
$a=2;
$b="1.2SBC3";
$c="EFG";//强制转换成int类型，得出的值为0
$result1=$a.$b;
$result2=$a*$b;
var_dump(intval($c));
$result3=$a*$c;
print("$result1,<br>$result2,<br>$result3 <br>");
echo "<hr/>";
$myarray = array('My String','Another String','Hi, Word');
$str = implode("-",$myarray);//My String-Another String-Hi, Word
$len = strlen($str);
for($i=0;$i<$len;$i++) {
    if($str[$i] === 'i') {
        $str[$i] = strtoupper($str[$i]);
    } else {
        continue;
    }
}
var_dump($str);
$myarray = explode('-',$str);
var_dump($myarray);
echo "<hr/>";
$a = 012;
echo $a/4;


