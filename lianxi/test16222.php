<?php
//PHP实现中文字串截取无乱码的方法
header('content-type:text/html;charset=utf8');
ini_set('display_errors', '1');
ini_set('error_reporting', E_ALL | E_STRICT);
function GBsubstr($string, $start, $length) {
    if(strlen($string)>$length){
        $str=null;
        $len=$start+$length;
        for($i=$start;$i<$len;$i++){
            if(ord(substr($string,$i,1))>0xa0){
                $str.=substr($string,$i,2);
                $i++;
            }else{
                $str.=substr($string,$i,1);
            }
        }
        return $str.'...';
    }else{
        return $string;
    }
}
function substr_text($str, $start=0, $length, $charset="utf-8", $suffix="")
{
    if(function_exists("mb_substr")){
        return mb_substr($str, $start, $length, $charset).$suffix;
    }
    elseif(function_exists('iconv_substr')){
        return iconv_substr($str,$start,$length,$charset).$suffix;
    }
    $re['utf-8']  = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
    $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
    $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
    $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
    preg_match_all($re[$charset], $str, $match);
    $slice = join("",array_slice($match[0], $start, $length));
    return $slice.$suffix;
}
print_r(substr_text('字符串截取', 1, 3));
//echo GBsubstr('中文无乱码，123345',1,4);
echo mb_substr('中文无乱码，1234356',1,3,'utf-8');

 echo date('Y');

echo '<hr/>';
/*
  16-19 位卡号校验位采用 Luhm 校验方法计算：
  1，将未带校验位的 15 位卡号从右依次编号 1 到 15，位于奇数位号上的数字乘以 2
  2，将奇位乘积的个十位全部相加，再加上所有偶数位上的数字
  3，将加法和加上校验位能被 10 整除。
*/
function luhm($s) {
    $n = 0;
    for ($i = strlen($s); $i >= 1; $i--) {
        $index=$i-1;
        //偶数位
        if ($i % 2==0) {
            $n += $s{$index};
        } else {//奇数位
            $t = $s{$index} * 2;
            if ($t > 9) {
                $t = (int)($t/10)+ $t%10;
            }
            $n += $t;
        }
    }
    return ($n % 10) == 0;
}
$r = luhm('6225881414207430');
var_dump($r);

// 创建一个人类
class Person
{
    // 下面是人的成员属性
    var $name;	// 人的名子
    var $sex;	// 人的性别
    var $age;	// 人的年龄

    // 定义一个构造方法参数为姓名$name、性别$sex和年龄$age
    function __construct($name, $sex, $age)
    {
        // 通过构造方法传进来的$name给成员属性$this->name赋初使值
        $this->name = $name;

        // 通过构造方法传进来的$sex给成员属性$this->sex赋初使值
        $this->sex = $sex;

        // 通过构造方法传进来的$age给成员属性$this->age赋初使值
        $this->age = $age;
    }

    // 这个人的说话方法
    function say()
    {
        echo "我的名子叫：" . $this->name . " 性别：" . $this->sex . " 我的年龄是：" . $this->age;
    }
}

// 通过构造方法创建3个对象$p1、p2、$p3,分别传入三个不同的实参为姓名、性别和年龄
$p1 = new Person("张三","男", 20);
$p2 = new Person("李四","女", 30);
$p3 = new Person("王五","男", 40);
// 下面访问$p2对象中的说话方法
$p2->say();
// 下面访问$p1对象中的说话方法
$p1->say();



// 下面访问$p3对象中的说话方法
$p3->say();
echo "<hr/>";
$st = array("s2"=>12);
var_dump($st) ;
echo "<hr/>";
/**
 * 设计模式之单例模式
 * $_instance必须声明为静态的私有变量
 * 构造函数必须声明为私有,防止外部程序new类从而失去单例模式的意义
 * getInstance()方法必须设置为公有的,必须调用此方法以返回实例的一个引用
 * ::操作符只能访问静态变量和静态函数
 * new对象都会消耗内存
 * 使用场景:最常用的地方是数据库连接。
 * 使用单例模式生成一个对象后，该对象可以被其它众多对象所使用。
 */
class man
{
    //保存例实例在此属性中
    private static $_instance;

    //构造函数声明为private,防止直接创建对象
    private function __construct()
    {
        echo '我被实例化了！';
    }

    //单例方法
    public static function get_instance()
    {
        var_dump(isset(self::$_instance));

        if(!isset(self::$_instance))
        {
            self::$_instance=new self();
        }
        return self::$_instance;
    }

    //阻止用户复制对象实例
    private function __clone()
    {
        trigger_error('Clone is not allow' ,E_USER_ERROR);
    }

    function test()
    {
        echo("test");

    }
}

// 这个写法会出错，因为构造方法被声明为private
//$test = new man;

// 下面将得到Example类的单例对象
$test = man::get_instance();
$test = man::get_instance();
$test->test();

// 复制对象将导致一个E_USER_ERROR.
//$test_clone = clone $test;
echo "<hr/>";

$str = 'sfsadfasdf aaaa bbbb cccc ddddd';
echo ucwords($str);//将每个单词首字母大写
echo "<hr/>";
echo trim(" i love iwind ").'<br/>'; // 将得到 "i love iwind"
echo rtrim(" i love iwind ").'<br/>'; // 将得到 " i love iwind"
echo ltrim(" i love iwind ").'<br/>'; // 将得到 "i love iwind "
echo "<hr/>";
echo md5("i love iwind").'<br/>';
echo md5("i love iwind12");
echo "<hr/>";
$article = "BREAKING NEWS: In ultimate irony, man bites dog.";
$wordCount = str_word_count($article);
echo $wordCount;
echo "<hr/>";
$article = "阿斯顿发生的发生的阿斯顿发生地方阿斯顿发爱上地方 阿斯顿发生地方撒的发生地方阿斯顿发生地方爱上地方啊地方.";
$summary = substr_text($article,1, 20);
echo $summary;
echo '<hr/>';
$c_une = convert_uuencode($article);
//echo $c_une;
echo convert_uudecode($c_une).'<br/>';
$article = "BREAKING NEWS: In ultimate irony, man bites dog.";
var_dump (explode(' ',$article));
$arraytostr = array('a','b','c','d');
var_dump(implode(',',$arraytostr));//也可以用join(',',$arraytostr)
$age=array("Bill"=>"60","Steve"=>"56","Mark"=>"31");
print_r(array_change_key_case($age,CASE_UPPER));
print_r(array_change_key_case($age,CASE_LOWER));//键值有相同的，后面的一个将覆盖前一个
$cars=array("Volvo","BMW","Toyota","Honda","Mercedes","Opel");
var_dump(array_chunk($cars,4));
$a1=array_fill(3,4,"blue");
var_dump($a1);
$arr = array("a","b","c","d");
function isHave($var){
    if($var!="b") return true;
}
$arr = array_filter($arr,"isHave");
var_dump($arr);
function myfunction($v)
{
    return($v*$v);
}

$a=array(1,2,3,4,5);
var_dump(array_map("myfunction",$a));
function myfunction1($v)
{
    if ($v==="Dog")
    {
        return "Fido";
    }
    return $v;
}

$a=array("Horse","Dog","Cat");
var_dump(array_map("myfunction1",$a));
function myfunction2($v)
{
    $v=strtoupper($v);
    return $v;
}
$a=array("Animal" => "horse", "Type" => "mammal");
print_r(array_map("myfunction2",$a));//将所有键值大写
$a1=array("Dog","Cat");
$a2=array("Puppy","Kitten");
var_dump(array_map(null,$a1,$a2));

$a1=array("Dog","Cat");
$a2=array("Fido","Missy");
array_multisort($a2,$a1);
var_dump($a1);
var_dump($a2);
echo "<hr/>";
$a1=array("a"=>array("red"),"b"=>array("green","blue"),);
$a2=array("a"=>array("yellow"),"b"=>array("black"));
$result=array_replace_recursive($a1,$a2);

var_dump($result);

$result=array_replace($a1,$a2);
var_dump($result);
echo "<hr/>";
$a=array("Volvo","XC90",array("BMW","Toyota"));
$reverse=array_reverse($a);
$preserve=array_reverse($a,true);

var_dump($a);
var_dump($reverse);
var_dump($preserve);
$a=array("a"=>"5","b"=>5,"c"=>"5");
echo array_search(5,$a,false);
echo "<hr/>";
$people = array("Bill", "Steve", "Mark", "David");
print_r (each($people));
echo "<hr/>";
function my_sort($a,$b)
{
    if ($a==$b) return 0;
    return ($a<$b)?-1:1;
}

$arr=array("a"=>4,"b"=>2,"c"=>8,'d'=>6);
uasort($arr,"my_sort");

foreach($arr as $x=>$x_value)
{
    echo "Key=" . $x . ", Value=" . $x_value;
    echo "<br>";
}
echo "<hr/>";
//将相同的键合并
$arr = array(
    array('num'=>5,'period'=>3),
    array('num'=>10,'period'=>3),
    array('num'=>15,'period'=>9)
);
$temp = array();
foreach($arr as $item) {
    list($n, $p) = array_values($item);
    $temp[$p] =  array_key_exists($p, $temp) ? $temp[$p]+$n : $n;
}

$arr = array();
foreach($temp as $p => $n)
    $arr[] = array('num'=>$n, 'period'=>$p);

var_dump($arr);

//自定义字符翻转
function string_strrev($str)
{
    $len=strlen($str);
    $newstr = '';
    for($i=$len-1;$i>=0;$i--)//必须要减1,因为当成一个数组，数组下标是从0开始
    {
        $newstr .= $str[$i];
    }
    return $newstr;
}
$str = 'adssdasd12311111';
echo strrev($str);
echo "<br/>";
echo string_strrev($str);
var_dump(time());
echo "<hr/>";

function otest1 ($a){
    echo( '一个参数' );
}
function otest2 ( $a,$b){
    echo( '二个参数' );
}
function otest3 ( $a,$b,$c){
    echo( '三个啦' );
}

function otest (){
    $args=func_get_args();//返回数组
    $num=func_num_args();//返回int类型
    call_user_func_array( 'otest'.$num,$args );
}
otest(1,2);
echo "<hr/>";
$str = 'zzzzz';
echo strlen($str);
echo "<hr/>";
$str='<div style="color:#333"><p><img src="http://img.m.com/88-2724b02d3ccd8.jpg" title="88-2724b02d3ccd8.jpg" alt="-3fd8629f5f4712b3ee.jpg"></p></div>';
//$str = '123123';
$pattern="/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/";
preg_match_all($pattern,$str,$match);
//print_r($match[1][0]);
$a = $match[1] ? $match[1][0] : 0;
echo $a;
echo "<hr/>";
$url = "http://www.phpddt.com/abc/de/fg.php?id=1";
$path = parse_url($url);
var_dump($path);
var_dump($path['path']);
echo pathinfo($path['path'],PATHINFO_BASENAME);  //php
echo "<br/>";
$html = "<meta http-equiv='Content-Type' content='text/html; charset=gbk'>";
//匹配标准的meta标签
$pattern = "/<meta\s+http-equiv=(\'|\")?Content-Type(\'|\")?\s+content=(\'|\")text\/html;\s+charset=(.*)(\'|\")>/i";
$replacement = "<meta http-equiv='Content-Type' content='text/html; charset=big5'>";
$result = preg_replace($pattern, $replacement, $html);
echo htmlspecialchars($result);
echo "<hr/>";
function listDir($dir = '.'){
    if ($handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) {
            if($file == '.' || $file == '..'){
                continue;
            }
            if(is_dir($sub_dir = realpath($dir.'/'.$file))){//realpath 输出绝对地址
                echo 'FILE in PATH:'.$dir.':'.$file.'<br>';
                listDir($sub_dir);//递归函数（自己调用自己）
            }else{
                echo 'FILE:'.$file.'<br>';
            }
        }
        closedir($handle);
    }
}
//listDir('/home/zzw/software/');
echo "<hr/>";
if (preg_match('/^\d{3,4}-\d{7,8}$/', '400-1231231') == 0) {
    echo "12";
} else {
    echo "333";
}
?>