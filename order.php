<?php
include("includes/header.php");

$link = mysqli_connect("localhost", "root", "", "shop_db");

if (mysqli_connect_errno())
    exit("خطای زیر رخ داده است :" . mysqli_connect_error());

$pro_code = 0;
if (isset($_GET['id']))
    $pro_code = $_GET['id'];

if (!(isset($_SESSION["state_login"]) && $_SESSION["state_login"] === true)) {
?>
    <div class="message-container" style="text-align: center;">
        <span class='warning'><b>برای خرید پستی محصول انتخاب شده باید وارد سایت شوید</b></span>
        <br/><br/>
        درصورتی که عضو فروشگاه هستید برای ورود
        <a href='login.php' class='link-blue'><b>اینجا</b></a>
        کلیک کنید
        <br/>
        و در صورتی که عضو نیستید برای ثبت نام در سایت
        <a href='register.php' class='link-green'><b>اینجا</b></a>
        کلیک کنید
        <br /><br />
    </div>
<?php
    exit();
}

$query = "SELECT * FROM products WHERE pro_code='$pro_code'";
$result = mysqli_query($link, $query);

?>

<style>
    .form-container {
        width: 100%;
        border-collapse: collapse;
    }

    .form-container, .form-container td {
        border: 1px solid #ddd;
    }

    .form-container td {
        padding: 10px;
    }

    .message-container {
        padding: 20px;
        text-align: center;
    }

    .warning {
        color: red;
        font-weight: bold;
    }

    .link-blue {
        text-decoration: none;
        color: blue;
    }

    .link-green {
        text-decoration: none;
        color: green;
    }

    .input-readonly {
        background-color: lightgray;
        text-align: right;
        width: 100%;
        padding: 5px;
    }

    .input-editable {
        text-align: left;
        width: 100%;
        padding: 5px;
    }

    .button-submit {
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
        text-align: center;
    }

    .button-submit:hover {
        background-color: #45a049;
    }

    .product-details {
        border-style: dotted dashed;
        vertical-align: top;
        width: 33%;
        text-align: center;
        padding: 10px;
    }

    .product-details h4 {
        color: brown;
    }

    .product-details img {
        width: 200px;
        height: 120px;

    }

    .product-details span {
        color: green;
    }
</style>

<form name="order" action="action_order.php" method="POST">
    <table class="form-container">
        <tr>
            <td style="width: 60%;">
                <?php
                if ($row = mysqli_fetch_array($result)) {
                ?>
                    <table style="width: 100%;" border="0">
                        <tr>
                            <td style="width: 22%;">کد کالا <span style="color: red;">*</span></td>
                            <td style="width: 78%;"><input type="text" id="pro_code" name="pro_code" value="<?php echo ($pro_code); ?>" class="input-readonly" readonly /></td>
                        </tr>
                        <tr>
                            <td>نام کالا <span style="color: red;">*</span></td>
                            <td><input type="text" id="pro_name" name="pro_name" value="<?php echo ($row['pro_name']); ?>" class="input-readonly" readonly /></td>
                        </tr>
                        <tr>
                            <td>تعداد یا مقدار درخواستی <span style="color: red;">*</span></td>
                            <td><input type="text" id="pro_qty" name="pro_qty" class="input-editable" onchange="calc_price();" /></td>
                        </tr>
                        <tr>
                            <td>قیمت واحد کالا<span style="color: red;">*</span></td>
                            <td><input type="text" id="pro_price" name="pro_price" value="<?php echo ($row['pro_price']); ?>" class="input-readonly" readonly />ریال</td>
                        </tr>
                        <tr>
                            <td>مبلغ قابل پرداخت <span style="color: red;">*</span></td>
                            <td><input type="text" id="total_price" name="total_price" value="0" class="input-readonly" readonly />ریال</td>
                        </tr>
                        <script type="text/javascript">
                            function calc_price() {
                                var pro_qty = <?php echo ($row['pro_qty']); ?>;
                                var price = document.getElementById('pro_price').value;
                                var count = document.getElementById('pro_qty').value;
                                var total_price;

                                if (count > pro_qty) {
                                    alert('تعداد موجودی انبار کمتر از درخواست شما است!!');
                                    document.getElementById('pro_qty').value = 0;
                                    count = 0;
                                }

                                if (count == 0 || count == '')
                                    total_price = 0;
                                else
                                    total_price = count * price;

                                document.getElementById('total_price').value = total_price;
                            }
                        </script>
                        <?php
                        $query = "SELECT * FROM users WHERE username='{$_SESSION['username']}'";
                        $result = mysqli_query($link, $query);
                        $user_row = mysqli_fetch_array($result);
                        ?>
                        <tr>
                            <td>نام خریدار <span style="color: red;">*</span></td>
                            <td><input type="text" id="realname" name="realname" value="<?php echo ($user_row['realname']); ?>" class="input-readonly" readonly /></td>
                        </tr>
                        <tr>
                            <td>پست الکترونیکی <span style="color: red;">*</span></td>
                            <td><input type="text" id="email" name="email" value="<?php echo ($user_row['email']); ?>" class="input-readonly" readonly /></td>
                        </tr>
                        <tr>
                            <td>شماره تلفن همراه <span style="color: red;">*</span></td>
                            <td><input type="text" id="mobile" name="mobile" value="09" class="input-editable" /></td>
                        </tr>
                        <tr>
                            <td>آدرس دقیق پستی جهت دریافت محصول <span style="color: red;">*</span></td>
                            <td><textarea id="address" name="address" class="input-editable" cols="30" rows="3" wrap="virtual"></textarea></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="button" value="خرید محصول" class="button-submit" onclick="check_input();" /></td>
                        </tr>
                    </table>
            </td>
            <td>
                <script type="text/javascript">
                    function check_input() {
                        var r = confirm("از صحت اطلاعات وارد شده اطمینان دارید؟");
                        if (r == true) {
                            var validation = true;
                            var count = document.getElementById('pro_qty').value;
                            var mobile = document.getElementById('mobile').value;
                            var address = document.getElementById('address').value;

                            if (count == 0 || count == '')
                                validation = false;

                            if (mobile.length < 11)
                                validation = false;

                            if (address.length < 15)
                                validation = false;

                            if (validation)
                                document.order.submit();else
                                alert('برخی از ورودی های فرم سفارش محصول به درستی پر نشده‌اند');
                        }
                    }
                </script>
                <div class="product-details">
                    <h4><?php echo ($row['pro_name']) ?></h4>
                    <img src="images/products/<?php echo ($row['pro_image']) ?>" alt="Product Image" />
                    <p>قیمت واحد: <?php echo ($row['pro_price']) ?> ریال</p>
                    <p>مقدار موجودی: <span style="color: red;"><?php echo ($row['pro_qty']) ?></span></p>
                    <p>توضیحات: <span><?php 
                        $count = strlen($row['pro_detail']);
                        echo (substr($row['pro_detail'], 0, (int)($count / 4))); 
                    ?>...</span></p>
                </div>
            </td>
        </tr>
    </table>
</form>
<?php
}

include("includes/footer.php");
?>