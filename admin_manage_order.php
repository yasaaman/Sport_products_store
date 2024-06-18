<?php
include ("includes/header.php");

if (!(isset($_SESSION["state_login"]) && $_SESSION["state_login"] === true && $_SESSION["user_type"] == "admin")) {
    echo '<script type="text/javascript">location.replace("index.php");</script>';
    exit();
}

$link = mysqli_connect("localhost", "root", "", "shop_db");

if (mysqli_connect_errno()) {
    exit("خطاي زير رخ داده است :" . mysqli_connect_error());
}
?>

<br />

<?php
$query = "SELECT * FROM orders";
$result = mysqli_query($link, $query);
?>

<table border="1px" style="width: 100%;">
    

<?php
while ($row = mysqli_fetch_array($result)) {
?>
	<tr bgcolor="#C7CAF1">
        <td>كد سفارش</td>
        <td>نام خریدار</td>
        <td>نام محصول</td>
        <td>تاریخ سفارش</td>
        <td>تعداد سفارش</td>
        <td>قيمت كالا</td>
        <td>قیمت نهایی</td>
    </tr>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td>
            <?php
            $query = "SELECT * FROM users WHERE username='{$row['username']}'";
            $result2 = mysqli_query($link, $query);
            if ($row_user = mysqli_fetch_array($result2)) {
                echo $row_user['realname'];
            } else {
                echo "نامشخص"; 
            }
            ?>
        </td>
        <td>
            <?php
            $query = "SELECT * FROM products WHERE pro_code='{$row['pro_code']}'";
            $result2 = mysqli_query($link, $query);
            if ($row_product = mysqli_fetch_array($result2)) {
                echo $row_product['pro_name'];
            } else {
                echo "نامشخص"; 
            }
            ?>
        </td>
        <td><?php echo $row['orderdate']; ?></td>
        <td><?php echo $row['pro_qty']; ?></td>
        <td><?php echo $row['pro_price']; ?>&nbsp; ريال</td>
        <td><?php echo $row['pro_qty'] * $row['pro_price']; ?>&nbsp; ريال</td>
    </tr>
    <tr bgcolor="#C7CAF1">
        <td>شماره تماس</td>
        <td>آدرس</td>
        <td>کد مرسوله پستی</td>
        <td>وضعیت سفارش</td>
    </tr>
    <tr>
        <td><?php echo $row['mobile']; ?></td>
        <td><?php echo $row['address']; ?></td>
        <td><?php echo $row['trackcode']; ?></td>
        <td>
            <?php 
            switch ($row['state']) {
                case 0: echo "تحت بررسی"; break;
                case 1: echo "آماده برای ارسال"; break;
                case 2: echo "ارسال شده"; break;
                case 3: echo "سفارش لغو شده است"; break;
            }
            ?>
        </td>
    </tr>
    <tr bgcolor="#FFED00" style="height: 10px;">
        <td colspan="7"></td>
    </tr>
<?php
}
?>
</table>

<?php
include ("includes/footer.php");
?>
