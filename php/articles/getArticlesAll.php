<?php
/* getArticlesAll.php
 * create by : Invoker
 * created: 2017/12/25 10:10
 */


/**
 *  如果一个表和另一个表存在主外键关系
 *      可以根据外键来去另一个表里面查找一些对应的数据
 *
 *      联表查询
 *
 *      1 先查一个表 -- 如果不是把所有字段查出来，至少要包含外键
 *      2 使用 left join 关键字来联表查询
 *
 *          select 字段(至少要包含外键) from 表1 left join 表2 on 表1.外键 = 表2.主键
 *
 *      3 字段要包含表2的字段，才能显示表2的内容
 *      4 如果联表的字段名有重复，最好使用表名.字段名的形式来进行筛选
 *
 *      -- SELECT title,user_id FROM articles

        --  SELECT articles.id,title,user_id,nickname FROM articles LEFT JOIN users ON articles.user_id = users.id

        -- SELECT * FROM articles LEFT JOIN users ON articles.user_id = users.id

        -- 主外键关系
        -- 一个表格，里面存储了另一个表的  主键
        -- 在现在的数据库里： articles表的user_id这个字段的值要从 users 表的 主键 中来
        -- user_id这个存储了别的表的主键的字段 相对于当前表articles来说叫做 外键
        -- 根据需求查询指定字段
        -- SELECT a.id,a.title,a.created,a.status,u.nickname,c.name,user_id,category_id FROM articles a LEFT JOIN users u ON a.user_id = u.id LEFT JOIN categories c ON a.category_id = c.id

        SELECT * FROM articles a LEFT JOIN users u ON a.user_id = u.id LEFT JOIN categories c ON a.category_id = c.id
 *
 *
 * -- 目的： 查出文章的标题，文章的作者，文章的分类，文章的发布时间，文章的状态
-- articles.字段
-- 文章的作者是：昵称  昵称存在了user表里面 --》 联表查询
-- 查询文章表的字段
--  SELECT a.title,a.created,a.status FROM articles a
-- 根据主外键关系查出文章作者的昵称
-- SELECT a.title,a.created,a.status,u.nickname FROM articles a LEFT JOIN users u ON a.user_id = u.id

-- 查询文章所属的分类
-- 根据主外键关系查询分类的名称
-- SELECT a.title,c.name FROM articles a LEFT JOIN categories c ON a.category_id = c.id

SELECT a.id,a.title,a.created,a.status,u.nickname,c.name FROM articles a LEFT JOIN users u ON a.user_id = u.id LEFT JOIN categories c ON a.category_id = c.id
 *
 *
 *      查询语句
 *
 *          select 字段名,字段名,字段名 from 表名  --   查询指定字段
 *
 *          select * from 表名  --  查询所有字段
 *
 *
 */

/**
 *  查询文章的操作
 *
 *      连接数据库 - 执行sql语句 - 得到结构 - 展示给用户
 *
 */

//$connect = mysqli_connect("127.0.0.1","root","root","gz16alibx");
//mysqli_set_charset($connect,"utf8");
//$sql = "SELECT a.id,a.title,a.created,a.status,u.nickname,c.name FROM articles a LEFT JOIN users u ON a.user_id = u.id LEFT JOIN categories c ON a.category_id = c.id";
//
//$res = mysqli_query($connect,$sql);

/**
 * 已经把数据库的查询操作封装了，直接调用
 */
require_once  "../DB_Util/sql_helper.php";
$sql = "SELECT a.id,a.title,a.created,a.status,u.nickname,c.name FROM articles a LEFT JOIN users u ON a.user_id = u.id LEFT JOIN categories c ON a.category_id = c.id";
$res = query($sql);
//判断数据的结果，来决定查询是否成功
$arr = array("code"=>200,"msg"=>"操作失败");
if($res){
    $arr["code"] = 100;
    $arr["msg"] = "操作成功";
    $arr["data"] = $res;
}

//把数据返回给前端
echo  json_encode($arr,JSON_UNESCAPED_UNICODE);

?>
