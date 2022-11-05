<?php
session_start();
if(isset($_SESSION["username"]) && $_SESSION["role"]==1){
// Truy vấn database
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
include("../connect.php");

// 2. Chuẩn bị câu truy vấn $sqlSelect, lấy dữ liệu ban đầu của record cần update
// Lấy giá trị khóa chính được truyền theo dạng QueryString Parameter key1=value1&key2=value2...
$userid = $_GET["userid"];
$sqlSelect = "SELECT * FROM users WHERE userid=$userid;";

// 3. Thực thi câu truy vấn SQL để lấy về dữ liệu ban đầu của record cần update
$resultSelect = mysqli_query($conn, $sqlSelect);
$Row = mysqli_fetch_array($resultSelect, MYSQLI_ASSOC); // 1 record

// Nếu không tìm thấy dữ liệu -> thông báo lỗi
if(empty($Row)) {
    echo "Giá trị id: $userid không tồn tại. Vui lòng kiểm tra lại. <a href='javascript: history.go(-1)'>Trở lại</a>";
    die;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update user</title>
    <!-- Liên kết JS Jquery bằng CDN -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>

    <!-- Liên kết JS Popper bằng CDN -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <!-- Liên kết JS Bootstrap bằng CDN -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- Liên kết JS FontAwesome bằng CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>

    <!-- Liên kết CSS Bootstrap bằng CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body style="width: 30%; height: 30%; margin-left: 35%; margin-top: 5%">
<!-- Main content -->
<div class="container">
    <h1>Form Cập nhật User</h1>

    <form name="frmEdit" id="frmEdit" method="Post" action="" class="form">
        <table class="table">
            <tr>
                <td>UserID</td>
                <td><input type="text" name="userid" id="userid" class="form-control" value="<?php echo $Row['userid'] ?>" readonly /></td>
            </tr>
            <tr>
                <td>Username</td>
                <td><input type="text" name="txtUsername" id="txtUsername" class="form-control" value="<?php echo $Row['username'] ?>" /></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="text" name="txtPassword" id="txtPassword" class="form-control" value="<?php echo $Row['password'] ?>"  /></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type="text" name="txtEmail" id="txtEmail" class="form-control" value="<?php echo $Row['email'] ?>" ></textarea></td>
            </tr>
            <tr>
                <td>Fullname</td>
                <td><input type="text" name="txtFullname" id="txtFullname" class="form-control" value="<?php echo $Row['fullname'] ?>" /></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button name="btnSave" class="btn btn-primary"><i class="fas fa-save"></i> Lưu dữ liệu</button>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <a href="index.php">Trở lại</a>
                </td>
            </tr>
        </table>
    </form>
</div>
</body>
    </html>

<?php
// 4. Nếu người dùng có bấm nút Đăng ký thì thực thi câu lệnh UPDATE
if (isset($_POST['btnSave'])) {
    // Lấy dữ liệu người dùng hiệu chỉnh gởi từ REQUEST POST
    $username = addslashes($_POST['txtUsername']);
    $password = addslashes($_POST['txtPassword']);
    $email = addslashes($_POST['txtEmail']);
    $fullname = addslashes($_POST['txtFullname']);

    // Câu lệnh UPDATE
    $sql = "UPDATE users SET username='$username', password=md5('$password'), email='$email', fullname='$fullname' WHERE userid=$userid;";

    // Thực thi UPDATE
    mysqli_query($conn, $sql);

    // Đóng kết nối
    mysqli_close($conn);

    // Sau khi cập nhật dữ liệu, tự động điều hướng về trang Danh sách
    header('location:index.php');
}
}
?>


