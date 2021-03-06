<?php
include "./api/authenticate.php";
if(!Authenticate()){
        $_SESSION['error']="Vui lòng đăng nhập để vào trang profile";
        header("Location: ./login.php");
        exit;
}
include "./api/connect.php";
$sql="SELECT * FROM `cli_list` WHERE `id`=$_SESSION[id]";
$res=mysqli_query($connect,$sql);
$res=mysqli_fetch_assoc($res);
$temp=explode(",",$res['address']);
$addr="";
for ($i=0;$i<count($temp)-1;$i++)
$addr.=$temp[$i];
$province=$temp[count($temp)-1];
if(isset($_GET['view']) && $_GET['view']=='list-order')
$page=1;


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="stylesheet" href="./asset/account.css">
    <link rel="stylesheet" href="./asset/footer.css">
    <link rel="icon" href="https://img.icons8.com/external-kmg-design-flat-kmg-design/32/000000/external-user-back-to-school-kmg-design-flat-kmg-design.png" type="image/.jpg">

</head>
<body>
        <?php require "header.php"?>
        <h1 class="title-page"><?php if(isset($page)) echo"ĐƠN HÀNG ĐÃ ĐẶT";
                                        else echo "TÀI KHOẢN CỦA BẠN"
        ?></h1>
        <div class="content_wrap_container  ">
            <div class="account_wrap ">
                <h3 class="header-account ">TÀI KHOẢN</h3>
                <div class="border_account"></div>
                <div class="item_list <?php  if(!isset($page)) echo'chosen-page' ?> linked">
                    <div class="icon-infor">
                        <img src="https://img.icons8.com/ios-glyphs/20/000000/user--v1.png"/>
    
                    </div>
                    <div class=" item-text-account">Thông tin tài khoản
                      
                    </div>
                    <a href="./account.php"></a>
                </div>
                <div class="item_list linked <?php  if(isset($page)) echo'chosen-page' ?>">
                    <div class="icon-infor">
                        <img src="https://img.icons8.com/ios-filled/20/000000/list.png"/>
                    </div>
                    <div class=" item-text-account">Quản lí đơn hàng</div>
                    <a href="./account.php?view=list-order"></a>
                </div>
                <div class="item_list linked">
                    <div class="icon-infor ">
                        <img src="https://img.icons8.com/external-dreamstale-lineal-dreamstale/20/000000/external-sign-out-interface-dreamstale-lineal-dreamstale.png"/>
                    </div>
                    <div class="linked item-text-account">Đăng xuất</div>
    
                    <a href="./signout.php"></a>
                </div>
            </div>

            <?php if(isset($_GET['view']) &&$_GET['view']=='update-account'){
             
    ?>
        <!-- update account's information -->
        <div class="content_wrap ">
            <div class="update-account-wrap ">
                <form  class="update-account-form" method="post">
                    <input class="form-item" name="name" type="text" placeholder="Họ và Tên" value="<?php echo $res['name']?>"> 
                     <select class="form-item" name="gender" >
                        <option value="0"> Nam</option>
                        <option value="1"> Nữ</option>
                    </select>
                    <input class="form-item" name="phone_number" type="number" placeholder="Số điện thoại(*)" value="<?php echo $res['phone']?>">
                    <input class="form-item" name="birthday" type="date" placeholder="Ngày sinh(dd/mm/yyyy)(*)" value="<?php echo $res['birthday']?>">
                    <input class="form-item" name="address_detail" type="text" placeholder="Địa chỉ" value="<?php  echo $addr ?>">

                    <select class="form-item" name="address_province" id="select_pro">
                        <option  value=" "> Vui lòng chọn tỉnh / thành phố </option>
                    </select>
                    <div class="success-update hidden">Cập nhật tài khoản thành công</div>
                    <button class="form-item" type="submit"> Cập nhật </button>
                    <div class=" cancel-update">
                          hoặc
                        <a href="./account.php">Hủy</a>
                    </div>
                </form>

            </div>
        </div>
        <script src="./js/account.js"></script>

    <!-- list order -->
   <?php } else if(isset($_GET['view']) && $_GET['view']=='list-order'){ 
       include "./api/getbill.php";
       $arrBill=getListOrders(0);
    ?>

        <link rel="stylesheet" href="./asset/grid.css">
        <link rel="stylesheet" href="./asset/bill.css">
        <div class="wrap_bill">
        <?php 
        if(count($arrBill)==0) echo "<h1> Bạn chưa có hóa đơn nào! </h1>";
        foreach($arrBill as $id=>$oneBill){?>
        <div class="bill-item" id="<?php echo $id?>">
                <div class="row name-table-container ">
                    <div class="tb-name-product c-4 m-4 l-4 l-o-2 col"> TÊN SẢN PHẨM</div>
                    <div class="l-2 c-2 m-2 col" >SỐ LƯỢNG</div>
                    <div class="l-2 c-2 m-2 col">GIÁ</div>
                    <div class="l-2 c-2 m-2 col" >THÀNH TIỀN</div>
                </div>

                <?php 
                $checkFirstPro=-1;
                $sumOneBill=0;
                foreach($oneBill['product'] as $oneProduct){
                   
                ?>
                <!-- first product ( show and the others are hidden) -->
                <div class="row bill-one-product <?php if($checkFirstPro==-1) $checkFirstPro=0;else echo"hidden";
                ?>" >
                        <div class="product-img c-2 m-2 l-2">  
                            <img src="<?php echo $oneProduct['photo']?>"alt="">   
                        </div> 
                        <div class="c-4 m-4 l-4 col">  
                            <div class="product-name ">  
                                <?php echo $oneProduct['name']?>  
                            </div> 
                            <div class="product-co-size-del">  
                                    <div class="color">Màu: Đen</div>  
                                    <div class="size">Size: 39</div>   
                            </div> 
                        
                        </div> 
                        <div class="quantity c-2 m-2 l-2 col"> 
                        <?php echo $oneProduct['quantity']?>    
                        </div> 
                        <div class="one-price c-2 m-2 l-2 col"> <?php echo number_format($oneProduct['price'])?>   ₫</div>   
                        <div class="sum-price c-2 m-2 l-2 col"> <?php $sumOneBill+=$oneProduct['price']*$oneProduct['quantity'];
                                                             echo number_format($oneProduct['price']*$oneProduct['quantity'])?>   ₫</div>
                        <div class="barrier"> </div>   
                </div> 
                <?php }?>
                 
                <div class="bill-view-more">Xem thêm</div>   
                <div class="infor_delivery">
                     <div>Người nhận: <span><?php echo $oneBill['receiver_name']?></span></div>
                     <div>Địa chỉ: <span><?php echo $oneBill['receiver_address']?></span></div>
                     <div>Số điện thoại liên hệ:<span> <?php echo $oneBill['receiver_phone']?></span></div>
                 </div>
                <div class="bill-total">
                    <div>
                        <div class="shipping-fee">Phí ship: 1000</div>
                        <div class="total-bill-item">Tổng tiền: <?php echo number_format($sumOneBill)?> VNĐ</div>
                    </div>             
                    <div>
                        <div class="bill_status">
                            <?php if($oneBill['receipt_stat']=="Mới") echo 'CHƯA ĐƯỢC DUYỆT' ;
                                 else if($oneBill['receipt_stat']=="Đã hủy") echo 'ĐÃ HỦY';
                                 else echo 'ĐÃ DUYỆT';
                            ?>
                        </div>
                        <?php if($oneBill['receipt_stat']=="Mới") echo' <div class="bill-cancel">HỦY ĐƠN</div>'?>
                    </div>
                    
                    
                </div>
            </div>
            <?php }?>
        
            <div class="load-more"> Xem thêm hóa đơn</div>
        </div>
        
        <script src="./js/bill.js"></script>

                <!-- change password -->
        <?php } else if(isset($_GET['view']) && $_GET['view']=='change-password'){ ?>
            <div class="content_wrap  ">
                <form  class="update-account-form" method="post">
                        <input class="form-item" name="password" type="password" placeholder="Mật khẩu cũ" > 
                        <input class="form-item" name="new_password" type="password" placeholder="Mật khẩu mới" > 
                        <input class="form-item" name="new_password_again" type="password" placeholder="Mật khẩu mới" > 
                        <div class="success-update hidden">Cập nhật mật khẩu thành công</div>
                        <button class="form-item" type="submit">Submit</button>
                </form>
            </div>
            <script src="./js/changepass.js"></script>
        <?php } else{ ?>
        <div class="content_wrap  ">

            <!--  Home page  -->
            <h3 class="header-account  ">
                <div class="content-text">
                    Thông tin tài khoản
                </div>
                <div class="content-update linked">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                            width="25" height="25"
                            viewBox="0 0 172 172"
                            style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#ffffff"><path d="M152.5425,6.88c-3.23844,0 -6.57094,1.19594 -9.03,3.655l-4.6225,4.73l17.845,17.845c-0.01344,0.01344 4.73,-4.6225 4.73,-4.6225c4.93156,-4.93156 4.93156,-13.02094 0,-17.9525c-2.4725,-2.4725 -5.68406,-3.655 -8.9225,-3.655zM133.3,20.425l-78.1525,78.1525l-0.215,1.075l-3.225,16.6625l-1.075,5.0525l5.0525,-1.075l16.6625,-3.225l1.075,-0.215l78.1525,-78.1525l-4.945,-4.8375l-76.54,76.4325l-8.385,-8.385l76.4325,-76.54zM10.32,34.4c-1.90812,0 -3.44,1.54531 -3.44,3.44v123.84c0,1.89469 1.53188,3.44 3.44,3.44h123.84c1.90813,0 3.44,-1.54531 3.44,-3.44v-99.76l-6.88,6.88v89.44h-116.96v-116.96h89.44l6.88,-6.88z"></path></g></g></svg>
                    Cập nhật thông tin tài khoản
                    <a href="./account.php?view=update-account"></a>
                </div>
            </h3>
            <div class="border_account header-account-content"></div>
            <div class="item_list">
                <div class=" item-text-account">Họ và tên: <?php echo $res['name']?></div>
            </div>
            <div class="item_list">
                <div class=" item-text-account">Email: <?php echo $res['email']?></div>
            </div>
            <div class="item_list">
                <div class=" item-text-account">Địa chỉ:  <?php echo $res['address']?></div>
            </div>
            <div class="item_list">
                <div class=" item-text-account">Điện thoại: <?php echo $res['phone']?> </div>
            </div>  
            <div class="item_list">
                <div class=" change_password linked">Đổi mật khẩu
                    <a href="./account.php?view=change-password"></a>
                </div>
            </div>  
        </div>

        <?php }?>
    

    </div>
   
    <?php require "footer.php"; echo "<script> var province=\"$province\"; </script>" ?>
</body>
</html>