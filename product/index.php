<?php
//Khai báo sử dụng session
session_start();
if (isset($_SESSION["username"]) && $_SESSION["role"] ==1){
    header("location:admin/index.php");
    exit();
}else if (isset($_SESSION["username"]) && $_SESSION["role"] ==0){
    header("location:users/index.php");
    exit();
}else if(!isset($_SESSION["username"])){
    //Khai báo utf-8 để hiển thị được tiếng việt
    header('Content-Type: text/html; charset=UTF-8');

//Xử lý đăng nhập
    if (isset($_POST['login']))
    {
        //Kết nối tới database
        include('connect.php');

        //Lấy dữ liệu nhập vào
        $username = addslashes($_POST['txtUsername']);
        $password = addslashes($_POST['txtPassword']);

        //Kiểm tra đã nhập đủ tên đăng nhập với mật khẩu chưa
        if (!$username || !$password) {
            echo "Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu <a href='javascript: history.go(-1)'>Trở lại</a>";
            exit;
        }

        // mã hóa pasword
        $password = md5($password);

        //Kiểm tra tên đăng nhập có tồn tại không
        $query_name_pass="SELECT userid,username,password,role FROM users WHERE username='$username'";
        $query = mysqli_query($conn,$query_name_pass);
        if (mysqli_num_rows($query) == 0) {
            echo "Tên đăng nhập này không tồn tại <a href='javascript: history.go(-1)'>Trở lại</a>";
            exit;
        }

        //Lấy mật khẩu, role trong database ra
        $row = mysqli_fetch_array($query);

        //So sánh 2 mật khẩu có trùng khớp hay không
        if ($password != $row['password']) {
            echo "Mật khẩu không đúng. Vui lòng nhập lại <a href='javascript: history.go(-1)'>Trở lại</a>";
            exit;
        }
        // so sánh role
        if($row['role'] == 1){
            header("Location: ./admin/index.php");
        }else {
            header("Location: ./users/index.php");
        }

        //Lưu tên đăng nhập
        $_SESSION["username"] = $row["username"];
        $_SESSION["role"] = $row["role"];
        $_SESSION["userid"] = $row["userid"];
        echo $_SESSION["username"];
        echo $_SESSION["role"];
        echo $_SESSION["userid"];

        die();

        mysqli_close($conn);
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!--        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>-->
<!---->
<!--         Liên kết JS Popper bằng CDN -->
<!--        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>-->
<!---->
<!--         Liên kết JS Bootstrap bằng CDN -->
<!--        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>-->
<!---->
<!--        Liên kết JS FontAwesome bằng CDN -->
<!--        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    </head>
    <body style="width: 30%; height: 30%; margin-left: 35%; margin-top: 5%;background-image: url(images/bg.jpg);" >
    <h2 style="text-align: center">LOGIN</h2>

        <form action="" method='POST' id="login">
            <!-- username input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="txtUsername">Username</label>
                <input required type="text" id="txtUsername" name="txtUsername" class="form-control" />
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
                <label class="form-label"  for="txtPassword">Password</label>
                <input required type="password" id="txtPassword" name="txtPassword" class="form-control" />
            </div>

            <!-- Submit button -->
            <button type="submit" name="login" class="btn btn-primary btn-block mb-4">Sign in</button>

            <!-- Register buttons -->
            <div class="text-center">
                <p>Not a member? <a href="register.php">Register</a></p>
            </div>
        </form>

    </body>
</html>