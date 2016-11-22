<?php
namespace Common\Model;
use Think\Model;
class OrderModel extends Model
{

  protected $_map = array(
      //左边的是表单字段 =>右边是数据库字段
      'price' => 'order_price',

  );

  protected $_auto = array(
    //数据库字段名称   // 函数名称      //运行的时机： 1 新增  2 修改 3 全部情况     // 如果是PHP函数=function 自定义为callback
    array("order_ordertime","time",1,"function"),
    array("order_no",'getNo',1,"callback"),
    array('order_address','getAddress',1,'callback'),
    array("order_phone",'getPhone',1,"callback"),
    // array("order_price",'getPrice',3,'callback'),
    // array("order_ispay",'isPay',3,'callback'),
    // array("order_payaccount",'getPayAccount',3,'callback'),
    // array("order_paychannel",'getPayChannel',3,'callback'),
    // array("order_paytime",'getPaytime',3,'callback'),
  );
  public function getNo()
  {
    $num = '';
    for ($i=0; $i < 20; $i++) {
      $num  .= rand(0,9);
    }
    return $num;
  }



  public function getAddress(){
    $addr_id = I('post.addr_id');
    $m = M('addr');
    $con['addr_id'] = $addr_id;
    $res = $m->where($con)->getField('addr_address');
    return $res;

  }
  public function getPhone(){
    $addr_id = I('post.addr_id');
    $m = M('addr');
    $con['addr_id'] = $addr_id;
    $res = $m->where($con)->getField('addr_phone');
    return $res;
  }


}
