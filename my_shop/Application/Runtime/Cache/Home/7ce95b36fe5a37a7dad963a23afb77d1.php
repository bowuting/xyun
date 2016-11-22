<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="cn">

    <meta charset="UTF-8">


<link href="//cdn.bootcss.com/semantic-ui/2.2.6/semantic.min.css" rel="stylesheet">
<!-- <link href="//cdn.bootcss.com/layer/2.4/skin/layer.css" rel="stylesheet"> -->


<link rel="stylesheet"	href="//cdnsh.bowuting.com/cdn/nice-validator/dist/jquery.validator.css">


</head>
<body>


<div class="ui container">

    <br>
<div class="ui menu">
    <a class="item" href="/xyun/my_shop/index.php/Home/">
        首页
    </a>
    <a class="item" href="/xyun/my_shop/index.php/admin/">
        后台
    </a>
    <a class="item" href="/xyun/my_shop/index.php/Home/Index/gallery">
        商品列表
    </a>
    <?php
 if(empty($_SESSION['uid'])){ ?>
      
        <a class="item" href="/xyun/my_shop/index.php/Login/Index/signin">
            登录
        </a>

    <?php  } else { ?>

      <a class="item" href="/xyun/my_shop/index.php/Login/Index/signout">
          登出
      </a>
      <a  class="item" href="/xyun/my_shop/index.php/Login/Index/me">
          个人中心
      </a>
    <?php  } ?>

    <a  class="item" href="/xyun/my_shop/index.php/Home/Index/shopcart">我的购物车</a>

    <!-- <form class="item" action="/xyun/my_shop/index.php/Home/Index/gallery" method="get">
      <div class="ui input">
          <input id="search" type="text"  name="keyword" placeholder="Search...">
          <button id="searchbtn" type="submit" class="ui basic button">商品搜索</button>
      </div>
    </form> -->
    <div class="ui input">
      <input id="search" type="text"  name="keyword" placeholder="Search...">
      <a id="searchbtn" href="javascript:void(0)" class="ui basic button">搜索</a>
    </div>
</div>


    <div class="ui grid">

        <div class="eight wide column">

          <h2 class="ui header"><?php echo ($goodsInfo['goods_name']); ?></h2>

          <hr>

          <h3 class="ui header">商品货号：<?php echo ($goodsInfo['goods_id']); ?></h3>
          <h3 class="ui header"><?php echo ($goodsInfo['goods_desc']); ?></h3>
          <h3 class="ui header">上架时间：<?php echo (date("Y-m-d  ",$goodsInfo["goods_createtime"])); ?></h3>
          <h3 class="ui header">￥:<?php echo ($goodsInfo['goods_price'] / 100); ?></h3>
          <img src="<?php echo ($goodsInfo['goods_pic']); ?>" alt="" />
        </div>
          <div class="three wide column">
            <form class=""  method="post">
              <button type="button" class="" id="reduce-btn">-</button>
              <input id="num" style="width:30px" type="text" name="num" value="1">
              <button type="button" name="add" class="" id="add-btn">+</button>

              <!-- <input type="button" name="name" value="加入购物车" class="ui primary button add-shopcart-btn"> -->
              <button type="button"class="ui primary button add-shopcart-btn"><i class="add to cart icon"></i>加入购物车 </button>

              </form>
            <hr>


          </div>

    </div>

</div>

</body>

<script src="//cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>

<script src="//cdn.bootcss.com/semantic-ui/2.2.6/semantic.min.js"></script>
<script src="//cdn.bootcss.com/layer/2.4/layer.min.js"></script>


<script type="text/javascript" src="//cdnsh.bowuting.com/cdn/nice-validator/dist/jquery.validator.js"></script>
<script type="text/javascript" src="//cdnsh.bowuting.com/cdn/nice-validator/dist/local/zh-CN.js"></script>

<script type="text/javascript">
    $(document).ready(function(){

      $(".add-shopcart-btn").click(function(){
        // alert('加入购物车');
        var goodsid="<?php echo ($_GET['goods_id']); ?>";
        var num = $('#num').val();
        var isgoods = "1";

        $.post("/xyun/my_shop/index.php/Home/Index/addshopcart",
          {
            goodsid:goodsid,
            num:num,
            isgoods:isgoods
          },
          function (data,status) {

            if (data == 1) {
              layer.alert('添加成功');
            } else {
              layer.alert('添加失败');
            }
          });
          // alert('加入购物车');
      });

      $("#add-btn").click(function(){
          var val = $('#num').val();
          val = parseInt(val);
          val += 1;
          $('#num').val(val);
          // console.log(val);

    });

    $("#reduce-btn").click(function(){
        var val = $('#num').val();
        val = parseInt(val);
        if (val <= 1) {
          val = 1;
          $('#num').val(val);
          layer.alert('不能再减了');
          return false;
        }

        val -= 1;
        $('#num').val(val);
        // console.log(val);

  });





    });
</script>

</html>