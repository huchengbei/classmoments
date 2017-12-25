<?php
namespace Home\Controller;
use Think\Controller;
class NoticeController extends Controller {
    public function index(){
    	$this->redirect('User/index');
    	//$this->display();
        //$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover,{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }
    public function lists(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        //由视图中得出数据
        $noticeD =  D('ViewNotice');
        $currentUser = session('currentUser');
        $map['classId'] = $currentUser['classId'];
        //dump($map);
        $notices = $noticeD->where($map)->order('createTime desc')->select();
        //dump($classMembers);
        
        //return;
        session('notices',null);
        session('notices',$notices);
        $mainPage = U('Notice/notice');
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

    public function edit(){
        if(!session('currentUser'))
            $this->redirect('User/index');
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

    public function add(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        session('notice',null);
        $mainPage = U('Notice/save');
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
        $noticeId = I('get.noticeId');
        $noticeD = D('Notice');
        $map['noticeId'] = $noticeId;
        $re = $noticeD->where($map)->delete();

        $currentUser = session('currentUser');
        
        $this->redirect('lists');
    }

    public function notice(){
        if(!session('currentUser'))
            $this->redirect('User/index');

        $this->notices = session('notices');
        $this->currentUser = session('currentUser');
        $this->currentUserType = session('currentUserType');
        //dump($this->classMembers);
        //dump($this->taskMembers);
        $this->display();
    }


    public function save(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        if(IS_POST){
            $noticeId = I('post.noticeId');
            $title = I('post.title');
            $content =I('post.content');

            $data['title'] = $title;
            $data['content'] = $content;
            //echo $endTime;
            //dump($data);
            //return;
            $map['noticeId'] = $noticeId;
            $noticeD  = D('Notice');
            
            if($noticeId){
                $re = $noticeD->where($map)->save($data);
            }else{
                $data['createTime'] = date('Y-m-d H:i:s',NOW_TIME);
            	$currentUser = session('currentUser');
                $data['authorId'] = $currentUser['userId'];
                $data['classId'] = $currentUser['classId'];
                $re = $noticeD->add($data);
            }
            //echo $manager->getLastSql();

            $this->redirect('lists');
        }else{
            $this->error = session('error');
            $this->notice = session('notice');
            $this->display();
            session('error',null);
        }
        
    }
}