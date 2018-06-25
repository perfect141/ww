<?php
/* uploadFile.php
 * create by : Invoker
 * created: 2017/12/27 11:57
 */

// php里面专门用来接收浏览器发送过来的文件的
//$_FILES
// 通过 $_FILES 就可以获取到前端传递回来的图片

//echo "<pre>";
//print_r($_POST);
//echo "</pre>";
//
//echo "<pre>";
//print_r($_FILES);
//echo "</pre>";

//转存
//move_uploaded_file(文件流临时存储位置,路径+你想要保存的文件的名称);
//move_uploaded_file($_FILES["file"]["tmp_name"],$_FILES["file"]["name"]);

//$path = "../../uploads/" . $_FILES["file"]["name"];
//echo $path;
////现在我们约定要把上传的文件存储在 根目录 下的 uploads 文件夹里面
//move_uploaded_file($_FILES["file"]["tmp_name"],$path);

//如果还是保存原来的文件名，如果重名是会被覆盖的，这不合理
//为了保证文件名不重复 - 必须采用一些策略：
//1 随机数  -- 100000--9999999 之间
//2 最常用的  时间戳  当前时间 + .jpg
// 在php厘米获取毫秒不是那么容易
// 命名：  时间戳(秒) + 随机数 + 后缀名
//time() + 随机数 + .jpg
// 开始拼接文件名

//获取文件的后缀名 -- 以. 来切割文件名，最后一个肯定是后缀名
$arrFileExt = explode(".",$_FILES["file"]["name"]);
$ext = end($arrFileExt);
$fileName = time() . rand(10000,99999) . "." . $ext;

//还是有一个问题要注意：
    //确定上传的路径一定存在？
$path = "../../uploads/";
//判断一下路径是否存在
if(!file_exists($path)){
    //如果不存在，我们帮你创建一个
    mkdir($path);
}

//把文件转存
$res = move_uploaded_file($_FILES["file"]["tmp_name"],$path . $fileName);

$arr = array("code"=>200,"msg"=>"操作失败");
if($res){
    $arr["code"] = 100;
    $arr["msg"] = "操作成功";
    $arr["path"] = $path . $fileName;
}

echo  json_encode($arr,JSON_UNESCAPED_UNICODE);
?>
