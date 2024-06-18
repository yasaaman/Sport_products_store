<?php
session_start();
?>
<!doctype html>
<html lang="fa">
<head>
    <meta charset="utf-8">
    <title> فروشگاه محصولات ورزشی ایرانیان</title>
    <!--<link href="css/style.css" rel="stylesheet" type="text/css">-->
    <style>
        
body {
	font-family: 'b nazanin', sans-serif;
	margin: 0;
	padding: 0;
	background-color: #f3e5f5 ;
	direction: rtl;
}

.header {
	background-color: #8e24aa; 
	color: #fff;
	padding: 15px;
	text-align: center;
}

.header .logo {
	font-size: 24px;
}

nav {
	background-color: #ab47b; 

}

.nav-menu {
	list-style: none;
	padding: 0;
	margin: 0;
	display: flex;
	justify-content: center;
	align-items: center;	
    background-color:# ; 

}

.nav-menu li {
	margin: 0 10px;
}

.nav-menu li a {
	display: block;
	color: #000;
	text-decoration: none;
	padding: 10px 20px;
	transition: background-color 0.3s, color 0.3s;
	border-radius: 5px;
}

.nav-menu li a:hover {
	background-color: #ce93d8; 
	color: #fff;
}

.container {
	padding: 20px;
	text-align: center;

}

.footer {
	background-color: #8e24aa; 
	color: #fff;
	text-align: center;
	padding: 10px 0;
	position: fixed;
	bottom: 0;
	width: 100%;
}

</style>
</head>

<body dir="rtl">
    <header class="header">
        <div class="logo">به فروشگاه ایرانیان خوش آمدید</div>
    </header>
    <nav>
        <ul class="nav-menu">
            <li><a class="set_style_link" href="index.php">صفحه اصلی</a></li>
            <li><a class="set_style_link" href="register.php">عضویت در سایت</a></li>
            <?php
            if (isset($_SESSION["state_login"]) && $_SESSION["state_login"] === true) {
            ?>
                <li><a class="set_style_link" href="logout.php">خروج از سایت<?php echo(" ({$_SESSION['realname']}) ") ?></a></li>
            <?php
            } else {
            ?>
                <li><a class="set_style_link" href="login.php">ورود به سایت</a></li>
            <?php
            }
            ?>
            <li><a class="set_style_link" href="site_info.php">درباره ما</a></li>
            <?php
            if (isset($_SESSION["state_login"]) && $_SESSION["state_login"] === true && $_SESSION["user_type"] == "admin") {
            ?>
                <li><a class="set_style_link" href="admin_products.php">مدیریت محصولات</a></li>
                <li><a class="set_style_link" href="admin_manage_order.php">مدیریت سفارشات</a></li>
            <?php
            }
            ?>
        </ul>
    </nav>
</body>
</html>
