<html>
<head>
	<title>Ticker</title>
	<script type="text/javascript" src="https://code.jquery.com/jquery-latest.js"></script>
  <style>
     .marquee {
          width: 100%;
          height: 95%;
          overflow: hidden;
          position: relative;
          border: 1px solid #000;
         
          background-color: #222;
         
          -webkit-border-radius: 5px;
          border-radius: 5px;
         
          -webkit-box-shadow: inset 0px 2px 2px rgba(0, 0, 0, .5), 0px 1px 0px rgba(250, 250, 250, .2);
          box-shadow: inset 0px 2px 2px rgba(0, 0, 0, .5), 0px 1px 0px rgba(250, 250, 250, .2);
    }
    .marquee p {
          position: absolute;
          font-family: Tahoma, Arial, sans-serif;
          width: 100%;
          font-size: 2.5vw;
          margin: 0;
          line-height: 50px;
          text-align: center;
          color: #fff;
          text-shadow: 1px 1px 0px #000000;
          filter: dropshadow(color=#000000, offx=1, offy=1);
    }
    .marquee p {
          transform:translateX(100%);
    }
    @keyframes left-one {
0% { transform:translateX(100%); }
1% { transform:translateX(0); }
9% { transform:translateX(0); }
10%{ transform:translateX(-100%); }
100%{ transform:translateX(-100%); }
}

@keyframes left-two {
10% { transform:translateX(100%); }
11% { transform:translateX(0); }
19% { transform:translateX(0); }
20%{ transform:translateX(-100%); }
100%{ transform:translateX(-100%); }
}

@keyframes left-three {
20% { transform:translateX(100%); }
21% { transform:translateX(0); }
29% { transform:translateX(0); }
30%{ transform:translateX(-100%); }
100%{ transform:translateX(-100%); }
}

@keyframes left-four {
30% { transform:translateX(100%); }
31% { transform:translateX(0); }
39% { transform:translateX(0); }
40%{ transform:translateX(-100%); }
100%{ transform:translateX(-100%); }
}

@keyframes left-five {
40% { transform:translateX(100%); }
41% { transform:translateX(0); }
49% { transform:translateX(0); }
50%{ transform:translateX(-100%); }
100%{ transform:translateX(-100%); }
}

@keyframes left-six {
50% { transform:translateX(100%); }
51% { transform:translateX(0); }
59% { transform:translateX(0); }
60%{ transform:translateX(-100%); }
100%{ transform:translateX(-100%); }
}

@keyframes left-seven {
60% { transform:translateX(100%); }
61% { transform:translateX(0); }
69% { transform:translateX(0); }
70%{ transform:translateX(-100%); }
100%{ transform:translateX(-100%); }
}

@keyframes left-eight {
70% { transform:translateX(100%); }
71% { transform:translateX(0); }
79% { transform:translateX(0); }
80%{ transform:translateX(-100%); }
100%{ transform:translateX(-100%); }
}

@keyframes left-nine {
80% { transform:translateX(100%); }
81% { transform:translateX(0); }
89% { transform:translateX(0); }
90%{ transform:translateX(-100%); }
100%{ transform:translateX(-100%); }
}

@keyframes left-ten {
90% { transform:translateX(100%); }
91% { transform:translateX(0); }
99% { transform:translateX(0); }
100%{ transform:translateX(-100%); }
}

.marquee p:nth-child(1) {
animation: left-one 60s ease infinite;
}
.marquee p:nth-child(2) {
animation: left-two 60s ease infinite;
}
.marquee p:nth-child(3) {
animation: left-three 60s ease infinite;
}
.marquee p:nth-child(4) {
animation: left-four 60s ease infinite;
}
.marquee p:nth-child(5) {
animation: left-five 60s ease infinite;
}
.marquee p:nth-child(6) {
animation: left-six 60s ease infinite;
}
.marquee p:nth-child(7) {
animation: left-seven 60s ease infinite;
}
.marquee p:nth-child(8) {
animation: left-eight 60s ease infinite;
}
.marquee p:nth-child(9) {
animation: left-nine 60s ease infinite;
}
.marquee p:nth-child(10) {
animation: left-ten 60s ease infinite;
}
  </style>
</head>

<body>

<?php 

	$ch = curl_init("https://www.newsmax.com/rss/Newsfront/16/");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_CAINFO, 'cacert.pem');

	$data = curl_exec($ch);
	//var_dump( $data );
	curl_close($ch);

	$doc = new SimpleXmlElement($data, LIBXML_NOCDATA);
	
	echo("<div class='marquee'>");
	

	foreach ($newsArray as $item) 
	{
		echo '<p>'. $item . '</p>';
	} 

	 echo("</div>");


 

?>

</body>
</html>
