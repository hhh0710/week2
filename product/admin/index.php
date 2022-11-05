<?php
session_start();
if(isset($_SESSION["username"]) && $_SESSION["role"]==1){
include('../connect.php');
// lấy dữ liệu từ db
$query_db="SELECT userid,username,password,fullname,email FROM users";
$query= mysqli_query($conn,$query_db);
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>admin</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <!-- Liên kết JS Jquery bằng CDN -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>

        <!-- Liên kết JS Popper bằng CDN -->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

        <!-- Liên kết JS Bootstrap bằng CDN -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

        <!-- Liên kết JS FontAwesome bằng CDN -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>

    </head>
    <body>
    <h1>Hello <?php echo $_SESSION["username"];
        ?></h1>
    <?php
    $data = [];
    $i=1;
    while ($row = mysqli_fetch_array($query,MYSQLI_ASSOC)) {
        $data[] = array(
            'i' => $i,
            'userid' => $row['userid'],
            'username' => $row['username'],
            'password' => $row['password'],
            'fullname' => $row['fullname'],
            'email' => $row['email'],
        );
    }

    ?>
    <br>
    <div style="display: block">
        <a href="createUser.php" class="btn btn-primary">
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


    <table class="table table-borderd">
        <thead>
        <tr>
            <th colspan="7">THÔNG TIN USER</th>
        </tr>
            <tr>
                <td>STT</td>
                <td>UserId</td>
                <td>Username</td>
                <td>Password</td>
                <td>Fullname</td>
                <td>Email</td>
                <td>Action</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row) :?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row["userid"]; ?></td>
            <td><?php echo $row["username"]; ?></td>
            <td><?php echo $row["password"]; ?></td>
            <td><?php echo $row["fullname"]; ?></td>
            <td><?php echo $row["email"]; ?></td>
            <td>
                <a href="editUser.php?userid=<?php echo $row["userid"]?>" id="btnUpdate" class="btn btn-primary">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="deleteUser.php?userid=<?php echo $row["userid"]?>" id="btnDelete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?');">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </td>
        </tr>
        <?php
            $i++;
            endforeach;
            mysqli_close($conn);
        ?>
        </tbody>
    </table>
    </body>
</html>
<?php
}else{
    header("location:../index.php");
}
?>