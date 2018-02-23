<?php
	include 'class/sql.php';

	$SQL = new SQL;

	if(isset($_POST['fcfs-add'])){
		if($_POST['fcfs-add']>=4){
			$SQL->addProcessFCFS($_POST['fcfs-add']+1,$SQL->getMicrotime());
		}
		$results = $SQL->getFCFS();
		echo json_encode($results);
	}else if(isset($_POST['fcfs-reset'])){
		$SQL->initFCFS();
		$results = $SQL->getFCFS();
		echo json_encode($results);
	}else if(isset($_POST['fcfs-update'])){
		$SQL->updateFCFS($SQL->getMicrotime());
		$results = $SQL->getFCFS();
		echo json_encode($results);	
	}
	}else if(isset($_POST['fcfs-ave'])){
		echo $SQL->getAveFCFS();
	}
	}
