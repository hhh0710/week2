<?php
session_start();
if(isset($_SESSION["username"]) && $_SESSION["role"]==1) {
// Truy vấn database
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
    include_once("../connect.php");

// 2. Chuẩn bị câu truy vấn $sqlSelect, lấy dữ liệu ban đầu của record cần update
// Lấy giá trị khóa chính được truyền theo dạng QueryString Parameter key1=value1&key2=value2...
    $id = $_GET['userid'];
    $sql = "DELETE FROM users WHERE userid=$id;";

// 3. Thực thi câu lệnh DELETE
    $result = mysqli_query($conn, $sql);

// 4. Đóng kết nối
    mysqli_close($conn);

// Sau khi cập nhật dữ liệu, tự động điều hướng về trang Danh sách
    header('location:index.php');
}else{
    echo "ko có quyền";
}