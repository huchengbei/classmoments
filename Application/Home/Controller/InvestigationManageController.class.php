<?php


namespace Home\Controller;
use Think\Controller;

class InvestigationManageController extends Controller {
    public function index(){
    	$this->redirect('User/index');
    	//$this->display();
        //$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover,{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }
    public function lists(){
        if(!session('currentUser'))
            $this->redirect('User/index');

        $investigation =  D('ViewInvestigation');
        $currentUser = session('currentUser');
        $investigationMap['classId'] = $currentUser['classId'];
        //dump($map);

        $count = $investigation->where($investigationMap)->count();
        $Page       = new \Think\Page($count,10);// 实例化分页类 
        $show       = $Page->show();// 分页显示输出// 进行分页数据查询 
        $limit = $Page->firstRow.','.$Page->listRows;
        //var_dump($Page);
        session('show',null);
        session('show',$show);

        $investigations = $investigation->where($investigationMap)->order('investigationId desc')->limit($limit)->select();
        //echo $investigation->getLastSql();
        //dump($investigations);

        $investigationUser = D('ViewInvestigationUser');
        $map = array();
        foreach ($investigations as $key => $value) {
            # code...
            unset($map);
            $map['investigationId'] = $value['investigationId'];
            $map['userId'] = $currentUser['userId'];
            $investigations[$key]['finish'] = $investigationUser->where($map)->find()?1:0;
        }
        session('investigations',null);
        session('investigations',$investigations);

        $mainPage = U('InvestigationManage/investigations');
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
        session('investigation',null);
        $mainPage = U('InvestigationManage/save');
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

    public function doinvestigation(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $investigationId = I('get.investigationId');
        $investigationD = D('InvestigationTitle');
        $question = D('InvestigationQuestion');
        $map['investigationId'] = $investigationId;
        //var_dump($map);
        $investigation = $investigationD->where($map)->find();
        $investigation['questions'] = $question->where($map)->select();
        //dump($student);
        $option = D('InvestigationOption');
        foreach ($investigation['questions'] as $key => $value) {
            # code...
            $investigation['questions'][$key]['options'] = $option->where("questionId=%d",array($value['questionId']))->select();
        }
        session('investigation',null);
        session('investigation',$investigation);
        $mainPage = U('InvestigationManage/doinvestigationPage');
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

    public function doinvestigationPage(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $this->investigation = session('investigation');
        $this->currentUser = session('currentUser');
        $this->currentUserType = session('currentUserType');
        //dump($this->classMembers);
        //dump($this->taskMembers);
        $this->display();
    }

    public function showResult(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $investigationId = I('get.investigationId');
        $investigationD = D('ViewInvestigation');
        $questionD = D('InvestigationQuestion');
        $optionD =D('ViewInvestigationOptionRecord');

        $map = array();
        $map['investigationId'] = $investigationId;
        $investigation = $investigationD->where($map)->find();
        $investigation['questions'] = $questionD->where($map)->order('questionId')->select();
        foreach ($investigation['questions']  as $key => $question) {
            # code...
            unset($map);
            $map['questionId'] =$question['questionId'];
            //print_r($map);
            //return;
            $investigation['questions'][$key]['options']=$optionD->where($map)->order('optionId')->select(); 
        }
        //print_r($investigation);
        
        session('investigation',null);
        session('investigation',$investigation);
        $mainPage = U('InvestigationManage/showResultPage');
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
        $this->investigation = session('investigation');
        //print_r($this->investigation);
        $this->display();
    }

    public function voting(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $post = I('post.');
        $questions = $post['questions'];
        $options = $post['options'];
        $investigationId = $post['investigationId'];
        $ip =  get_client_ip();
        $currentUser = session('currentUser');
        $userId = $currentUser['userId'];
        $investigationTime = date('Y-m-d H:i:s',NOW_TIME);

        $data = array();
        $record =array();
        foreach ($questions as $key => $value) {
            # code...
            unset($record);
            $record['optionId'] = $value;
            $record['userId'] = $userId;
            $record['investigationTime'] = $investigationTime;
            $record['ip'] = $ip;
            $data[] = $record;
        }
        foreach ($options as $key => $value) {
            # code...
            unset($record);
            $record['optionId'] = $value;
            $record['userId'] = $userId;
            $record['investigationTime'] = $investigationTime;
            $record['ip'] = $ip;
            $data[] = $record;
        }

        $recordD = D('InvestigationRecord');
        $re =$recordD->addAll($data);
        $this->redirect('lists');
    }

    public function edit(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $investigationId = I('get.investigationId');
        //dump(I('get.userId'));
        $investigationD = D('InvestigationTitle');
        $question = D('InvestigationQuestion');
        $map['investigationId'] = $investigationId;
        //var_dump($map);
        $investigation = $investigationD->where($map)->find();
        $investigation['questions'] = $question->where($map)->select();
        //dump($student);
        $option = D('InvestigationOption');
        $questionData = array();
        foreach ($investigation['questions'] as $key => $value) {
            # code...
            $investigation['questions'][$key]['options'] = $option->where("questionId=%d",array($value['questionId']))->select();
            $questionData[] = count($investigation['questions'][$key]['options']);
        }
        //var_dump($investigation);
        if(!$questionData){
            $questionData[]=2;
        }

        session('questionData',null);
        session('questionData',json_encode($questionData));
        session('investigation',null);
        session('investigation',$investigation);
        $mainPage = U('InvestigationManage/save');
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
        $investigationId = I('get.investigationId');
        //print_r(I('get.'));
        $investigationD = D('InvestigationTitle');
        $map['investigationId'] = $investigationId;
        $re = $investigationD->where($map)->delete();
        //echo $investigationD->getLastSql();

        $this->redirect('lists');
    }

    public function investigations(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $this->investigations = session('investigations');
        $this->currentUser = session('currentUser');
        $this->currentUserType = session('currentUserType');
        $this->show = session('show');
        //var_dump($this->investigations);
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
            $investigationId = $post['investigationId'];

            $investigationD = D('InvestigationTitle');
            $questionD = D('InvestigationQuestion');
            $optionD = D('InvestigationOption');

            $map['investigationId'] = $investigationId;

            $pram['title'] = $post['title'];
            $pram['startTime']= $post['startTime'];
            $pram['endTime'] = $post['endTime'];

            if($investigationId){
                $investigationD->where($map)->save($pram);
            }else{
                $pram['classId'] = $currentUser['classId'];
                $pram['authorId'] = $currentUser['userId'];
                $pram['createTime'] = date('Y-m-d H:i:s',NOW_TIME);
                $investigationId = $investigationD->add($pram);//这里返回主键值
            }

            foreach ($post['questions'] as $key => $question) {
                # code...
                unset($map);
                unset($pram);
                $questionId = $question['questionId'];

                $pram['investigationId'] = $investigationId;
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
            $this->investigation = session('investigation');
            $this->classMembers = session('classMembers');
            $this->display();
        }
        
    }
}