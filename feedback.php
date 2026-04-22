<!DOCTYPE html>    
<html>    
  <head>    
    <style>   
        *{
          margin:0px;
          padding:0px;
          font-family:sans-serif;
        }  
        body{
          background: #4e5663;
        }  
        .container{
        display:flex;
        justify-content:space-between;
        width:85%;
        margin: 50px auto;
        background-color: #404b56;
        border-radius:10px;
        padding:40px 40px;
        }
        .left-column{
        width:45%;
        padding:10px;
        }
        .right-column{
        width:45%;
        background:white;
        padding:20px;
        border-radius:10px;
        }
        .feedback{
        color:white;
        }
        .feedback h1{
          font-size:32px;
          display: inline-block;
          position: relative;
        }

        .feedback h1:after {
          content: '';
          position: absolute;
          width: 100%;
          transform: scaleX(0);
          height: 2px;
          bottom: 0;
          left: 0;
          background-color:#fea116 ;
          transform-origin: bottom right;
          transition: transform 0.25s ease-out;
        }

        .feedback h1:hover:after {
          transform: scaleX(1);
          transform-origin: bottom left;
        }
        .feedback form{
        margin-top:20px;
        display:flex;
        flex-direction:column;
        gap:10px;
        }
        .feedback label{
        display:block;
        margin-top:15px;
        }
        .feedback input[type="text"],input[type="email"],textarea{
          color: black;
          width:90%;
          padding:15px;
          border: 1px solid #e3d9bf;
          outline-color:#e3d9bf;
          background:#f4f4f4;
          border-radius:10px;
        }
        #pass { 
          color: red; 
          font-size: 12px; 
        } 
        .feedback textarea{
        height:100px;
        }
        .feedback button{
        background-color:#fea116;
        display:inline-block;
        width:125px;
        font-size:17px;
        border:none;
        border-radius:10px;
        color:white;
        padding:10px 15px;
        margin-top:10px;
        cursor: pointer;
        }
        .contact{
        text-align:center;
        padding:25px;
        }
        .contact h1{
        font-size:32px;
        color:#fea116;
        }
        .contact p{
        margin:8px 0px;
        font-size:18px;
        line-height:1.5;
        }
        .contact h3{
        margin-top:20px;
        }
        @media screen and (max-width:768px){
        .container{
        display:flex;
        flex-direction:column;
        align-items:center;
        }
        .left-column{
        width:85%;
        }
        .right-column{
        width:85%;
        margin-top:25px;
        }
        }
        /* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */    
    </style>    
  </head>    
  <body> 
    <?php include 'inc/header.php'?> 
    <!-- fetch data from database in right-column -->
    <?php 
      $contact_q = "SELECT * FROM `contact` WHERE `srno`=?";
      $value = [1];
      $contact_r = mysqli_fetch_assoc(select($contact_q,$value,'i'));
    ?>
    <div class="container">
      <div class="left-column">
        <div class="feedback">
          <h1>Feedback</h1>
          <form method="POST">
            <label for="name">Name:</label>
            <input type="text" name="name" placeholder="Enter Your Name" required>
            <label for="email" >Email:</label><span id="pass"></span>
            <input type="text" name="email" id="email" placeholder="Enter Email"required>
            <label for="feedback" >Feedback:</label>
            <textarea name="message" placeholder="Give your feedabck here" required></textarea>
            <button type="submit" name="send">Submit</button>
          <form>
        </div>
      </div>
      <div class="right-column">
        <div class="contact">
          <h1> Contact Us </h1>
          <p><?php echo $contact_r['descript']; ?></p>
          <h3>Contact informations</h3>
          <p>Email: <?php echo $contact_r['email']; ?></p>
          <p>Phone: +<?php echo $contact_r['phone']; ?></p>
          <p>Address: <?php echo $contact_r['address']; ?></p>
        </div>
      </div>
    </div>
    <!-- data is inserted here -->
    <?php 
      if(isset($_POST['send']))
      {
        $ft_data = filteration($_POST);
        $email = $ft_data['email'];
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $emailErr = "Invalid email format.Fill correct email";
          echo"<script>alert('$emailErr');</script>";
        }
        else{
          $q="INSERT INTO `feed_back`(`name`, `email`, `message`) VALUES (?,?,?)";
          $value=[$ft_data['name'],$ft_data['email'],$ft_data['message']];
          $res = insert($q,$value,'sss');
          if($res==1){
            echo"<script> alert('You Feedback is sent =)');</script>";
          }
          else{
            echo"<script> alert('Server Down! Try again later.');</script>";
          }
        }
      }
    ?>
    <?php include 'inc/footer.php'?>
  </body>    
</html>    