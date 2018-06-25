<?php
/* getCategoriesAll.php
 * create by : Invoker
 * created: 2017/12/27 9:33
 */
require_once "../DB_Util/sql_helper.php";

/**
 *  获取所有的分类
 *
 */

$sql = "SELECT * FROM categories";
//查询
$res = query($sql);
$arr = array("code"=>200,"msg"=>"操作失败");
if($res){
    $arr["code"] = 100;
    $arr["msg"] = "操作成功";
    $arr["data"] = $res;
}

echo  json_encode($arr,JSON_UNESCAPED_UNICODE);

?>
