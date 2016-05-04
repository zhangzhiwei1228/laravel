<?php
/**
 * Created by PhpStorm.
 * User: zzw
 * Date: 16-4-5
 * Time: 下午1:21
 */
header("content-type:text/html;charset=utf8");
//ini_set('display_errors', '1');
//ini_set('error_reporting', E_ALL | E_STRICT);
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
echo "Connection to server sucessfully";
//store data in redis list
$redis->lpush("tutorial-list", "Redis");
$redis->lpush("tutorial-list", "Mongodb");
$redis->lpush("tutorial-list", "Mysql");
// Get the stored data and print it
$arList = $redis->lrange("tutorial-list", 0 ,5);
echo "Stored string in redis:: ".
   print_r($arList);
class Stock{
   private $_data = array();//定义一个空数组
   private $_end = null;//定义一个空指针（数组下标）
   public function push($data) {
      if($this->_end === null)//如果没有下标，就赋值为0
         $this->_end = 0;
      else
         $this->_end ++;
      $this->_data[$this->_end] = $data;
   }
   public function pop(){
      if(empty($this->_data)) return false;//当出栈时，先判断数组是否为空
      $ret = $this->_data[$this->_end];//输出出栈的值
      array_splice($this->_data,$this->_end);// 函数从数组中移除选定的元素，并用新元素取代它。
                                             //该函数也将返回包含被移除元素的数组。
      $this->_end --;//将数组下标减一
      return $ret;
   }
   public function getData() {
      return $this->_data;
   }
}

$data = new Stock();
$data->push('zhang');
$data->push('zhi');
$data->push('wei');
//$data->pop();
var_dump($data->pop(),$data->getData());
echo "<hr/>";
$a1=array("a"=>"red","b"=>"green","c"=>"blue","d"=>"yellow");
$a2=array("a"=>"purple","b"=>"orange");
print_r(array_splice($a1,0,2,$a2));
var_dump($a1);// Array ( [0] => purple [1] => orange [c] => blue [d] => yellow )
var_dump($a2);//还是原来的样式
echo "<hr/>";
//求最大值，递归
function getMaxValueInArray($a){
   $max = 0;
   foreach($a as $key => $value){
      if(is_array($value)){
         $value=getMaxValueInArray($value);
      }
      //$max=min($max,$value);//取最小值
      $max=max($max,$value);
   }
   return $max;
}
$a = array(91,array(-1,8,3,18,89),array(5,6,8,12,90));//,18,array(1,20,7),array(19,4,6));
echo getMaxValueInArray($a);
echo "<hr/>";
//设计无限分类
function get_array($id=0){
   $con = mysql_connect('localhost','root','123456') or die('no connection mysql');
   mysql_query("set names 'utf8'"); //数据库输出编码 应该与你的数据库编码保持一致.建议用UTF-8 国际标准编码.
   mysql_select_db('test'); //打开数据库
   $sql = "select id,title from classify where pid= $id";
   $result = mysql_query($sql,$con);//查询子类
   $arr = array();
   if($result && mysql_affected_rows()){//如果有子类
      while($rows=mysql_fetch_assoc($result)){ //循环记录集
         $rows['list'] = get_array($rows['id']); //调用函数，传入参数，继续查询下级
         $arr[] = $rows; //组合数组
      }
      return $arr;
   }
}
function get_str($id = 0) {
   $con = mysql_connect('localhost','root','123456') or die('no connection mysql');
   mysql_query("set names 'utf8'"); //数据库输出编码 应该与你的数据库编码保持一致.南昌网站建设公司百恒网络PHP工程师建议用UTF-8 国际标准编码.
   mysql_select_db('test'); //打开数据库
   global $str;//必须设置成全局变量
   $sql = "select id,title from classify where pid= $id";
   $result = mysql_query($sql,$con);//查询pid的子类的分类
   if($result && mysql_affected_rows()){//如果有子类
      $str .= '<ul>';
      while ($row = mysql_fetch_array($result)) { //循环记录集
         $str .= "<li>" . $row['id'] . "--" . $row['title'] . "</li>"; //构建字符串
         get_str($row['id']); //调用get_str()，将记录集中的id参数传入函数中，继续查询下级
      }
      $str .= '</ul>';
   }
   return $str;
}
var_dump(get_array(0));
var_dump(get_str(0));
echo "<hr/>";

function getExt($url){
   $arr = parse_url($url);
   $file = basename($arr['path']);
   $ext = explode('.',$file);
   return $ext[1];
}
$urls = 'www.baidu.com/test.php/?u=12';
$suffix = getExt($urls);
$ext = explode(".",$suffix);
if($ext[0]) {
   echo '.',$suffix;
}
var_dump($ext);
var_dump(getExt($urls));
//同时也可以用 pathinfo($path['path'],PATHINFO_BASENAME);
// 或者直接用pathinfo获取全部参数，然后取extension的值（这个是对后面没有参数的情况下）
$test = pathinfo("http://localhost/index.php");//后面不带参数的情况
print_r($test['extension']);

$arr = parse_url($urls);
echo pathinfo($arr['path'], PATHINFO_BASENAME);
echo "<hr/>";
//获取传的参数值
$url = 'http://www.baidu.com/index.php?m=content&c=index&a=lists&catid=6&area=0&author=0&h=0';
var_dump(pathinfo($url)['extension']);
//用正则表达式
function getKeyValue($url) {
   $result = array();
   $mr = preg_match_all('/(\?|&)(.+?)=([^&?]*)/i', $url, $parameter);
   if ($mr !== FALSE) {
      //var_dump($parameter);
      for ($i = 0; $i < $mr; $i++) {
         $result[$parameter[2][$i]] = $parameter[3][$i];//2是key组成的数组，3是value组成的数组
      }
   }
   return $result;
}
var_dump(getKeyValue($url));
echo "<hr/>";
//替换html中的meta标签中的内容
$html = "<meta http-equiv='Content-Type' content='text/html; charset=gbk'>";
//匹配标准的meta标签 ?匹配在他之前的那个字符
$pattern = "/<meta\s+http-equiv=(\'|\")?Content-Type(\'|\")?\s+content=(\'|\")text\/html;\s+charset=(.*)(\'|\")>/i";
$replacement = "<meta http-equiv='Content-Type' content='text/html; charset=big5'>";
$result = preg_replace($pattern, $replacement, $html);
var_dump($result);
echo "<hr/>";
$arr = array(
    'I', 'AM', 'MILO!', 'DAY', 'DAY', 'UP!'
);
var_dump(implode(' ',$arr));
var_dump(strtolower(implode(' ',$arr)));
echo "<hr/>";
//sort rsort asort arsort ksort krsort 的区别
/*
 * sort 根据value从低到高进行排序 索引从0开始重新排序
 * rsort 根据value从高到低进行排序 索引从0开始重新排序
 * asort 根据value从低到高进行排序 不改变索引
 * arsort 根据value从高到低进行排序 不改变索引
 * ksort 根据键从低到高进行排序
 * krsort根据键从高到低进行排序
 */

//php中引用的使用
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
//求三个数值的最大值或最小值
function MaxValue($val1, $val2, $val3,$type=false) {
   if($type)
      return ( $val1 < $val2 ? $val1 : $val2 ) < $val3 ? ( $val1 < $val2 ? $val1 : $val2 ) : $val3;
   else
      return ( $val1 > $val2 ? $val1 : $val2 ) > $val3 ? ( $val1 > $val2 ? $val1 : $val2 ) : $val3;
}
echo MaxValue(1,2,4,true);
echo "<hr/>";
//将数组1变成数组2
$arr_2 = array (
    '0' => array (
        '0' => array ( 'tid' => 1, 'name' => 'Name1'),
        '1' => array ( 'tid' => 2, 'name' => 'Name2'),
        '2' => array ( 'tid' => 5, 'name' => 'Name3'),
        '3' => array ( 'tid' => 7, 'name' => 'Name4') ),
    '1' => array (
        '0' => array ( 'tid' => 9, 'name' => 'Name5' ) ) );
$arr1 = array (
    '0' => array ('fid' => 1, 'tid' => 1, 'name' =>'Name1' ),
    '1' => array ('fid' => 1, 'tid' => 2 , 'name' =>'Name2' ),
    '2' => array ('fid' => 1, 'tid' => 5 , 'name' =>'Name3' ),
    '3' => array ('fid' => 1, 'tid' => 7 , 'name' =>'Name4' ),
    '4' => array ('fid' => 3, 'tid' => 9, 'name' =>'Name5' )
);
function changeArrayStyle($arr){
   $result = array();
   foreach($arr as $key=>$value){
      $result[$value["fid"]][] = $value;
      unset($result[$value["fid"]][$key]['fid']);
   }
   unset($result[3][0]['fid']);
   return array_values($result);
}
$arr2=changeArrayStyle($arr1);
echo "<pre>";
var_dump($arr2);
echo "<hr/>";
//字符串"open_door" 转换成 "OpenDoor"、"make_by_id" 转换成 "MakeById"。
function string_change($str) {
   $str = str_replace('_','',$str);//此处为了形成两个单词
   $str = ucwords($str);//对每个单词的首字符大写
   $str = str_replace(" ",'',$str);//用空替换空格
   echo $str;
}
string_change("open_door");
echo "<hr/>";
//遍历文件夹的所以子文件夹和子文件
/*
 * 1,先打开目录 opendir
 * 2,while遍历读取文件 readdir 且不能为false
 * 3,将.和..文件过滤掉
 * 4,对于子文件是目录用is_dir 判断，如果是 就用realpath（realpath() 函数返回绝对路径。）
 * 如果不是就直接返回文件
 * 5,是子目录的再递归子目录
 */
function listDir($dir = '.') {
   if($hand = opendir($dir)) {
      while(($file = readdir($hand)) !== false ){
         if($file == '.' || $file == '..'){
            continue;
         }
         if(is_dir($sub_dir = realpath($dir.'/'.$file))) {
            echo 'FILE in PATH:'.$dir.':'.$file.'<br>';
            listDir($sub_dir);
         } else {
            echo 'FILE in PATH:'.$file.'<br>';
         }
      }
      closedir($hand);
   }
}
//listDir('/home/zzw/');

//将数字三位分割加逗号，如1,234,567,890
/*
 * 用php内置函数的用法(三个内置函数)
 */
function number_substr($str) {
   $str = strrev($str);//先将字符串反转
   $arr = str_split($str,3); //把字符串按3个字符的长度拆成数组.
   $str = strrev(implode($arr,','));//将数组用逗号进行组合，然后在反转回来
   return $str;
}
/*
 * php内置方法（只能用两个）
 */
function getString($str,$num,$sep)//数字序列，分割几位，所用符号
{
   $temp = strrev($str);
   $arr  = str_split($temp,$num);
   $length = count($arr);
   $temp = "";
   for($i=$length-1;$i>=0;$i--)
   {
      if($i>0)
         $temp=$temp.strrev($arr[$i]).$sep;
      else
         $temp=$temp.strrev($arr[$i]);
   }
   return $temp;
}
echo getString('1234567890',3,','),"<br/>";
echo number_substr('1234567890');
echo "<hr/>";
/*
 * 将字符串转换成十进制
 * getv计算总结果; gett计算字母代表的数字; getw计算权值;
 */
function getv($s){
   $v = '';
   $arr=str_split($s,1);
   for ($i=0;$i<strlen($s);$i++)
   {
      $v=gett($arr[$i])*getw(strlen($s)-$i-1)+$v;
   }
   echo $v;
}
function getw($w){ //计算字母代表的数字
   $x=1;
   for ($i=0;$i<$w;$i++){
      $x=26*$x;
   }
   return $x;
}
function gett($ch){ //计算权值
   return (ord($ch)-96);
}
$str="asd";//写你想要算的字符串;
echo getv($str);
echo "<hr/>";
/*
 * php 创建多级目录
 */
function createdir($path,$mode){
   if (is_dir($path)){  //判断目录存在否，存在不创建
      echo "目录'" . $path . "'已经存在";
   } else { //不存在创建
      $re=mkdir($path,$mode,true); //第二个参数表明文件的权限，第三个参数为true即可以创建多极目录
      if ($re){
         echo "目录创建成功";
      } else {
         echo "目录创建失败";
      }
   }
}
$path="/home/zzw/"; //要创建的目录
$mode=0755; //创建目录的模式
createdir($path,$mode);//测试
/*
 * 确保多个进程同时写入同一个文件成功
 * php 支持进程而不支持多线程
 * 对写入的文件加锁就行
 *
 * flock(file,lock,block)
 * file 必需，规定要锁定或释放的已打开的文件
 * lock 必需。规定要使用哪种锁定类型。
 * block 可选。若设置为 1 或 true，则当进行锁定时阻挡其他进程。
 * lock
 * LOCK_SH 要取得共享锁定（读取的程序）
 * LOCK_EX 要取得独占锁定（写入的程序）
 * LOCK_UN 要释放锁定（无论共享或独占）
 * LOCK_NB 如果不希望 flock() 在锁定时堵塞
 */
function write_file($file,$content) {
   $fp = fopen($file,"w+");
   if(flock($fp,LOCK_EX)) {
      //获得写锁，写入数据
      fwrite($fp,$content);
      //写入完成，解锁
      flock($fp,LOCK_UN);
   } else {
      echo "file is locking...";
   }
   fclose($fp);
}
/*
 * php 双向队列
 * 队列是指允许在一端（队尾）进入插入，而在另一端（队头）进行删除的线性表。Rear指针指向队尾，front指针指向队头。
   队列是“先进行出”（FIFO）或“后进后出”（LILO）的线性表。
　　队列运算包括
　　（1）入队运算：从队尾插入一个元素；
　　（2）退队运算：从队头删除一个元素。
      循环队列：s=0表示队列空，s=1且front=rear表示队列满

   一个双向队列是限定在两端end1,end2都可以进行插入删除操作的线性表。
   对空调间是end1=end2.若用顺序方式来组织双端队列，试根据下列要求，定义双端队列的结构，
   并给出指定端（i=1,2）进行插入和删除操作
 */
/*
 * 用到的array函数
 * array_push — 将一个或多个单元压入数组的末尾（入栈）
 * array_unshift — 在数组开头插入一个或多个单元
 * array_pop — 将数组最后一个单元弹出（出栈）
 * array_shift — 将数组开头的单元移出数组
 */
class Deque
{
   public $queue  = array();
   public $length = 0;

   public function frontAdd($node){//头部入列
      array_unshift($this->queue,$node);
      $this->countqueue();
   }

   public function frontRemove(){//头部出列
      $node = array_shift($this->queue);
      $this->countqueue();
      return $node;
   }

   public function rearAdd($node){//尾部入列
      array_push($this->queue,$node);
      $this->countqueue();
   }

   public function rearRemove(){ //尾部出列
      $node = array_pop($this->queue);
      $this->countqueue();
      return $node;
   }

   public function countqueue(){//队列长度
      $this->length = count($this->queue);
   }
   public function makeEmpty()//清空队列
   {
      unset($this->queue);
   }
}
$que = new Deque();
$que->frontAdd("zhang");
$que->frontAdd("zhi");
$que->frontAdd("wei");
$que->frontAdd("ni");
$que->frontAdd("hao");
$que->rearAdd("a");
var_dump($que);
$que->frontRemove();
var_dump($que);
echo "<hr/>";
/*
 * 想获取网站资源
 *
 */
$readcontents = fopen("http://www.baidu.com", "rb");
$contents = stream_get_contents($readcontents);
fclose($readcontents);
//var_dump($contents) ;
//方法2
//var_dump(file_get_contents("http://www.zbmf.com"));
//php5魔术方法
/*
 * __construct() :实例化对象时被调用；
 * __destruct()：析构函数会在到某个对象的所有引用都被删除或者当对象被显式销毁时执行。
 * __call()：调用对象不存在方法时被调用；
 * __get()：调用（读取）对象不存在的属性时被调用；
 * __set()：设置(赋值)对象不存在的属性时被调用；
 * __toString()：打印一个对象时被调用，比如echo $obj,print($obj);
 * __clone():克隆对象时被调用，比如$t = new Test();$tt = clone $t;
 * __sleep():serialize之前被调用，若对象比较大，想做一些删除在序列化，可以考虑使用该方法；
 * __wakeup()：unserialize之前被调用，做些对象的初始化；
 * __isset()：检测对象是否存在属性的时候被调用，如 isset($c->name)；
 * __unset():unset一个对象属性时被调用，如：unset($c->name);
 * __set_state()：调用var_export时被调用，用__set_state的返回值作为 var_export的返回值；
 * __autoload()：实例化一个对象时，如果对应的类不存在，在该方法被调用
 */
//php5魔术变量
/*
 * __LINE__ 文件中的当前行号。
 * __FILE__ 文件的完整路径和文件名。如果用在被包含文件中，则返回被包含的文件名。自 PHP 4.0.2 起，__FILE__ 总是包含一个绝对路径（如果是符号连接，则是解析后的绝对路径），而在此之前的版本有时会包含一个相对路径。
 * __DIR__ 文件所在的目录。如果用在被包括文件中，则返回被包括的文件所在的目录。它等价于 dirname(__FILE__)。除非是根目录，否则目录中名不包括末尾的斜杠。（PHP 5.3.0中新增） =
 * __FUNCTION__ 函数名称（PHP 4.3.0 新加）。自 PHP 5 起本常量返回该函数被定义时的名字（区分大小写）。在 PHP 4 中该值总是小写字母的。
 * __CLASS__ 类的名称（PHP 4.3.0 新加）。自 PHP 5 起本常量返回该类被定义时的名字（区分大小写）。在 PHP 4 中该值总是小写字母的。
 * __METHOD__ 类的方法名（PHP 5.0.0 新加）。返回该方法被定义时的名字（区分大小写）。
 * __NAMESPACE__ 当前命名空间的名称（大小写敏感）。这个常量是在编译时定义的（PHP 5.3.0 新增）
 *
 */
echo "<hr/>";
class Person
{
   // 下面是人的成员属性， 都是封装的私有成员
   private $name;		//人的名子
   private $sex;		//人的性别
   private $age;		//人的年龄

   //__get()方法用来获取私有属性
   function __get($property_name)
   {
      echo "在直接获取私有属性值的时候，自动调用了这个__get()方法<br />";
      if (isset($this->$property_name))
      {
         return ($this->$property_name);
      }
      else
      {
         return NULL;
      }
   }

   //__set()方法用来设置私有属性
   function __set($property_name, $value)
   {
      echo "在直接设置私有属性值的时候，自动调用了这个__set()方法为私有属性赋值<br />";
      $this->$property_name = $value;
   }
}

$p1 = new Person();

// 直接为私有属性赋值的操作， 会自动调用__set()方法进行赋值
$p1->name = "张三";
$p1->sex = "男";
$p1->age = 20;

// 直接获取私有属性的值， 会自动调用__get()方法，返回成员属性的值
echo "姓名：" . $p1->name . "<br />";
echo "性别：" . $p1->sex . "<br />";
echo "年龄：" . $p1->age . "<br />";
echo "<hr/>";
class Person1
{
   // 下面是人的静态成员属性
   public static $myCountry = "中国";

   // var $name; //人的名子

   // 这是人的静态成员方法
   public static function say()
   {
      echo "我是中国人";
   }
}

// 输出静态属性
$name = new Person1();
echo $name::$myCountry;
echo Person1::$myCountry;

// 访问静态方法
Person1::say();

// 重新给静态属性赋值
Person1::$myCountry = "美国";
echo Person1::$myCountry;
echo "<hr/>";
//oop 多态
// 定义了一个形状的接口，里面有两个抽象方法让子类去实现
interface Shape
{
   function area();
   function perimeter();
}

// 定义了一个矩形子类实现了形状接口中的周长和面积
class Rect implements Shape
{
   private $width;
   private $height;

   function __construct($width, $height)
   {
      $this->width = $width;
      $this->height = $height;
   }

   function area()
   {
      return "矩形的面积是：" . ($this->width * $this->height);
   }

   function perimeter()
   {
      return "矩形的周长是：" . (2 * ($this->width + $this->height));
   }
}

// 定义了一个圆形子类实现了形状接口中的周长和面积
class  Circular implements Shape
{
   private $radius;

   function __construct($radius)
   {
      $this->radius=$radius;
   }

   function area()
   {
      return "圆形的面积是：" . (3.14 * $this->radius * $this->radius);
   }

   function perimeter()
   {
      return "圆形的周长是：" . (2 * 3.14 * $this->radius);
   }
}

// 把子类矩形对象赋给形状的一个引用
$shape = new Rect(5, 10);
echo $shape->area() . "<br>";
echo $shape->perimeter() . "<br>";

// 把子类圆形对象赋给形状的一个引用
$shape = new Circular(10);
echo $shape->area() . "<br>";
echo $shape->perimeter() . "<br>";