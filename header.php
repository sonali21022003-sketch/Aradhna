<?php  
    session_start();
?>

<link rel="stylesheet" href="style/homestyle.css">
<?php 
    require("admin Panel/inc/db_config.php");
    require("admin Panel/inc/essential.php");
?> 
<!-- for navbar -->
<?php 
    $about_q = "SELECT * FROM `settings` WHERE `srno`=?";
    $value = [1];
    $about_r = mysqli_fetch_assoc(select($about_q,$value,'i'));
?>
    <nav class="navbar">
        <div class="navdiv">
            <div class="logo"><?php echo $about_r['sitetitle']; ?></div>
            <input type="checkbox" id="click">
            <label for="click" class="hamburger">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </label>
            <ul class="nav-list" id="nav">
                <li><a href="home.php">Home</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="booking.php">Booking</a></li>
                <li><a href="donation.php">Donation</a></li>
                <li><a href="feedback.php">Feedback</a></li>
                <?php 
                    if(isset($_SESSION['login']) && $_SESSION['login']==true)
                    {
                        echo<<<data
                            <li>
                                <button class="dropbtn" id="drop-btn"> $_SESSION[uname]</button>
                                <div class="dropdown-content" id="drop-content">
                                    <a href="profile.php">Profile</a>
                                    <a href='user_bookings.php'>Dashboard</a>
                                    <a id='logout' href='logout.php'>LogOut</a>
                                </div>
                            </li>
                        data;
                    }
                    else
                    {
                        echo<<<data
                            <li><button id="myBtn">Login</button></li>
                            <li><button id="reg-btn">Register</button></li>
                        data;
                    }
                ?>

            </ul>
        </div>
    </nav>
    <!-- login modal  -->
    <div id="myModal" class="modal">
        <div class="wrapper">
            <form id="login-form" method="POST">
                <span class="close">&times;</span>
                <h1>login</h1>
                <div class="input-box">
                    <input type="text" name="uname" placeholder="Username"required>
                </div>
                <div class="input-box">
                    <input type="password" name="upass" placeholder="Password" required>
                </div>
                <!-- <div class="remember-forget">
                    <label><input type="checkbox">Remember Me</label>
                    <a href="#">Forget Password?</a>
                </div> -->
                <button type="submit" class="btn" name="login">Login</button>
                <div class="register-link">
                    <p>Don't have account ? <a id="rg-btn">Register</a></p>
                </div>
            </form>
        </div>
    </div>
    <!-- javascript for login modal -->
    <script>
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("myBtn");
        var model = document.getElementById("rgmodal");
        var rbtn = document.getElementById("rg-btn");
        var span = document.getElementsByClassName("close")[0];
        btn.onclick = function () {
            modal.style.display = "flex";
        }
        span.onclick = function () {
            modal.style.display = "none";
        }
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        rbtn.onclick = function () {
            model.style.display = "flex";
            modal.style.display = "none";
        }

    </script>
    <!-- registration form  -->
    <!-- database connection is footer page -->
    <div id="rgmodal" class="reg-modal">
        <div class="main">
            <span class="cls">&times;</span>
            <h1>Registration</h1>
            <form id="register-form" method="POST">   <!-- go to footer.php -->
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter your first name" required>

                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" placeholder="Enter your DOB" required>

                <label for="email">Email:</label>
                <input type="text" id="email" name="email" placeholder="Enter your email" required>

                <label for="mobile">Contact:</label>
                <input type="text" id="mobile" name="mobile" placeholder="Enter your Mobile Number" title="Enter valid phone number (10 digit)" pattern="[1-9]{1}[0-9]{9}" required>
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" placeholder="House no.,Town(village),City,State,Country" required>

                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
                
                <label for="uname">User Name:</label>
                <input type="text" id="uname" name="uname" placeholder="Enter Username" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password"
                    pattern="^(?=.*\d)(?=.*[a-zA-Z])(?=.*[^a-zA-Z0-9])\S{8,}$" required
                    title="Password must contain at least one number,one alphabet, one symbol, 
                    and be at  least 8 characters long">

                <label for="repassword">Re-type Password:</label>
                <input type="password" id="repassword" name="repassword" placeholder="Re-Enter your password" required>
                <span id="pass"></span>
                <div class="wrap">
                    <button type="submit" onclick="solve()" name="register">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function solve() {
            let password =
                document.getElementById('password').value;
            let repassword =
                document.getElementById('repassword').value;
            let mobile =
                document.getElementById('mobile').value;
            let mail =
                document.getElementById('email').value;
            let flag = 1;
            let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailRegex.test(mail)) {
                flag = 0;
                pass.innerText =
                    'Please enter a valid email address.';
                setTimeout(() => { pass.innerText = ""; }, 60000);
            }


            if (password !== repassword) {
                flag = 0;
                pass.innerText =
                    "Passwords do not match. Please re-enter.";
                setTimeout(() => { pass.innerText = ""; }, 60000);
            }

           

            let passwordRegex =
                /^(?=.*\d)(?=.*[a-zA-Z])(?=.*[^a-zA-Z0-9])\S{8,}$/;

            if (!passwordRegex.test(password)) {
                flag = 0;
                pass.innerText =
                    'Password must be at least 8 characters' +
                    ' long and include at least one number,' +
                    ' one alphabet, and one symbol.';
                setTimeout(() => { pass.innerText = ""; }, 60000);
            }
            
        }

        // register modal
        var model = document.getElementById("rgmodal");
        var rgbtn = document.getElementById("reg-btn");
        var spn = document.getElementsByClassName("cls")[0];
        rgbtn.onclick = function () {
            model.style.display = "flex";
        }
        spn.onclick = function () {
            model.style.display = "none";
        }
        window.onclick = function (event) {
            if (event.target == model) {
                model.style.display = "none";
            }
        }
    </script>
    <!-- drop-down -->
    <script>
        var drop_cont=document.getElementById("drop-content");
        var drop_btn=document.getElementById("drop-btn");

        drop_btn.onclick = function () {
            drop_cont.style.display = "block";
        }

        window.onclick = function (event) {
            if (event.target !=drop_btn) {
                drop_cont.style.display = "none";
            }
        }

    </script>