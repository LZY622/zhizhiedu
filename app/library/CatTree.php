<?php
	/**
	* 
	*/
	class CatTree{
		//成员属性
		private $idName;
		private $pidName;
		private $catName;
		private $ordName;
		private $child;
		private $level;
		private $pid;
		private $list;
		private $items;
		private $path;
		private $tabName;
		//成员方法默认数据库type表中有四个字段 id name pid ord
		function __construct($tabName='type',$level=0,$path='0,',$pid=0,$child='child',$idName='cateid',$pidName='pid',$catName='catename',$ordName='ord'){
			$this->idName = $idName;
			$this->pidName = $pidName;
			$this->catName = $catName;
			$this->ordName = $ordName;
			$this->level = $level;
			$this->path = $path;
			$this->pid = $pid;
			$this->child = $child;
			$this->tabName = env('DB_PREFIX').$tabName;
			$this->list = [];
		}
		//链接数据库得到数据
		private function link(){
			$link = @mysqli_connect(env('DB_HOST'),env('DB_USERNAME'),env('DB_PASSWORD')) or die('连接数据库失败');
			mysqli_select_db($link,env('DB_DATABASE')) or die('连接数据库失败');
			mysqli_set_charset($link,env('DB_CHARSET'));
			$sql = "SELECT * FROM {$this->tabName}";
			$result = mysqli_query($link,$sql);
			while ($row = mysqli_fetch_assoc($result)) {
				$data[] = $row;
			}
			$this->items = $data;
		}
		//获得新数据
		public function getTree(){
			$this->link();
			//调用便利数据的方法
			$this->data($this->items,$this->pid,$this->level,$this->path);
			// var_dump($this->list);
			//调用获取子类的方法
			return $this->childs($this->list);
		}
		//遍历数据
		private function data($data,$pid,$level,$path){
			//判断
			if (array_key_exists($this->ordName, $data[0])) {
				//对数组进行排序
				usort($data,array(__CLASS__,'paixu'));//__CLASS__获取类名和方法
			}
			//遍历层级关系
			foreach ($data as $k => $v) {
				if ($v[$this->pidName] == $pid) {
					$v['level'] = $level;
					//制作当前path路径
					if($v[$this->pidName] != 0){
						$v['path'] = $path.$v[$this->pidName].',';
					}else {
						$v['path'] = $path;
					}
					$this->list[$v[$this->idName]] = $v;
					//递归
					$this->data($data,$v[$this->idName],$level+1,$v['path']);
				}
			}
		}

		//获取子类
		private function childs(array $data){
			foreach ($data as $k=>&$v) {
				$v[$this->child] = '';
				foreach ($data as $key => $val) {
					if (in_array($v[$this->idName],explode(',', $val['path']))) {
						$v[$this->child] .= $val[$this->idName].',';
					}
				}
				$v[$this->child] = rtrim($v[$this->child],',');
			}
			return $data;
		}
		//排序回调函数
		private function paixu($x,$y){
			if ($x[$this->ordName] == $y[$this->ordName]) {
				return 0;
			}elseif ($x[$this->ordName] < $y[$this->ordName]) {
				return -1;//正序
			} else {
				return 1;//倒叙
			}
			
		}
	}


?>