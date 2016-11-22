#MyShop thinkPHP 前端 综合使用框架

#后台

    ### 分类管理
              * 1、>thinkPHP的三大自动
              <pre><code>
                class GoodsCatModel extends Model {
                    //自动映射   注意:左右两边的表单和数据库字段不能一样
                    protected $_map = array(
                        //左边的是表单字段 =>右边是数据库字段
                        'id'=>"goodscat_id",
                        'pid'=>"goodscat_pid",
                        'name' => 'goodscat_name',
                        'sort' => 'goodscat_sort',
                        //'desc' => 'goodscat_desc',
                    );
                    //自动完成
                    protected $_auto = array(
                        //数据库字段名称   // 函数名称      //运行的时机： 1 新增  2 修改 3 全部情况  4 如果是PHP函数=function 自定义为callback
                        array("goodscat_createtime","time",1,"function"),
                        array("goodscat_createpeople","getPeople",1,"callback"),
                    );
                  }
                  </code></pre>
              * 2、>无限极分类
              * 3、>更新商品分类时 自动选取上级分类
              <pre><code>
                  $("select").each(function(index, element) {
                      // console.log($(this).attr('default'));
                      // console.log("option[value='"+$(this).attr('default')+"']");
                      $(element).find("option[value='"+$(this).attr('default')+"']").attr('selected','selected');
                  });
                  </code></pre>
              * 4、>thinkPHP模板里面的条件选择：
              <pre><code>
                  <if condition="$v.lev eq 1">
                      |-- {$v.goodscat_name}
                      <elseif condition="$v.lev eq 2" />
                      &nbsp;&nbsp;&nbsp;&nbsp; |--{$v.goodscat_name}
                  </if>
              </code></pre>
              * 5、>layer弹窗框架的使用
              <pre><code>
              layer.open({                                  // 更新 打开弹窗
                type: 2,
                skin: 'layui-layer-rim',
                title:'修改商品分类',
                area: ['600px', '360px'],
                shadeClose: true, //点击遮罩关闭
                content: '__URL__/updateGoodsCat/id/' + id,
              // content: '__APP__/Admin/index/createGoodsCat',
              cancel:function() {
                  location.reload();
                }
              });
              </code></pre>

      商品管理
              1、连表查询 取出商品信息同时  还要取出商品所在分类的信息
                ```
                $result =  $m -> where($con)
                    ->order($o)
                    ->join("LEFT JOIN x_goods_cat ON x_goods_cat.goodscat_id = x_goods.goods_cid")
                    ->select();
                ```

              2、二维数组的排序
              ```
              if ($time) {
                      foreach ($result as $k => $v) {
                          $result[$k]['quality'] = $v['goods_createtime'] + $v['goods_qualitytime'] * 86400;

                      }
                      $quality = array();
                      foreach ($result as $v){

                          $quality[] = $v['quality'];

                      }
                      if ($time == 'desc') {
                          array_multisort($quality,SORT_DESC,$result);
                      } else if ($time == 'asc') {
                          array_multisort($quality,SORT_ASC,$result);
                      }

                  }
              ```

      用户管理



  商品管理
  用户管理







index 首页
gallery 画廊  （按分类进行查找、搜索、筛选、排序order）
1、界面构架 include head.html js.html nav.html
2、按分类进行查找 a链接传值 cid
3、搜索
   if($keyword){
            $con['goods_name']=array("like","%".$keyword."%");
        }

4、筛选
属性选择器、正则表达式  __SELF__

5、排序
一种是数据库order
一种是 数组函数排序

作业：
goods 商品详情页（商品数量添加到购物车ajax）
shopcart 购物车界面（ajax修改商品数量。价格要跟着改变）
