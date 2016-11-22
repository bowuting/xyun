<?php

namespace Login\Controller;
use Think\Controller;

class IndexController extends Controller {

    public function registerFirst(){
        // self::verify();
        // dump($_SESSION['verify_code']);

        $this->display();
    }
    public function registerSecond(){
        // echo "第二步";
        $data = I('post.');
        dump($data);
        $this->assign('data',$data);
        $this->display();

    }
    public function verify() {
        $config = array(
            'fontSize' => 22, // 验证码字体大小
            'length' => 3, // 验证码位数
            'imageH' => 0,
            'imageW' => 0,
            'useCurve' => false,
            'useNoise' => false,
        );
        $Verify = new \Think\Verify($config);
        $Verify->entry();
    }


    public function ajaxIsThisPhoneRegistered(){
        // dump(I('post.'));
        $phone = I('post.phone');
        $User = D('User');
        $res = $User->getUserForPhone($phone);
        // dump($res);
        // exit;
         if (!$res) {
             echo "";
         } else {
             echo "已经被注册";
         }
    }

    public function ajaxCheckVerify(){
        $code = I('post.verify');
        $verify = new \Think\Verify();
        $res =  $verify->check($code,'');
        // dump($res);
        if ($res) {
            echo "";
        } else {
            echo "验证码错误";
        }
    }



    public function sendSms(){
      $phonenum=trim(I('param.phonenum'));
      $Sms = D('Sms');
      $res1 = $Sms->isSms($phonenum);

      $code="";
      for($i=0;$i<4;$i++){
          $code .= rand(0,9);
      }
      // echo $res;
      // exit;
      if (!$res1) {

          // 没有注册过  短信数据库没有该手机号码
          // $result = sendSms($phonenum,$code);
          $result = 100;
          if ($result == 100) {   //发送成功
          if ($Sms->addPhone($phonenum,$code)) {  // 写入数据库   新的手机号
              echo "1";
            }
          } else {
            echo "0";             //发送失败
          }
      } else {  // 注册过  该手机号在短信数据库里存在
          $res2 = $Sms->isBlack($phonenum);
          if (!$res2) {    //如果不是黑名单

            $res3 = $Sms->isLastSendOnToday($phonenum);
            // echo $res3;
            //
            if (!$res3) {                                         //不是今天发的  则将今天的发生次数置1
                $res5 = $Sms->updatePhone($phonenum,$code,1);   //更新code和今天的次数 最后发送时间
                $res6 = $Sms->setIncTotalTimes($phonenum);      //更新总次数 + 1
                // $result = sendSms($phonenum,$code);
                if ($res5 && $res6) {
                  echo "1";
                } else {
                  echo "0";
                }
            } else {                                       //是今天发的  则判断今天发送次数超过5没有
              $res4 = $Sms->isSmsFiveTimesToday($phonenum);
              if ($res4 < 5) {  //今天还没有超过5次
                  $res5 = $Sms->updatePhone($phonenum,$code,0);    //更新code和最后发送时间
                  $res6 = $Sms->setIncTotalTimes($phonenum);      //更新总次数 + 1
                  $res7 = $Sms->setIncTodayTimes($phonenum);
                  // $result = sendSms($phonenum,$code);
                    if ($res5 && $res6) {
                      echo "1";
                    } else {
                      echo "0";
                    }
                } else {
                    echo "3";   // 今天已经发生5次
                }
            }

          } else {        //如果是黑名单 则直接提示是黑名单  不能发送短信
            echo "2";
          }
      }
    }

    public function ajaxCheckSmsVerity(){
      $smscode=trim(I('param.smscode'));
      $phone=trim(I('param.phone'));
      // dump($smscode);

      $Sms = D('Sms');
      $res1 = $Sms->checkSms($phone,$smscode);
      $res2 = $Sms->checkSms10Min($phone);
      // echo $res1;
      // echo $res2;
      if ($res1 && $res2) {
        echo "";
      } else {
        if ($res1 === 0) {
          echo "验证码错误";
        } else {
          echo "验证码已失效";
        }
      }


    }

    public function test(){
      if (empty($_SESSION['uid'])) {
        echo "登录";
      } else {
        echo "登出";
      }
    }


    public function register(){

      if(I('post.')){
            $UserModel=D('User');
            if (!$UserModel->create($_POST,1)){
                $this->error($UserModel->getError());
            } else {
                $result=$UserModel->add();
                if($result>0){
                    $this->redirect('signin');
                    exit;
                }else{
                    $this->error("注册失败");
                    exit;
                }
            }
        } else {
          $this->error('非法操作');
        }

    }

    public function signin(){
      $this->display();
    }
    public function signout(){
      session('uid',null);
      $this->success('登出成功','http://localhost/github/my_shop/index.php/Home/');
    }

    public function signinProcess(){
      // dump(I('post.'));
      $phone = trim(I('post.phone'));
      $passwd = trim(I('post.passwd'));

      $m = M('user');
      $con['user_phone'] = $phone;
      $salt = $m->where($con)->getField('user_salt');
      $uid  = $m->where($con)->getField('user_id');
      $form_passwd = md5($salt.$passwd);
      $db_passwd = $m->where($con)->getField('user_passwd');
      if ($form_passwd === $db_passwd) {
        session('uid',$uid);
        // dump($_SESSION);
        $this->redirect("Home/Index/gallery");
      } else {
        $this->error('用户名或者密码错误');
      }
    }

    public function me(){
        if (session('uid')) {
          $uid =  session('uid');
          $user = D('User');
          $info = $user->getUserInfo($uid);
          $this->assign('info',$info);
          //  dump($info);

          $m = M('addr');
          $con['addr_uid'] = $uid;
          $list = $m->where($con)->select();
          // dump($list);
          $this->assign('list',$list);

          $this->display();
        } else {
          $this->redirect('Login/Index/signin');
        }
    }

    public function addaddress()
    {

      // dump($_POST);
      // exit;
      $Addr = D('Addr');

      if (!$Addr->create($_POST,1)) {
          $this->error($GoodsModel->getError());
      } else {

          $result=$Addr->add();
          if($result>0){

            echo "1";

              // $this->success("新增成功");
              // exit;
          } else {

              $this->error("新增失败");
              exit;
          }
      }


    }




}
