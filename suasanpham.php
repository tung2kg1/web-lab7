<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php

    require('ketNoiDatabase.php');
    $masp = $_GET['id'];
    $sql = "SELECT * FROM sanpham WHERE masp = '$masp'";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);
    $img = $row['imgURL'];  


    if (isset($_POST['submit'])) {
        $gia = $_POST['gia'];
        $tensp = $_POST['ten'];
        $mota = $_POST['mota'];

        $hinhanh = $_FILES['hinhanh']['name'];
        $target_dir = "./images/";

        // Check if a new image was uploaded
        if ($hinhanh) {
            // If an old image existed, delete it
            if (file_exists("./images/" . $img)) {
                unlink("./images/" . $img);
            }

            // Set the target file path for the new image
            $target_file = $target_dir . $hinhanh;

            // Move the uploaded image to the target directory
            move_uploaded_file($_FILES["hinhanh"]["tmp_name"], $target_file);
        } else {
            // If no new image was uploaded, use the old image name
            $target_file = $target_dir . $img;
            $hinhanh = $img;
        }

        // Update the database record with the new data
        if (isset($tensp) && isset($gia) && isset($mota) && isset($hinhanh)) {
            $sql = "UPDATE sanpham SET `tensp` = '$tensp', `gia` = '$gia', `mota` = '$mota', `imgURL` = '$hinhanh' WHERE sanpham.masp = '$masp'";
            mysqli_query($conn, $sql);

            // Redirect to the homepage
            header("Location: trangchu.php");
        }
    }
    ?>

    <a href="trangchu.php">Quay về</a>
    <h1>Cập nhật sản phẩm</h1>

    <form action="" method="POST" enctype="multipart/form-data">
        <div>
            <label for="ten">Tên sản phẩm</label>  

            <input type="text" id="ten" name="ten" value="<?= $row["tensp"] ?>">
        </div>
        <div>
            <label for="gia">Giá sản phẩm</label>
            <input type="number"  
    id="gia" name="gia" value="<?= $row["gia"] ?>">
        </div>
        <div>
            <img style="width:200px;height:200px;" src="./images/<?= $row["imgURL"] ?>" alt="">
        </div>
        <div>
            <label for="file">Hình ảnh</label>
            <input type="file" id="file" name="hinhanh" value="Choose File">
        </div>
        <div>
            <label for="mota">Mô tả</label>
            <textarea name="mota" id="mota" cols="30" rows="10"><?= $row["mota"] ?></textarea>
        </div>
        <button type="submit" name="submit">Cập nhật sản phẩm</button>
</form>   
</body>
</html>