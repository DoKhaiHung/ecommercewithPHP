<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search</title>
  <link rel="stylesheet" href="./asset/search.css">
  <link rel="icon" href="public/icongame.jpg" type="image/.jpg">
</head>
<body>
    <?php
    if (empty($_GET['search'])){
         header("Location: ./");
    }
    require "header.php";
    require "api/connect.php";
    $MaxProductsOnePage=8;
    $sql="
    SELECT * FROM `products_list` WHERE name LIKE '%".addslashes($_GET['search'])."%'
    limit $MaxProductsOnePage  
    ";
    
    echo "<script>
            const search='$_GET[search]'
        </script>";
    $res=mysqli_query($connect,$sql);
    ?>
    <img class="img_container"src="https://file.hstatic.net/1000230642/collection/banner-kid_d89442a89fda42dfb7dc7349b6472f71_master.jpg" alt="">
   <h1 class="result-textheader"> Kết quả tìm kiếm </h1>
   <div class="result_container">
        <div class="result_section">
        <?php 
        if(mysqli_num_rows($res)>0){
        $i=1;
        foreach ($res as $item) {?>
            <div class="section-box">
                <a href="./product.php?id=<?php echo $item['id']?>"class="search-link">
                    <span class="number"> <?php echo $i?> </span>
                    <div class="item_search">
                        <div class="item-pic">
                            <img src="<?php echo $item['photo']?>" alt="">
                        </div>
                        <div class="item-text"><?php echo $item['name']?></div>
                    </div>
                </a>
            </div>
        <?php $i++; };
        }else {
            echo "<h1 align=\"center\"> Không có sản phẩm nào !</h1>";
        }
        ?>
        </div>
   </div>
   <div class="load-more"> Xem thêm</div>

  <script src="js/search.js"></script>
</body>
</html>