<?php
namespace Common\Model;
use Think\Model;
class AddrModel extends Model
{

  protected $_map = array(
      //左边的是表单字段 =>右边是数据库字段

      'name'=>"addr_name",
      'phone'=>"addr_phone",
      'pro' => 'addr_pro',
      'city' => 'addr_city',
      'qu' => 'addr_qu',
      'addr' => 'addr_address',
      'uid' => 'addr_uid',
  );
  public  function getContent(){
      $content = I('post.pro').I('post.city').I('post.qu').I('post.addr');
      return $content;
  }
  protected $_auto = array(
    //数据库字段名称   // 函数名称      //运行的时机： 1 新增  2 修改 3 全部情况     // 如果是PHP函数=function 自定义为callback
    array("addr_createtime","time",1,"function"),
    array('addr_content','getContent',3,"callback"),
  );



}
