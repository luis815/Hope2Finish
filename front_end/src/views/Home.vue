<template>
    <head>
    <title>Kyros Home</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="A video website for content creators."> 
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    
</head>
    
<body>
	<h1>Kyros</h1>
	<div class="topnav">
        <input type="text" placeholder="Search..">
    </div>
	<div class = "rightnav">
		Welcome KyrosUser!
	</div>
	<div class = "subscriptions">
		Subscriptions
	</div>
    <div id="container">
        
        <div id="videos">
        
            <a data="I7LJIuB2CHE"></a>
            <a data="ctx4YBEdOxo"></a>
            <a data="vMPR7k9DWlw"></a>
            <a data="u5V_VzRrSBI"></a>
            
        </div>
    </div>
    
    <div id="overlay">
        <div class="modal">
            <i class="fa fa-close" id="close"></i>
            <div id="loader"></div>
            <p>Comments</p>
			<textarea input type="text" placeholder="Enter Comment" rows="4" cols="50"></textarea><br><br>
			<input type="submit" value="Submit"/>
			<div id="share">
                <a id="twitter" target="_blank" href=""><i class="fa fa-twitter"></i></a>
                <a id="pinterest" target="_blank" href=""><i class="fa fa-pinterest"></i>
                <a id="facebook" target="_blank" href=""><i class="fa fa-facebook"></i></a>
                <a id="googleplus" target="_blank" href=""><i class="fa fa-google-plus"></i></a>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="scripts.js"></script>
</body>
</template>

<script>
    export default {
        name: "Kyros Home"
    }
	$(document).ready(function() {
		$('#videos a').each(function() {
			var data = $(this).attr('data');
			$(this).append('<img src="http://img.youtube.com/vi/'+data+'/maxresdefault.jpg" />');
		});
		
		$('#videos a').click(function() {
			var data = $(this).attr('data');
			$('#loader').append('<iframe width="560" height="315" src="https://www.youtube.com/embed/'+data+'" frameborder="0" allowfullscreen></iframe>');     
			$('#facebook').attr('href','http://www.facebook.com/sharer.php?u=https://www.youtube.com/watch?v='+data);
			$('#twitter').attr('href','http://twitter.com/home?status=https://www.youtube.com/watch?v='+data);
			$('#googleplus').attr('href','https://plus.google.com/share?url='+data);
			$('#pinterest').attr('href','http://pinterest.com/pin/create/button/?url='+data);
			$('#overlay').fadeIn(250);  
		});
		
		$('#close').click(function() {
		   $('#overlay').fadeOut(250,function() {
			  $('#loader').html(''); 
		   });
		});
	});

</script>

<style scoped>
    h1 {
    font: bold 30px/50px "Trebuchet", sans-serif; 
    text-align: center;
    padding-bottom: 5px;
	}
	body {
		text-align: center;
	}
	.subscriptions {
		font: bold 30px/50px "Trebuchet", sans-serif;
		margin: 2% 0 -5% 0;
	}
	.leftcolDiv {
		float: left;
		margin: 0 1% 1% 10%;
		padding: 1%;
		width: 39%;
	}
	.rightcolDiv {
		float: right;
		margin: 0% -5% 1% 1%;
		padding: 1%;
		width: 39%;
	}
	.topnav input[type=text] {
		padding: 6px;
		border: solid;
		margin: -50% 0 0 0%;
		font-size: 17px;
		width: 30%;
	}
	.rightnav{
		float: right;
		margin: -5% 1% 0 0; /*top right down left*/
		font-size: 120%;
	}
	.innerdiv {
		border: 5px outset;
		box-shadow : 2px 10px 10px #888888;
		margin: 1% -10% 1% 15%;
		padding: 7%;
		width: 50%
	}
	#container {
		max-width: 100%;
		margin: 50px auto;
	}

	#videos a {
		display: block;
		width: 23%;
		margin: 2% 1%;
		float: left;
		cursor: pointer;
		text-decoration: none;
		outline: 0;
	}

	#videos a:hover {
		opacity: 0.7;   
	}

	#videos a img { 
		width: 100%;
		height: auto;
	}

	#overlay {
		-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#80000000, endColorstr=#80000000)"; 
		background: rgba(0,0,0, 0.8); 
		position:fixed; 
		top: 0; 
		right: 0; 
		left:0; 
		bottom: 0; 
		width: 100%; 
		height: 100%; 
		z-index: 99999; 
		display: none;
		overflow-y:auto;
	}

	#overlay .modal {
		background: #fff;
		box-shadow: 0px 0px 8px rgba(0,0,0,0.9);
		border-radius: 5px;
		width: 90%;
		margin: 100px auto;
		max-width: 800px;
		min-height: 100px;
		position: relative;
		padding: 30px 20px 15px;
	}

	#overlay .modal #close {
		color: #333;
		position: absolute;
		top: 5px;
		right: 5px;
		cursor: pointer;
	}

	#overlay .modal #close:hover {
		color: #666; 
	}

	#overlay iframe {
		width: 100%;
		height: 400px;
	}

	#overlay #share { 
		margin: 15px 0 0 0;
	}

	#overlay #share i {
		color: #fff;
		text-align: center; 
		background: #333;
		border-radius: 250px;
		padding: 5px;
		width: 16px;
	}

	#overlay #share i:hover {
		background: #666;   
	}

	#overlay #share a {
		text-decoration: none;   
	}
</style>