<?php
/* checklogin.php
 * create by : Invoker
 * created: 2017/12/24 14:48
 */
/**
 *  检测用户是否登录
 *      如果已经登录过，存着一个session["user_id]
 *
 */

$arr = array("code"=>200,"msg"=>"你还没有登录，请重新登录");

//先开启session
session_start();

if(!empty($_SESSION) && !empty($_SESSION["user_id"])){
    //条件满足，就已经登录过了
    $arr["code"] = 100;
    $arr["msg"] = "已经登录";
}

echo  json_encode($arr,JSON_UNESCAPED_UNICODE);

?>
