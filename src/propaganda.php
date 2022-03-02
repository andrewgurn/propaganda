<?php
	require_once("propagandaConfig.php");
?>

<html>
	<head>
		<title>Propaganda Screen</title>
		<script type="text/javascript" src="https://code.jquery.com/jquery-latest.js"></script>
		<style>
			body
			{
				background: url('<?php echo(PAGEBACKGROUND); ?>');
				background-size: cover;
				background-repeat: no-repeat;
			}
			iframe
			{
				overflow: hidden;
				display: block;
				border: 0px;
				width: 100%;
				height: 100%;
			}
			.weather
			{
				position: absolute;
				left: 2%;
				top: 2%;
				width: 11%;
				height: 93%;
				background: rgba(0,0,0,.5); 
				padding: 10px; 
				overflow: hidden; 
			}
			.ticker
			{
				position: absolute;
				left: 15%;
				top: 86%;
				width: 83%;
				height: 12%;
			}
			
			.main
			{
				position: absolute;
				left: 15%;
				top: 2%;
				width: 83%;
				height: 83%;
				text-align: center;
			}
			.main img
			{
				height: 100%;
				margin-left: auto;
				margin-right: auto;
				vertical-align: middle;
				
			}
			
		</style>
	</head>
	<body>
		<div class="weather">
			<iframe id="weather" frameborder="0" src="propagandaWeather.php"></iframe>
		</div>
		<div class="ticker">
			<iframe id="ticker" frameborder="0" src="propagandaTicker.php"></iframe>
		</div>
		<div class="main" id='main'>
			
		</div>
	</body>
	
	<script>
			
		var contentDisplayTime = 10000;
				
		$(document).ready(function() {
			getMainContent();
		});
		
		//reload the news ticker every 15 minutes (900000 miliseconds)
		setInterval(function(){
		   $('#ticker').attr('src', function (i, val){ return val; });
		}, <?php echo(TICKERREFRESH); ?>);
		
		//reload the weather panel every 1 hour (3600000 miliseconds)
		setInterval(function(){
		   $('#weather').attr('src', function (i, val){ return val; });
		},  <?php echo(WEATHERREFRESH); ?>);
		
		//reload the main content panel every 15 minutes (900000 miliseconds)
		setInterval(function(){
			getMainContent();
		},  <?php echo(MAINCONTENTREFRESH); ?>);
		
		//Here's the initial call to the infinite loop refresh function for the main content
		//Just using a default of 10 seconds before the first refresh, just to make sure everything is ready and loaded
		setTimeout(cycleMainContent, 10000);
		
					
		//Go get the main content from the database
		function getMainContent()
		{
			
			$.ajax({
			    dataType: 'text',
			    type: 'POST',
			    url: 'propagandaLoader.php',
			    contentType: "application/x-www-form-urlencoded;",
			    success: function(result){
				  	
				   $('#main').html(result);  
					 
			    },
			    error: function(xhr, textStatus, errorThrown) {
			       	
				   $('#main').html('<div class="error">AJAX error getting quesion results!  Does your display device have a network connection?</div>');
				  
			    }
			});
			
		}
		
		//Cycle through the main content
		function cycleMainContent()
		{
			$('.main').each(function(){
				
				//find the item currently being displayed and fade it out  
				//I'm keeping track of this by sticking "current" in the class attribute of its container div
				var $cur = $(this).find('.current').removeClass('current').fadeOut();
				
				//find the item to display next.  If we're on the last item, we'll go back to the first one.
				var $next = $cur.next().length?$cur.next():$(this).children().eq(0);
				
				//the time to display each item is stored on the class attribute of its container div
				//to retrieve it, I'm just stripping out everything that isn't a number
				contentDisplayTime = $next.attr("class").replace(/\D/g,'');
				
				//if the next element to show is an iframe, refresh it.  No need to refresh images
				if($next.prop('nodeName') == 'iframe')
				{
					$next.attr('src', $next.attr('src'));
				}
				
				//make the next item current and fade it in
				$next.addClass('current').delay(1000).fadeIn();
			});	
			
			//since we're cycling through in perpituity, we'll call ourself again here after waiting for the display time value we grabbed earlier
			setTimeout(cycleMainContent, contentDisplayTime);	
		}
		
	
	</script>
	
</html>
