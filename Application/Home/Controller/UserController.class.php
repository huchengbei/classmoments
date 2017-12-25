<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
    public function index(){
    	$this->redirect('login');
    	//$this->display();
        //$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover,{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }

    public function login(){
    	if(IS_POST){
	    	$username = I('post.username');
	    	$password = I('post.password');
	    	//echo $username." ".$password;

            $map['username'] = $username;
            $map['password'] = $password;
            $user = D('ViewStudentInfo');
            $class = D('Class');
            $manager = D('Manager');
            $userdata = $user->where($map)->find();
            if($userdata){
                session('currentUser',$userdata);

                $classMap['classId'] = $userdata['classId'];
                $classMap['monitorId'] = $userdata['userId'];

                $managerMap['classId'] = $userdata['classId'];
                $managerMap['userId'] = $userdata['userId'];

                $classdata = $class->where($classMap)->find();
                /*
                dump($userdata);
                dump($classMap);
                dump($classdata); 
                return ;
                */
                if($classdata){
                    session('currentUserType','monitor');
                }elseif($manager->where($managerMap)->find()){
                    session('currentUserType','manager');
                }else{
                    session('currentUserType','student');
                }
                //dump(session('currentUserType'));
                $currentUserType = session('currentUserType');
                switch ($currentUserType) {
                    case 'monitor':
                        # code...
                        $this->redirect('Index/mainMonitor');
                        break;
                    case 'manager':
                        # code...
                        $this->redirect('Index/mainManager');
                        break;
                    case 'student':
                        # code...
                        $this->redirect('Index/mainStudent');
                        break;
                    
                    default:
                        # code...
                        break;
                }
            }else{
                $this->error = "密码错误";
                $this->op='login';
                $this->display('welcome');
            }


    	}else{
            //$this->display();
            $this->display('welcome');
    	}
    }

    public function logout(){
        session('currentUser',null);
        session('currentUserType',null);
        $this->redirect('login');
    }

    public function register(){
    	if(IS_POST){
    		$username = I('post.username');
    		$password = I('post.password');
    		$nikename = I('post.nikename');
    		$type = I('post.type');
    		$uniqueCode = I('post.uniqueCode');
    		$grade = I('post.grade');
    		$className = I('post.className');

    		$user = D('User');
    		$class = D('Class');

    		if($user->where('username=\''.$username.'\'')->find()){
    			$this->error = "用户名已存在";
                $this->op='register';
    			$this->display('welcome');
    			return ;
    		}

    		$userdata['username'] = $username;
    		$userdata['nikename'] = $nikename;
    		$userdata['password'] = $password;

 			if($type=='join'){
 				$classId = $class->where('uniqueCode=\''.$uniqueCode.'\'')->getField('classId');
 				if($classId){
	 				$userdata['classId'] = $classId;
	 				$user->add($userdata);
	 				$this->success("注册成功！","login",3);
 				}else{
 					$this->error = "班级惟一代码错误";
                    $this->op='register';
	    			$this->display('welcome');
	    			return ;
 				}
 			}else{
 				$user->add($userdata);
    			$userId = $user->where($userdata)->getField('userId');

    			$classdata['grade'] = $grade;
    			$classdata['className'] = $className;
    			$uniqueCode = randCode(6);
    			//print_r($uniqueCode);
    			print_r('uniqueCode='.$uniqueCode);
    			$status = $class->where('uniqueCode=\''.$uniqueCode.'\'')->find();
    			while($status){
    				$uniqueCode = randCode(6);
    				$status = $class->where('uniqueCode=\''.$uniqueCode.'\'')->find();
    			}
    			$classdata['uniqueCode'] = $uniqueCode;
    			$classdata['monitorId'] = $userId;
    			$class->add($classdata);
    			$classId = $class->where('uniqueCode=\''.$uniqueCode.'\'')->getField('classId');

    			$data['classId'] = $classId;
    			$user->where('userId='.$userId)->save($data);
	 			$this->success("注册成功！","login");
 			}
    	}else{
    		$this->display('welcome');
    	}
    }

    public function change(){
        $userId = I('post.userId');
        $password0 = I('post.password0');
        $password1= I('post.password1');
        $userD = D('User');
        $map['userId'] =$userId;
        $map['password'] = $password0;
        if($userD->where($map)->find()){
            $map1['userId'] = $userId;
            $data['password'] = $password1;
            $userD->where($map1)->save($data);
            $currentUserType = session('currentUserType');
            switch ($currentUserType) {
                case 'monitor':
                    # code...
                    $this->redirect('Index/mainMonitor');
                    break;
                case 'manager':
                    # code...
                    $this->redirect('Index/mainManager');
                    break;
                case 'student':
                    # code...
                    $this->redirect('Index/mainStudent');
                    break;
                
                default:
                    # code...
                    break;
            }
        }else{
            session('error',"原密码错误！");
            $this->changePassword();
        }
    }

    public function changePasswordPage(){
        $this->error = session('error');
        $this->currentUser = session('currentUser');
        $this->display();
        session('error',null);
    }

    public function changePassword(){
        $mainPage = U('User/changePasswordPage');
        //echo $mainPage;
        //return ;
        $this->mainPage = $mainPage;
        $this->currentUser = session('currentUser');
        
        $currentUserType = session('currentUserType');
        switch ($currentUserType) {
            case 'monitor':
            # code...
                $this->display('Index:mainMonitor');
                break;
            case 'manager':
                # code...
                $this->display('Index:mainManager');
                break;
            case 'student':
                # code...
                $this->display('Index:mainStudent');
                break;
           
            default:
                # code...
                break;
        }
    }

}