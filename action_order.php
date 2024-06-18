<?php
include("includes/header.php");

if (!(isset($_SESSION["state_login"]) && $_SESSION["state_login"] === true)) {
?>
    <script type="text/javascript">
        <!--
        location.replace("index.php");
        -->
    </script>
<?php
    exit();
}

$pro_code = $_POST['pro_code'];
$pro_name = $_POST['pro_name'];
$pro_qty = $_POST['pro_qty'];
$pro_price = $_POST['pro_price'];
$total_price = $_POST['total_price'];

$realname = $_POST['realname'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$address = $_POST['address'];
$username = $_SESSION['username'];

$link = mysqli_connect("localhost", "root", "", "shop_db");

if (mysqli_connect_errno()) {
    exit("خطاي با شرح زير رخ داده است :" . mysqli_connect_error());
}

$query = "INSERT INTO orders 
    (id,
     username,
     orderdate,
     pro_code,
     pro_qty,
     pro_price,
     mobile,
     address,
     trackcode,
     state
     ) VALUES
      ('0',
       '$username',
       '" . date('y-m-d') . "',
       '$pro_code',
       '$pro_qty',
       '$pro_price',
       '$mobile',
       '$address',
       '000000000000000000000000',
       '0')";

if (mysqli_query($link, $query) === true) {
    echo "<div style='width: 80%; margin: 20px auto; padding: 15px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);'>";
    echo "<p style='color:green;'><b>سفارش شما با موفقیت در سامانه ثبت شد</b></p>";
    echo "<p style='color:brown;'><b>کاربر گرامی آقا/خانم $realname</b></p>";
    echo "<p style='color:brown;'><b>محصول $pro_name با کد $pro_code به تعداد/مقدار $pro_qty با قیمت پایه $pro_price ریال را سفارش داده‌اید</b></p>";
    echo "<p style='color:red;'><b>مبلغ قابل پرداخت برای سفارش ثبت شده $total_price ریال است</b></p>";
    echo "<p style='color:blue;'><b>پس از بررسی سفارش و تایید آن با شما تماس گرفته خواهد شد</b></p>";
    echo "<p style='color:blue;'><b>محصول خریداری شده از طریق پست جمهوری اسلامی ایران طبق آدرس درج شده ارسال خواهد شد</b></p>";
    echo "<p style='color:blue;'><b>در هنگام تحویل گرفتن محصول آن را بررسی و از صحت و سالم بودن آن اطمینان حاصل کنید سپس مبلغ کالا را طبق فاکتور ارائه شده به مامور پست تحویل دهید</b><br/><br/></p>";
    echo "</div>";

    $query_update = "UPDATE products SET pro_qty = pro_qty - $pro_qty WHERE pro_code = '$pro_code'";
    mysqli_query($link, $query_update);

} else {
    echo "<p style='color:red;'><b>خطا در ثبت سفارش</b></p>";
}

mysqli_close($link);
include("includes/footer.php");
?>
