<?php
require '../admin Panel/inc/db_config.php';
require '../admin Panel/inc/essential.php';



if(isset($_POST['register']))
{
    $data=filteration($_POST);
    if($data['password']!=$data['repassword'])
    {
        echo 'password_mismatch';
        exit;
    }
    //check if e-mail address is well-formed
    if(!filter_var($data['email'],FILTER_VALIDATE_EMAIL)) {
        echo 'Invalid_Email';
        exit;
    }

    if(strlen($data['mobile'])<10) {  // changed "if(!strlen($data['mobile'])==10) " on 26/6/2024
        echo 'Invalid mobile number';
        exit;
    }

    $u_exist = select("SELECT * FROM `userpanel` WHERE `username`=? OR `password`=?",[$data['uname'],$data['password']],"ss");
    //  if username or password already exist.

    if(mysqli_num_rows($u_exist)!=0)  
    {
        $result_fetch=mysqli_fetch_assoc($u_exist);// if user already exist
        if($result_fetch['username']==$data['uname'])
        {
            echo 'User_Exist';
            exit;
        }
        else{               // Password already exist.
            echo 'Password_Exist';
            exit;
        }
    }
   
    $password=password_hash($data['password'],PASSWORD_BCRYPT);   //bluefish method of securing user's password (it contain 60 digit/char)
    
    $query="INSERT INTO `userpanel` (`name`, `dob`, `email`, `mobile`, `address`, `gender`, `username`, `password`) VALUES (?,?,?,?,?,?,?,?)";
    $value=[$data['name'], $data['dob'], $data['email'], $data['mobile'], $data['address'], $data['gender'], $data['uname'], $password];
    if(insert($query,$value,'sssissss'))
    {
        echo 1;
    }
    else{
        echo 'failed';
    }


}

if(isset($_POST['login']))
{
$data=filteration($_POST);
$u_exist = select("SELECT * FROM `userpanel` WHERE `username`=? OR `password`=?",[$data['uname'],$data['upass']],"ss");
if(mysqli_num_rows($u_exist)==0)  
{
    echo 'inv_uname_upass';
}
else
{
    $u_fetch=mysqli_fetch_assoc($u_exist);
    if($u_fetch['username']==$data['uname'])
    {
        if(password_verify($data['upass'],$u_fetch['password']))
        {
            session_start();
            $_SESSION['login']=true;
            $_SESSION['uId']=$u_fetch['srno'];
            $_SESSION['name']=$u_fetch['name'];
            $_SESSION['phone']=$u_fetch['mobile'];
            $_SESSION['uname']=$u_fetch['username'];
            echo 1;
        }
        else
        {
            echo 'Inv_pass';
        }
            
    }
    else{               // Password already exist.
        echo 'Inv_user';
    }
}
} 
?>