<?php 
include "authenticate.php";
if(!Authenticate() || empty($_SESSION['quantity'])){
    header("Location: ../");
    exit;
}

if(empty($_POST['name']) || empty($_POST['address'])|| empty($_POST['phone']) ||!(strlen($_POST['phone']) ==10 || strlen($_POST['phone']) ==11) || $_POST['phone'][0]!='0'){
    echo json_encode(0);
}else{
    require "connect.php";
    $name=addslashes($_POST['name']);
    $address=addslashes($_POST['address']);
    $phone=addslashes($_POST['phone']);
    
    $findMaxId="SELECT id from out_list
    ORDER BY id DESC
    LIMIT 1";
    $res=mysqli_query($connect,$findMaxId);
    $id_bill=mysqli_fetch_row($res)[0];
    // add new bill
    do{
        $id_bill++;
        $sql="INSERT INTO `out_list` (`id`, `client_id`, `receiver_name`, `receiver_phone`, `receiver_address`, `note`) 
        VALUES ('$id_bill', '$_SESSION[id]', '$name', '$phone', '$address', '')";
        $result=mysqli_query($connect, $sql);
        $loi=mysqli_error($connect);    
    }while($loi);
    
    // insert into middle table between product and customer
    $sql_product="INSERT INTO `out_product` (`out_id`, `product_id`, `quantity`) VALUES ";

    // insert into receipt history
    $sql_receipt="INSERT INTO `receipt_history` (`out_id`) VALUES ($id_bill)";
    $check_first=0;
    foreach($_SESSION['cart'] as $key=> $item ) { 
        if($check_first==0){
            $sql_product.="('$id_bill','$key','$item[quantity]')";
            $check_first=1;
        }  
        else{
            $sql_product.=",('$id_bill','$key','$item[quantity]')";
        }
    }
    $temp=mysqli_query($connect,$sql_product);
    $temp=mysqli_query($connect,$sql_receipt);
    unset($_SESSION['cart'],$_SESSION['quantity']);
    echo json_encode(1);
    mysqli_close($connect);
}

?>