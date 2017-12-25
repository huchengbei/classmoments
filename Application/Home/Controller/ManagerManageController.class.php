<?php
namespace Home\Controller;
use Think\Controller;
class ManagerManageController extends Controller {
    public function index(){
    	$this->redirect('User/index');
    	//$this->display();
        //$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover,{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }
    public function lists(){
        if(!session('currentUser'))
            $this->redirect('User/index');

        $user =  D('ViewStudent');
        $currentUser = session('currentUser');
        $classMap['classId'] = $currentUser['classId'];
        //dump($map);
        $classMembers = $user->where($classMap)->order('usernumber')->select();

        //dump($classMembers);
        session('classMembers',null);
        session('classMembers',$classMembers);

        $manager =  D('ViewManager');
        $managerMap['classId'] = $currentUser['classId'];

        $count = $manager->where($managerMap)->count();
        $Page       = new \Think\Page($count,10);// 实例化分页类
        $show       = $Page->show();// 分页显示输出// 进行分页数据查询
        $limit = $Page->firstRow.','.$Page->listRows;
        //var_dump($Page);
        session('show',null);
        session('show',$show);

        //dump($map);
        $managerMembers = $manager->where($managerMap)->order('usernumber')->limit($limit)->select();
        //dump($managerMembers);
        //echo $manager->getLastSql();
        session('managerMembers',null);
        session('managerMembers',$managerMembers);
        $mainPage = U('ManagerManage/student');
        //echo $mainPage;
        //return ;
        
        $this->mainPage = $mainPage;
        $this->pageSize = 10;
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

    public function add(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        session('student',null);
        $mainPage = U('ManagerManage/save');
        //echo $mainPage;
        $this->mainPage = $mainPage;
        $this->pageSize = 10;
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

    public function edit(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $userId = I('get.userId');
        $classId = I('get.classId');
        //dump(I('get.userId'));
        $manager = D('ViewManager');
        $map['userId'] = $userId;
        $map['classId'] = $classId;
        $student = $manager->where($map)->find();
        //dump($student);
        session('student',null);
        session('student',$student);
        $mainPage = U('ManagerManage/save');
        //echo $mainPage;
        //return ;
        //dump($this->dormBuilds);
        $this->mainPage = $mainPage;
        $this->pageSize = 10;
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

    public function delete(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $userId = I('get.userId');
        $classId = I('get.classId');
        $manager = D('Manager');
        $map['userId'] = $userId;
        $map['classId']= $classId;
        $re = $manager->where($map)->delete();

        $this->redirect('lists');
    }

    public function student(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $this->currentUser=session('currentUser');
        $this->currentUserType = session('currentUserType');
        $this->managerMembers = session('managerMembers');
        $this->show = session('show');
        //dump($this->classMembers);
        $this->display();
    }

    public function save(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        if(IS_POST){
            $userId = I('post.userId');
            $classId = I('post.classId');
            $position = I('post.position');
            $power = I('post.power');
            $tel = I('post.tel');
            $description =I('post.description');

            $data['position'] = $position;
            $data['power'] = $power;
            $data['description'] = $description;
            $data['tel'] = $tel;

            $manager = D('Manager');
            $managerMap['userId'] = $userId;
            $managerMap['classId'] = $classId;

            $re = $manager->where($managerMap)->find();
            if($re){
                $re = $manager->where($managerMap)->save($data);
            }else{
                $data['userId'] = $userId;
                $data['classId'] = $classId;
                $re = $manager->add($data);
            }
            //echo $manager->getLastSql();

            $this->redirect('lists');

        }else{
            $this->student = session('student');
            $this->classMembers = session('classMembers');
            $this->display();
        }
        
    }

    public function getData(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $type=I('post.type');
        $userId = I('post.userId');
        $classId = I('post.classId');
        //echo 2;
        //echo "type=".$type;
        switch ($type) {
            case 'studentInfo':
                //echo 1;
                $user =  D('ViewStudent');
                $map['userId'] = $userId;
                $student = $user->where($map)->find();
                //dump($student);
                //echo $user->getLastSql();
                $this->ajaxReturn($student);
                //$this->ajaxReturn('44');
                break;
            
            default:
                # code...
                break;
        }
    }
}