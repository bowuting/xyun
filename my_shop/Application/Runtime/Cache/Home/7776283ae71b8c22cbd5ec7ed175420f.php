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
          <!-- <div ng-app="">
 	          <p>名字 : <input type="text" ng-model="name"></p>
 	          <h1>Hello {{name}}</h1>
          </div> -->
          <form class="" action="/xyun/my_shop/index.php/Home/Index/order" method="post">
              <table class="ui celled table">
                <thead>
                  <tr>
                    <th>
                      <input type="checkbox" class="checkbox-all" data-check="all">  全选

                    </th>
                    <th>名称</th>
                    <th>图片</th>
                    <th>单价</th>
                    <th>数量</th>
                    <th>小计</th>

                  </tr>
                </thead>

                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td>
                        <input type="checkbox" data-check="<?php echo ($vo["goods_id"]); ?>" class="checkbox n_check" name="ch[]" value="<?php echo ($vo["goods_id"]); ?>">
                    </td>
                    <!-- <input type="hidden" name="goods_id" value="<?php echo ($vo["goods_id"]); ?>"> -->
                    <td>
                      <?php echo ($vo["goods_name"]); ?>
                    </td>
                    <td>
                      <img width="50px" height="50px"src="<?php echo ($vo["goods_pic"]); ?>" alt="" />
                    </td>
                    <td>
                      <p data-onePrice="<?php echo ($vo["goods_id"]); ?>" >
                        <!-- <input type="hidden" name="goods_price" value="<?php echo ($vo['goods_price']); ?>"> -->
                        <?php echo ($vo['goods_price']/100); ?>
                      </p>
                    </td>
                    <td>
                      <button class="reduce" data-reduce="<?php echo ($vo["goods_id"]); ?>" type="button"  >-</button>

                      <span data-quantity="<?php echo ($vo["goods_id"]); ?>" style="width:30px" type="text" name="num"  > <?php echo ($vo['mycart_quantity']); ?> </span>
                      <button class="add" data-add="<?php echo ($vo["goods_id"]); ?>" type="button"  >+</button>

                    </td>
                    <td>

                      <p data-subtotal="<?php echo ($vo["goods_id"]); ?>" class="price">

                        <?php echo ($vo['goods_price']/100*$vo['mycart_quantity']); ?>
                      </p>
                    </td>
                  </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                <tr>
                  <td colspan="6">
                    <span style="float: right">
                      总价：<span  id="all-price" >0</span>元
                    </span>
                  </td>
                </tr>
                <tr>
                  <td colspan="6">
                    <span style="float: right">
                      <input id="submit" type="submit"  value="结算submit">
                      <!-- <button type="button" class="orderbtn" name="button">结算</button> -->
                    </span>
                  </td>
                </tr>
              </table>

          </form>

          <!-- <button type="button" class="" name="button">结算</button> -->

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


    function sub(con,goodsid){
        // console.log(con);
        // console.log('data-' + con);

        console.log(goodsid);
        var onePrice =  parseInt($('[data-onePrice="'+ goodsid + '"]').text());
        var quantity = parseInt($('[data-quantity="'+ goodsid + '"]').text());
        var Subtotal = 0;

        if (con == 'add') {


          $.post("/xyun/my_shop/index.php/Home/Index/addshopcart",
            {
              goodsid:goodsid,
              num:quantity + 1,
            },
            function (data,status) {

              if (data == 1) {
                  quantity += 1;
                  Subtotal = quantity * onePrice;

                  $('[data-quantity="'+ goodsid + '"]').text(quantity);
                  $('[data-subtotal="'+ goodsid + '"]').text(Subtotal);
                  allPrice();
              } else {
                layer.alert('稍后再试~');
              }
            });



        } else {
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
                Subtotal = quantity * onePrice;

                  $('[data-quantity="'+ goodsid + '"]').text(quantity);
                  $('[data-subtotal="'+ goodsid + '"]').text(Subtotal);
                  allPrice();
              } else {
                layer.alert('添加失败');
              }
            });

        }
        // Subtotal = quantity * onePrice;
        //         $('[data-quantity="'+ goodsid + '"]').text(quantity);
        //         $('[data-subtotal="'+ goodsid + '"]').text(Subtotal);

    }


      $(".add").click(function(){
        var goodsid = $(this).attr('data-add');
        sub('add',goodsid);
        allPrice();

      });

      $(".reduce").click(function(){
        var goodsid = $(this).attr('data-reduce');
        sub('reduce',goodsid);
        allPrice();
      //  allPrice();
      });


      function allPrice() {

        var allPrice = 0;

        $(".checkbox").each(function () {
          // if ($(this).is(':checked')) {
          //   console.log($(this).attr('data-check'));
          // }
          // return false;
          if($(this).is(':checked')){

              var goodsid = $(this).attr('data-check');
              var subtotalPrice =  parseInt($('[data-subtotal="'+ goodsid + '"]').text());

              allPrice += subtotalPrice;

            }

          });

          $('#all-price').text(allPrice);
      }

      $(".checkbox-all").click(function(){
        if($(this).is(':checked')){

              var isAll = $(this).is(":checked");

              if(isAll){
               //选择了
               $(".n_check").prop("checked", true);
           }
          //  else{
          //      $(".n_check").prop("checked", false);
          //  }

              // if (isAll == 'all') {
              //   console.log('dad');
              //   // location.reload();
              //
              //   $('.n_check').attr("checked",'checked');
              //
              //   // console.log(isAll);
              // }

            }
            allPrice();

        });



        $(".checkbox").click(function(){

             allPrice();

          });


          // $('.orderbtn').click(function(){
          //   var arr = new Array();  ;
          //   var  i = 0;
          //    $(".checkbox").each(function () {
          //      if($(this).is(':checked')){
          //          var goodsid = $(this).attr('data-check');
          //          arr[i] = goodsid;
          //          i += 1;
          //        }
          //   });
          //
          //
          //   var str = JSON.stringify(arr);
          //
          //   // console.log(str);
          //   // console.log(goodsid);
          //
          //
          //
          //            $.post("/xyun/my_shop/index.php/Home/Index/order",
          //              {
          //                goodsids:str,
          //              },
          //             //  dataType:"json",
          //             //  contentType:"application/json",
          //              function (data,status) {
          //
          //                console.log(data);
          //                return false;
          //
          //                 if (data == 1) {
          //                   layer.open({                              // 更新  打开弹窗
          //                     type: 2,
          //                     skin: 'layui-layer-rim',
          //                     title:'结算',
          //                     area: ['1200px', '900px'],
          //                     // shadeClose: true, //点击遮罩关闭
          //                      content: '/xyun/my_shop/index.php/Home/Index/orderProcess',
          //                     closeBtn: 2,
          //                   shift: 0,
          //                   maxmin: true,
          //                   moveType: 0,
          //                     //content: '/xyun/my_shop/index.php/Admin/index/createGoodsCat',
          //                   cancel:function() {
          //                       location.reload();
          //                     }
          //                   });
          //                 }
          //
          //
          //              });
          //
          //
          //
          //
          //
          // });


          $('#submit').click(function() {

            var isCheck = false;
            $(".checkbox").each(function () {
                isCheck =  $(this).is(':checked') || isCheck;
            });

            if (!isCheck) {
              layer.alert('请至少选一件商品~');
              return false;
            }
          });
    });

</script>

</html>