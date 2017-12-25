<?php
namespace Home\Controller;
use Think\Controller;
class StudentManageController extends Controller {
    public function index(){
    	$this->redirect('User/index');
    }
    public function lists(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        //由视图中得出数据
        $user =  D('ViewStudent');
        $currentUser = session('currentUser');
        $map['classId'] = $currentUser['classId'];

        $count = $user->where($map)->count();
        $Page       = new \Think\Page($count,10);// 实例化分页类 
        $show       = $Page->show();// 分页显示输出// 进行分页数据查询 
        $limit = $Page->firstRow.','.$Page->listRows;
        //var_dump($Page);
        $classMembers = $user->where($map)->order('usernumber')->limit($limit)->select();
        //dump($classMembers);
        session('show',null);
        session('show',$show);
        session('classMembers',null);
        session('classMembers',$classMembers);
        $mainPage = U('StudentManage/student');
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

    public function edit(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $userId = I('get.userId');
        $user = D('User');
        $map['userId'] = $userId;
        $student = $user->where($map)->find();
        session('student',null);
        session('student',$student);
        $mainPage = U('StudentManage/save');
        //echo $mainPage;
        //return ;
        $dormBuilds = M('Dorm_build')->select();
        session('dormBuilds',null);
        session('dormBuilds',$dormBuilds);
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

    public function add(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        session('student',null);
        $mainPage = U('StudentManage/save');
        $dormBuilds = M('Dorm_build')->select();
        session('dormBuilds',null);
        session('dormBuilds',$dormBuilds);
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

    public function delete(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $userId = I('get.userId');
        $user = D('User');
        $map['userId'] = $userId;
        $re = $user->where($map)->delete();

        $currentUser = session('currentUser');
        
        $this->redirect('lists');
    }

    public function student(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $this->classMembers = session('classMembers');
        $this->currentUser =session('currentUser');
        $this->currentUserType=session('currentUserType');
        $this->show = session('show');
        //dump($this->classMembers);
        $this->display();
    }

    public function save(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        if(IS_POST){
            $userId = I('post.userId');
            $username = I('post.username');
            $usernumber = I('post.usernumber');
            $password = I('post.password');
            $nikename = I('post.nikename');
            $sex = I('post.sex');
            $dormName = I('post.dormName');
            $dormBuildId = I('post.dormBuildId');
            $tel = I('post.tel');

            $data['username'] = $username;
            $data['usernumber'] = $usernumber;
            $data['password'] = $password;
            $data['nikename'] = $nikename;
            $data['sex'] = $sex;
            $data['dormName'] = $dormName;
            $data['dormBuildId'] = $dormBuildId;
            $data['tel'] = $tel;

            $map1['username'] = $username;
            $map2['usernumber'] = $usernumber;
            $currentUser=session('currentUser');
            $map2['classId'] = $currentUser['classId'];
            $map['userId'] = array('neq',$userId);
            $user = D('User');
            if($user->where($map)->where($map1)->find()){
                session('error',null);
                session('error',"用户名已存在!");
                $mainPage = U('StudentManage/save');
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
            }elseif ($user->where($map)->where($map2)->find()) {
                session('error',null);
                session('error',"学号已存在!");
                $mainPage = U('StudentManage/save');
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
            }
            $currentUser = session('currentUser');
            $classMap['classId'] = $currentUser['classId'];
            if($userId){
                $userMap['userId'] = $userId;
                $re = $user->where($userMap)->save($data);
            }else{
                $data['classId'] = $currentUser['classId'];
                $re = $user->add($data);
            }

            $this->redirect('lists');
        }else{
            $this->error = session('error');
            $this->student = session('student');
            $this->dormBuilds = session('dormBuilds');
            $this->display();
            session('error',null);
        }
        
    }

    public function import(){
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
            for($i=2;$i<=$highestRow;$i++){//$i 为真实的行数，以1开头
                $record['username']= $objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue(); 
                $record['usernumber']= $objPHPExcel->getActiveSheet()->getCell("B".$i)->getValue(); 
                $record['nikename']= $objPHPExcel->getActiveSheet()->getCell("C".$i)->getValue(); 
                $record['password']= $objPHPExcel->getActiveSheet()->getCell("D".$i)->getValue(); 
                $record['sex']= $objPHPExcel->getActiveSheet()->getCell("E".$i)->getValue(); 
                $record['dormBuildName']= $objPHPExcel->getActiveSheet()->getCell("F".$i)->getValue(); 
                $record['dormName']= $objPHPExcel->getActiveSheet()->getCell("G".$i)->getValue(); 
                $record['tel']= $objPHPExcel->getActiveSheet()->getCell("H".$i)->getValue(); 
                $record['zzmm']= $objPHPExcel->getActiveSheet()->getCell("I".$i)->getValue();
                $map['dormBuildName'] = $record['dormBuildName'];
                $record['dormBuildId'] = M('DormBuild')->where($map)->getField('dormBuildId');
                $data[] = $record;
                }
            $response['status'] = 1;
            $response['data'] = $data;
            session('importStudents',null);
            session('importStudents',$data);
            $this->ajaxReturn($response);
            return;
            
        }
    }

    public function importing(){
        $data = session('importStudents');
        $user = M('User');
        $errorData=array();
        foreach ($data as $key => $value) {
            # code...
            $map1['username'] = $value['username'];
            $map2['usernumber'] = $value['usernumber'];
            $currentUser = session('currentUser');
            $map2['classId'] = $currentUser['classId'];
            if($user->where($map1)->find() || $user->where($map2)->find()){
                $errorData[]= $value;
            }else{
                $value['classId'] = $currentUser['classId'];
                $re = $user->add($value);
                //dump($value);
                //print_r($value);
                //print_r($re);
            }
        }
        if(count($errorData)){
            $response['status'] = 0;
            $response['data'] = $errorData;
        }else{
            $response['status'] = 1;
        }

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