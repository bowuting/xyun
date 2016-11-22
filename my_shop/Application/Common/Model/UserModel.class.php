<?php
namespace Common\Model;
use Think\Model;
class UserModel extends Model {

  protected $_map = array(
    'name' =>'user_name', // 把表单中name映射到数据表的username字段
    // 'mail' =>'email', // 把表单中的mail映射到数据表的email字段
    'phone_last' => 'user_phone',
    
    );

    /*自动完成*/
     protected $_auto = array (
         array('user_no','getNo',1,'callback'),
         array('user_createtime','time',1,'function'),
         array('user_salt','getSalt',1,'callback'),
         array('user_passwd','getPasswd',1,'callback'),
     );
     public function getNo(){

        $num="";
        for($i=0;$i<5;$i++){
            $num.=rand(0,9);
        }

        $m=M('user');
        $con['user_no']=$num;
        $result=$m->where($con)->find();

        if($result){
            //存在就是重复
          $UserModel=D('User');
          $UserModel->getNo();
        }else{
            //不重复
            return $num;
        }
       }





       public function getSalt(){
         $num="";
         for($i=0;$i<5;$i++){
             $num.=rand(0,9);
         }
         session('salt',$num);
         return $num;
        }

          public function getPasswd(){
            $salt=session('salt');
            session('salt',null);
           $passwd=trim(I('param.passwd'));
           return md5($salt.$passwd);
           # code...
         }


    public function getUserForPhone($phone){
        $m = M(user);
        $con['user_phone'] = $phone;
        $res = $m->where($con)->select();
        // dump($res);
        if (!empty($res)) {
            return true;
        } else {
            return false;
        }
    }
    public function getUserInfo($uid){
      $m = M('user');
      $con['user_id'] = $uid;

      $res = $m->where($con)->find();
      return $res;
      // var_dump($res);

    }
}

?>
