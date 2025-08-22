<?php
require_once "dbconnect.php";

try {
    $sql = "select * from category";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll(); // multiple rows return
} catch (PDOException $e) {
    echo $e->getMessage();
}

// when insertBtn is click
if (isset($_POST['insertBtn'])) {
    $productName = $_POST['pName'];
    $category = $_POST['category'];
    $desc = $_POST['description'];
    $sellPrice = $_POST['sPrice'];
    $qty = $_POST['quantity'];
    $buyPrice = $_POST['bPrice'];
    $productImage = $_FILES['pImg'];
    $filePath = "productImages/" . $productImage['name'];

    echo $productImage['pName'] . "<br>";
    echo $productImage['type'] . "<br>";
    echo $productImage['size'] . "<br>";
    echo $productImage['tmp_name'] . "<br>";

    //move temp file into specified directory
    try {
        if (move_uploaded_file($productImage['tmp_name'], $filePath)) {

            // id	product_name	cost	price	description	image_path	category	quantity
            $sql = "insert into product (product_name,cost,price,description,image_path,category,quantity) 
        values (?,?,?,?,?,?,?)";

            $stmt = $conn->prepare($sql);
            $flag = $stmt->execute([$productName, $buyPrice, $sellPrice, $desc, $filePath, $category, $qty]);

            if ($flag) {
                header("Location:viewInfo.php");
            }
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Product</title>
    <!-- cdn link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php require_once "navigation.php" ?>
        </div>
        <div class="row">
            <div class="col-md-12 mx-auto py-3">
                <form action="insertProduct.php" class="form card mx-auto py-3 px-3" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-2">
                                <label for="pName" class="form-label">Product Name</label>
                                <input type="text" class="form-control" name="pName" id="pName" required>
                            </div>
                            <div class="mb-2">
                                <label for="" class="form-label"></label>
                                <select name="category" id="" class="form-select">
                                    <option value="">Choose Category</option>
                                    <?php
                                    if (isset($categories)) {
                                        foreach ($categories as $category) {
                                            echo "<option value=$category[id]>$category[cat_name]</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-2">
                                <lable for="desc" class="form-lable">Description</lable>
                                <textarea name="description" id="desc" class="form-control"></textarea>
                            </div>
                            <div class="mb-2">
                                <label for="bPrice" class="form-label">Buy Price</label>
                                <input type="number" class="form-control" name="bPrice" id="bPrice">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2">
                                <label for="sPrice" class="form-label">Sale Price</label>
                                <input type="number" class="form-control" name="sPrice" id="sPrice">
                            </div>

                            <div class="mb-2">
                                <label for="qty" class="form-label">Product Quantity</label>
                                <input type="number" class="form-control" name="quantity" id="qty">
                            </div>

                            <div class="mb-2">
                                <label for="pImg" class="form-control mb-2">Product Image</label>
                                <input type="file" class="form-control" name="pImg" id="pImg">
                            </div>
                            <div class="mb-2">
                                <button type="submit" class="btn btn-primary mt-3" name="insertBtn">Add Product</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

</body>

</html>