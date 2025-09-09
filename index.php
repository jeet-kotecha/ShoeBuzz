<?php
	include("function/login.php");
	include("function/customer_signup.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Shoe Buzz</title>
	<link rel="icon" href="img/logo.jpg" />
	<link rel = "stylesheet" type = "text/css" href="css/style.css" media="all">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<script src="js/bootstrap.js"></script>
	<script src="js/jquery-1.7.2.min.js"></script>
	<script src="js/carousel.js"></script>
	<script src="js/button.js"></script>
	<script src="js/dropdown.js"></script>
	<script src="js/tab.js"></script>
	<script src="js/tooltip.js"></script>
	<script src="js/popover.js"></script>
	<script src="js/collapse.js"></script>
	<script src="js/modal.js"></script>
	<script src="js/scrollspy.js"></script>
	<script src="js/alert.js"></script>
	<script src="js/transition.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
	<div id="header">
		<img src="img/logo.jpg">
		<label>Shoe Buzz</label>
			<ul>
				<li><a href="#signup"   data-toggle="modal">Sign Up</a></li>
				<li><a href="#login"   data-toggle="modal">Login</a></li>
			</ul>
	</div>
		<div id="login" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:400px;"> 
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h3 id="myModalLabel">Login...</h3>
			</div>
				<div class="modal-body">
					<form method="post">
					<center>
						<input type="email" name="email" placeholder="Email" style="width:250px;">
						<input type="password" name="password" placeholder="Password" style="width:250px;">
					</center>
				</div>
			<div class="modal-footer">
				<input class="btn btn-primary" type="submit" name="login" value="Login">
				<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close</button>
					</form>
			</div>
		</div>

		<div id="signup" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<h3 id="myModalLabel">Sign Up Here...</h3>
				</div>
					<div class="modal-body">
						<center>
					<form method="post">
						<input type="text" name="firstname" placeholder="Firstname" style="width:430px;" required><br>
						<input type="text" name="mi" placeholder="Middle Initial" style="width:430px;" maxlength="1" required><br>
						<input type="text" name="lastname" placeholder="Lastname" style="width:430px;" required><br>
						<input type="text" name="address" placeholder="Address" style="width:430px;" required><br>
						<input type="text" name="country" placeholder="Country" style="width:430px;" required><br>
						<input type="text" name="pincode" placeholder="Pin Code" style="width:430px;" required maxlength="6"><br>
						<input type="text" name="mobile" placeholder="Mobile Number" style="width:430px;" maxlength="19"><br>
						<input type="email" name="email" placeholder="Email" style="width:430px;" required><br>
						<input type="password" name="password" placeholder="Password" style="width:430px;" required><br>
						</center>
					</div>
				<div class="modal-footer">
					<input type="submit" class="btn btn-primary" name="signup" value="Sign Up">
					<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close</button>
				</div>
					</form>
			</div>
	<br>
<div id="container">
	<div class="nav">
			 <ul>
				<li><a href="index.php"><i class="icon-home"></i>Home</a></li>
				<li><a href="product.php"><i class="icon-th-list"></i>Category</a>
				<li><a href="aboutus.php"><i class="icon-bookmark"></i>About Us</a></li>
				<li><a href="contactus.php"><i class="icon-inbox"></i>Contact Us</a></li>
				<li><a href="privacy.php"><i class="icon-info-sign"></i>Privacy Policy</a></li>
				<li><a href="faqs.php"><i class="icon-question-sign"></i>FAQs</a></li>
			</ul>
	</div>
<div class="hero">
	<div id="carousel">
		<div id="myCarousel" class="carousel slide">
			<div class="carousel-inner">
				<div class="active item" style="padding:0; border-bottom:0 solid #111;"><img src="img/banner1.jpg" class="carousel"></div>
				<div class="item" style="padding:0; border-bottom:0 solid #111;"><img src="img/banner2.jpg" class="carousel"></div>
				<div class="item" style="padding:0; border-bottom:0 solid #111;"><img src="img/banner3.jpg" class="carousel"></div>
			</div>
				<a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
				<a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
		</div>
	</div>

</div>
	<div id="content">
		<div id="product" style="position:relative; margin-top:5%;">
			<center><h2><legend>Feature Items</legend></h2></center>
			<br />
			<?php

				$query = $conn->query("SELECT *FROM product WHERE category='feature' ORDER BY product_id DESC") or die (mysqli_error());

					while($fetch = $query->fetch_array())
						{

						$pid = $fetch['product_id'];

						$query1 = $conn->query("SELECT * FROM stock WHERE product_id = '$pid'") or die (mysqli_error());
						$rows = $query1->fetch_array();

						$qty = $rows['qty'];
						if($qty <= 5){

						}else{
							echo "<div class='float'>";
							echo "<center>";
							echo "<a href='details.php?id=".$fetch['product_id']."'><img class='img-polaroid' src='img/".$fetch['product_image']."' height = '300px' width = '300px'></a>";
							echo " ".$fetch['product_name']."";
							echo "<br />";
							echo "Price ".$fetch['product_price']." Rs.";
							echo "<br />";
							echo "<h3 class='text-info' style='font-size:20px;line-height: 19px;'> Size: ".$fetch['product_size']."</h3>";
							echo "</center>";
							echo "</div>";
						}
						}
			?>
		</div>
	</div>
	<br />
</div>
	<br />
	<div id="footer">
		<div class="ufooter">
				<div class="footer-first">
				<img src="img/logo.jpg">
				<p>Made For Your Every Step.</p>
				</div>	
				<div class="footer-second">
				<ul>
					<li><a href="faqs.php">PRE-SALE FAQS</a></li>
					<li><a href="contactus.php">CONTECT US</a></li>
					<li><a href="privacy.php">PRIVACY POLICY</a></li>
					<li><a href="aboutus.php">ABOUT US</a></li>
				</ul>
				</div>
				<div class="footer-third">
				<ul>
					<li>EXPLOER Footwear For :</li>
					<li><a href="product.php">Mens</a></li>
					<li><a href="Women.php">Womens</a></li>
					<li><a href="Kids.php">Kids</a></li>
				</ul>
				</div>
<!-- 				
			<div class="footer-fourth">
				<ul>
					<li>LOCATION :</li>
					<li></li>
					<li></li>
					<li></li>
				</ul>
			</div>
			 -->
			<div class="footer-fifth">
			<ul>
				<li>CONTECT US :</li>
				<li><a href="https://www.facebook.com"><i class="fa-brands fa-facebook"></i>    Facebook</a></li>
				<li><a href="https://www.instagram.com"><i class="fa-brands fa-instagram"></i>    Instagram</a></li>
				<li><a href="https://twitter.com/"><i class="fa-brands fa-x-twitter"></i>    x-twitter</a></li>
			</ul>
		</div>
					</div>
		<div class="foot">
			<p style="font-size:13px;"> Copyright &copy; Shoe Buzz Inc. 2025 Brought To You by <b>Prem & Jeet</b></p>
		</div>		
	</div>
</body>
</html>
