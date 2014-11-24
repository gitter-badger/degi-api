<?php
namespace Administrator\model;

use Zend\File\Transfer\Adapter\Http;

class Tool
{
	function createfile($path,$filename){
		if(!is_dir($path.'/'.$filename)){
			$oldmask = umask(0);
			if(!mkdir($path.'/'.$filename,0777,true)){
				umask($oldmask);
				return true;
			}
			umask($oldmask);
		}
		return false;
	}
    function deleteimg ($path, $img_name){
    	if (file_exists($path . '/' . $img_name)) {
    	    
    		@chmod($path, 0777);
    		@unlink($path . '/' . $img_name);
    	}
    }
    public function upload($input, $fielType = null){
        if (! isset($fielType)) {
            $fielType = array(
                'jpg',
                'jpeg',
                'png',
                'gif',
                'bmp'
            );
        }
        $msg_type = '';
        $fielType_nub = count($fielType);
        foreach ($fielType as $key => $val) {
            $dar = ((int) $fielType_nub - 1 == $key) ? '' : ',';
            $msg_type .= $val . $dar;
        }
        $adapter = new Http();
        $fileinfo = $adapter->getFileInfo();
        $files = array();
        // 如果只有一筆
        $isImg = false;
        $re['success'] = true;
        $re['msg']='';
        if (count($fileinfo) >= 1) {
            foreach ($fileinfo as $index => $file) {
                if ($file['name'] != '') {
                    $t_filename = explode('.', $file['name']);
                    $t_filename = strtolower(end($t_filename));
                    if (in_array($t_filename, $fielType)) {
                        $re['success'] = true;
                        $isImg = true;
                    } else {
                        $re['success'] = false;
                        $re['msg'] .= 'Please upload file formats:' . $msg_type;
                    }
                    $size = (isset($input['size'][$index])) ? $input['size'][$index] : 200;
                    $img_size = $size * 1024;
                    if ($re['success'] && $file['size'] > $img_size) {
                        $re['success'] = false;
                        $re['msg'] .= $file['name'] . 'File is too large , please upload the file under ' . $size . 'kb';
                    }
                }
            }
        }
        // 是圖片
        if ($isImg && $re['success']) {
            $re = $this->imageUpload($input);
        }
        return $re;
    }
	public function copy_file($src,$dst){
		$dir = opendir($src);
		@mkdir($dst);
		while(false !== ( $file = readdir($dir)) ) {
			if (( $file != '.' ) && ( $file != '..' )) {
				copy($src . '/' . $file,$dst . '/' . $file);
				unlink($src . '/' . $file);
			}
		}
		closedir($dir);
	}
	public function SureRemoveDir($dir, $DeleteMe) {
		if(!$dh = @opendir($dir)) return;
		while (false !== ($obj = readdir($dh))) {
			if($obj=='.' || $obj=='..') continue;
			if (!@unlink($dir.'/'.$obj)) $this->SureRemoveDir($dir.'/'.$obj, true);
		}
		if ($DeleteMe){
			closedir($dh);
			@rmdir($dir);
		}
	}
    public function imageUpload($input){ 
        $adapter = new Http();
        $fileinfo = $adapter->getFileInfo();
        $files = array();
        $rs['success'] = false;
        foreach ($fileinfo as $index => $file) {
            if ($file['name'] != '') {
                if (isset($input['m_path'][$index])) {
                    $filePath = $input['m_path'][$index];
                } else {
                    $filePath = $input['path'];
                }
                $t_filename = explode('.', $file['name']);
                $t_filename = strtolower(end($t_filename));
                $filename = time() . '.' . $t_filename;
                
                $adapter->addFilter('File\Rename', array('target' => PUBLIC_PATH.'/'.$filePath .'/'.$filename,'overwrite' => true));
                if ($adapter->receive($file['name'])) {
                    $files[$index] = $filename;
                }
                $rs['success'] = true;
                $rs['files'] = $files;
            }
        }
        return $rs;
    }
}
?>