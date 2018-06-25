<?php
/* login.php
 * create by : Invoker
 * created: 2017/12/24 11:41
 */

//判断post请求
if(!empty($_POST)){
    //获取数据
    $email = $_POST["email"];
    $password = $_POST["password"];
    // 去数据库中获取对应的用户
    // 1 连接服务
    $connect = mysqli_connect("127.0.0.1","root","root");
    // 2 选择数据库
    mysqli_select_db($connect,"gz16alibx");
    // 3  有必要的时候设置一下编码 -- 一般都会设置
    mysqli_set_charset($connect,"utf8");
    // 4  准备操作数据库得到sql语句
    $sql = "SELECT * FROM users WHERE email = '{$email}'";

    // 5  执行sql代码并接受结果
    $res = mysqli_query($connect,$sql);

    //得到查询结果之后，看看里面有没有数据 -- 一般会把结果集转换为二位数组
    $arr = array();
    //循环取出结果集里面的每行数据 - 以关联数组的形式返回
    while ($row = mysqli_fetch_assoc($res)){
        $arr[] = $row;
    }
//    $arr 就是最后的二位数组结果

    //准备一个返回的格式数组
    $resArr = array("code"=>200,"msg"=>"登录失败，请重试");

    //对二维数组里面的数据进行验证
    if(!empty($arr)){
        //如果有数据，再判断密码是否正确 以及 允许登录的状态是否为1
        if($arr[0]["password"] ==   $password && $arr[0]["status"] == 1)  {
//            如果密码相等，就是登录成功
            $resArr["code"] = 100;
            $resArr["msg"] = "登录成功";
            $resArr["user_id"] = $arr[0]["id"];

            //验证登录--一开始在登录成功的时候，把一个数据存储到seesion里面，将来用户再次访问网站，就验证session，如果配对，就是曾经登录过
            // 要操作seesion，必须先开启服务
            session_start();
            //把数据存到session里面
            //因为存什么都是可以的，随便存什么都行，既然存什么都行，尽可能小 -- 一般存id就够了
            $_SESSION["user_id"] = $arr[0]["id"];
        }
    }

    //把结果返回给浏览器 -- 输出
    echo json_encode($resArr,JSON_UNESCAPED_UNICODE);
}

?>
