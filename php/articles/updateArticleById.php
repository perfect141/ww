<?php
/* updateArticleById.php
 * create by : Invoker
 * created: 2017/12/28 10:37
 */

require_once "../DB_Util/sql_helper.php";

//数据都保存在了$_POST厘米
//根据id更新数据
//UPDATE 表名 SET 键=值,键=值,键=值 WHERE id = id值
//把id从$_POST中拿出来
$id = $_POST["id"];
//因为id是不需要跟新的，所以把id从 $_POST里面删除
unset($_POST["id"]);
//$sql = "UPDATE articles SET slug='abc',status=0";
//$sql = "UPDATE articles SET ";
//foreach ($_POST as $key => $value){
//    $sql .= $key."='".$value."',";
//}
////此时还多了一个逗号
//$sql = substr($sql,0,-1);
////拼接要修改的条件
//$sql .= " where id={$id}";
//echo  $sql;

//调用封装好的方法执行更新操作
$res = update("articles",$_POST,$id);
$arr = array("code"=>200,"msg"=>"操作失败");
if($res){
    $arr["code"] = 100;
    $arr["msg"] = "操作成功";
}

//把数据返回给前端
echo  json_encode($arr,JSON_UNESCAPED_UNICODE);

?>
