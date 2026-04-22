<html>
<head>
	<title>Puja Details</title>
	<style type="text/css">
		.head{
			display: flex;
			justify-content: center;
			align-items: center;
			flex-direction: column;
			width:100%;
			height:70%;
			background: url('image/puja/V1.jpg');
			background-size:cover;
			background-position: center;
		}

		.head h1{
			color:white;
			font-size:70px;
			text-align:center;
			letter-spacing:10px;
			margin-top:30px;
			padding:20px 0 20px 0;
		}
		.head .search-box{
			display:flex; 
			justify-content:center;
		}
		.search-box input{
			background:transparent;
			width:300px;
			height:40px;
			border-radius:7px;
			border:2px solid white;
			margin-right:0;
			padding:10px;
			color:white;
		}
		.search-box input[type=text]{
			font-size:20px;
			color:white;
		}
		.search-box button{
			color:white;
			margin-left:0;
			border-radius:7px;
			border:2px solid white;
			width:40px;
			height:40px;
			background:transparent;
		}
		.search-box button:hover{
			cursor:pointer;
			color:white;
			background:#00000094;
		}
		.heading{ 
			margin: 20px 0 20px 0;
			text-align: center;
			font-size: 30px;
			font-weight: 800;
			color: black;
		}
		.heading:hover{
			cursor: pointer;
			text-decoration-line: underline;
			transition: all 0.5 ease;
		}
		
	</style>
</head>
<body>
	<?php include 'inc/header.php'; ?>
	<?php 
		if(!isset($_GET['id']))
		{
			redirect('booking.php');
		}
		$data = filteration($_GET);
		$puja_res= select("SELECT * FROM `puja` WHERE `id`=?",[$data['id']],'i');
		if(mysqli_num_rows($puja_res)==0)
		{
			redirect('booking.php');
		}
		$puja_data= mysqli_fetch_assoc($puja_res);
	?>
	<div class="g-head">
		<h3>Puja<span>Details</span></h3>
	</div>	
	<div class="puja-cont">
		<div class="s-nav">
			<a href="home.php">Home</a><span>>>></span><a href="booking.php">Booking</a>
		</div>
		<div class="puja-box">
			<?php
				$login=0;
					if(isset($_SESSION['login']) && $_SESSION['login']==true)
					{
						$login=1;
					}
				$path=PUJA_IMG_PATH;
				
				echo<<<data
					<div class="p-d-card wd-40">
						<img src="$path$puja_data[image]">
					</div>
					<div class="p-d-card wd-60">
						<h3>$puja_data[puja_name]</h3>
						<p class="pj-head">Dakshina</p> <p class="pj-val"><span>&#8377;</span> $puja_data[price]</p>
						<p class="pj-head">Samagri</p> <p class="pj-val"><span>&#8377;</span> $puja_data[samagri]</p>
						<p class="pj-head">Duration</p> <p class="pj-val">$puja_data[duration]</p>
						<p class="pj-head">Description</p>
						<p class="pj-val">$puja_data[description]</p>
						<button class="p-btn" onclick="checkLogin($login,$puja_data[id])">Book Now</button>
					</div>
				data;
			?>
		</div>
		<div class="puja-box">        
		</div>
	</div>
	<?php include 'inc/footer.php'?>
</body>
</html>