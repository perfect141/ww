
//登录验证要做的
$(function () {
    autoWidth();

    $("#feature").on("change",function () {

        //当事件被触发之后，把选中的图片，上传到服务端
        //1 先得到选中的图片
        var file = this.files[0];
        //2 把图片上传到服务端
        var xhr = new XMLHttpRequest();
        xhr.open("post","../php/common/uploadFile.php");
        //  如果 Cotent-Type application/x-www-form-urlencoded 是会跑到 $_POST 里面
        //xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        //如果是上传文件并且使用的是 FormData对象，此时 请求头可以不用设置
        xhr.onreadystatechange = function () {
            if(xhr.readyState == 4 && xhr.status == 200){
                // console.log(xhr.responseText);
                var res = JSON.parse(xhr.responseText);
                console.log(res);
                if(res.code == 100){
                    //把预览图设置给 图片 可以显示在页面上
                    $("#img-file").attr("src",res.path).show();
                    //因为在提交的时候，要把路径也存储到数据库，所以还要把 name为 feature 的控件的value属性设置给他
                    $("#featuredata").val(res.path);
                }
            }
        }
        // xhr.send(FormData对象);
        //xhr.send("file="+file);
        // console.log("file="+file);
        // 上传文件，不能直接把文件作为键值对的值，发送给服务端
        //如果要上传文件 --》 必须把文件转换成字节流(文件流)
        // 通过 formData 对象的append 方法，就可以把文件自动的转换成字节流
        var data = new FormData();
        //调用 FormData对象的append方法，将文件转换为字节流
        data.append("file",file);
        //发送的时候，就发送 FormData对象即可
        xhr.send(data);
    });

    //加载分类，生成分类的下拉框
    $.post("../php/categories/getCategoriesAll.php",function (res) {
        // console.log(res);
        if(res.code == 100){
            //生成结构，插入下拉框
            var html = "";
            for(var i = 0; i<res.data.length; i++){
                html += "<option value='"+ res.data[i].id +"'>"+ res.data[i].name +"</option>";
            }
        }
        $("#category").html(html);
    },"json");


    //点击保存的时候，把数据发送到服务端，存到数据库里
    $("#btn-sure").on("click",function () {
        //收集数据
        var data = $("#articledata").serialize();

        //判断到底是新增还是更新操作
        if(location.search){
            //更新操作
            //收集数据
            //拼接文章id
            data = data + "&id="+articleId;
            //把数据发送到服务端
            $.post("../php/articles/updateArticleById.php",data,function (res) {
                console.log(res);
                if(res.code == 100){
                    layer.confirm("您是想去查看呢还是继续编辑呢？点击确定查看，点击取消继续编辑",{icon: 1},function (index) {
                        location.href = "articles.html";
                    });
                }else{
                    layer.alert(res.msg,{icon: 2});
                }
            },"json");
        }else{
            //新增操作
            //此时这个数据还缺少一个用户的id
            // 策略是一开始在登录的时候就把用户的id，存储到cookie里面
            //已经使用$.cookie把用户id存储起来了，直接获取即可
            var user_id = $.cookie("user_id");
            // console.log(user_id);
            data += "&user_id=" + user_id;
            //提交到服务端
            $.post("../php/articles/addArticle.php",data,function (res) {
                // console.log(res);
                if(res.code == 100){
                    // layer.alert(res.msg,{icon: 1});
                    //如果新增成功之后，可以选择跳转到查询页面，也可以让其继续编辑
                    // 比如弹一个框，询问他是直接去查看还是继续编辑
                    layer.confirm("您是想去查看呢还是继续编辑呢？点击确定查看，点击取消继续编辑",{icon: 1},function (index) {
                        location.href = "articles.html";
                    });
                }else{
                    layer.alert(res.msg,{icon: 2});
                }
            },"json");
        }


        //阻止默认的提交
        return false;//如果不想return 就把他改成普通的按钮
    });


    //要在一开始加载完毕的时候，如果是修改功能，id传递过来
    if(location.search){
        //更新的逻辑
        //根据id获取对应的文章数据填充到表单里面
        var articleId = location.search.split("=")[1];
        //根据id从服务端获取数据
        $.post("../php/articles/getArticleById.php",{id: articleId},function (res) {
            console.log(res);
            //把数据填充到表单里
            if(res.code == 100){
                $("#title").val(res.data.title);
                $("#content").val(res.data.content);
                $("#slug").val(res.data.slug);
                //一开始图片是隐藏的，要显示出来
                $("#img-file").attr("src",res.data.feature).show();
                //我们的图片路径是保存在隐藏域里面的，要给隐藏域的value赋值
                $("#featuredata").val(res.data.feature);
                $("#category").val(res.data.category_id);
                $("#created").val(res.data.created.replace(" ","T"));
                $("#status").val(res.data.status);
            }
        },"json");
    }else{
        //新增的逻辑
    }
});