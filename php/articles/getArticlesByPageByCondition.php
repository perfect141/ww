<?php
/* getArticlesByPageByCondition.php
 * create by : Invoker
 * created: 2017/12/27 10:21
 */

require_once "../DB_Util/sql_helper.php";

/**
 *  一开始请求数据的时候，没有条件的
 *
 *  只有点击了筛选再次来获取数据结构的时候才会带条件
 *
 *  在一开始就判断一下，有没有条件，sql语句是不一样的
 *      要求前端把条件以参数的形式返回
 *          要求分类id穿回来，状态数字传回来
 *              category_id 接收
 *              status      接收
 *
 */

/**
 *  获取分页必须的参数
 */
$currentPage = $_POST["currentPage"];
$pageCount = $_POST["pageCount"];

/**
 * 如果数组里面的索引没有，会给浏览返回警告，就无法正常解析json格式的数据
 */
//定义变量接收参数，因为不一定有这个参数，所以在后面进行判断之后再赋值
$category_id;// = $_POST["category_id"];
$status;// = $_POST["status"];

//判断一下数组里面有没有这个索引
if(isset($_POST["category_id"])){
    $category_id = $_POST["category_id"];
}
if(isset($_POST["status"])){
    $status = $_POST["status"];
}
//先把没有条件和没有分页的语句准备好，以便后面根据条件和分页进行拼接
$sql = "SELECT a.id,a.title,a.created,a.status,a.category_id,a.user_id,u.nickname,c.name FROM articles a LEFT JOIN users u ON a.user_id=u.id LEFT JOIN categories c ON a.category_id=c.id ";

$condition = "";

//只要有category_id或者status就必须带条件
if(isset($category_id) || isset($status)){
    $sql .= " where ";
    $condition .= " where ";
}
//如果$category_id和$status已经赋值，说明条件已经被传递回来了
if(isset($category_id)){
    $sql .= " a.category_id = {$category_id} ";
    $condition .= " a.category_id = {$category_id} ";
}
if(isset($status)){
    //如果没有根据分类查找，之前就没有条件
    //但是如果有分类，之前已经有条件了，多个条件之间使用 and 连接
    if(isset($category_id)){
        $sql .= " and a.status = {$status} ";
        $condition .= " and a.status = {$status} ";
    }else {
        $sql .= " a.status = {$status} ";
        $condition .= " a.status = {$status} ";
    }
}
//计算开始下标
$offset = ($currentPage - 1) * $pageCount;
//拼接分页的sql语句
$sql .= " LIMIT {$offset},{$pageCount}";
//查询结果
$res = query($sql);

//查出数据的总条数
$countSql = "SELECT COUNT(*) AS maxCount FROM articles a " . $condition ;

$count = query($countSql);

$arr = array("code"=>200,"msg"=>"操作失败");
if($res){
    $arr["code"] = 100;
    $arr["msg"] = "操作成功";
    $arr["data"] = $res;
    $arr["dataCount"] = $count[0]["maxCount"];
}

echo  json_encode($arr,JSON_UNESCAPED_UNICODE);

?>
