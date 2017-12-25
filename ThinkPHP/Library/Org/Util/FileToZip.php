<?php
namespace Org\Util;
class FileToZip{
    public $currentdir;//当前目录
    public $filename;//文件名
    public $savepath;
    public function __construct($curpath,$filename,$filename){
        $this->currentdir=$curpath;//返回当前目录
        $this->savepath=$savepath;//返回保存路径
        $this->filename=$filename;//返回保存文件名
    }        
    //遍历目录
    function list_dir($dir){
    	$result = array();
    	if (is_dir($dir)){
                $file_dir = scandir($dir);
                foreach($file_dir as $file){
    		if ($file == '.' || $file == '..'){
                        continue;
    		}
    		elseif (is_dir($dir.$file)){
                        $result = array_merge($result, list_dir($dir.$file.'/'));
    		}
    		else{
                        array_push($result, $dir.$file);
    		}
                }
    	}
    	return $result;
    }
    
    /**
     * 压缩文件(zip格式)
     */
    public function tozip(){
        $datalist=$this->list_dir($currentdir);
        if(!file_exists($savepath.$filename)){   
            //重新生成文件   
            $zip = new \ZipArchive();//使用本类，linux需开启zlib，windows需取消php_zip.dll前的注释   
            if ($zip->open($savepath.$filename.'.zip',\ZipArchive::OVERWRITE)) {   
		      exit('无法打开文件，或者文件创建失败');
            }   
            foreach( $datalist as $val){   
		      if(file_exists($val)){   
              $zip->addFile( $val, basename(iconv('UTF-8', 'GB2312', $val)));//第二个参数是放在压缩包中的文件名称，如果文件可能会有重复，就需要注意一下   
		      }   
            }   
            $zip->close();//关闭   
	   }
        
    }