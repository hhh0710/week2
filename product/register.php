<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Trang đăng ký</title>
<!--    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>-->

    <!-- Liên kết JS Popper bằng CDN -->
<!--    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>-->

    <!-- Liên kết JS Bootstrap bằng CDN -->
<!--    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>-->

    <!-- Liên kết JS FontAwesome bằng CDN -->
<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>-->

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body style="width: 35%; height: 35%; margin-left: 35%; margin-top: 5%;background-image: url(images/bg.jpg);">
<h1 style="text-align: center">REGISTER</h1>
<form action="" method="POST" class="form" name="formCreate">
    <table class="table">
        <tr>
            <td>
                Tên đăng nhập :
            </td>
            <td>
                <input required type="text" name="txtUsername" id="txtUsername" size="50" class="form-control" />
            </td>
        </tr>
        <tr>
            <td>
                Mật khẩu :
            </td>
            <td>
                <input required type="password" name="txtPassword" id="txtPassword" size="50" class="form-control" />
            </td>
        </tr>
        <tr>
            <td>
                Email :
            </td>
            <td>
                <input required type="text" name="txtEmail" id="txtEmail" size="50" class="form-control"/>
            </td>
        </tr>
        <tr>
            <td>
                Họ và tên :
            </td>
            <td>
                <input required type="text" name="txtFullname" id="txtFullname" size="50" class="form-control"/>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button name="btnSave" class="btn btn-primary"><i class="fas fa-save"></i> Lưu dữ liệu</button>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <a  class="btn btn-primary" href="index.php">Trở lại</a>
            </td>
        </tr>
    </table>
</form>
<?php
include("connect.php");
if ( isset($_POST['btnSave']) ) {

    // 3. Nếu người dùng có bấm nút `Lưu dữ liệu` thì thực thi câu lệnh INSERT
    // Lấy dữ liệu người dùng hiệu chỉnh gởi từ REQUEST POST
    $username = addslashes($_POST['txtUsername']);
    $password = addslashes($_POST['txtPassword']);
    $email = addslashes($_POST['txtEmail']);
    $fullname = addslashes($_POST['txtFullname']);

    if (!$username || !$password || !$email || !$fullname) {
        echo "Vui lòng nhập đầy đủ thông tin.";
        exit;
    }

    // Mã khóa mật khẩu
    $password = md5($password);

    //Kiểm tra tên đăng nhập này đã có người dùng chưa
    $query_username = "SELECT username FROM users WHERE username='$username'";
    if (mysqli_num_rows(mysqli_query($conn, $query_username)) > 0) {
        echo "Tên đăng nhập này đã có người dùng. Vui lòng chọn tên đăng nhập khác. <a href='javascript: history.go(-1)'>Trở lại</a>";
        exit;
    }
    //validate username
    if (!preg_match("/^[a-zA-Z0-9]+$/i", $username)) {
        echo "Email này không hợp lệ. Vui long nhập email khác. <a href='javascript: history.go(-1)'>Trở lại</a>";
        exit;
    }
    //Kiểm tra email có đúng định dạng hay không
    if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $email)) {
        echo "Email này không hợp lệ. Vui long nhập email khác. <a href='javascript: history.go(-1)'>Trở lại</a>";
        exit;
    }

    //Kiểm tra email đã có người dùng chưa
    $query_email = "SELECT email FROM users WHERE email='$email'";
    if (mysqli_num_rows(mysqli_query($conn, $query_email)) > 0) {
        echo "Email này đã có người dùng. Vui lòng chọn Email khác. <a href='javascript: history.go(-1)'>Trở lại</a>";
        exit;
    }

    //Lưu thông tin thành viên vào bảng
    $query_add_user = "INSERT INTO users (
        username,
        password,
        email,
        fullname
    )
    VALUE (
        '{$username}',
        '{$password}',
        '{$email}',
        '{$fullname}'
    )";
    @$addmember = mysqli_query($conn, $query_add_user);
    mysqli_close($conn);
    //Thông báo quá trình lưu
    if ($addmember)
//        echo "Quá trình đăng ký thành công. <a href='/'>Về trang chủ</a>";
        header('location:index.php');
    else
        echo "Có lỗi xảy ra trong quá trình đăng ký. <a href='register.php'>Thử lại</a>";
}
?>
</body>
</html>