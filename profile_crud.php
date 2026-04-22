<?php
require '../admin Panel/inc/db_config.php';
require '../admin Panel/inc/essential.php';

if(isset($_POST['profile_form']))
{
    $ft_data = filteration($_POST);
    if(!filter_var($ft_data['pemail'],FILTER_VALIDATE_EMAIL)) {
        echo "Invalid_Email";
        exit;
    }
     session_start();

    $q="UPDATE `userpanel` SET `name`='$ft_data[pname]',`dob`='$ft_data[pdob]',`email`='$ft_data[pemail]',`mobile`='$ft_data[pmobile]',`address`='$ft_data[paddress]',`gender`='$ft_data[pgender]' WHERE `srno`='$_SESSION[uId]'";
    if(mysqli_query($con,$q))
    {
        echo 1;
    }
    else
    {
        echo "failed";
    }
}
?>