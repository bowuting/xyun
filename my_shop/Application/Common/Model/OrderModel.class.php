<?php
namespace Common\Model;
use Think\Model;
class OrderModel extends Model
{

  protected $_map = array(
      //左边的是表单字段 =>右边是数据库字段
      'price' => 'order_totalprice',
      'addr_name' => 'order_address_name',
      'addr_phone' => 'order_address_phone',
      'addr_content' => 'order_address_content',

  );

  protected $_auto = array(
    //数据库字段名称   // 函数名称      //运行的时机： 1 新增  2 修改 3 全部情况     // 如果是PHP函数=function 自定义为callback
    array('order_time','time',1,'function'),
    array('order_no','getNo',1,'callback'),
    array('order_uid','getUid',1,'callback'),

    // array("order_price",'getPrice',2,'callback'),
    array("order_ispay",'isPay',2,'callback'),
    array("order_payaccount",'getPayAccount',2,'callback'),
    array("order_paychannel",'getPayChannel',2,'callback'),
    array("order_paytime",'getPaytime',2,'callback'),
  );
  protected function getNo(){
    $uid = session('uid');
    $now = time();
    $now = date('YmdHis',$now);
    $no = $now . rand(0,9) . $uid;

    return $no;
  }
  protected function getUid(){
    $uid =  session('uid');
    return $uid;
  }







}
