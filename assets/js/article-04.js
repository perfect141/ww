/*
*  项目中是绝对不允许写一个页面的功能分成多个js的
*   这么做是某些同学要求把js内容简化
*
* */

$(function () {
  autoWidth();
    //点击编辑按钮，可以跳转到 新增页面
    $("#dataset").on("click",".edit",function () {
        //获取articleid
        var id = $(this).parent().parent().attr("article_id");
        //让页面跳转到新增页面 -- 还要通过url传参的方式进行id的传递
        location.href="addArticle.html?id=" + id ;
    });
});