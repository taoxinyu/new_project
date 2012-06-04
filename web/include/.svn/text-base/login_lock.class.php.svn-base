<?php
class login_lock{
	const LOCK_TIME = 15;
    const LOCK_TIMES = 5;
	protected $_db;
	protected $_reset=false;
	public $data=array();
	function __construct()
	{
		if(!isset($this->_db))$this->_db=$GLOBALS['db'];
		$this->data["ip"]=$_SERVER["REMOTE_ADDR"];
		$sql="select * from login_lock where ip='".$this->data['ip']."'";
		$query=$this->_db->query($sql);
		$data=$this->_db->fetchAssoc($query);
		if($data){
		$this->data=$data;
		}else{
		$this->data["times"]=$this->data["time"]=0;
		};
	}
	function setTime(){
		$this->data["time"]=time();
	}
	function is_lock(){
	    if($this->data["time"]&&time()-$this->data["time"]<self::LOCK_TIME*60){
		$this->setTime();
		return true;
		}
		return false;
	}
	function init_times(){
	    $this->data["times"]=0;
		$this->_reset=true;
	}
	function error_handler(){
	    $this->data["times"]=$this->data["times"]?$this->data["times"]+1:1;
		if($this->data["times"]>=self::LOCK_TIMES){
			$this->init_times();
			$this->setTime();
			return false;
		}else{
		return self::LOCK_TIMES-$this->data["times"];
		}
	}
	function __destruct(){
	    if($this->data["times"]||$this->is_lock()||$this->_reset){
	    if(isset($this->data["id"])){
		$sql="update login_lock set times=".$this->data["times"].", time=".($this->data["time"]?$this->data["time"]:0).", dateline=".time()." where id=".$this->data["id"];
		}else{
		$sql="insert into login_lock(ip,times,dateline)values('".$this->data['ip']."',".$this->data["times"].",".time().")";
		}}
     	$this->_db->query($sql);
		$rand=rand(0,9);
		if($rand==5){
		   $this->_db->query("delete from login_lock  where  dateline<".(time()-self::LOCK_TIME*60));
		}
		$this->_db->close();
	}
}