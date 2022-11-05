<?php
session_start();
if(isset($_SESSION["username"]) && $_SESSION["role"]==0){
include('../connect.php');
// lấy dữ liệu từ db
$userid = $_SESSION['userid'];
$query_db="SELECT tusid,user_tus,content,image,createdat FROM status WHERE user_tus = '$userid'";
$query= mysqli_query($conn,$query_db);
    $data = [];
    $i = 1;
    while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        $data[] = array(
            'i' => $i,
            'content' => $row['content'],
            'image' => $row['image'],
            'createdat' => $row['createdat']
        );
    }
    ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>User</title>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>

    <!-- Liên kết JS Popper bằng CDN -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <!-- Liên kết JS Bootstrap bằng CDN -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- Liên kết JS FontAwesome bằng CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>

<h1>HELLO <?php echo $_SESSION["username"];
    ?></h1>
</h1>
<div style="display: block">
    <a href="createStatus.php" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm mới
    </a>
    <div style="float: right">
        <a href="../logout.php" class="btn btn-primary">
            <i class="fas fa-sign-out" aria-hidden="true"></i> logout
        </a>
    </div>
    <div style="float: right">
        <a href="../changePass.php" class="btn btn-primary">
            <i class="fas fa-sign-out" aria-hidden="true"></i> Change password
        </a>
    </div>
</div>
<?php foreach ($data as $row) :?>
<div style="border: 1px solid black ; width: 700px; height: 700px; border-radius: 10px; margin-bottom: 20px; margin-top: 20px">
    <div style="text-align: right;margin: 10px"><?php echo $row["createdat"]; ?></div>
    <div style=" margin-left: 5px"><?php echo $row["content"]; ?></div>
        <img style="object-fit: contain;margin: 10px ;width: 670px;height: 600px " src="data:image/png;base64,<?php echo $row["image"]; ?>" alt="">
</div>
        <?php
        $i++;
    endforeach;
    mysqli_close($conn);
    ?>
</body>
</html>
    <?php
}else{
    header("location:../index.php");
}
?>