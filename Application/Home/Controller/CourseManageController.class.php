<?php
namespace Home\Controller;
use Think\Controller;
class CourseManageController extends Controller {
    public function index(){
    	$this->redirect('User/index');
    	//$this->display();
        //$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover,{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }
    public function lists(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        //由视图中得出数据
        $courseM =  M('ViewSubject');
        $currentUser = session('currentUser');
        $map['classId'] = $currentUser['classId'];
        //dump($classMembers)

        $count = $courseM->where($map)->count();
        $Page       = new \Think\Page($count,10);// 实例化分页类 
        $show       = $Page->show();// 分页显示输出// 进行分页数据查询 
        $limit = $Page->firstRow.','.$Page->listRows;
        //dump($map);
        $courses = $courseM->where($map)->order('term,subjectCode')->limit($limit)->select();
        //return;
        session('show',null);
        session('show',$show);
        session('courses',null);
        session('courses',$courses);
        $mainPage = U('CourseManage/course');
        //echo $mainPage;
        //return ;
        
        $this->mainPage = $mainPage;
        $this->pageSize = 10;
        $this->currentUser = session('currentUser');
        $this->currentUserType = session('currentUserType');
        
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
/*
    public function edit(){
        $noticeId = I('get.noticeId');
        $noticeD = D('Notice');
        $map['noticeId'] = $noticeId;
        $notice = $noticeD->where($map)->find();
        //print_r($notice);
        //return;
        session('notice',null);
        session('notice',$notice);
        $mainPage = U('Notice/save');
        //echo $mainPage;
        //return ;
        $currentUser = session('currentUser');
        //dump($this->dormBuilds);
        $this->mainPage = $mainPage;
        $this->pageSize = 10;
        $this->currentUser = session('currentUser');
        $this->currentUserType = session('currentUserType');
        
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
*/
    public function add(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $currentUser = session('currentUser');
        session('course',null);
        $subjects = M('Subject')->select();
        //print_r($subjects);
        session('subjects',null);
        session('subjects',$subjects);
        $map['universityId'] = $currentUser['universityId'];
        $colleges = M('College')->where($map)->select();
        //print_r($subjects);
        session('colleges',null);
        session('colleges',$colleges);
        $mainPage = U('CourseManage/save');
        //echo $mainPage;
        //return ;
        $currentUser = session('currentUser');

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
        $courseId = I('get.courseId');
        $courseM = M('ClassSubject');
        $map['courseId'] = $courseId;
        $re = $courseM->where($map)->delete();
        //echo $courseM->getLastSql();
        //return;
        $currentUser = session('currentUser');
        
        $this->redirect('lists');
    }

    public function course(){
        if(!session('currentUser'))
            $this->redirect('User/index');

        $this->courses = session('courses');
        $this->currentUser = session('currentUser');
        $this->currentUserType = session('currentUserType');
        $this->show = session('show');
        //dump($this->classMembers);
        //dump($this->taskMembers);
        $this->display();
    }


    public function save(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        if(IS_POST){
            $currentUser = session('currentUser');

            $post = I('post.');
            $term = $post['term'];
            $subjectId = $post['subjectId'];
            $subjectCode = $post['subjectCode'];
            $subjectname = $post['subjectname'];
            $collegeId = $post['collegeId'];
            $classId = $currentUser['classId'];

            $data = array();
            if($subjectId==0){
                $data['subjectname'] = $subjectname;
                $data['subjectCode'] = $subjectCode;
                $data['collegeId'] = $collegeId;
                $subjectId = M('Subject')->add($data);
            }

            unset($data);
            $data['term'] = $term;
            $data['subjectId'] = $subjectId;
            $data['classId'] = $classId;
            if(M('ClassSubject')->where($data)->find()){
                session('error',null);
                session('error',"本学期 ".$subjectname." 课程已存在!");
                $mainPage = U('CourseManage/save');
                $this->mainPage = $mainPage;
                
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
                return;
            }else{
                $re = M('ClassSubject')->add($data);
            }
            
            //echo $manager->getLastSql();
            $this->redirect('lists');
            //$this->redirect('lists');
        }else{
            $this->subjects = session('subjects');
            $this->error = session('error');
            $this->colleges = session('colleges');
            $this->display();
            session('error',null);
        }
        
    }

    public function getData(){
       // if(!session('currentUser'))
         //   $this->redirect('User/index');
        $type=I('post.type');
        $subjectId = I('post.subjectId');
        //echo 2;
        //echo "type=".$type;
        switch ($type) {
            case 'subjectInfo':
                //echo 1;
                $map['subjectId'] = $subjectId;
                $subjectM =  M('ViewSubjectInfo');
                $subjects = $subjectM->where($map)->find();
                //dump($student);
                //echo $user->getLastSql();
                $this->ajaxReturn($subjects);
                //$this->ajaxReturn('44');
                break;
            
            default:
                # code...
                break;
        }
    }
}