<?php
    include 'sql.php';
    $SQL = new SQL;
    if(session_unset()){
      session_start();
    }else{
      session_destroy();
      session_start();
    }
?> 

<html>
	<head>
	<title>422 Process Scheduling</title>
	<script type="text/javascript" src='jquery/jquery.js'></script>
	</head>

	<body>
	<h1><center>Process Table</center></h1>

	<div class='col-lg-12'>
	<table border="1" id="tab">
	<thead>
		<th class='td1' width="5%">Process Number</th>
        <th class='td1'>Arrival Time</th>
        <th class='td1' width="10%">Turnaround</th>
        <th class='td1'>Service Time</th>
        <th class='td1'>Finish Time</th>
        <th class='td1' width='10%'>Remaining Turnarounds</th>
        <th class='td1' width='10%' id='prio-th'>Priority</th>
    </thead>
    <tbody id='tbody-1'></tbody>
	</table>
	</div>

	<footer style="position: fixed;bottom: 2%;">
	<div>
		<button id='fcfs-set'>First Come First Serve</button>

	</div>
		<div class='fcfs row col-md-12' id='fcfs'>
		<br>
			<label>Turnarounds</label>
			<input type="text" class='form-control' name="Input">
			<label>Average Waiting Time</label>
			<input type="text" class="form-control" disabled="true">
			<button class='btn' id='fcfs-add'>Add</button>
			&nbsp;<button class='btn' id='fcfs-reset'>Reset</button>
		</div>

	</footer>
	</body>
</html>
<script type="text/javascript" src='index.js'></script>