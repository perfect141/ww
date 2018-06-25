<?php
/* addArticle.php
 * create by : Invoker
 * created: 2017/12/27 16:10
 */

//获取从前端得到的数据，插入到文章表里面
$_POST;

/**
 *
 *  插入语句的格式是：
 *
 *      insert into 表名 (键,键,键) values(值，值，值)
 */
//1  先把所有的键和值变成独立的数组
//$keys = array_keys($_POST);
//$values = array_values($_POST);
//
//$sql = "INSERT INTO articles (" . implode(",",$keys) . ") values('" . implode("','",$values) . "')";
////如果要操作数据库，又要5步
//$connect = mysqli_connect("127.0.0.1","root","root","gz16alibx");
//mysqli_set_charset($connect,"utf8");
//$res = mysqli_query($connect,$sql);

require_once "../DB_Util/sql_helper.php";
//调用封装好的方法
$res = insert($_POST,"articles");

$arr = array("code"=>200,"msg"=>"操作失败");
if($res){
    $arr["code"] = 100;
    $arr["msg"] = "操作成功";
}

//把数据返回给前端
echo  json_encode($arr,JSON_UNESCAPED_UNICODE);

?>
