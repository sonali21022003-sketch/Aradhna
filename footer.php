<html>
    <head>
        <style>
            *{
                margin: 0;
                text-decoration: none;
                font-family: 'Times New Roman', Times, serif;
            }
            body{
                display:block;
            }
            footer{
                margin-top: 20px;
                background: #343434;
                padding-top: 20px;
                color: white;
                width: 100%;
            }
            .footer-container{
                margin:auto;
                display: flex;
                justify-content: center;
            }
            h3{
                font-size: 28px;
                margin-bottom: 15px;
                text-align: center;
                word-wrap: break-word;
            }
            .footer-content{
                width:33.3%;
                padding: 5px;
            }
            .footer-content p{
                width: 70%;
                margin: auto;
                padding:7px;
                overflow: auto;
            }
            .footer-content ul{
                padding:0;
                list-style: none;
                text-align: center;
            }
            .footer-list li,.footer-list a{
                width: auto;
                padding: 7px;
                position: relative;
                color: white;
            }
            .footer-list li::before{
                content: '';
                position: absolute;
                transform: translate(-50%,-50%);
                left: 50%;
                top: 100%;
                width: 0;
                height: 2px;
                background: #f18930;
                transition-duration: .5s;
            }
            .footer-list li:hover::before{
                width:70px;
            }
            .footer-bar{
                margin-top: 10px;
                background-color: #f18930;
                text-align: center;
                padding: 10px 0;
            }
            .footer-bar p{
                color: #343434;
                margin: 0;
                font-size: 16px;   /*16px*/
            }
        </style>
    </head>
<body>
<footer>
    <?php 
        $about_q = "SELECT * FROM `settings` WHERE `srno`=?";
        $value = [1];
        $about_r = mysqli_fetch_assoc(select($about_q,$value,'i'));
    
        $contact_q = "SELECT * FROM `contact` WHERE `srno`=?";
        $value = [1];
        $contact_r = mysqli_fetch_assoc(select($contact_q,$value,'i'));
    ?>
    <div class="footer-container">
        <div class="footer-content">
            <h3><?php echo $about_r['sitetitle']; ?></h3>
            <p> <?php echo $about_r['aboutus']; ?></p>
        </div>
        <div class="footer-content">
            <h3>Quick Links</h3>
            <ul class="footer-list">
                <li><a href="home.php">Home</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="booking.php">Booking</a></li>
                <li><a href="donation.php">Donation</a></li>
                <li><a href="feedback.php">Feedback</a></li>
            </ul>
        </div>
        <div class="footer-content">
            <h3>Contact Us</h3>
            <p>Email: <?php echo $contact_r['email']; ?></p>
            <p>Phone: +<?php echo $contact_r['phone']; ?></p>
            <p>Address: <?php echo $contact_r['address']; ?></p>
        </div>
    </div>
    <div class="footer-bar">
        <p>&copy; 2025 your company. All rights reserved.</p>
    </div>
</footer>
</body>
</html>
<!-- script for login and registeration  -->
<script>
    let register_form = document.getElementById('register-form');
    register_form.addEventListener('submit',(e)=>{
        e.preventDefault();
        let data = new FormData();
        data.append('name',register_form.elements['name'].value);
        data.append('dob',register_form.elements['dob'].value);
        data.append('email',register_form.elements['email'].value);
        data.append('mobile',register_form.elements['mobile'].value);
        data.append('address',register_form.elements['address'].value);
        data.append('gender',register_form.elements['gender'].value);
        data.append('uname',register_form.elements['uname'].value);
        data.append('password',register_form.elements['password'].value);
        data.append('repassword',register_form.elements['repassword'].value);
        data.append('register','');

        let xhr= new XMLHttpRequest();
        xhr.open("POST","ajax/login_register.php",true);
        xhr.onload = function(){
            if(this.responseText=='password_mismatch')
            {
                alert("Invalid Password");
            }
            else if(this.responseText=='Invalid_Email')
            {
                alert("Invalid Email Entered");
            }
            else if(this.responseText=='User_Exist')
            {
                alert("User Already Exist");
            }
            else if(this.responseText=='Password_Exist')
            {
                alert("Password Already Exist");
            }
            else if(this.responseText=='failed')
            {
                alert("Server Down Registration failed");
            }
            else if(this.responseText==1)
            {
                register_form.reset();
                alert("Thank you for registration");
            }
            else
            {
                alert("Registration failed");   
            }
        }
        xhr.send(data);
    });

    let login_form = document.getElementById('login-form');
    login_form.addEventListener('submit',(e)=>{
       e.preventDefault();
        let data = new FormData();
        data.append('uname',login_form.elements['uname'].value);
        data.append('upass',login_form.elements['upass'].value);
        data.append('login','');

        let xhr= new XMLHttpRequest();
        xhr.open("POST","ajax/login_register.php",true);
        xhr.onload = function(){
            if(this.responseText=='inv_uname_upass')
            {
                alert("Invalid Username OR Password");
            }
            else if(this.responseText=='Inv_user')
            {
                alert("Invalid Username Entered");
            }
            else if(this.responseText=='Inv_pass')
            {
                alert("Invalid Password Entered");
            }
            else
            {
                let fileurl=window.location.href.split('/').pop().split('?').shift();
                if(fileurl=='booking.php')
                {
                    window.location=window.location.href;
                }
                else{
                    window.location = window.location.pathname; 
                }
              
            }
        }
        xhr.send(data);
    });

    function checkLogin(status,pujaId)
    {
        if(status)
        {
            window.location.href='bookform.php?id='+pujaId;
        }
        else{
            alert('Please Login First.')
        }
    }
</script>