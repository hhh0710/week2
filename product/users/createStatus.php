<?php
session_start();
if(isset($_SESSION["username"]) && $_SESSION["role"]==0){
    include("../connect.php");
    if ( isset($_POST['btnSave']) ) {

        // 3. Nếu người dùng có bấm nút `Lưu dữ liệu` thì thực thi câu lệnh INSERT
        // Lấy dữ liệu người dùng hiệu chỉnh gởi từ REQUEST POST
        $content = addslashes($_POST['txtContent']);
//        move_uploaded_file($_FILES["images"]["tmp_name"], $_FILES["file"]["name"]);
        if(isset($_FILES["images"]) && $_FILES["images"]["error"] == 0) {
            $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
            $filename = $_FILES["images"]["name"];
            $filetype = $_FILES["images"]["type"];
//            $filesize = $_FILES["photo"]["size"];
            // xác minh phần mở rộng và loại MIME tệp
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if(!array_key_exists($ext, $allowed)) die("Lỗi: Vui lòng chọn định dạng tệp hợp lệ. <a href='javascript: history.go(-1)'>Trở lại</a>");
        }
        $image = base64_encode(file_get_contents($_FILES['images']["tmp_name"]));
        $createdat = date('Y-m-d H:i:s');
        //Lưu thông tin thành viên vào bảng
        $query_add_stt = "INSERT INTO status (
        user_tus,
        content,
        image,
        createdat
    )
    VALUE (
        '{$_SESSION['userid']}',
        '{$content}',
        '{$image}',
        '{$createdat}'
    )";
        @$addstt = mysqli_query($conn, $query_add_stt);
        mysqli_close($conn);
        //Thông báo quá trình lưu
        if ($addstt)
//        echo "Quá trình đăng ký thành công. <a href='/'>Về trang chủ</a>";
            header('location:index.php');
        else
            echo "Có lỗi xảy ra trong quá trình ddawng tus. <a href='createStatus.php'>Thử lại</a>";
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Đăng status</title>
        <link rel="stylesheet" href="../css/style.css">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>

        <!-- Liên kết JS Popper bằng CDN -->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

        <!-- Liên kết JS Bootstrap bằng CDN -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

        <!-- Liên kết JS FontAwesome bằng CDN -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body style="width: 30%; height: 30%; margin-left: 35%; margin-top: 5%">
    <h1>Đăng status</h1>
    <form action="" method="POST" class="form" name="formCreate" enctype="multipart/form-data">
        <table class="table">
            <tr>
                <td>
                    Content:
                </td>
                <td>
                    <input required type="text" name="txtContent" id="txtContent" size="50" class="form-control" />
                </td>
            </tr>
            <tr>
                <td>
                    Images :
                </td>
                <td>
<!--                    <input required type="text" name="txtContent" id="txtContent" size="50" class="form-control" />-->
                    <input type="file" name="images" id="images"/>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <button name="btnSave" class="btn btn-primary"><i class="fas fa-save"></i> Lưu dữ liệu</button>
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
<?php }else{echo "ko có quyền";}?>