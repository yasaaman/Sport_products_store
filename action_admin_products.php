<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدیریت محصولات</title>
    <style>
        body {
            font-family: 'Tahoma', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        form {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form input[type="text"], form textarea, form input[type="file"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 14px;
        }

        form input[type="submit"], form input[type="reset"] {
            padding: 10px 20px;
            margin: 10px 5px 0 0;
            font-size: 14px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
        }

        form input[type="submit"]:hover, form input[type="reset"]:hover {
            background-color: #45a049;
        }

        form img {
            display: block;
            margin-top: 10px;
            max-width: 100%;
            height: auto;
        }

        .error-message {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }

        .success-message {
            color: green;
            font-weight: bold;
            margin-top: 10px;
        }

        .edit-success {
            color: green;
            font-weight: bold;
        }

        .edit-error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<?php include("includes/header.php"); ?>

<?php
if (!(isset($_SESSION["state_login"]) && $_SESSION["state_login"] === true && $_SESSION["user_type"] == "admin")) {
    ?>
    <script type="text/javascript">
        <!--
        location.replace("index.php");	 
        -->
    </script>
    <?php
    exit; 
}

$link = mysqli_connect("localhost", "root", "", "shop_db");

if (mysqli_connect_errno()) {
    exit("خطاي زير رخ داده است :" . mysqli_connect_error());
}

if (!(isset($_GET['action']) && $_GET['action'] == 'DELETE')) {

    if (isset($_POST['pro_code']) && !empty($_POST['pro_code']) && isset($_POST['pro_name']) &&
        !empty($_POST['pro_name']) && isset($_POST['pro_qty']) && !empty($_POST['pro_qty']) &&
        isset($_POST['pro_price']) && !empty($_POST['pro_price']) && isset($_POST['pro_detail']) &&
        !empty($_POST['pro_detail'])) {

        $pro_code = $_POST['pro_code'];
        $pro_name = $_POST['pro_name'];
        $pro_qty = $_POST['pro_qty'];
        $pro_price = $_POST['pro_price'];
        $pro_image = basename($_FILES["pro_image"]["name"]);
        $pro_detail = $_POST['pro_detail'];
    } else {
        exit("<p class='error-message'>برخی از فیلد ها مقدار دهی نشده است.</p>");
    }
}

if (isset($_GET['action'])) {

    $id = $_GET['id'];

    switch ($_GET['action']) {
        case 'EDIT':
            $query = "UPDATE products SET
                      pro_code='$pro_code',
                      pro_name='$pro_name',
                      pro_qty='$pro_qty',
                      pro_price='$pro_price',
                      pro_detail='$pro_detail'
                      WHERE pro_code='$id'";

            if (mysqli_query($link, $query)) {
                echo ("<p class='edit-success'><b>محصول انتخاب شده با موفقیت ویرایش شد.</b></p>");
            } else {
                echo ("<p class='edit-error'><b>خطا در ویرایش محصول</b></p>");
            }

            break;

        case 'DELETE':
            $query = "SELECT pro_image  FROM products WHERE pro_code='$id'";
            $result = mysqli_query($link, $query);
            $row = mysqli_fetch_array($result);
            $pro_image = $row['pro_image'];

            $query = "DELETE  FROM products WHERE pro_code='$id'";

            if (mysqli_query($link, $query)) {
                echo ("<p class='success-message'><b>محصول انتخاب شده با موفقیت حذف شد.</b></p>");
                unlink("images/products/" . $pro_image);
            } else {
                echo ("<p class='error-message'><b>خطا در حذف محصول</b></p>");
            }

            break;
    }

    mysqli_close($link);
    include("includes/footer.php");
    exit();
}

$target_dir = "images/products/";
$target_file = $target_dir . basename($_FILES["pro_image"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

$check = getimagesize($_FILES["pro_image"]["tmp_name"]);
if ($check !== false) {
    echo "<p>پرونده انتخابی یک تصویر از نوع - " . $check["mime"] . " است.</p>";
    $uploadOk = 1;
} else {
    echo "<p class='error-message'>پرونده انتخاب شده یک تصویر نیست.</p>";
    $uploadOk = 0;
}

if (file_exists($target_file)) {
    echo "<p class='error-message'>پرونده ای با همین نام در سرور موجود است.</p>";
    $uploadOk = 0;
}

if ($_FILES["pro_image"]["size"] > 500000) {
    echo "<p class='error-message'>اندازه پرونده انتخابی بیشتر از 500 کیلوبایت است.</p>";
    $uploadOk = 0;
}

if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "<p class='error-message'>فقط پسوندهای JPG, JPEG, PNG & GIF برای پرونده مجاز هستند</p>";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "<p class='error-message'>پرونده انتخاب شده به سرور ارسال نشد.</p>";
} else {
    if (move_uploaded_file($_FILES["pro_image"]["tmp_name"], $target_file)) {
        echo "<p class='success-message'>پرونده " . basename($_FILES["pro_image"]["name"]) . " با موفقیت به سرور انتقال یافت.</p>";
    } else {
        echo "<p class='error-message'>خطا در ارسال پرونده به سرور</p>";
    }
}

if ($uploadOk == 1) {
    $query = "INSERT INTO products (pro_code, pro_name, pro_qty, pro_price, pro_image, pro_detail) VALUES ('$pro_code', '$pro_name', '$pro_qty', '$pro_price', '$pro_image', '$pro_detail')";

    if (mysqli_query($link, $query)) {
        echo ("<p class='success-message'><b>کالا با موفقیت به انبار انبار اضافه شد.</b></p>");
        }    else
            echo ("<p style='color:red;'><b>خطا در ثبت مشخصات کالا در انبار</b></p>");
    } else
        echo ("<p style='color:red;'><b>خطا در ثبت مشخصات کالا در انبار</b></p>");
    
    mysqli_close($link);
   

    include ("includes/footer.php");
    ?>