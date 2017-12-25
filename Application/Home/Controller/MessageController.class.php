<?php
namespace Home\Controller;
use Think\Controller;
class MessageController extends Controller {
    public function index(){
    	$this->redirect('User/index');
    	//$this->display();
        //$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover,{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }
    public function lists(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        //由视图中得出数据
        $messageD =  D('ViewMessage');
        $currentUser = session('currentUser');
        $map['classId'] = $currentUser['classId'];
        //dump($map);
        $messages = $messageD->where($map)->order('createTime desc')->select();
        //dump($classMembers);
        
        //return;
        session('messages',null);
        session('messages',$messages);
        $mainPage = U('Message/message');
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
        $messageId = I('get.messageId');
        $messageD = D('Message');
        $map['messageId'] = $messageId;
        $message = $messageD->where($map)->find();
        //print_r($message);
        //return;
        session('message',null);
        session('message',$message);
        $mainPage = U('Message/save');
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
        session('message',null);
        $mainPage = U('Message/save');
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
        $messageId = I('get.messageId');
        $messageD = D('Message');
        $map['messageId'] = $messageId;
        $re = $messageD->where($map)->delete();

        $currentUser = session('currentUser');
        
        $this->redirect('lists');
    }

    public function message(){
        if(!session('currentUser'))
            $this->redirect('User/index');

        $this->messages = session('messages');
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
            $messageId = I('post.messageId');
            $title = I('post.title');
            $content =I('post.content');

            $data['title'] = $title;
            $data['content'] = $content;
            //echo $endTime;
            //dump($data);
            //return;
            $map['messageId'] = $messageId;
            $messageD  = D('Message');
            
            if($messageId){
                $re = $messageD->where($map)->save($data);
            }else{
                $data['createTime'] = date('Y-m-d H:i:s',NOW_TIME);
            	$currentUser = session('currentUser');
                $data['authorId'] = $currentUser['userId'];
                $data['classId'] = $currentUser['classId'];
                $re = $messageD->add($data);
            }
            //echo $manager->getLastSql();

            $this->redirect('lists');
        }else{
            $this->error = session('error');
            $this->message = session('message');
            $this->display();
            session('error',null);
        }
        
    }
}