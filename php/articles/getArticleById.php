<?php
/* getArticleById.php
 * create by : Invoker
 * created: 2017/12/28 10:16
 */

require_once "../DB_Util/sql_helper.php";

//先的到前端传递回来的id
$id = $_POST["id"];
//根据id查询数据
$sql = "SELECT * FROM articles a WHERE id = {$id}";
$res = query($sql);

$arr = array("code"=>200,"msg"=>"操作失败");
if($res){
    $arr["code"] = 100;
    $arr["msg"] = "操作成功";
    $arr["data"] = $res[0];
}

echo  json_encode($arr,JSON_UNESCAPED_UNICODE);

?>
