<?php
namespace Home\Controller;
use Think\Controller;
class ScoreManageController extends Controller {
    public function index(){
    	$this->redirect('User/index');
    }
    public function lists(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        //由视图中得出数据
        $scoreM =  M('ViewScoreAvgRank');
        $currentUser = session('currentUser');
        $map['classId'] = $currentUser['classId'];
        
        $term = I('post.term');
        //print_r($term);
        session('term',I('post.term'));

        if(session('term')!=0)
            $map['term'] = session('term');
        $count = $scoreM->where($map)->count();
        $Page       = new \Think\Page($count,10);// 实例化分页类
        $show       = $Page->show();// 分页显示输出// 进行分页数据查询 
        $limit = $Page->firstRow.','.$Page->listRows;
        //dump($map);
        $students = $scoreM->where($map)->order('term,rank')->limit($limit)->select();
        //dump($classMembers);
        session('show',null);
        session('show',$show);
        session('students',null);
        session('students',$students);
        //print_r($students);
        $mainPage = U('ScoreManage/student');
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

    public function analyseClass(){
        $classId = I('get.classId');
        $map['classId'] = $classId;
        $scoreM =  M('ViewScoreAvgRank');
        $terms = $scoreM->distinct(true)->Field('term')->order('term')->where($map)->select();
        //echo $scoreM->getLastSql();;
        foreach ($terms as $key => $value) {
            # code...
            $map['term'] = $value['term'];
            $max=0;
            for ($i=0; $i < 10; $i++) { 
                # code...
                $map1['avg'] = array(array('egt',$i*10),array('lt',10+$i*10));
                $terms[$key]['data'][$i] = $scoreM->where($map)->where($map1)->count();
            }
            $terms[$key]['data'][9] += $scoreM->where($map)->where('avg=100')->count();
            for ($i=0; $i < 10; $i++) { 
                # code...
                $max = ($max>$terms[$key]['data'][$i])?$max:$terms[$key]['data'][$i];
            }
            $terms[$key]['max'] = $max;
        }
        //print_r($terms);
        session('classScoreAnalyse',null);
        session('classScoreAnalyse',$terms);

        $mainPage = U('ScoreManage/analyseClassPage');
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

    public function analyseClassPage(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        //print_r(session('term'));
        $this->classScoreAnalyse = session('classScoreAnalyse');
        $this->currentUser =session('currentUser');
        $this->currentUserType=session('currentUserType');
        $this->show = session('show');
        //dump($this->classMembers);
        $this->display();
    }

    public function analyse(){
        $currentUser= session('currentUser');
        $scoreM =  M('ViewScoreAvgRank');

        $userId = I('get.userId');
        $map['classId'] = $currentUser['classId'];
        $map['userId'] = $userId;
        //print_r(session());
        //dump($map);
        $scoreAnalyse = $scoreM->order('term')->where($map)->select();
        //dump($classMembers);
        session('scoreAnalyse',null);
        session('scoreAnalyse',$scoreAnalyse);

        $map1['classId'] = $map['classId'];
        $classMembers = M('User')->where($map1)->select();
        session('classMembers',null);
        session('classMembers',$classMembers);
        $mainPage = U('ScoreManage/analysePage');
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

    public function analysePage(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        //print_r(session('term'));
        $this->classMembers = session('classMembers');
        $this->scoreAnalyse = session('scoreAnalyse');
        $this->currentUser =session('currentUser');
        $this->currentUserType=session('currentUserType');
        $this->show = session('show');
        //dump($this->classMembers);
        $this->display();
    }

    public function getData(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $currentUser = session('currentUser');
        $type=I('post.type');
        $userId = I('post.userId');
        $classId =  $currentUser['classId'];
        //echo 2;
        //echo "type=".$type;
        switch ($type) {
            case 'scoreInfo':
                //echo 1;classId
                $scoreM =  M('ViewScoreAvgRank');
                $map['userId'] = $userId;
                $map['classId'] = $classId;
                $scoreAnalyse = $scoreM->where($map)->order('term')->select();
                //dump($student);
                //echo $user->getLastSql();
                $this->ajaxReturn($scoreAnalyse);
                //$this->ajaxReturn('44');
                break;
            
            default:
                # code...
                break;
        }
    }

    public function student(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        //print_r(session('term'));
        $this->students = session('students');
        $this->currentUser =session('currentUser');
        $this->currentUserType=session('currentUserType');
        $this->term = session('term');
        $this->show = session('show');
        //dump($this->classMembers);
        $this->display();
    }

    public function import(){
        $currentUser = session('currentUser');
        if (!empty($_FILES)) {
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     8388608 ;// 设置附件上传大小
            //$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  =      './Uploads/'; // 设置附件上传根目录
            $upload->savePath  =      '/temp/'; // 设置附件上传（子）目录
            $upload->replace = true;    //存在同名文件是否是覆盖,此处为覆盖
            $upload->saveName = md5(microtime()); //上传文件的保存规则，支持数组和字符串方式定义,此处为不改变名称
            $upload->exts     =    array('xls','xlsx');
            $upload->autoSub = true;   //是否自动使用子目录保存上传文件 此处为是
            $upload->subName = array('date','Ymd');

            $info   =   $upload->upload();
            if (!$info) {
                $info['status'] = 0;
                $info['message'] = $upload->getError();
                $this->ajaxReturn($info);
                return;
            } else {
                 foreach($info as $file)
                 {
                        $file_name="./Uploads".$file['savepath'].$file['savename'];
                 }   
            }
            vendor('PHPExcel.PHPExcel.IOFactory','','.php');      
            $objReader = \PHPExcel_IOFactory::createReader('Excel5');
            $objPHPExcel = $objReader->load($file_name,$encode='utf-8');
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow(); // 取得总行数
            $highestColumn = $sheet->getHighestColumn(); // 取得总列数
            $data = array();
            $record =array();
            $map['classId'] = $currentUser['classId'];
            $map['term'] = I('post.term');
            $subjects = M('ViewSubject')->where($map)->order('subjectCode')->select();
            $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
            for($i=1;$i<=$highestRow;$i++){//$i 为真实的行数，以1开头
                $j=0;
                $record[$j++] = $objPHPExcel->getActiveSheet()->getCell($cellName[$j-1].$i)->getValue();
                $record[$j++] = $objPHPExcel->getActiveSheet()->getCell($cellName[$j-1].$i)->getValue();
                foreach ($subjects as $key => $value) {
                    # code...
                    $record[$j] = $objPHPExcel->getActiveSheet()->getCell($cellName[$j].$i)->getValue();
                    $j++; 
                }
                $data[] = $record;
                }
            $response['status'] = 1;
            $response['data'] = $data;
            $response['subjects'] = $subjects;
            session('importScores',null);
            session('importScores',$data);
            session('importScoresInfo',$response);
            $this->ajaxReturn($response);
            return;
            
        }
    }

    public function importing(){
        $currentUser = session('currentUser');
        $response = session('importScoresInfo');

        $subjects = $response['subjects'];
        $user= $response['data'];
        $scoreM = M('Score');
        $userM = M('User');
        $record = array();
        $da = array();
        $map=array();
        foreach ($user as $key => $value) {
            # code...
            if($key==0){

            }else{
                $map['usernumber'] = $value[0];
                $map['classId'] = $currentUser['classId'];
                $userId = $userM->where($map)->getField('userId');
                foreach ($subjects as $ks => $vs) {
                    # code...
                    $record['userId'] = $userId;
                    $record['courseId'] = $vs['courseId'];
                    $record['score'] = $value[$ks+2];
                    $da[]= $record;
                }
            }
        }
        foreach ($da as $key => $value) {
            # code...
            unset($map);
            $map['userId'] = $value['userId'];
            $map['courseId'] = $value['courseId'];
            if($scoreM->where($map)->find()){
                $scoreM->save($value);
            }else{
                $scoreM->add($value);
            }
        }

        //print_r($da);
        
        $response['status'] = 1;

        $this->ajaxReturn($response);
        return;
    }

    public function export(){
        $currentUser = session('currentUser');
        $map['classId'] = $currentUser['classId'];
        $className = M('Class')->where($map)->getField('className');
        $xlsName  = $className."成员信息";
        $xlsCell  = array(
            array('username','用户名'),
            array('usernumber','学号'),
            array('nikename','姓名'),
            array('password','密码'),
            array('sex','性别'),
            array('dormBuildName','宿舍楼'),
            array('dormName','宿舍号'),
            array('tel','联系方式'),
            array('zzmm','政治面貌')  
        );
        $xlsModel = M('ViewStudentInfo');
    
        $xlsData  = $xlsModel->Field('username,usernumber,nikename,password,sex,dormBuildName,dormName,tel,zzmm')->select();
        exportExcel($xlsName,$xlsCell,$xlsData);
    }
}