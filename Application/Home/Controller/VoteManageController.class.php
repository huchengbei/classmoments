<?php


namespace Home\Controller;
use Think\Controller;

class VoteManageController extends Controller {
    public function index(){
    	$this->redirect('User/index');
    	//$this->display();
        //$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover,{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }
    public function lists(){
        if(!session('currentUser'))
            $this->redirect('User/index');

        $vote =  D('ViewVote');
        $currentUser = session('currentUser');
        $voteMap['classId'] = $currentUser['classId'];
        //dump($map);

        $count = $vote->where($voteMap)->count();
        $Page       = new \Think\Page($count,10);// 实例化分页类 
        $show       = $Page->show();// 分页显示输出// 进行分页数据查询 
        $limit = $Page->firstRow.','.$Page->listRows;
        //var_dump($Page);
        session('show',null);
        session('show',$show);

        $votes = $vote->where($voteMap)->order('voteId desc')->limit($limit)->select();
        //echo $vote->getLastSql();
        //dump($votes);

        $voteUser = D('ViewVoteUser');
        $map = array();
        foreach ($votes as $key => $value) {
            # code...
            unset($map);
            $map['voteId'] = $value['voteId'];
            $map['userId'] = $currentUser['userId'];
            $votes[$key]['finish'] = $voteUser->where($map)->find()?1:0;
        }
        session('votes',null);
        session('votes',$votes);

        $mainPage = U('VoteManage/votes');
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
        session('vote',null);
        $mainPage = U('VoteManage/save');
        $questionData = array();
        $questionData[]=2;
        session('questionData',null);
        session('questionData',json_encode($questionData));
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

    public function dovote(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $voteId = I('get.voteId');
        $voteD = D('VoteTitle');
        $question = D('VoteQuestion');
        $map['voteId'] = $voteId;
        //var_dump($map);
        $vote = $voteD->where($map)->find();
        $vote['questions'] = $question->where($map)->select();
        //dump($student);
        $option = D('VoteOption');
        foreach ($vote['questions'] as $key => $value) {
            # code...
            $vote['questions'][$key]['options'] = $option->where("questionId=%d",array($value['questionId']))->select();
        }
        session('vote',null);
        session('vote',$vote);
        $mainPage = U('VoteManage/dovotePage');
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

    public function dovotePage(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $this->vote = session('vote');
        $this->currentUser = session('currentUser');
        $this->currentUserType = session('currentUserType');
        //dump($this->classMembers);
        //dump($this->taskMembers);
        $this->display();
    }

    public function showResult(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $voteId = I('get.voteId');
        $voteD = D('ViewVote');
        $questionD = D('VoteQuestion');
        $optionD =D('ViewVoteOptionRecord');

        $map = array();
        $map['voteId'] = $voteId;
        $vote = $voteD->where($map)->find();
        $vote['questions'] = $questionD->where($map)->order('questionId')->select();
        foreach ($vote['questions']  as $key => $question) {
            # code...
            unset($map);
            $map['questionId'] =$question['questionId'];
            //print_r($map);
            //return;
            $vote['questions'][$key]['options']=$optionD->where($map)->order('optionId')->select(); 
        }
        //print_r($vote);
        
        session('vote',null);
        session('vote',$vote);
        $mainPage = U('VoteManage/showResultPage');
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
        $this->vote = session('vote');
        //print_r($this->vote);
        $this->display();
    }

    public function voting(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $post = I('post.');
        $questions = $post['questions'];
        $options = $post['options'];
        $voteId = $post['voteId'];
        $ip =  get_client_ip();
        $currentUser = session('currentUser');
        $userId = $currentUser['userId'];
        $voteTime = date('Y-m-d H:i:s',NOW_TIME);

        $data = array();
        $record =array();
        foreach ($questions as $key => $value) {
            # code...
            unset($record);
            $record['optionId'] = $value;
            $record['userId'] = $userId;
            $record['voteTime'] = $voteTime;
            $record['ip'] = $ip;
            $data[] = $record;
        }
        foreach ($options as $key => $value) {
            # code...
            unset($record);
            $record['optionId'] = $value;
            $record['userId'] = $userId;
            $record['voteTime'] = $voteTime;
            $record['ip'] = $ip;
            $data[] = $record;
        }

        $recordD = D('VoteRecord');
        $re =$recordD->addAll($data);
        $this->redirect('lists');
    }

    public function edit(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $voteId = I('get.voteId');
        //dump(I('get.userId'));
        $voteD = D('VoteTitle');
        $question = D('VoteQuestion');
        $map['voteId'] = $voteId;
        //var_dump($map);
        $vote = $voteD->where($map)->find();
        $vote['questions'] = $question->where($map)->select();
        //dump($student);
        $option = D('VoteOption');
        $questionData = array();
        foreach ($vote['questions'] as $key => $value) {
            # code...
            $vote['questions'][$key]['options'] = $option->where("questionId=%d",array($value['questionId']))->select();
            $questionData[] = count($vote['questions'][$key]['options']);
        }
        //var_dump($vote);
        if(!$questionData){
            $questionData[]=2;
        }

        session('questionData',null);
        session('questionData',json_encode($questionData));
        session('vote',null);
        session('vote',$vote);
        $mainPage = U('VoteManage/save');
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
        $voteId = I('get.voteId');
        //print_r(I('get.'));
        $voteD = D('VoteTitle');
        $map['voteId'] = $voteId;
        $re = $voteD->where($map)->delete();
        //echo $voteD->getLastSql();

        $this->redirect('lists');
    }

    public function votes(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $this->votes = session('votes');
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
            $voteId = $post['voteId'];

            $voteD = D('VoteTitle');
            $questionD = D('VoteQuestion');
            $optionD = D('VoteOption');

            $map['voteId'] = $voteId;

            $pram['title'] = $post['title'];
            $pram['startTime']= $post['startTime'];
            $pram['endTime'] = $post['endTime'];

            if($voteId){
                $voteD->where($map)->save($pram);
            }else{
                $pram['classId'] = $currentUser['classId'];
                $pram['authorId'] = $currentUser['userId'];
                $pram['createTime'] = date('Y-m-d H:i:s',NOW_TIME);
                $voteId = $voteD->add($pram);//这里返回主键值
            }

            foreach ($post['questions'] as $key => $question) {
                # code...
                unset($map);
                unset($pram);
                $questionId = $question['questionId'];

                $pram['voteId'] = $voteId;
                $pram['title'] = $question['title'];
                $pram['mode'] = $post['mode'][$key];
                
                $map['questionId'] =$questionId;

                if($questionId){
                    $questionD->where($map)->save($pram);
                }else{
                    $questionId = $questionD->add($pram);
                }

                foreach ($question['options'] as $ko => $option) {
                    # code...
                    unset($map);
                    unset($pram);
                    $optionId = $option['optionId'];

                    $pram['questionId'] = $questionId;
                    $pram['content'] = $option['content'];

                    $map['optionId'] = $option['optionId'];

                    if($optionId){
                        $optionD->where($map)->save($pram);
                    }else{
                        $optionD->add($pram);
                    }
                }

            }
            //echo $manager->getLastSql();

            $this->redirect('lists');

        }else{
            $this->questionData = session('questionData');
            $this->vote = session('vote');
            $this->classMembers = session('classMembers');
            $this->display();
        }
        
    }
}