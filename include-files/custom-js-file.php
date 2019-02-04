<?php

	$timezone = new DateTimeZone("Asia/Kolkata" );
	$date2 = new DateTime();
	$date2->setTimezone($timezone );
	$time = (string)$date2->format( 'H:i:s' );

	$timeFirst  = strtotime($_SESSION['currentend'].":00");
	$timeSecond = $time;

	$timeSecond = strtotime($time);

	$differenceInSeconds = $timeFirst - $timeSecond; 
	if($differenceInSeconds <= 0)
	{
		$differenceInSeconds=2;
	}
?>

<script>
//var d =	new Date(new Date().getTime()).toLocaleTimeString('en-US', { hour12: false }); 
function showtimeupalert(from, align){
    	color = Math.floor((Math.random() * 4) + 1);

    	$.notify({
        	icon: "ti-time",
        	message: "Mess is <b>Closed </b> "

        },{
            type: 'danger',
            timer: 4000,
            placement: {
                from: from,
                align: align
            }
        });
	}

var diff =<?php echo $differenceInSeconds*1000; ?>;
var deniedpage = <?php $pagerfxr = basename($_SERVER['PHP_SELF']); if($pagerfxr=="presentday.php"){ echo "0"; } else { echo "1"; } ?>;
if((diff==2000) )
{
	if(deniedpage == 0)
	{
		window.setTimeout(function(){

		// Move to a new location or you can do something else
		window.location.href = 'dashboard.php';
		}, 500);
	}
	else
	{
		
		showtimeupalert('top','center');
	}
}
else
{
	window.setTimeout(function(){

		// Move to a new location or you can do something else
		window.location.href = 'dashboard.php';
	}, diff);
}
</script> 