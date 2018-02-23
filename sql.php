<?php
	date_default_timezone_set('Asia/Manila');

	session_start();

	class SQL{
		private $conn;
		public function __construct(){
			$this->conn = new mysqli("localhost","root","","422memory");
		}
		public function initFCFS(){
			$sql = "DELETE FROM fcfs WHERE 1";
			$query = mysqli_query($this->conn,$sql);
		}
		
		public function getMicrotime(){
			$time = microtime();
			$string = explode(' ', $time);
			$time = $string[1];
			return $time;
		}
		public function addProcessFCFS($process,$time){
			if($process<4) return false;
			$sql = "SELECT * FROM fcfs WHERE 1";
			$query = mysqli_query($this->conn,$sql);
			$sql = "INSERT INTO fcfs (`arrivaltime`,`executetime`,`currenttime`,`processorder`) VALUES ('".$time."','".$process."','".$process."','".mysqli_num_rows($query)."')";
			$query = mysqli_query($this->conn,$sql);
			return $query;
		}
		
		public function updateFCFS($reftime){
			$sql = "SELECT * FROM fcfs WHERE finishtime='0' ORDER BY processorder ASC";
			$query = mysqli_query($this->conn,$sql);
			if(mysqli_num_rows($query)>0){
				$row = mysqli_fetch_assoc($query);
				if($row['finishtime']==0){
					$time = $row['currenttime']-1;
					$order = $row['processorder'];
					if($row['currenttime']==$row['executetime']&&$time==0){
						$sql = "UPDATE fcfs SET servicetime='".$reftime."',finishtime='".$reftime."' ,currenttime='1' WHERE processorder='".$order."'";
					}else if($row['currenttime']==$row['executetime'])
						$sql = "UPDATE fcfs SET servicetime	='".$reftime."' ,currenttime='".$time."' WHERE processorder='".$order."'";
					else if($time==0){
						$sql = "UPDATE fcfs SET finishtime='".$reftime."' ,currenttime='1' WHERE processorder='".$order."'";
					}else{
						$sql = "UPDATE fcfs SET currenttime='".$time."' WHERE processorder='".$order."'";
					}
					mysqli_query($this->conn,$sql);
				return true;					}
			}else return false;
		}
		public function getFCFS(){
			$sql = "SELECT * FROM fcfs WHERE 1 ORDER BY processorder ASC";
			$query = mysqli_query($this->conn,$sql);
			if(mysqli_num_rows($query)>0){
				$itemArray = array();
				while($row = mysqli_fetch_assoc($query)){
					array_push($itemArray, $row);
				}
				return $itemArray;
			}else return false;
		}
		
		public function getAveFCFS(){
			$sql = "SELECT * FROM fcfs WHERE finishtime!='0'";
			$sum = 0;
			$query = mysqli_query($this->conn,$sql);
			$rows = mysqli_num_rows($query);
			if($rows>0){
				while($row=mysqli_fetch_assoc($query)){
					$diff = $row['servicetime']-$row['arrivaltime'];
					$sum += $diff;
				}
				return $sum/$rows;
			}else return false;
		}
	}
?>
