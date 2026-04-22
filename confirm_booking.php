<?php
require '../admin Panel/inc/db_config.php';
require '../admin Panel/inc/essential.php';
 
  if(isset($_POST['booking_form']))
  {
    $ft_data = filteration($_POST);
    $q="INSERT INTO `bookings`( `userId`, `pujaId`,`venue`, `dop`,`samgri`, `total_amt`) VALUES (?,?,?,?,?,?)";
    $value=[$ft_data['userId'],$ft_data['pujaId'],$ft_data['address'],$ft_data['dop'],$ft_data['smg'],$ft_data['total']];
    $res=insert($q,$value,'iissii');
    if($res)
    {
      echo 1;
    }
    else{
      echo 0;
    }
    
  }
?>