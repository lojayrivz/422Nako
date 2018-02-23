$(document).ready(function(){

	var fcfs = true, fcfstoggle=false;

	$('#srt').hide();
	$('#sjn').hide();
	$('#ps').hide();
	$('#prio-th').hide();
	$('#rr').hide();
	$('#tab2').hide();
	$('#mlq').hide();

	function setMode(mode){
		switch(mode){
			case "fcfs": fcfs = true; sjn = false; ps = false; srt=false; rr=false; mlq=false;
						 $('#fcfs').show(); $('#sjn').hide(); $('#ps').hide(); $('#srt').hide(); $('#rr').hide(); $('#mlq').hide();  $('#tab2').hide();
						 $('#type-th-1').html("");
						 $('#type-th-2').html("");
						 break;
		}
	}

	$('#fcfs-set').click(function(){
		setMode("fcfs");
		if(!fcfstoggle){
			$('#sjn-set').hide();
			$('#ps-set').hide();
			$('#srt-set').hide();
			$('#rr-set').hide();;
			$('#mlq-set').hide();
			fcfstoggle = true;
		}else{
			$('#sjn-set').show();
			$('#ps-set').show();
			$('#srt-set').show();
			$('#rr-set').show();
			$('#mlq-set').show();
			fcfstoggle = false;
		}
		$('#prio-th').hide();
	});


	$('#fcfs-add').click(function(){
		if(fcfs){
			var input = $('#fcfs-input').val();
			$.post('/422/input.php','fcfs-add='+input,function(response){
				var html = "", count = 0;
				$.each(response,function(index,element){
					bursttime = element.executetime-1;
					remain = element.currenttime-1;
					html += "<tr><td>"+count+"</td><td>"+element.arrivaltime+"</td><td>"+bursttime	+"</td><td>"+element.servicetime+"</td><td>"+element.finishtime+"</td><td>"+remain+"</td></tr>";
					count++;
				});
				$('#tbody-1').html(html);
			},'json');
		}
	});


	$('#fcfs-reset').click(function(){
		$.post('/422/input.php','fcfs-reset=1',function(response){
			$('#tbody-1').html("");
		});
	});

	
	setInterval(function(){
		if(fcfs){
			$.post('/422/input.php','fcfs-update=1',function(response){
				var html = "", count = 0;
				$.each(response,function(index,element){
					bursttime = element.executetime - 1;
					remain = element.currenttime - 1;
					html += "<tr><td>"+count+"</td><td>"+element.arrivaltime+"</td><td>"+bursttime+"</td><td>"+element.servicetime+"</td><td>"+element.finishtime+"</td><td>"+remain+"</td></tr>";
					count++;
				});
				$('#tbody-1').html(html);
			},'json');
			$.post('/422/input.php','fcfs-ave=1',function(response){
				$('#fcfs-input-waiting').attr("value",response+" seconds");
			});
		}
	},1000);
});