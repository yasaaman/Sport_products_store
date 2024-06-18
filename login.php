<?php
include("includes/header.php");
if (isset($_SESSION["state_login"]) && $_SESSION["state_login"] === true) {
?>
<script type="text/javascript">
<!--
location.replace("index.php"); 
-->
</script>
<?php
}
?>
<style>
    
    .login-form {
        width: 50%;
        margin: 20px auto;
        padding: 20px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-table {
        width: 100%;
        border-collapse: collapse;
    }

    .form-table td {
        padding: 10px;
    }

    .form-table input[type="text"],
    .form-table input[type="password"] {
        width: calc(100% - 20px);
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 3px;
        outline: none;
    }

    .form-table input[type="submit"],
    .form-table input[type="reset"] {
        padding: 8px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .form-table input[type="submit"]:hover,
    .form-table input[type="reset"]:hover {
        background-color: #45a049;
    }

    .form-actions {
        text-align: center;
    }
</style>

<br />
<div class="login-form">
    <form name="login" action="action_login.php" method="POST">
        <table class="form-table">
            <tr>
                <td>نام کاربری <span style="color: red;">*</span></td>
                <td><input type="text" id="username" name="username" required /></td>
            </tr>
            <tr>
                <td>کلمه عبور <span style="color: red;">*</span></td>
                <td><input type="password" id="password" name="password" required /></td>
            </tr>
            <tr>
                <td colspan="2" class="form-actions">
                    <input type="submit" value="ورود" />
                    <input type="reset" value="جدید" />
                </td>
            </tr>
        </table>
    </form>
</div>

<?php
include("includes/footer.php");
?>
