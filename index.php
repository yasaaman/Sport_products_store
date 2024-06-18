<?php
include ("includes/header.php");



$link = mysqli_connect("localhost", "root", "", "shop_db");

if (mysqli_connect_errno())
    exit("خطاي  زير رخ داده است :" . mysqli_connect_error());

$query = "SELECT * FROM products";            

$result = mysqli_query($link, $query);            

?>

<!--<link href="css/style.css" rel="stylesheet" type="text/css">-->
 <div class="container">
     <h2>کیفیت ما اعتبار ماست </h2>
     <p>اینجا شما می‌توانید بهترین محصولات را پیدا کنید.</p>
</div>


 <table style="width: 100%;" border="1px"  >
  <tr>
  
  <?php

$counter = 0;
while ($row = mysqli_fetch_array($result)) {
    $counter++;
?> 
	<td style="border-style: dotted dashed;vertical-align: top;width: 33%; text-align: center;" >

       <h4 style="color: brown;"><?php echo ($row['pro_name']) ?></h4>
 <a href="product_detail.php?id=<?php echo ($row['pro_code']) ?>" style="text-decoration: none;">
       <img src="images/products/<?php echo ($row['pro_image']) ?>" width="250px" height="150px" />
  </a>    
       <br/>

    قيمت  : <?php echo ($row['pro_price']) ?> &nbsp; ريال
    <br/>

    تعداد موجودي  : <span style="color:red;"><?php echo ($row['pro_qty']) ?></span>
    <br/>

     توضيحات  : <span style="color:green;"> <?php echo (substr($row['pro_detail'],0,240)) ?> ...</span>

     <br/><br/>
    <b><a href="product_detail.php?id=<?php echo ($row['pro_code']) ?>" style="text-decoration: none;">توضيحات تكميلي و خريد</a></b>
    <br/><br/>
           
    </td>  
    
<?php
    if ($counter % 3 == 0)
        echo ("</tr><tr>");
} 

if ($counter % 3 != 0)
    echo ("</tr>");

?>  
</table>

<?php
include ("includes/footer.php");
?>
   
