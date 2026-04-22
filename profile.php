<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>testing</title>
    <link rel="stylesheet" href="style/homestyle.css">
    <style>
        body{
            background: #4e5663;
        }
        .profile-box{
            display: flex;
            justify-content: center;
            margin: 30px 30px;
            flex-direction: column;
            align-items: center;
        }
        .profile-box h1{
          
            color: white;
            text-align: center;
        }
        .profile-box form{
            background-color: #404b56;
            width: 60%;
            margin: 30px;
            padding: 40px;
            display: flex;
            flex-direction: column;
        }
        .profile-box label { 
            display: block; 
            width: 100%; 
            margin-top: 10px; 
            margin-bottom: 5px; 
            text-align: left; 
            color: white; 
            font-weight: bold; 
        } 

        .profile-box input { 
            display: block; 
            width: 100%; 
            margin-bottom: 15px; 
            padding: 10px; 
            box-sizing: border-box; 
            border: 1px solid #ddd; 
            border-radius: 5px; 
        } 

        .profile-box select { 
            display: block; 
            width: 100%; 
            margin-bottom: 15px; 
            padding: 10px; 
            box-sizing: border-box; 
            border: 1px solid #ddd; 
            border-radius: 5px; 
        } 
        .profile-box form col{
            width: 100%;
            height: 100%;
        }
                
    </style>
</head>
<body>
    <?php include "inc/header.php"; 
        if(!(isset($_SESSION['login']) && $_SESSION['login']==true))
        {
        redirect('home.php');
        }
        $u_exist = select("SELECT * FROM `userpanel` WHERE `srno`=? LIMIT 1",[$_SESSION['uId']],'i');
        if(mysqli_num_rows($u_exist)==0){
        redirect('home.php');
        }
        $u_fetch=mysqli_fetch_assoc($u_exist);
    ?>
    <div class="profile-box">
        <h1>Basic Information about User</h1>
            <form id="profile-form" method="POST">
                <label>Name:</label>
                <input type="text" id="pname" name="name" value="<?php echo $u_fetch['name']; ?> " required>

                <label>Date of Birth:</label>
                <input type="date" id="pdob" name="dob" value="<?php echo $u_fetch['dob']; ?>" required>

                <label>Gender:</label>
                <select id="pgender" name="gender" required>
                    <option value="<?php echo $u_fetch['gender']; ?>"><?php echo $u_fetch['gender']; ?></option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>

                <label for="email">Email:</label>
                <input type="text" id="pemail" name="email" value="<?php echo $u_fetch['email']; ?>" required>

                <label for="mobile">Contact:</label>
                <input type="number" id="pmobile" name="mobile" value="<?php echo $u_fetch['mobile']; ?>" required
                    maxlength="10">
                <label for="address">Address:</label>
                <textarea type="text" id="paddress" name="address" placeholder="House no.,Town(village),City,State,Country"><?php echo $u_fetch['address']; ?></textarea>
                
                <div class="wrap">
                    <button type="submit" name="profile">Save Changes</button>
                </div>
            </form>
    </div>
    <?php include "inc/footer.php"; ?>
    <script>
        
        let profile_form=document.getElementById('profile-form');
        profile_form.addEventListener('submit',(e)=>{
            
            let data = new FormData();
            data.append('pname',profile_form.elements['pname'].value);
            data.append('pdob',profile_form.elements['pdob'].value);
            data.append('pemail',profile_form.elements['pemail'].value);
            data.append('pmobile',profile_form.elements['pmobile'].value);
            data.append('paddress',profile_form.elements['paddress'].value);
            data.append('pgender',profile_form.elements['pgender'].value);
            data.append('profile_form','');

            let xhr= new XMLHttpRequest();
            xhr.open("POST","ajax/profile_crud.php",true);
            xhr.onload = function(){
                if(this.responseText=='Invalid_Email')
                {
                    alert("Invalid Email Entered");
                }
                else if(this.responseText=='failed')
                {
                    alert("Updation failed ! try later.");
                }
                else if(this.responseText==1)
                {
                    alert("Changes are made.");
                }
                else
                {
                    alert(" Server Down failed");   
                }
            }
            xhr.send(data);
        });

    </script>
</body>
</html>