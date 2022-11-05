<?php
session_start();
if(isset($_SESSION["username"])){
// Truy vấn database
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
    include("connect.php");

// 2. Chuẩn bị câu truy vấn $sqlSelect, lấy dữ liệu ban đầu của record cần update
// Lấy giá trị khóa chính được truyền theo dạng QueryString Parameter key1=value1&key2=value2...
    $uname = $_SESSION["username"];
    $sqlSelect = "SELECT username, password FROM users WHERE username='$uname'";

// 3. Thực thi câu truy vấn SQL để lấy về dữ liệu ban đầu của record cần update
    $resultSelect = mysqli_query($conn, $sqlSelect);
    $Row = mysqli_fetch_array($resultSelect, MYSQLI_ASSOC); // 1 record

// Nếu không tìm thấy dữ liệu -> thông báo lỗi
    if(empty($Row)) {
        echo "Giá trị username: $uname không tồn tại. Vui lòng kiểm tra lại.";
        die;
    }
    ?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Trang đổi mật khẩu</title>
<!--    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>-->
<!---->
<!--    Liên kết JS Popper bằng CDN -->
<!--    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>-->
<!---->
<!--    Liên kết JS Bootstrap bằng CDN -->
<!--    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>-->
<!---->
<!--    Liên kết JS FontAwesome bằng CDN -->
<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body  style="width: 30%; height: 30%; margin-left: 35%; margin-top: 5%">
<h1>Đổi mật khẩu</h1>
<form action="" method="POST" class="form" name="formCreate">
    <table class="table">
        <tr>
            <td>
                Username :
            </td>
            <td>
                <input readonly type="text" name="txtUsername" id="txtUsername" size="50" class="form-control" value="<?php echo $uname;?>" />
            </td>
        </tr>
        <tr>
            <td>
                Mật khẩu cũ :
            </td>
            <td>
                <input required type="text" name="txtPassword" id="txtPassword" size="50" class="form-control" />
            </td>
        </tr>
        <tr>
            <td>
                Mật khẩu mới:
            </td>
            <td>
                <input required type="password" name="txtNewPassword" id="txtNewPassword" size="50" class="form-control" />
            </td>
        </tr>
        <tr>
            <td>
                Nhập lại mật khẩu mới :
            </td>
            <td>
                <input required type="password" name="txtCfPassword" id="txtCfPassword" size="50" class="form-control"/>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button name="btnSave" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
            </td>
        </tr
        <tr>
            <td colspan="2">
                <a href="index.php">Trở lại</a>
            </td>
        </tr>
    </table>
</form>
</body>
</html>
<?php
// 4. Nếu người dùng có bấm nút update thì thực thi câu lệnh UPDATE
if (isset($_POST['btnSave'])) {
    // Lấy dữ liệu người dùng hiệu chỉnh gởi từ REQUEST POST
    $password = addslashes($_POST['txtPassword']);
    $newPassword = addslashes($_POST['txtNewPassword']);
    $CfPassword = addslashes($_POST['txtCfPassword']);
    //check pass cũ
    //hash pass

    if(md5($password) == $Row["password"]){
        if($newPassword==$CfPassword){
            // Câu lệnh UPDATE
            $sql = "UPDATE users SET password=md5('$newPassword') WHERE username='$uname'";

            // Thực thi UPDATE
            mysqli_query($conn, $sql);

            // Đóng kết nối
            mysqli_close($conn);

            // Sau khi cập nhật dữ liệu, tự động điều hướng về trang Danh sách
            header('location:logout.php');

        }else{

            echo "mật khẩu không khớp ";
            exit();
        }
    }else{
        echo "mật khẩu không đúng";
        exit();
    }

}
}else{
    header("location:index.php");
}
?>