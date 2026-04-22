<html>
<head>
	<title>Booking page</title>
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
		
	</style>
</head>
<body>
	<?php include 'inc/header.php'; ?>
	<div class="head">
		<h1>Booking</h1>
	</div>
	<h1 class="heading"> Book Your Puja Now</h1>
	<div class="container">
		<?php

			$login=0;
			if(isset($_SESSION['login']) && $_SESSION['login']==true)
            {
				$login=1;
			}
			$details = selectAll('puja');
			$path=PUJA_IMG_PATH;
			while($row=mysqli_fetch_assoc($details))
			{
				echo<<<data
					<div class="card">
						<div class="card-img">
							<img src="$path$row[image]">
						</div>
						<h2>$row[puja_name]</h2>
						<p class="price"><span>&#8377;</span>$row[price]</p>
						<p class="puja-desc">$row[description]</p>
						<div class="btn"><button class="b-btn" onclick="checkLogin($login,$row[id])">Book Now</button><a href="puja_details.php?id=$row[id]">More Details</a></div>
					</div>
				data;
			}
		?>
	</div>
	<?php include 'inc/footer.php'?>
</body>
</html>