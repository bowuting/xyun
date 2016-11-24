<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="cn">

    <meta charset="UTF-8">


<link href="//cdn.bootcss.com/semantic-ui/2.2.6/semantic.min.css" rel="stylesheet">
<!-- <link href="//cdn.bootcss.com/layer/2.4/skin/layer.css" rel="stylesheet"> -->


<link rel="stylesheet"	href="//cdnsh.bowuting.com/cdn/nice-validator/dist/jquery.validator.css">

    <title>订单结算页</title>
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
    <a class="item" href="/xyun/my_shop/index.php/Home/Index/myorder">
        我的订单
    </a>
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

        <div class="sixteen wide column">

          <h2>订单结算页</h2>

          <form class="" action="/xyun/my_shop/index.php/Home/Index/orderProcess" method="post">


              <?php if(is_array($addrs)): $i = 0; $__LIST__ = $addrs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$addrone): $mod = ($i % 2 );++$i;?><div>
                  <span data-addr-id="<?php echo ($addrone["addr_id"]); ?>" data-click="0" class="ppp" style="border:1px solid;width:200px"><?php echo ($addrone["addr_name"]); ?> <?php echo ($addrone["addr_city"]); ?></span>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <span> <?php echo ($addrone["addr_name"]); ?> </span>
                  <span> <?php echo ($addrone["addr_phone"]); ?></span>
                  <span> <?php echo ($addrone["addr_content"]); ?></span>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>

              <input id="addrname" type="hidden" name="addr_name" value="">
              <input id="addrphone" type="hidden" name="addr_phone" value="">
              <input id="addrcontent" type="hidden" name="addr_content" value="">

              <table class="ui celled table">

                <thead>
                  <tr>
                    <th>名称</th>
                    <th>图片</th>
                    <th>单价</th>
                    <th>数量</th>
                  </tr>
                </thead>

                <?php if(is_array($res)): $i = 0; $__LIST__ = $res;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><input type="hidden" name="gidsStr" value="<?php echo ($gidsStr); ?>">
                  <tr>
                      <td><?php echo ($vo["goods_name"]); ?></td>
                      <td><img width="50px" height="50px"src="<?php echo ($vo["goods_pic"]); ?>" alt="" /></td>
                      <td><?php echo ($vo[goods_price]/100); ?></td>
                      <td><?php echo ($vo["mycart_quantity"]); ?></td>
                  </tr><?php endforeach; endif; else: echo "" ;endif; ?>

              </table>

              <input type="hidden" name="allPrice" value="<?php echo ($allPrice); ?>">
              <span>总价：<?php echo ($allPrice/100); ?></span>
              <input type="submit" id="submit" value="结算"  >

          </form>

        </div>  <!--end sixteen wide column -->

    </div>  <!--end ui grid -->

  </div> <!--end ui container -->

</body>

<script src="//cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>

<script src="//cdn.bootcss.com/semantic-ui/2.2.6/semantic.min.js"></script>
<script src="//cdn.bootcss.com/layer/2.4/layer.min.js"></script>


<script type="text/javascript" src="//cdnsh.bowuting.com/cdn/nice-validator/dist/jquery.validator.js"></script>
<script type="text/javascript" src="//cdnsh.bowuting.com/cdn/nice-validator/dist/local/zh-CN.js"></script>


<script type="text/javascript">

  $(document).ready(function(){       //选取地址

      $('.ppp').click(function() {

      $('.ppp').css('background-color','white');
      $('.ppp').attr('data-click','0');

      $(this).css('background-color','red');
      $(this).attr('data-click','1')

      var name    = $(this).next().text();
      var phone   = $(this).next().next().text();
      var content = $(this).next().next().next().text();

      $('#addrname').val(name);
      $('#addrphone').val(phone);
      $('#addrcontent').val(content);

    });

    $('#submit').click(function(){       //判断有没有选择收货地址
      var count = 0;
        $('.ppp').each(function() {
           count += parseInt($(this).attr('data-click'));
        });
        if (count != 1) {
          layer.alert('您还没有选择收获地址呢');
          return false;
        }
    });

  });





</script>

</html>