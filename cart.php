<?php
include("function/session.php");
include("db/dbconn.php");

// ---- ACTION HANDLER ----
$id     = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case "add":
        if ($id > 0) {
            if (isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id]++;
            } else {
                $_SESSION['cart'][$id] = 1;
            }
        }
        header("Location: cart.php"); // prevent refresh issue
        exit();

    case "remove":
        if ($id > 0 && isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]--;
            if ($_SESSION['cart'][$id] <= 0) {
                unset($_SESSION['cart'][$id]);
            }
        }
        header("Location: cart.php");
        exit();

    case "empty":
        unset($_SESSION['cart']);
        header("Location: cart.php");
        exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Shoe Buzz</title>
    <link rel="icon" href="img/logo.jpg" />
    <link rel="stylesheet" type="text/css" href="css/style.css" media="all">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="js/jquery-1.7.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
<div id="header">
    <img src="img/logo.jpg">
    <label>Shoe Buzz</label>
    <?php
    $uid   = (int)$_SESSION['id'];
    $query = $conn->query("SELECT * FROM customer WHERE customerid = '$uid'") or die(mysqli_error($conn));
    $fetch = $query->fetch_array();
    ?>
    <ul>
        <li><a href="function/logout.php"><i class="icon-off icon-white"></i>Logout</a></li>
        <li>Welcome: <a href="#profile" data-toggle="modal"><i class="icon-user icon-white"></i><?php echo $fetch['firstname'] . " " . $fetch['lastname']; ?></a></li>
    </ul>
</div>

<br>
<div id="container">
    <div class="nav">
        <ul>
            <li><a href="home.php"><i class="icon-home"></i>Home</a></li>
            <li><a href="product1.php"><i class="icon-th-list"></i>Category</a></li>
            <li><a href="aboutus1.php"><i class="icon-bookmark"></i>About Us</a></li>
            <li><a href="contactus1.php"><i class="icon-inbox"></i>Contact Us</a></li>
            <li><a href="privacy1.php"><i class="icon-info-sign"></i>Privacy Policy</a></li>
            <li><a href="faqs1.php"><i class="icon-question-sign"></i>FAQs</a></li>
        </ul>
    </div>

    <form method="post" class="well" style="background-color:#fff;">
        <table class="table">
            <label style="font-size:25px;">My Cart</label>
            <tr>
                <th><h3>Image</h3></th>
                <th><h3>Product Name</h3></th>
                <th><h3>Size</h3></th>
                <th><h3>Quantity</h3></th>
                <th><h3>Price</h3></th>
                <th><h3>Add</h3></th>
                <th><h3>Remove</h3></th>
                <th><h3>Subtotal</h3></th>
            </tr>
            <?php
            if (!empty($_SESSION['cart'])) {
                $total = 0;
                foreach ($_SESSION['cart'] as $id => $qty) {
                    $result = $conn->query("SELECT * FROM product WHERE product_id=$id");
                    $row    = $result->fetch_assoc();

                    $name         = substr($row['product_name'], 0, 40);
                    $price        = (float)str_replace(",", "", $row['product_price']); // fix numeric issue
                    $image        = $row['product_image'];
                    $product_size = $row['product_size'];
                    $line_cost    = $price * (int)$qty;
                    $total       += $line_cost;

                    echo "<tr>";
                    echo "<td><img height='70' width='70' src='img/$image'></td>";
                    echo "<td><input type='hidden' value='$id' name='pid[]'> $name</td>";
                    echo "<td>$product_size</td>";
                    echo "<td><input type='hidden' value='$qty' name='qty[]'> $qty</td>";
                    echo "<td>$price</td>";
                    echo "<td><a href='cart.php?id=".$id."&action=add'><i class='icon-plus-sign'></i></a></td>";
                    echo "<td><a href='cart.php?id=".$id."&action=remove'><i class='icon-minus-sign'></i></a></td>";
                    echo "<td><strong>Price: $line_cost</strong></td>";
                    echo "</tr>";
                }

                echo "<tr>";
                echo "<td colspan='4'></td>";
                echo "<td><h2>TOTAL:</h2></td>";
                echo "<td colspan='2'><input type='hidden' value='$total' name='total'><h2 class='text-danger'>Price : $total</h2></td>";
                echo "<td><a class='btn btn-danger btn-sm pull-right' href='cart.php?action=empty'><i class='fa fa-trash-o'></i> Empty cart</a></td>";
                echo "</tr>";
            } else {
                echo "<tr><td colspan='8' class='alert alert-error text-center'>Cart is empty</td></tr>";
            }
            ?>
        </table>

        <div class='pull-right'>
            <a href='home.php' class='btn btn-inverse btn-lg'>Continue Shopping</a>
            <?php
            if (!empty($_SESSION['cart'])) {
                echo "<button name='pay_now' type='submit' class='btn btn-inverse btn-lg'>Purchase</button>";
                include("function/paypal.php");
            }
            ?>
        </div>
    </form>
</div>

<br>
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
					<li><a href="product.php">Footwear For Men</a></li>
					<li><a href="Women.php">Footwear For Women</a></li>
					<li><a href="Kids.php">Footwear For Kids</a></li>
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
    
    <div class="foot">
        <p style="font-size:13px;">Copyright &copy; Shoe Buzz Inc. 2025 Brought To You by <b>Prem & Jeet</b></p>
    </div>
</div>
</body>
</html>