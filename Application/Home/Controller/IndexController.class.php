<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	$this->redirect('User/index');
    	//$this->display();
        //$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover,{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }
    public function mainMonitor(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        //$this->mainPage=$this->mainPage?$this->mainPage:U('blank');
        $this->mainPage=U('blank');
        //dump($this->mainPage);
        $this->currentUser=session('currentUser');
        $this->currentUserType = session('currentUserType');
        $this->display('Index:mainMonitor');
    }
    public function mainManager(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        //$this->mainPage=$this->mainPage?$this->mainPage:U('blank');
        $this->mainPage=U('blank');
        //dump($this->mainPage);
        $this->currentUser=session('currentUser');
        $this->currentUserType = session('currentUserType');
        $this->display('Index:mainManager');
    }
    public function mainStudent(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        //$this->mainPage=$this->mainPage?$this->mainPage:U('blank');
        $this->mainPage=U('blank');
        //dump($this->mainPage);
        $this->currentUser=session('currentUser');
        $this->currentUserType = session('currentUserType');
        $this->display('Index:mainStudent');
    }
    public function blank(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $currentUser= session('currentUser');
        $scoreM =  M('ViewScoreAvgRank');

        $map['classId'] = $currentUser['classId'];
        $map['userId'] = $currentUser['userId'];
        //print_r(session());
        //dump($map);
        $scoreAnalyse = $scoreM->where($map)->select();
        //dump($classMembers);
        $this->scoreAnalyse = $scoreAnalyse;
    	$noticeD =  D('ViewNotice');
        $currentUser = session('currentUser');
        $map['classId'] = $currentUser['classId'];
        $uniqueCode = D('Class')->where($map)->getField('uniqueCode');
        $this->uniqueCode = $uniqueCode;
        $map1['classId'] = $currentUser['classId'];
        $map2['classId'] = $currentUser['classId'];
        $map2['userId'] = $currentUser['userId'];
        $tasknum = M('ViewTask')->where($map1)->count() - M('ViewTaskfiles')->where($map2)->count();
        $classnum = M('User')->where($map1)->count();
        //dump($map);
        $notice = $noticeD->where($map)->order('createTime desc')->find();
        $this->classnum=$classnum;
        $this->tasknum = $tasknum;
    	$this->data = $notice;
    	$this->currentUser = session('currentUser');
    	$this->display();
    	//dump($ttest);
    }
}