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
        <div class="sixteen wide column" >

          <form class="" action="/xyun/my_shop/index.php/Home/Index/order" method="post">
              <table class="ui celled table">

                  <thead>
                    <tr>
                      <th><input type="checkbox" class="checkbox-all" data-check="all"> 全选</th>
                      <th>名称</th>
                      <th>图片</th>
                      <th>单价</th>
                      <th>数量</th>
                      <th>小计</th>
                    </tr>
                  </thead>

                  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                      <td>
                        <input type="checkbox" class="checkbox-one" data-check-one="<?php echo ($vo["goods_id"]); ?>" name="check[]" value="<?php echo ($vo["goods_id"]); ?>">
                      </td>
                      <td>
                        <?php echo ($vo["goods_name"]); ?>
                      </td>
                      <td>
                        <img width="50px" height="50px" src="<?php echo ($vo["goods_pic"]); ?>" alt="" />
                      </td>
                      <td>
                        <p data-onePrice="<?php echo ($vo["goods_id"]); ?>" ><?php echo ($vo['goods_price']/100); ?></p>
                      </td>
                      <td>
                        <button class="reduce" data-reduce="<?php echo ($vo["goods_id"]); ?>" type="button"  >-</button>
                        <span data-quantity="<?php echo ($vo["goods_id"]); ?>" style="width:30px" > <?php echo ($vo['mycart_quantity']); ?> </span>
                        <button class="add" data-add="<?php echo ($vo["goods_id"]); ?>" type="button"  >+</button>
                      </td>
                      <td>
                        <p data-subtotal="<?php echo ($vo["goods_id"]); ?>" class="price"> <?php echo ($vo['goods_price']/100*$vo['mycart_quantity']); ?> </p>
                      </td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                  <tr>
                    <td colspan="6">
                      <span style="float: right"> 总价：<span  id="all-price" >0</span>元
                      </span>
                    </td>
                  </tr>

                  <tr>
                    <td colspan="6">
                      <span style="float: right">
                        <input id="submit" type="submit"  value="结算submit">
                      </span>
                    </td>
                  </tr>

              </table>

          </form>

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

      $(".add").click(function(){    //点击加按钮
          var goodsid = $(this).attr('data-add');
          sub('add',goodsid);
          getAllPrice();

      });

      $(".reduce").click(function(){  //点击减少按钮
          var goodsid = $(this).attr('data-reduce');
          sub('reduce',goodsid);
          getAllPrice();

      });


      $(".checkbox-all").click(function(){   //点击全选按钮

          if($(this).is(':checked')){
              $(".checkbox-one").prop("checked", true);
          } else {
              $(".checkbox-one").prop("checked", false);
          }
          getAllPrice();

        });

        $(".checkbox-one").click(function(){     //点击单个物品单选时候  判断是否全部选中  如果有其中一个没有选中   则将全部选中的取消

              var oneCheckIfAllTrue = false;
              $(".checkbox-one").each(function () {
                  oneCheckIfAllTrue =  $(this).is(':checked') && oneCheckIfAllTrue;
              });

              if (!oneCheckIfAllTrue) {
                $('.checkbox-all').prop("checked", false);
              }
              getAllPrice();

          });


          $('#submit').click(function() {    //点击提交按钮

            var isCheck = false;
            $(".checkbox-one").each(function () {
                isCheck =  $(this).is(':checked') || isCheck;
            });

            if (!isCheck) {
              layer.alert('请至少选一件商品~');
              return false;
            }
          });



          function getAllPrice() {   //计算总价并更新总价

            var allPrice = 0;

            $(".checkbox-one").each(function() {

              if($(this).is(':checked')){

                  var goodsid = $(this).attr('data-check-one');    //得到点击了的id
                  var subtotalPrice =  parseInt($('[data-subtotal="'+ goodsid + '"]').text());

                  allPrice += subtotalPrice;
                }
              });
              console.log(allPrice);

              $('#all-price').text(allPrice);
          }



            function sub(con,goodsid){     //单个物品加减 计算单个物品总价并更新  还有ajax请求 更新数据库

                var onePrice =  parseInt($('[data-onePrice="'+ goodsid + '"]').text());
                var quantity = parseInt($('[data-quantity="'+ goodsid + '"]').text());
                var subtotal = 0;

                if (con == 'add') {
                        //点击增加按钮
                        $.post("/xyun/my_shop/index.php/Home/Index/addshopcart",
                          {
                            goodsid:goodsid,
                            num:quantity + 1,
                          },
                          function (data,status) {

                            if (data == 1) {
                                quantity += 1;
                                subtotal = quantity * onePrice;

                                $('[data-quantity="'+ goodsid + '"]').text(quantity);
                                $('[data-subtotal="'+ goodsid + '"]').text(subtotal);
                                getAllPrice();
                            } else {
                              layer.alert('稍后再试~');
                            }
                          });

                } else {
                      //点击减少按钮
                      if (quantity <= 1) {
                        layer.alert('不能再减了~');
                        return false;
                      }

                      $.post("/xyun/my_shop/index.php/Home/Index/addshopcart",
                        {
                          goodsid:goodsid,
                          num:quantity - 1,
                        },
                        function (data,status) {

                          if (data == 1) {
                            quantity -= 1;
                            subtotal = quantity * onePrice;

                              $('[data-quantity="'+ goodsid + '"]').text(quantity);
                              $('[data-subtotal="'+ goodsid + '"]').text(subtotal);
                              getAllPrice();
                          } else {
                            layer.alert('添加失败');
                          }
                        });
                      }
              }



    });

</script>

</html>