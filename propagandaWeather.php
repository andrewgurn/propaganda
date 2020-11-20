<?php
	require_once('propagandaConfig.php');
	
	$companyLogo = COMPANYLOGO;
?>

<html>
	<head>
	</head>
	<body>
		<div id="weather" style="text-align: center; font-family: Arial; font-weight: bold; font-size: 1.2em; color: #FFF;  ">
			<?php 

				$url = 'https://api.openweathermap.org/data/2.5/forecast/daily?zip=17603,us&APPID='.OPENWEATHERAPIKEY;
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_URL,$url);
				$result=curl_exec($ch);
				curl_close($ch);
				$json = json_decode($result, true);
				$today = new DateTime();
				$twoDaysFromNow = date_add($today, date_interval_create_from_date_string('2 days'));
				$twoDaysFromNowDayOfWeekName = $twoDaysFromNow->format('l');

				//today
				$weatherIconCode =  $json['list'][0]['weather'][0]['icon'];
				$weatherIcon = "https://openweathermap.org/img/wn/$weatherIconCode@2x.png";
				$highK = $json['list'][0]['temp']['max'];
				$lowK = $json['list'][0]['temp']['min'];
				$humidity = $json['list'][0]['humidity'];
				$high = round((($highK - 273.15) * 1.8) + 32);
				$low = round((($lowK - 273.15) * 1.8) + 32);

				//tomorrow
				$tomorrowsWeatherIconCode =  $json['list'][1]['weather'][0]['icon'];
				$tomorrowsWeatherIcon = "https://openweathermap.org/img/wn/$tomorrowsWeatherIconCode@2x.png";
				$tomorrowsHighK = $json['list'][1]['temp']['max'];
				$tomorrowsLowK = $json['list'][1]['temp']['min'];
				$tomorrowsHumidity = $json['list'][1]['humidity'];
				$tomorrowsHigh = round((($tomorrowsHighK - 273.15) * 1.8) + 32);
				$tomorrowsLow = round((($tomorrowsLowK - 273.15) * 1.8) + 32);

				//two days
				$twoDaysWeatherIconCode =  $json['list'][2]['weather'][0]['icon'];
				$twoDaysWeatherIcon = "https://openweathermap.org/img/wn/$twoDaysWeatherIconCode@2x.png";
				$twoDaysHighK = $json['list'][2]['temp']['max'];
				$twoDaysLowK = $json['list'][2]['temp']['min'];
				$twoDaysHumidity = $json['list'][2]['humidity'];
				$twoDaysHigh = round((($twoDaysHighK - 273.15) * 1.8) + 32);
				$twoDaysLow = round((($twoDaysLowK - 273.15) * 1.8) + 32);

				echo("
					<p>
						Today
						<br />
						<img src='$weatherIcon'>
						<br />
						Low: $low &#8457;
						<br />High: $high &#8457;
						<br />$humidity% humidity
					</p>
					<hr>
					<p>
						Tomorrow
						<br />
						<img src='$tomorrowsWeatherIcon'>
						<br />
						Low: $tomorrowsLow &#8457;
						<br />High: $tomorrowsHigh &#8457;
						<br />$tomorrowsHumidity% humidity
					</p>
					<hr>
					<p>
						$twoDaysFromNowDayOfWeekName
						<br />
						<img src='$twoDaysWeatherIcon'>
						<br />
						Low: $twoDaysLow &#8457;
						<br />High: $twoDaysHigh &#8457;
						<br />$twoDaysHumidity% humidity
					</p>

					<p>
						<img src='$companyLogo' style='width: 100%; padding-bottom: 20px;'>
						<span id='clock' style='font-size: 1.5em; text-shadow: 5px -1px 0px #000000;'></span>
					</p>
					

				
				");
			?>
		</div>
	</body>
	<script>
		setInterval(function() { runTheClock(); }, 1000);

		function runTheClock() 
		{
			var d = new Date();
			document.getElementById('clock').innerHTML = d.toLocaleTimeString();
		}
		
	</script>
</html>	



