<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta charset="utf-8">
<!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
<!-- <meta http-equiv="Access-Control-Allow-Origin" content="*"> -->
<!-- Bootstrap -->

<!-- bootstrap css -->
<link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- layer css -->
<link href="//cdn.bootcss.com/layer/2.4/skin/layer.css" rel="stylesheet">

<!-- wangEditor css -->
<link rel="stylesheet" href="//cdnsh.bowuting.com/cdn/wangEditor/dist/css/wangEditor.min.css" rel="stylesheet">

  </head>
  <body>

      <form class="" action="/github/my_shop/index.php/Admin/Index/updateGoodsCatAction" method="post">
          <table class="table table-bordered">
              <tr>
                  <td>
                      分类名称：
                  </td>
                  <td>
                    <input type="hidden" id="id" name="id" value="<?php echo ($one['goodscat_id']); ?>">
                    <input type="text" id="name" name="name" value="<?php echo ($one['goodscat_name']); ?>">
                  </td>
              </tr>
              <tr>
                  <td>
                      分类：
                  </td>
                  <td>
                      <?php if($isHaveChild == 1): ?>该分类下有子类，不能修改。请先移除子类
                      <?php else: ?>

                      <select name="pid" default="<?php echo ($one['goodscat_pid']); ?>">
                          <option value="0">顶级节点</option>

                          <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["goodscat_id"]); ?>"
                                    <?php if($v["lev"] == 2): ?>disabled="disabled"
                                    <?php elseif($v["goodscat_id"] == $_GET['id']): ?>
                                        disabled="disabled"<?php endif; ?>
                              >

                                <?php if($v["lev"] == 1): ?>|-- <?php echo ($v["goodscat_name"]); ?>
                                    <?php elseif($v["lev"] == 2): ?>
                                    &nbsp;&nbsp;&nbsp;&nbsp; |--<?php echo ($v["goodscat_name"]); endif; ?>

                            </option><?php endforeach; endif; else: echo "" ;endif; ?>

                      </select>
                      <!-- <input type="text" name="lev" value=""> --><?php endif; ?>
                  </td>
              </tr>
              <tr>
                  <td>
                      排序：
                  </td>
                  <td>
                      <input id="sort" type="text" name="sort" value="<?php echo ($one["goodscat_sort"]); ?>">
                  </td>
              </tr>
              <tr>
                  <td colspan="2" class="text-center">
                    <input  type="submit" class="btn btn-primary"  value="提交">
                    <button type="button" name="button" class="btn btn-primary update_action_btn">ajax提交</button>
                  </td>
              </tr>
          </table>

      </form>



  </body>
  
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.js"></script>

<!-- layer js -->
<script src="//cdn.bootcss.com/layer/2.4/layer.js"></script>

<!-- wangEditor js -->
<script src="//cdnsh.bowuting.com/cdn/wangEditor/dist/js/wangEditor.min.js"></script>


  <script type="text/javascript">

  $(document).ready(function(){

    $(".update_action_btn").click(function(){
    $.post("/github/my_shop/index.php/Admin/Index/updateGoodsCatAction",
      {
        id:$("#id").val(),
        pid:$('select').val(),
        name:$("#name").val(),
        sort:$("#sort").val()
      },
      function (status) {
        if (status == 1) {
          layer.open({
          content: '更新成功',
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

      $("select").each(function(index, element) {
          // console.log($(this).attr('default'));
          // console.log("option[value='"+$(this).attr('default')+"']");
          $(element).find("option[value='"+$(this).attr('default')+"']").attr('selected','selected');
      });


    });  // ready(function(){ 结束


  </script>
</html>