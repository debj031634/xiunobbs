<?php
/**
 *------------------------------------------------------------------------------------*
 * 功能：iceEditor编辑器上传
 *------------------------------------------------------------------------------------*
 * 作者：ice
 * 官方：www.iceui.cn
 * 时间：2018-04-25
 * 更新时间：时间：2020-10-22
 * 更新内容：增加网络图片下载到本地
 * 版权声明：该版权完全归官方www.iceui.cn所有，可转载和个人学习使用，但请务必保留版权
 *------------------------------------------------------------------------------------*
 */
class ice_upload{
	//支持上传的文件格式
	private $type = ['jpg','jpeg','png','gif','bmp','exe','flv','swf','mkv','avi','rm','rmvb','mpeg','mpg','ogg','ogv','mov','wmv','mp4','webm','mp3','wav','mid','rar','zip','tar','gz','7z','bz2','cab','iso','chm','doc','docx','xls','xlsx','ppt','pptx','pdf','txt','md','torrent'];

	//上传目录
	private $dir ;

	private $rename = 'time';

	/* 为单个成员属性设置值 */
	private function setOption($key, $val) {
		$this->$key = $val;
	}
	public function __construct($upload="")
       {
			if($upload=='')$this->setOption('dir',isset($_SESSION['upload_path'])?$_SESSION['upload_path']:'/upload/files/'.date("Ymd").'/');
       }

	function uploadUrl($imgurl){
		/*********************** 基本参数 ***********************/
		header("Content-Type: text/html; charset=utf-8");
		header("X-Powered-By: uz");
		date_default_timezone_set('PRC');
		session_start();
		/*********************** 基本参数 ***********************/
		

		/*********************** 上传项配置区 开始 ***********************/
		//获取域名
		$http = ($this->_isHttps() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'];

		// 绝对路径
		define('URL',$_SERVER['DOCUMENT_ROOT']);


		//如果设置的上传目录不存在，则创建
		if (!file_exists(URL.$this->dir)) {
			@mkdir(URL.$this->dir,0777,true);
		}

		//定义用来返回上传文件成功后的URL连接的JSON格式
		$url = [];

		//网络图片下载到本地
		if($imgurl){
			$fileExt = $this->_fileExt($imgurl);
			$img = @file_get_contents($imgurl);
			if(!$img){
				$url['error'] = 1;
				$url['url'] = '';
			}else{
				$info = pathinfo($imgurl);
				$name = $this->_fileRename($info['basename']);
				//判断文件类型是否允许上传
				/*
				[
                'state' => 'SUCCESS',
                'url' => 'https://ms-assets.modstart.com/demo/modstart.jpg',
                'size' => 100,
                'title' => 'title',
                'original' => '',
                'source' => htmlspecialchars($imgUrl),
            ] */
				if (!$img || !in_array($fileExt,['jpg','jpeg','png','gif','bmp'])){
					$url['state'] = 'FAILED';
					$url['url'] = '';
				}
				if(file_put_contents(URL.$this->dir.$name, $img)){
					$url['state'] = 'SUCCESS';
					$url['url'] = $http.$this->dir.$name;
					$url['source'] = $imgurl;
				}
			}			
		}
		return $url;
	}
	
	function upload (){
		/*********************** 基本参数 ***********************/
		header("Content-Type: text/html; charset=utf-8");
		header("X-Powered-By: uz");
		date_default_timezone_set('PRC');
		session_start();
		/*********************** 基本参数 ***********************/
		

		/*********************** 上传项配置区 开始 ***********************/
		//获取域名
		$http = ($this->_isHttps() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'];

		// 绝对路径
		define('URL',$_SERVER['DOCUMENT_ROOT']);

		
		//上传控件名称
		$field = 'file';

		
		//上传文件存储大小的限制-默认30M
		$maxSize = 30 * 1048576;

		//上传文件的名称命名方式，默认以'time'方式命名
		//time 将以时间戳+数字排序     
		//fileName 将以文件原来的名称命名，如果该文件含有中文，则自动改为time形式命名  
		//填写其它字符串（禁止填写中文），将以该字符串形式命名，如果为批量上传，则将该字符串后面添加数字排序防止重名  
		
		/*********************** 上传项配置区 结束 ***********************/



		//如果设置的上传目录不存在，则创建
		if (!file_exists(URL.$this->dir)) {
			@mkdir(URL.$this->dir,0777,true);
		}

		//定义用来返回上传文件成功后的URL连接的JSON格式
		$url = [];


		

		//获取文件的类型
		$fileType = $_FILES[$field]['type'];

		$name = $_FILES[$field]['name'];

		//用来处理截图数据
		if($name == 'blob'){
			$ext = explode('/',$fileType);
			$name .= '.'.$ext[1];
		}

		//获取文件的名称
		$fileName = $this->_filePre($name);

		//获取文件的后缀名称
		$fileExt = $this->_fileExt($name);

		//重命名
		$name = $this->_fileRename($name,1);

		$error = 0;

		//判断文件类型是否允许上传
		if (!in_array($fileExt,$this->type)){
			$error = '该文件类型禁止上传';
		}

		//判断文件大小是否超出
		if ($_FILES[$field]["size"] > $maxSize){
			$error = '该文件太大禁止上传';
		}

		//获取文件的完整url地址
		$url['url'] = $http.$this->dir.$name;
		$url['name'] = $fileName.'.'.$fileExt;
		$url['error'] = $error;
		if(!$error){
			//将上传的文件移动到指定目录
			move_uploaded_file($_FILES[$field]["tmp_name"],URL.$this->dir.$name);
		}
		$url['state'] = $error?"FAILED":"SUCCESS";
			
		return $url;
	}

	//判断当前协议是否为HTTPS
	private function _isHttps() {
		if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
			return true;
		} elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
			return true;
		} elseif (!empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
			return true;
		}
		return false;
	}

	//获取文件后缀名，不包含 .
	private function _fileExt($name) {
		return strtolower(substr(strrchr($name, '.'), 1));
	}

	//获取文件的前缀，不包含 .
	private function _filePre($name) {
		return substr($name, 0, strrpos($name, '.'));
	}

	//重命名
	private function _fileRename($name,$key=1) {

		

		//获取文件的名称
		$fileName = $this->_filePre($name);

		//获取文件的后缀名称
		$fileExt = $this->_fileExt($name);

		if($this->rename == 'time'){
			$name = time()+$key.'.'.$fileExt; //以时间戳加排序数字重命名，防止重复
		}elseif($this->rename == 'fileName' || $this->rename == ''){
			//如果文件名含有中文，则以时间戳加排序数字重命名，防止出错
			if(preg_match("/([\x81-\xfe][\x40-\xfe])/", $fileName, $match)){
				$name = time()+$key.'.'.$fileExt;
			}else{
				//以文件原来的名称
				$name = $fileName.'.'.$fileExt;
			}
			
		}else{
			//自定义重命名,如果该上传为批量，则自定义的命名后面添加排序数字
			if($key>0){
				$name = $this->rename.$key.'.'.$fileExt;
			}else{
				$name = $this->rename.'.'.$fileExt;
			}
		}
		return $name;
	}
}

?>