<?php
namespace Home\Controller;
use Think\Controller;
class ChatRoomController extends Controller {
    public function index(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $mainPage = U('ChatRoom/room');
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

    public function sendMsg(){
        $msg = I('post.content');
        $currentUser = session('currentUser');
        $data['classId'] = $currentUser['classId'];
        $data['userId'] = $currentUser['userId'];
        $data['content'] = $msg;
        $data['createTime'] = date('Y-m-d H:i:s',NOW_TIME);
        $re=D('Chatroom')->add($data);
        $response['data'] = $re;
        if($re)
            $response['status']=1;
        else
            $response['status'] = 0;
        $this->ajaxReturn($response);
    }

    public function getMsg(){
        $classId = I('post.classId');
        $map['classId'] = $classId;
        $chatroomD = D('ViewChatroom');
        $msgs = $chatroomD->where($map)->select();
        $this->ajaxReturn($msgs);
        //$this->ajaxReturn('12');
    }

    public function room(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $this->currentUser =session('currentUser');
        $this->currentUserType=session('currentUserType');
        //dump($this->classMembers);
        $this->display();
    }
}