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
        <a class="item" href="/xyun/my_shop/index.php/Login/Index/registerFirst">
            注册
        </a>
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
        <div class="sixteenth wide column">
          <h2>个人中心</h2>
            <table class="ui celled table ">
              <tr>
                <td>
                  用户id:
                </td>
                <td>
                  用户手机：
                </td>
                <td>
                  注册时间：
                </td>
              </tr>
              <tr>
                <td>
                  <?php echo ($info["user_no"]); ?>
                </td>
                <td>
                  <?php echo ($info["user_phone"]); ?>
                </td>
                <td>
                  <?php echo (date("Y-m-d  H:i:s",$info["user_createtime"])); ?>
                </td>
              </tr>
            </table>
            <h2>
              我的收获地址
            </h2>

              <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$addr): $mod = ($i % 2 );++$i;?><p>
                  <?php echo ($addr["addr_name"]); ?>
                  <?php echo ($addr["addr_pro"]); ?>
                  <?php echo ($addr["addr_city"]); ?>
                  <?php echo ($addr["addr_qu"]); ?>
                  <?php echo ($addr["addr_address"]); ?>
                  <?php echo ($addr["addr_phone"]); ?>
                </p><?php endforeach; endif; else: echo "" ;endif; ?>


            <form class="" class="ui form"action="/xyun/my_shop/index.php/Login/Index/addaddress" method="post">
              <table class="ui celled table">
                <input type="hidden" name="uid" id="uid" value="<?php echo ($info["user_id"]); ?>">
                <tr>
                  <td>
                    姓名 <input type="text" name="name" id="name" value="">
                  </td>
                </tr>
                <tr>
                  <td>
                    电话 <input type="text" name="phone" id="phone" value="">
                  </td>
                </tr>
                <tr>
                  <td>
                    <div data-toggle="distpicker">
                      地址
                        <select name="pro"></select>
                        <select name="city"></select>
                        <select name="qu"></select>
                        <input type="text" name="addr" value="">
                    </div>
                  </td>
                  <td>

                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <!-- <input type="submit" name="name" value="添加地址"> -->
                    <button type="button" id="addbtn">添加地址</button>
                  </td>
                </tr>
              </table>
            </form>

            <h2>我的订单</h2>



        </div>

    </div>

</div>

</body>

<script src="//cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>

<script src="//cdn.bootcss.com/semantic-ui/2.2.6/semantic.min.js"></script>
<script src="//cdn.bootcss.com/layer/2.4/layer.min.js"></script>


<script type="text/javascript" src="//cdnsh.bowuting.com/cdn/nice-validator/dist/jquery.validator.js"></script>
<script type="text/javascript" src="//cdnsh.bowuting.com/cdn/nice-validator/dist/local/zh-CN.js"></script>


<script src="http://cdnsh.bowuting.com/cdn/city/js/distpicker.data.js"></script>
<script src="http://cdnsh.bowuting.com/cdn/city/js/distpicker.js"></script>
<script src="http://cdnsh.bowuting.com/cdn/city/js/main.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
      $('#addbtn').click(function(){
        var uid = $('[name="uid"]').val();
        var name = $('[name="name"]').val();
        var phone = $('[name="phone"]').val();
        var pro = $('[name="pro"]').val();
        var city = $('[name="city"]').val();
        var qu = $('[name="qu"]').val();
        var addr = $('[name="addr"]').val();
         $.post("/xyun/my_shop/index.php/Login/Index/addaddress",
          {
          uid :uid,
          name:name,
          phone :phone,
          pro:pro,
          city:city,
          qu:qu,
          addr:addr,
          },
          function (data,status) {
            if (data == 1) {
              layer.open({
              content: '添加成功',
              btn: ['好的'],
              yes: function(){
                  window.location.reload()}
              // cancel: function(){
              //     //右上角关闭回调
              //     window.location.reload()}
                });
            }
          });




      });


    });



</script>
</html>