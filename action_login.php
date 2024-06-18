<?php
include ("includes/header.php");  

	
if ((isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) &&
    !empty($_POST['password']))) {

    $username = $_POST['username']; 
    $password = $_POST['password'];  
} else
    exit("برخی از فیلد ها مقدار دهی نشده است");


$link = mysqli_connect("localhost", "root", "", "shop_db");

if (mysqli_connect_errno())
    exit("خطاي با شرح زير رخ داده است :" . mysqli_connect_error());


$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = mysqli_query($link, $query);  

$row = mysqli_fetch_array($result);  

if ($row) {
    $_SESSION["state_login"] = true;
    $_SESSION["realname"] = $row['realname'];
   
    $_SESSION["username"] = $row['username'];


    if ($row["type"] == 0)
        $_SESSION["user_type"] = "public";
        
    elseif ($row["type"] == 1) {
        $_SESSION["user_type"] = "admin";

?>

<script type="text/javascript">
<!--
location.replace("admin_products.php");	
-->
</script> 
   
<?php
    } 

    echo ("<p style='color:green; text-align:center; '><b>{$row['realname']} به فروشگاه ايرانيان خوش آمديد</b></p>");
} else
    echo ("<p style='color:red;lign:center; text-align:center;'><b>نام كاربري يا كلمه عبور يافت نشد</b></p>");


mysqli_close($link);   

include ("includes/footer.php"); 
?>
