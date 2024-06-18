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
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            border: 1px solid #ddd;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
        }

        table img {
            max-width: 100%;
            height: auto;
        }

        .action-links {
            display: inline-block;
            margin: 0 5px;
        }

        .action-links a {
            text-decoration: none;
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border-radius: 3px;
            transition: background-color 0.3s ease;
        }

        .action-links a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>


<?php
include ("includes/header.php");
if (!(isset($_SESSION["state_login"]) && $_SESSION["state_login"] === true && $_SESSION["user_type"] ==
    "admin")) {
?>
<script type="text/javascript">
<!--
location.replace("index.php");	 
-->
</script>
<?php
} 

$link = mysqli_connect("localhost", "root", "", "shop_db");  

if (mysqli_connect_errno())
    exit("خطاي زير رخ داده است :" . mysqli_connect_error());

$url = $pro_code = $pro_name = $pro_qty = $pro_price = $pro_image = $pro_detail = "";

$btn_caption="افزودن كالا";
if (isset($_GET['action']) && $_GET['action'] == 'EDIT') {
    $id = $_GET['id'];
    $query = "SELECT * FROM products WHERE pro_code='$id'";
    $result = mysqli_query($link, $query);
    if ($row = mysqli_fetch_array($result)) {
        $pro_code = $row['pro_code'];
        $pro_name = $row['pro_name'];
        $pro_qty = $row['pro_qty'];
        $pro_price = $row['pro_price'];
        $pro_image = $row['pro_image'];
        $pro_detail = $row['pro_detail'];
        $url = "?id=$pro_code&action=EDIT";
        $btn_caption="ويرايش كالا";

    }
		
}
?>

  <br />
  <form name="add_product" action="action_admin_products.php<?php if (!empty($url)) echo($url); ?>"  method="POST" enctype="multipart/form-data" >
    <table style="width: 100%;" border="0"  style="margin-left: auto;margin-right: auto;"  >
                         
    <tr>
       <td style="width: 22%;">کد کالا <span style="color: red;">*</span></td>
       <td style="width: 78%;"><input type="text" id="pro_code" name="pro_code" value="<?php echo ($pro_code) ?>"    /></td>
    </tr>
                          
    <tr>
       <td>نام کالا <span style="color: red;">*</span></td>
       <td><input type="text" style="text-align: right;" id="pro_name" name="pro_name" value="<?php echo ($pro_name) ?>"   /></td>
    </tr>
                         
    <tr>
       <td>موجودی کالا <span style="color: red;">*</span></td>
       <td><input type="text" style="text-align: left;" id="pro_qty" name="pro_qty" value="<?php echo ($pro_qty) ?>"   /></td>
    </tr>
                         
    <tr>
       <td>قیمت کالا <span style="color: red;">*</span></td>
       <td><input type="text" style="text-align: left;" id="pro_price" name="pro_price" value="<?php echo ($pro_price) ?>"   />ریال</td>
    </tr>
                         
    <tr>
       <td>آپلود تصویر کالا <span style="color: red;">*</span></td>
       <td><input type="file" style="text-align: left;" id="pro_image" name="pro_image"  size="30" />
       <?php if (!empty($pro_image))
    echo ("<img src='images/products/$pro_image' width='80' height='40' />"); ?>
       </td>
    </tr>
                         
    <tr>
       <td>توضیحات تکمیلی کالا <span style="color: red;">*</span></td>
       <td><textarea id="pro_detail" name="pro_detail" cols="45" rows="10" wrap="virtual"  >
       	<?php echo ($pro_detail) ?>
       </textarea></td>
    </tr>
                         
    <tr>
       <td><br /><br /></td>
       <td><input type="submit" value="<?php echo ($btn_caption) ?>" />&nbsp;&nbsp;&nbsp;<input type="reset" value="جديد" /></td>
    </tr>
                         
   </table>
  </form>
                    
<?php

$query = "SELECT * FROM products";
$result = mysqli_query($link, $query);

?>

<table>
    <tr>
        <th>کد کالا</th>
        <th>نام کالا</th>
        <th>موجودی کالا</th>
        <th>قیمت کالا</th>
        <th>تصویر کالا</th>
        <th>ابزار مدیریتی</th>
    </tr>

    <?php
    while ($row = mysqli_fetch_array($result)) {
        ?>
        <tr>
            <td><?php echo ($row['pro_code']) ?></td>
            <td><?php echo ($row['pro_name']) ?></td>
            <td><?php echo ($row['pro_qty']) ?></td>
            <td><?php echo ($row['pro_price']) ?>&nbsp; ریال</td>
            <td><img src="images/products/<?php echo ($row['pro_image']) ?>" width="150px" height="100px" /></td>
            <td>
                <div class="action-links">
                    <a href="action_admin_products.php?id=<?php echo ($row['pro_code']) ?>&action=DELETE">حذف</a>
                </div>
                <div class="action-links">
                    <a href="admin_products.php?id=<?php echo ($row['pro_code']) ?>&action=EDIT">ویرایش</a>
                </div>
            </td>
        </tr>
        <?php
    } 
    ?>
</table>

<?php include("includes/footer.php"); ?>

</body>
</html>

