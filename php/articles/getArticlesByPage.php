<?php
/* getArticlesByPage.php
 * create by : Invoker
 * created: 2017/12/25 14:44
 */

require_once "../DB_Util/sql_helper.php";

/**
 *  在sql语句里面可以使用分页查找的方式查找
 *
 *
 *      假设要获取第三页的10条数据
 *          从第21条开始取，总共取10条
 *
 *      select * from 表名 LIMIT 从哪里开始，总共取多少条
 *
 *
 *      select * from 表名 LIMIT offset,count
 *              注意： 获取的条数不包含 顺序为offset的这一条
 *              count 每一页有多少条数据
 *
 *
 *              offset = (当前的页码-1)  * count
 *
 *      可以确定的是： 当前页码和一个页面显示多少条数据都是前端传递回来的
 *
 *
 */

//1 从前端获取  当前页码  每页显示多少条
$currentPage = $_POST["currentPage"];
$pageCount = $_POST["pageCount"];

//算出从哪里开始获取，一共获取到少条
$offset = ($currentPage - 1) * $pageCount;
//拼接查询的sql语句
$sql = "(SELECT a.id,a.title,a.created,a.status,u.nickname,c.name FROM articles a LEFT JOIN users u ON a.user_id = u.id LEFT JOIN categories c ON a.category_id = c.id) LIMIT {$offset},{$pageCount}";
$res = query($sql);
//除了要获取这要展示的数据意外，还得获取总的数据条数
$countSql = "SELECT COUNT(*) AS maxCount FROM articles";
$countRes = query($countSql);

$arr = array("code"=>200,"msg"=>"操作失败");
if($res){
    $arr["code"] = 100;
    $arr["msg"] = "操作成功";
    $arr["data"] = $res;
    $arr["dataCount"] = $countRes[0]["maxCount"];
}

//把数据返回给前端
echo  json_encode($arr,JSON_UNESCAPED_UNICODE);

/**
 *  分页总结：
 *      知道怎么从服务端取数据  LIMIT offset,count
 *          offset = (当前页 - 1) * 页面的容纳的数据条数
 *          count = 页面的容纳的数据条数
 *  知道怎么在浏览器渲染
 *      如果只是渲染数据 - 模板引擎
 *
 *      分页结构
 *
 *          1 按钮有哪些  当前页  开始页码  结束页码
 *          2 特殊情况  开始页码不能小于1  结束页码不能大于最大页码
 *          3 最大页码 = ceil(总的数据条数 / 每页容纳多少条)
 *
 *      根据算出的开始和结束生成结构
 *
 *      注册点击事件，重复以上流程
 *
 *
 */


?>
