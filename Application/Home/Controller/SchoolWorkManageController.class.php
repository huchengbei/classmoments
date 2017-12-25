<?php
namespace Home\Controller;
use Think\Controller;
class SchoolWorkManageController extends Controller {
    public function index(){
    	$this->redirect('User/index');
    	//$this->display();
        //$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover,{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }
    public function lists(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        //由视图中得出数据
        $task =  D('ViewTask');
        $record = D('TaskRecord');
        $currentUser = session('currentUser');
        $map['classId'] = $currentUser['classId'];
        //dump($map);

        $count = $task->where($map)->count();
        $Page       = new \Think\Page($count,10);// 实例化分页类 
        $show       = $Page->show();// 分页显示输出// 进行分页数据查询 
        $limit = $Page->firstRow.','.$Page->listRows;
        //var_dump($Page);
        session('show',null);
        session('show',$show);
        $taskMembers = $task->where($map)->order('status')->order('createTime desc')->limit($limit)->select();

        //dump($classMembers);
        $recordMap = array();
        foreach ($taskMembers as $key => $value) {
        	# code...
            unset($recordMap);
            $recordMap['taskId'] = $value['taskId'];
            $recordMap['userId'] = $currentUser['userId'];
            $taskMembers[$key]['finish'] = $record->where($recordMap)->find()?1:0;
        	$taskMembers[$key]['startTime'] = date("m-d H:i",strtotime($value['startTime']));
        	$taskMembers[$key]['endTime'] = date("m-d H:i",strtotime($value['endTime']));
        	$taskMembers[$key]['createTime'] = date("m-d H:i",strtotime($value['createTime']));
        }
        
        session('taskMembers',null);
        session('taskMembers',$taskMembers);
        $mainPage = U('SchoolWorkManage/task');
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

    public function workslists($taskId){
        if(!session('currentUser'))
            $this->redirect('User/index');
        //由视图中得出数据
        $taskfiles =  D('ViewTaskfiles');
        $map['taskId'] = I('get.taskId')?I('get.taskId'):$taskId;
        //dump($map);

        $count = $taskfiles->where($map)->count();
        $Page       = new \Think\Page($count,10);// 实例化分页类 
        $show       = $Page->show();// 分页显示输出// 进行分页数据查询 
        $limit = $Page->firstRow.','.$Page->listRows;
        //var_dump($Page);
        session('show',null);
        session('show',$show);

        $worksMembers = $taskfiles->where($map)->order('uploadTime desc')->limit($limit)->select();
        //dump($classMembers);
        foreach ($worksMembers as $key => $value) {
        	# code...
        	$worksMembers[$key]['startTime'] = date("m-d H:i",strtotime($value['startTime']));
        	$worksMembers[$key]['endTime'] = date("m-d H:i",strtotime($value['endTime']));
        	$worksMembers[$key]['createTime'] = date("m-d H:i",strtotime($value['createTime']));
        	$worksMembers[$key]['uploadTime'] = date("m-d H:i",strtotime($value['uploadTime']));
            $size = $value['size'];
            if($size>1024*1024){
                $size = strval(round($size*100/1024/1024)/100).'MB'; 
            }elseif($size>1024){
                $size = strval(round($size*100/1024)/100).'KB'; 
            }else{
                $size = strval(round($size*100)/100).'B'; 
            }
            $worksMembers[$key]['size'] =$size;
        }
        
        session('worksMembers',null);
        session('worksMembers',$worksMembers);
        $mainPage = U('SchoolWorkManage/works');
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
        $taskId = I('get.taskId');
        $task = D('TaskTitle');
        $map['taskId'] = $taskId;
        $taskdata = $task->where($map)->find();
        session('task',null);
        session('task',$taskdata);
        $mainPage = U('SchoolWorkManage/save');
        //echo $mainPage;
        //return ;
        $currentUser = session('currentUser');
        $subjectMap['classId'] = $currentUser['classId'];

        $subjects = M('ViewSubject')->where($subjectMap)->select();
        session('subjects',null);
        session('subjects',$subjects);
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
        session('task',null);
        $mainPage = U('SchoolWorkManage/save');
        //echo $mainPage;
        //return ;
        $currentUser = session('currentUser');
        $subjectMap['classId'] = $currentUser['classId'];

        $subjects = M('ViewSubject')->where($subjectMap)->select();
        session('subjects',null);
        session('subjects',$subjects);
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

    public function download(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $taskId = I('taskId');
        $taskfiles =  D('ViewTaskfiles');
        $map['taskId'] = $taskId;
        //dump($map);
        $worksMembers = $taskfiles->where($map)->select();

        $filename ='./Uploads/works/'.$worksMembers[0]['taskId'].'.zip';

        if(true){   
            //重新生成文件   
            $zip = new \ZipArchive();//使用本类，linux需开启zlib，windows需取消php_zip.dll前的注释   
            if ($zip->open($filename, \ZIPARCHIVE::CREATE)!==TRUE) {   
                print_r('无法打开文件，或者文件创建失败');
            }   
            foreach( $worksMembers as $val){
                $fullname = "./Uploads".$val['location'].$val['savename'];
                //    echo $fullname;      
                if(file_exists($fullname)){
                    $zip->addFile( $fullname, $val['name']);//basename(iconv('UTF-8', 'GB2312', $val))第二个参数是放在压缩包中的文件名称，如果文件可能会有重复，就需要注意一下   
                }else{
                    echo "cant find  ".$val['name'];
                }   
            }   
            $zip->close();//关闭   
        }
        if(!file_exists($filename)){     
            print_r("无法找到文件"); //即使创建，仍有可能失败。。。。   
        } else{
            $this->redirect('SchoolWorkManage/downloading', array('taskId'=>$taskId));
            /*
            $url = U('SchoolWorkManage/downloading',array('taskId'=>$taskId));
            echo "<head>  <meta charset='UTF-8'></head>
                    <br/><center><a href ='".$url."' target='"."_blank"."'>下载地址</a></center>";
                    */
        } 
    }

    public function downloading($taskId){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $filename="./Uploads/works/".$taskId.'.zip';
        $task =  D('ViewTask');
        $map['taskId'] = $taskId;
        //dump($map);
        $taskdata = $task->where($map)->find();
        if(file_exists($filename)){
            //echo "1";
            $date=date("Ymd-H:i:m");
            header( "Content-type:  application/octet-stream "); 
            header( "Accept-Ranges:  bytes "); 
            header( "Content-Disposition:  attachment;  filename= ".$taskdata['title'].".zip"); 
            $size=readfile($filename); 
            header( "Accept-Length: " .$size);
            //$filename ="http://localhost/PHPTest/Uploads/works/2/高校工作推进表 (2).doc";
            $delResult = unlink($filename);
        }
        else{
            echo "<head>  <meta charset='UTF-8'></head>
                                <br/><center>文件不存在</center>";
        }
    }

    public function delete(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $taskId = I('get.taskId');
        $task = D('TaskTitle');
        $map['taskId'] = $taskId;
        $re = $task->where($map)->delete();

        $currentUser = session('currentUser');
        
        $this->redirect('lists');
    }

    public function deleteWork(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $recordId = I('get.recordId');
        $fileId = I('get.fileId');

        $taskfiles =  D('ViewTaskfiles');
        $map['fileId'] = $fileId;
        $map['recordId'] = $recordId;

        $re = $taskfiles->where($map)->find();

        if($re){
            $filename="./Uploads".$re['location'].$re['savename'];
            //$filename ="http://localhost/PHPTest/Uploads/works/2/高校工作推进表 (2).doc";
            $delFileResult = unlink($filename);

            $record = D('TaskRecord');
            $map1['recordId'] = $recordId;
            $delRecordResult = $record->where($map1)->delete();

            $file = D('File');
            $map2['fileId'] = $fileId;
            $delFileDataResult = $file->where($map2)->delete();
        }

        $currentUser = session('currentUser');
        
        $this->workslists($re['taskId']);
    }

    public function uploadWork(){
        if(!session('currentUser'))
            $this->redirect('User/index');
    	$taskId = I('get.taskId');
    	session('taskId',$taskId);

    	$mainPage = U('SchoolWorkManage/upworkPage');
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

    public function upload(){

    	$record = D('TaskRecord');
    	$currentUser = session('currentUser');
    	$taskId = I('post.taskId');
    	$map['taskId'] = $taskId;
    	$map['userId'] = $currentUser['userId'];
        $result = $record->where($map)->select();
        if($result){
        	$info['message'] = "<font color='#FF0000' size='5'><b>警告！！！</b></font>这个作业您已经提交，如想重新提交，请先将作业删除";
        	$info['status'] = 0;
        	$this->ajaxReturn($info);
        	return ;
        }else{

            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     8388608 ;// 设置附件上传大小
            //$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  =      './Uploads/'; // 设置附件上传根目录
            $upload->savePath  =      '/works/'; // 设置附件上传（子）目录
            $upload->replace = true;    //存在同名文件是否是覆盖,此处为覆盖
            $upload->saveName = md5(microtime()); //上传文件的保存规则，支持数组和字符串方式定义,此处为不改变名称
            $upload->autoSub = true;   //是否自动使用子目录保存上传文件 此处为是
            $upload->subName = $taskId;
            // 上传文件 
            $date = date("y-m-d H:i:s");
            $res   =   $upload->upload();
            $size = "";
            if(!$res) {// 上传错误提示错误信息
                    //$this->error($upload->getError());
            	$info['status'] = 0;
            	$info['message'] = $upload->getError();
                $this->ajaxReturn($info);
        		return ;
            }else{// 上传成功 获取上传文件信息
                foreach($res as $file){
                //echo $file['savepath'].$file['savename'];

                    $fileD = D('File');
                    $data = array(
    	                'name' => $file['name'],
                        'savename' => $file['savename'],
                        'location'=>$file['savepath'],
                        'size' => $file['size'],
                        'type' =>$file['type'],
                        'md5' =>$file['md5'],
                        'sha1' => $file['sha1'],
                    );
                    $res1 = $fileD->add($data);
                    $fileMap['savename'] = $file['savename'];
                    $fileId = $fileD->where($fileMap)->getField('fileId');

                    if($res1){

                    }else{
                    	$info['message'] = '数据库写入错误！';
    		        	$info['status'] = 0;
    		        	$this->ajaxReturn($info);
    		        	return ;
                    }

                    $recordData['taskId'] = $taskId;
                    $recordData['userId'] = $currentUser['userId'];
                    $recordData['fileId'] = $fileId;
                    $recordData['uploadTime'] = $date;

                    $res2=$record->add($recordData);

                    if($res2){

                    }else{
                    	$info['message'] = '数据库写入错误！';
    		        	$info['status'] = 0;
    		        	$this->ajaxReturn($info);
    		        	return ;
                    }
    				
    				if($file['size'] > 1024 * 1024)
    	                $size = round($file['size'] * 100 / (1024 * 1024)) / 100 ."MB";
                    elseif($file['size'] > 1024)
                        $size = round($file['size'] * 100 / 1024) / 100 ."KB";
                    else
                        $size = round($file['size'] * 100) / 100 ."B";
       
       				$info['message'] = '文件名：'.$file['name'].'<br/>上传完成。<br/>文件大小：'.$size.'<br/>';
    		        $info['status'] = 0;
    		        $this->ajaxReturn($info);
                            //print_r($info);
                }
            }
        }
    }

    public function upworkPage(){
        if(!session('currentUser'))
            $this->redirect('User/index');
    	$this->taskId = session('taskId');
        $this->currentUser = session('currentUser');
        $this->currentUserType = session('currentUserType');

        $this->display();
    }

    public function task(){

        $this->taskMembers = session('taskMembers');
        $this->currentUser = session('currentUser');
        $this->currentUserType = session('currentUserType');
        $this->show = session('show');
        //dump($this->classMembers);
        //dump($this->taskMembers);
        $this->display();
    }

    public function works(){
        if(!session('currentUser'))
            $this->redirect('User/index');
    	$this->worksMembers = session('worksMembers');
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
            $taskId = I('post.taskId');
            $title = I('post.title');
            $description =I('post.description');
            $subjectId = I('post.subjectId');
            $startTime = I('post.startTime');
            $endTime = I('post.endTime');
            $tip = I('post.tip');

            $data['title'] = $title;
            $data['subjectId'] = $subjectId;
            $data['description'] = $description;
            $data['startTime'] = $startTime;
            $data['endTime'] = $endTime;
            //echo $endTime;
            $data['createTime'] = date('Y-m-d H:i:s',NOW_TIME);
            $data['tip'] = $tip;
            //dump($data);
            //return;
            $task = D('TaskTitle');
	        $taskMap['taskId'] = $taskId;
	        $re = $task->where($taskMap)->find();

            if($re){
                $re = $task->where($taskMap)->save($data);
            }else{
            	$currentUser = session('currentUser');
                $data['authorId'] = $currentUser['userId'];
                $data['classId'] = $currentUser['classId'];
                $re = $task->add($data);
            }
            //echo $manager->getLastSql();

            $this->redirect('lists');
        }else{
            $this->error = session('error');
            $this->task = session('task');
            $this->subjects = session('subjects');
            $this->display();
            session('error',null);
        }
        
    }
}