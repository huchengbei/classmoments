<?php
namespace Home\Controller;
use Think\Controller;
class ActivityManageController extends Controller {
    public function index(){
    	$this->redirect('lists');
    	//$this->display();
        //$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover,{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }
    public function lists(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $activityD =  D('ViewActivity');
        $currentUser = session('currentUser');
        $activityMap['classId'] = $currentUser['classId'];

        $count = $activityD->where($activityMap)->count();
        $Page       = new \Think\Page($count,10);// 实例化分页类 
        $show       = $Page->show();// 分页显示输出// 进行分页数据查询 
        $limit = $Page->firstRow.','.$Page->listRows;
        //var_dump($Page);
        //return;
        //dump($map);
        $activitys = $activityD->where($activityMap)->order('createTime desc')->limit($limit)->select();
        //dump($classMembers);
        session('show',null);
        session('show',$show);
        //dump($map);
        //echo $vote->getLastSql();
        //dump($votes);

        $activityUser = D('ViewActivityUser');
        $map = array();
        foreach ($activitys as $key => $value) {
            # code...
            unset($map);
            $map['activityId'] = $value['activityId'];
            $map['userId'] = $currentUser['userId'];
            //print_r($map);
            $activitys[$key]['finish'] = $activityUser->where($map)->find()?1:0;
        }
        session('activitys',null);
        session('activitys',$activitys);

        $mainPage = U('ActivityManage/activitys');
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
        session('activity',null);
        $mainPage = U('ActivityManage/save');
        $qnum=1;
        session('qnum',null);
        session('qnum',$qnum);
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

    public function join(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $activityId = I('get.activityId');
        $activityD = D('Activity');
        $questionD = D('ActivityQuestion');
        $map['activityId'] = $activityId;
        //var_dump($map);
        $activity = $activityD->where($map)->find();
        $activity['questions'] = $questionD->where($map)->select();
        //dump($student);
        session('activity',null);
        session('activity',$activity);
        $mainPage = U('ActivityManage/joinPage');
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

    public function joinPage(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $this->activity = session('activity');
        $this->currentUser = session('currentUser');
        $this->currentUserType = session('currentUserType');
        //dump($this->classMembers);
        //dump($this->taskMembers);
        $this->display();
    }

    public function showResult(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $currentUser = session('currentUser');
        $userId = $currentUser['userId'];
        $activityId = I('get.activityId');

        $activityD = D('Activity');
        $activityUserD = D('ViewActivityUser');
        $questionD = D('ActivityQuestion');
        $questionContentD = D('ViewActivityQuestionContent');

        $map = array();
        $map['activityId'] = $activityId;
        $activity = $activityD->where($map)->find();
        $activity['questions'] = $questionD->where($map)->select();

        //$map['userId'] = $userId;
        $activityUser = $activityUserD->where($map)->select();

        $user = array();
        foreach ($activityUser as $key => $value) {
            # code...
            $map['userId'] = $value['userId'];
            $user[] = $questionContentD->where($map)->getField('content',true);
        }
        //print_r($vote);
        $activity['users'] = $user;
        session('activity',null);
        session('activity',$activity);
        $mainPage = U('ActivityManage/showResultPage');
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

    public function showResultPage(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $this->activity = session('activity');
        //print_r($this->activity);
        $this->display();
    }

    public function joining(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $post = I('post.');
        //print_r($post);
        //return;
        $questions = $post['questions'];
        //$activityId = $post['activityId'];
        $currentUser = session('currentUser');
        $userId = $currentUser['userId'];
        //$voteTime = date('Y-m-d H:i:s',NOW_TIME);

        $map = array();
        $record =array();
        $contentD = D('activityContent');
        foreach ($questions as $key => $value) {
            # code...
            unset($map);
            unset($record);
            $map['contentId'] = $value['contentId'];
            $record['questionId'] = $value['questionId'];
            $record['content'] = $value['content'];
            $record['userId'] = $userId;
            //$record['voteTime'] = $voteTime;
            //$record['ip'] = $ip;
            if($value['contentId'])
                $contentD->where($map)->save($record);
            else
                $contentD->add($record);
            //echo  $contentD->getLastSql();
        }

        $this->redirect('lists');
    }

    public function modify(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $activityId = I('get.activityId');
        //dump(I('get.userId'));
        $currentUser=session('currentUser');
        $activityD = D('Activity');
        $questionD = D('ViewActivityQuestionContent');
        $map['activityId'] = $activityId;
        //var_dump($map);
        $activity = $activityD->where($map)->find();
        $map['userId'] =$currentUser['userId'];
        $activity['questions'] = $questionD->where($map)->select();
        //dump($student);
        session('activity',null);
        session('activity',$activity);
        $mainPage = U('ActivityManage/joinPage');
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

    public function edit(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $activityId = I('get.activityId');
        //dump(I('get.userId'));
        $activityD = D('Activity');
        $questionD = D('ActivityQuestion');
        $map['activityId'] = $activityId;
        //var_dump($map);
        $activity = $activityD->where($map)->find();
        $activity['questions'] = $questionD->where($map)->select();
        //dump($student);
        $qnum = count($activity['questions']);

        session('qnum',null);
        session('qnum',$qnum);
        session('activity',null);
        session('activity',$activity);
        $mainPage = U('ActivityManage/save');
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
        $activityId = I('get.activityId');
        //print_r(I('get.'));
        $activityD = D('Activity');
        $map['activityId'] = $activityId;
        $re = $activityD->where($map)->delete();
        //echo $activityD->getLastSql();

        $this->redirect('lists');
    }

    public function activitys(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $this->activitys = session('activitys');
        $this->currentUser = session('currentUser');
        $this->currentUserType = session('currentUserType');
        $this->show = session('show');
        //var_dump($this->votes);
        //dump($this->classMembers);
        $this->display();
    }

    public function save(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        if(IS_POST){
            $post = I('post.');
            $currentUser = session('currentUser');
            //print_r($post);
            $activityId = $post['activityId'];

            $activityD = D('Activity');
            $questionD = D('ActivityQuestion');

            $map['activityId'] = $activityId;

            $pram['name'] = $post['name'];
            $pram['description'] = $post['description'];
            $pram['startTime']= $post['startTime'];
            $pram['endTime'] = $post['endTime'];

            if($activityId){
                $activityD->where($map)->save($pram);
            }else{
                $pram['classId'] = $currentUser['classId'];
                $pram['authorId'] = $currentUser['userId'];
                $pram['createTime'] = date('Y-m-d H:i:s',NOW_TIME);
                $activityId = $activityD->add($pram);//这里返回主键值
            }

            foreach ($post['questions'] as $key => $question) {
                # code...
                unset($map);
                unset($pram);
                $questionId = $question['questionId'];

                $pram['activityId'] = $activityId;
                $pram['question'] = $question['question'];
                
                $map['questionId'] =$questionId;
                //print_r($map);
                //return;

                if($questionId){
                    $questionD->where($map)->save($pram);
                }else{
                    $questionId = $questionD->add($pram);
                }
            }
            //echo $manager->getLastSql();

            $this->redirect('lists');

        }else{
            $this->qnum = session('qnum');
            $this->activity = session('activity');
            //print_r($this->activity);
            $this->display();
        }
        
    }
}