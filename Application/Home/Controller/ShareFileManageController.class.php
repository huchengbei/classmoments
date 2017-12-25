<?php
/**
 * Created by PhpStorm.
 * User: Alien-HQ
 * Date: 2016/5/5
 * Time: 16:44
 */

namespace Home\Controller;
use Think\Controller;

class ShareFileManageController extends Controller{
	public function lists(){
        if(!session('currentUser'))
            $this->redirect('User/index');
		//由视图中得出数据
        $shareFileM =  M('ViewShareFile');
        $currentUser = session('currentUser');
        $map['classId'] = $currentUser['classId'];
        //dump($map);

        $count = $shareFileM->where($map)->count();
        $Page       = new \Think\Page($count,10);// 实例化分页类 
        $show       = $Page->show();// 分页显示输出// 进行分页数据查询 
        $limit = $Page->firstRow.','.$Page->listRows;
        //var_dump($Page);
        session('show',null);
        session('show',$show);
        $shareFiles = $shareFileM->where($map)->order('shareId desc')->limit($limit)->select();
        foreach ($shareFiles as $key => $value) {
            # code...
            $size = $value['size'];
            if($size>1024*1024){
                $size = strval(round($size*100/1024/1024)/100).'MB'; 
            }elseif($size>1024){
                $size = strval(round($size*100/1024)/100).'KB'; 
            }else{
                $size = strval(round($size*100)/100).'B'; 
            }
            $shareFiles[$key]['size'] =$size;
        }

        session('shareFiles',null);
        session('shareFiles',$shareFiles);
        $mainPage = U('ShareFileManage/shares');
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

    public function down(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $shareId = I('get.shareId');

        $map['shareId'] = $shareId;

        $fileM = M('ViewShareFile');
        $file = $fileM->where($map)->find();

        $filename= "./Uploads".$file['location'].$file['savename'];
        if(file_exists($filename)){
            //echo "1";
            $date=date("Ymd-H:i:m");
            header( "Content-type:  application/octet-stream "); 
            header( "Accept-Ranges:  bytes "); 
            header( "Content-Disposition:  attachment;  filename= ".$file['name']); 
            $size=readfile($filename); 
            header( "Accept-Length: " .$size);
        }
        else{
            echo "<head>  <meta charset='UTF-8'></head>
                                <br/><center>文件不存在</center>";
        }
    }

    public function delete(){
        if(!session('currentUser'))
            $this->redirect('User/index');
        $shareId = I('get.shareId');

        $map['shareId'] = $shareId;

        $fileM = M('ViewShareFile');
        $file = $fileM->where($map)->find();

        $filename= "./Uploads".$file['location'].$file['savename'];

        if(!file_exists($filename) || unlink($filename) ){
            unset($map);
            $map['fileId'] = $file['fileId'];
            $re = M('File')->where($map)->delete();
        }
        $currentUser = session('currentUser');
        $this->redirect('lists');
    }

    public function upload(){
        $currentUser = session('currentUser');
        $map['taskId'] = $taskId;
        $map['userId'] = $currentUser['userId'];
        
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     52428800 ;// 设置附件上传大小
        //$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =      './Uploads/'; // 设置附件上传根目录
        $upload->savePath  =      '/shares/'; // 设置附件上传（子）目录
        $upload->replace = true;    //存在同名文件是否是覆盖,此处为覆盖
        $upload->saveName = md5(microtime()); //上传文件的保存规则，支持数组和字符串方式定义,此处为不改变名称
        $upload->autoSub = true;   //是否自动使用子目录保存上传文件 此处为是
        $upload->subName = array('date','Ymd');
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
                $fileD = M('File');
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

                $shareM = M('Share');
                $recordData['classId'] = $currentUser['classId'];
                $recordData['userId'] = $currentUser['userId'];
                $recordData['fileId'] = $fileId;
                $recordData['description'] = I('post.description');
                $recordData['shareTime'] = $date;

                $res2=$shareM->add($recordData);

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

	public function shares(){
        if(!session('currentUser'))
            $this->redirect('User/index');
		$this->shareFiles = session('shareFiles');
        $this->currentUser = session('currentUser');
        $this->currentUserType = session('currentUserType');
        $this->show = session('show');
        //dump($this->classMembers);
        //dump($this->taskMembers);
        $this->display();
	}
}