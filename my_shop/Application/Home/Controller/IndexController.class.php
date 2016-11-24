<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    // 首页
    public function index(){
        $this->display();
    }

    public function gallery(){

      // 得到所有get传值
      $cid = I('get.cid');
      $keyword = I('get.keyword');
      $color = I('get.color');
      $price = I('get.price');
      $price_2 = I('get.price_2');
      $time = I('get.time');

      $GoodsCatModel = D('GoodsCat');
      $result = $GoodsCatModel->getInfiniteGoodsCat();  //得到无限极分类
      $this->assign('list',$result);

      $GoodsModel = D(Goods);
      if ($cid == ""){
          $cid = $GoodsCatModel->getLastChildId($GoodsCatModel->getChildID('0'));  //如果没有cid则说明是取所有的  则得到所有的二级分类
          // $cid 现在是所有二级分类的id的数组
      } else {
          if ($GoodsCatModel->isHaveChild($cid)) {     //如果有cid  则看该cid有没有子类  如果有子类  则得到其所有子类（也就是二级分类）
              $cid = $GoodsCatModel->getChildID($cid);
          // $cid是某个一级分类的所有子类的id组成的数组
          }
      }

      $goodsList = $GoodsModel->getGoods('',$cid,$keyword,$color,$price,$price_2,$time);
      $this->assign('goodsList',$goodsList);

      $this->display();

    }

    public function goods(){
        $id = I('get.goods_id');
        $GoodsModel = D(Goods);
        $result = $GoodsModel->getOneGoods($id);
        $this->assign('goodsInfo',$result);
        // dump($result);
        $this->display();
    }

    public function addshopcart(){

        $goodsid = trim(I('param.goodsid'));
        $num = trim(I('param.num'));
        $isgoods = trim(I('param.isgoods'));  //商品是否存在
        $uid = session('uid');
        // $cart_info = $m->where('mycart_goods_id='.$id)->find();
        // dump($cart_info);
        // exit;
        $ShopcartModel = D('Shopcart');
        $res = $ShopcartModel->isInShopcart($uid,$goodsid);

            //
        if ($res === 1) { //如果已经在数据库 则更新
          if ($isgoods) {
            $r = $ShopcartModel->updateShopcart($uid,$goodsid,$num,$isgoods);
          } else {
            $r = $ShopcartModel->updateShopcart($uid,$goodsid,$num,null);
          }

        } else { //如果没有在数据库 则添加
          $r = $ShopcartModel->createShopcart($uid,$goodsid,$num);
        }

        if ($r >0 ) {
          echo "1";
        } else {
          echo '0;';
        }
    }

    public function shopcart(){
      // echo __URL__;
      if (empty(session('uid'))) {
        $this->error('您还没有登录，正在在为您跳转至登录页面！',__APP__.'/Login/Index/signin');
      }
        $ShopcartModel = D('Shopcart');
        $uid = session('uid');
        $res = $ShopcartModel->getShopcart($uid);
        // dump($res);
        $this->assign('list',$res);
        $this->display();
      }


      //订单显示页面 通过uid、gid得到订单各个信息 展示到页面
      public function order(){

        $gids = I('post.check');                         //得到一个商品id的数组
        $uid = session('uid');

        $shopcartModel = D('Shopcart');                  //得到连表查询之后的 商品信息和购物车信息
        $shopcartRes = $shopcartModel->getShopcartFromUidAndGid($uid,$gids);
        $this->assign('res',$shopcartRes);

        for ($i=0; $i < sizeof($shopcartRes); $i++) {    //将购物车的物品个数信息和商品信息  得到  总价格
          $allPrice +=  $shopcartRes[$i]['mycart_quantity'] * $shopcartRes[$i]['goods_price'];
        }
        $this->assign('allPrice',$allPrice);

        $gidsStr = implode('..',$gids);                  // 将gids（数组）转为以 .. 分割开来的字符串
        $this->assign('gidsStr',$gidsStr);

        $addrDB =  M('addr');                             //根据uid查的此人的收货地址信息
        $con['addr_uid'] = $uid;
        $addrs = $addrDB->where($con)->select();
        $this->assign('addrs',$addrs);

        $this->display();
      }


      //订单处理
      public function orderProcess()
      {
            $uid = session('uid');

            if(empty($uid)){
              $this->error('您还没有登录',__APP__.'/Login/Index/signin');
            } else {
                /*
                这是接收到的post数据
                'addr_name' => string ' 丁博武 ' (length=11)
                'addr_phone' => string ' 18883284586' (length=12)
                'addr_content' => string ' 陕西省西安市灞桥区国际港务区' (length=43)
                'gidsStr' => string '8' (length=1)
                'allPrice' => string '488800' (length=6)
                */

              $gidsStr = I('post.gidsStr');
              $gidsArr = explode('..',$gidsStr);   //拆分字符串  成  数组形式   goods id  数组形式

              // 订单总表
              $orderModel = D('Order');
              $orderModel->startTrans();   //开启事务
              if (!$orderModel->create($_POST,1)) {
                  $this->error($orderModel->getError());
              } else {
                  $orderid = $orderModel->add();
                  if (!($orderid > 0)) {
                    $orderModel->rollback();
                    $this->error('请稍后再试！');
                  }
              }

            //  订单子表
            $shopcart = D('Shopcart');
            $res = $shopcart->getShopcartFromUidAndGid($uid,$gidsArr); // 连表查询得到购物车信息和商品信息
            foreach ($res as $k => $v) {
                $data['orderdetail_orderid'] = $orderid;
                $data['orderdetail_goodsid'] = $v['goods_id'];
                $data['orderdetail_goodsname'] = $v['goods_name'];
                $data['orderdetail_goodsprice'] = $v['goods_price'];
                $data['orderdetail_quantity'] = $v['mycart_quantity'];
                $data['orderdetail_goodsdesc'] = $v['goods_desc'];
                $order_detail = M('order_detail');
                $r2 = $order_detail->add($data);
                if (!($r2 > 0)) {
                  $orderModel->rollback();
                }
            }

            //  从购物车删除
            $r3 = $shopcart->deleteShopcart($uid,$gidsArr);


            if ($r3 > 0  AND $orderid > 0) {
              $orderModel->commit();
              $this->success('订单提交成功 正在跳转支付界面','myorder',1);
            } else {
              $orderModel->rollback();
              $this->success('订单提交失败 请稍后尝试');
            }
        }
      }

      public function myorder(){
        $uid = session('uid');
        if(empty($uid)){
          $this->error('您还没有登录，正在为你跳转登录页面',__APP__.'/Login/Index/signin');
        } else {
          $order = M('order');
          $con['order_uid'] = $uid;
          $orderlist = $order->where($con)->select();

          $app_id = "dcf7509d-e33e-4629-ac84-fba86b6f6225";
          $app_secret = "3b7f00e0-d9e7-4eac-a1b7-2c05e7698d84";

          foreach($orderlist as $key=>$value){

            $title = "my_shop:".$value['order_no'];
            $amount = $value['order_totalprice'];//支付总价
            $out_trade_no = $value['order_no'];//内订单号，需要保证唯一性

            $orderlist[$key]["sign"] = md5($app_id . $title . $amount . $out_trade_no . $app_secret);
            $orderlist[$key]['paypeople']=session('uid');
        }
          $this->assign('orderlist',$orderlist);
          dump($orderlist);


          $orderdetail=M('order_detail');
          $orderdetailcon['orderdetail_uid']=$uid;
          $orderdetaillist=$orderdetail->where($orderdetailcon)->select();
          $this->assign("orderdetail",$orderdetaillist);

          $this->display();
          // echo "<h2>支付页面</h2>";
        }

      }


      /*支付的webhook 不用继承CommonController*/
        public function webhook(){
            //http类型为 Application/json, 非XMLHttpRequest的application/x-www-form-urlencoded, $_POST方式是不能获取到的
            $appId = "dcf7509d-e33e-4629-ac84-fba86b6f6225";
            $appSecret = "3b7f00e0-d9e7-4eac-a1b7-2c05e7698d84";
            $jsonStr = file_get_contents("php://input");
            $msg = json_decode($jsonStr);

            // 1.验证数字签名,防止黑客
            $sign = md5($appId . $appSecret . $msg->timestamp);
            if ($sign != $msg->sign) {
                // 签名不正确

                exit();
            }
            //2.是否是付款信息
            if ($msg->transaction_type != "PAY") {

                exit;
            }

            //3.支付状态是否变为支付成功
            //在BeeCloud获得渠道的确认信息（包括支付成功，退款成功）后，会通过主动推送的方式将确认消息推送给客户的server。
            //所以能收到这个消息基本都是true;交易是否成功，目前收到的消息都是交易成功的消息
            $result = $msg->trade_success;
            if ($result == false) {

                exit;
            }

            //4.验证 金额是否匹配
            $order = M('order');
            //开启事务
            // $order->startTrans();
            /*transaction_id才是真正的订单号，每个渠道都会返回这个*/
            $orderno = $msg->transaction_id;

            //取出数据库实际订单的金额,单位为分
            $con['order_no'] = $orderno;
            $actprice = $order->where($con)->getField('order_totalprice');
            // echo $actprice;
            //收到的服务器订单金额,单位为分
            $getprice = $msg->transaction_fee;
            if ($actprice != $getprice) {
                //金额不匹配,不安全,不往下执行
                exit;
            }
            /*
             * 5.查看该订单是否已经支付,已经支付就不再改变 不然会改变支付时间
             * 注意：同一条订单可能会发送多条支付成功的webhook消息，
             * 这是由渠道触发的(比如渠道的重试)，同一个订单的重复的支付成功的消息应该被忽略。退款同理。
            */
            $ispay=$order->where($con)->getField('order_ispay');
            if($ispay==1){
                //已经支付 不用执行了
                exit;
            }
            //6.修改 订单支付状态 支付渠道 支付者 支付时间-事务
            //收到支付渠道 'WX' or 'ALI' or 'UN' or 'KUAIQIAN' or 'JD' or 'BD' or 'YEE' or 'PAYPAL'

            // //取支付时间

            // //支付者

            $data['order_ispay'] = 1;
            $data['order_payaccount'] = $msg->message_detail->buyer_email;
            $data['order_paytime'] = time();
            $data['order_paychannel'] = $msg->channel_type;

            $result1 = $order->where($con)->save($data);
            if ($result1) {
              echo 'success';
              $this->success('支付成功','http://bowuting.cn/my_shop/index.php/Home/Index/myorder',2);
            }

        }

}
