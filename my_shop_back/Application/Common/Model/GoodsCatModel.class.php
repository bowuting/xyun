<?php
namespace Common\Model;
use Think\Model;
class GoodsCatModel extends Model {

    //三大自动

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
        //数据库字段名称   // 函数名称      //运行的时机： 1 新增  2 修改 3 全部情况     // 如果是PHP函数=function 自定义为callback
        array("goodscat_createtime","time",1,"function"),
        //array("goodscat_createpeople","getPeople",1,"callback"),
    );

    // public function getPeople(){
    //
    //     return 11;
    // }

    //自动验证  暂无

    public function getAllGoodsCat(){

        $m=M('goods_cat');
        return $result=$m->select();
    }

  //得到所有分类
  public function getInfiniteGoodsCat(){

             $m=M('goods_cat');

             //order排序
             $list=$m->order("goodscat_sort")->select();

             function subtree($arr,$id=0,$lev=1) {
                 $subs = array(); // 子孙数组
                 foreach($arr as $v) {
                     if($v['goodscat_pid'] == $id) {
                         $v['lev'] = $lev;
                         $subs[] = $v;
                         $subs = array_merge($subs,subtree($arr,$v['goodscat_id'],$lev+1));
                     }
                 }
                 return $subs;
             }

             $list = subtree($list,0,1);
             return $list;
         }


    public function getChildID($id){
        $m=M('goods_cat');
        $con['goodscat_pid']=$id;
        $result = $m->where($con)->select();
        $childID = array();
        foreach ($result as $k => $v) {
            $childID[] = $v['goodscat_id'];
        }
        return $childID;
    }
    public function getLastChildId($arr){
        $res = array();

        foreach ($arr as $k => $v) {
          $qq = $this->getChildID($v);
          foreach ($qq as $key => $value) {
            $res[] = $value;
          }
        }
        return $res;
    }
    public function isHaveChild($id){

        $m=M('goods_cat');
        $con['goodscat_pid']=$id;
        $result=$m->where($con)->find();

        if($result){
            return 1;
        }else{
            return 0;
        }

    }

}

?>
