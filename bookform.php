<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
      input[type=text],input[type=number],input[type=date], select, textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        margin-top: 6px;
        margin-bottom: 16px;
        resize: vertical;
      }
      .bk-container label {
        margin-bottom: 10px;
        display: block;
      }

      .bk-container .icon-container {
        margin-bottom: 20px;
        padding: 7px 0;
        font-size: 24px;
      }

      .bk-container .btn {
        background-color: #fea116;
        color: white;
        padding: 12px;
        margin: 10px 0;
        border: none;
        width: 100%;
        border-radius: 3px;
        cursor: pointer;
        font-size: 17px;
      }

      .bk-container .btn:hover {
        background-color: #d17e02;
      }

      .bk-container a {
        text-decoration: none;
        color: #fea116;
      }

      .bk-container hr {
        border: 1px solid lightgrey;
      } 

      .bk-container {
        margin: 20px;
        border-radius: 5px;
        background-color: #404b56;
        padding: 20px;
      }
      .v-cont{
        display: flex;
        flex-direction:column;
        border: 1px solid white;
        border-radius: 10px;
        padding: 20px;
        margin: 20px;
      }
      .v-cont label{
        width:100%;
      }
      .v-cont p{
        color: white;
        display: block;
        margin: 3px;
        font-size: 24px;
      }
      .bk-container span .dop-inst{
        color: red;
      }
      .b-pric {
        float: right;
        color: #fea116;
      }
      .b-txtarea{
        display:none;
        margin-left: 25px;
        width:30%; height: 50px;
        font-size: 20px;
      }
      .b-drop-down{
        display:flex;
        padding: 5px 7px;
        margin-left: 30px;
        width:15%; 
        height: 30px;
        
      }

    </style>
  </head>
  <body>
    <?php include 'inc/header.php'; ?>
    <?php 
      //check booking id from url
      if(!isset($_GET['id']))
      {
        redirect('booking.php');
      }
      else if(!(isset($_SESSION['login']) && $_SESSION['login']==true))
      {
        redirect('booking.php');
      }
      $data = filteration($_GET);
      $res=select("SELECT * FROM `puja` WHERE `id`=?",[$data['id']],'i');
      if(mysqli_num_rows($res)==0)
      {
        redirect('booking.php');
      }
      $puja_data=mysqli_fetch_assoc($res);

      $_SESSION['puja']=[
        "id" => $puja_data['id'],
        "puja_name" => $puja_data['puja_name'],
        "price" => $puja_data['price'],
        "samagri" => $puja_data['samagri'],
        "payment" => null,
        "available" => false,
      ];
      // fetching user data
      $user_res= select("SELECT * FROM `userpanel` WHERE `srno`=? LIMIT 1",[$_SESSION['uId']],"i");
      $user_data =mysqli_fetch_assoc($user_res);
    ?>
    <h1>Book Your Puja</h1>
    <div class="s-nav">
      <a href="home.php">Home</a> <span>>>></span><a href="booking.php">Booking</a>
    </div>
    <div class="bk-container">
      <form method="POST" id="booking-form">
        <h3>Booking Details</h3>
    
        <label for="fname"><i class="fa fa-user"></i> User Name</label>
        <input type="text" id="b-u-name" name="b-u-name" placeholder="Enter your name" value="<?php echo $user_data['name']; ?>" readonly required>
        
        <label for="ph"><i class="fa fa-phone"></i> Phone no.</label>
        <input type="text" id="ph" name="ph" placeholder="Enter your phone number" value="<?php echo $user_data['mobile']; ?>" required>

        <label for="venue"><i class="fa fa-institution"></i> Venue</label>
        <div class="v-cont">
          <label><input type="radio" name="venue" value="temple" id="temp-inp" onclick="no_dis()" checked="checked">Temple</label>
          <label><input type="radio" name="venue" onclick="dis()">Address</label>
          <textarea type="text" class="b-txtarea" name="address" id="address-inp" onchange="addr_val()" required><?php echo $user_data['address']; ?></textarea>
        </div>

        <label for="pname"><i class="fa fa-envelope"></i> Puja Name</label>
        <input type="text" readonly="readonly" id="pname" name="pname" placeholder="Enter Puja name" value="<?php echo $puja_data['puja_name']; ?>" readonly required>

        <label for="dop"><i class="fa fa-calendar"></i> Date of puja<span class="dop-inst"><sup>* enter 3 day before <sup></span>  </label>
        <input type="date" id="dop" name="dop" min="" required>

        <label><i class="fa fa-shopping-cart"></i> Buy Samagri</label>
        <select name="samgri" id="smgri" class="b-drop-down" onchange="pass_value()" required>
          <option value="">Select Option</option>
          <option value="00">No Samagri</option>
          <option value="<?php echo $puja_data['samagri']; ?>">Samagri <span class="rupee">&#8377;</span> <p><?php echo $puja_data['samagri']; ?></p></option>
        </select>

        <h3>Payment Detail</h3>
        <div class="v-cont">
          <h4>Total Amount
          <p>Puja Dakshina <span class="b-pric">&#8377; <span id="puja_price"><?php echo $puja_data['price']; ?></span></span></p>
          <p>Samagri Amount <span class="b-pric">&#8377; <span id="samagri_price"></span></span></p>
          <hr>
          <p style="color:black">Total <span class="b-pric" style="color:black"><b id="total"></b></span></p>
        </div>

        <button type="submit" name="submit" class="btn">Submit</button>
      </form>
    </div>
    <?php require("inc/footer.php"); ?>
  </body>
  <script>
    var date= new Date();
    var tdate= date.getDate()+3;
    var month=date.getMonth() +1;
    if(tdate<10){
        tdate = '0'+month;
    }
    if(month<10){
        month = '0'+month;
    }
    var year= date.getUTCFullYear();
    var minDate= year + "-" + month + "-" +tdate;   console.log(minDate);
    document.getElementById("dop").setAttribute('min', minDate);

    let booking_form=document.getElementById("booking-form");
    let userId= <?php echo $user_data['srno']; ?>;
    let pujaId=<?php echo  $puja_data['id']; ?>;
    let dop=document.getElementById("dop");
    let smg,total,address=document.getElementById("temp-inp").value;

    function dis()
    {
      document.getElementById("address-inp").style.display="flex";
      address=document.getElementById("address-inp").value;
    }

    function no_dis()
    {
      document.getElementById("address-inp").style.display="none";
      address=document.getElementById("temp-inp").value;
    }

    function addr_val()
    {
      address=document.getElementById("address-inp").value;
    }
    function pass_value()
    {
      smg = parseInt(document.getElementById("smgri").value);
      price = parseInt(document.getElementById("puja_price").innerText);
      total = parseInt(smg+price);
      console.log(smg);

      // showing values in form
      document.getElementById("samagri_price").innerText = smg;
      document.getElementById("total").innerText=total;
    }
   
    // passing values of form.

    booking_form.addEventListener('submit',function(e){
  
      let data = new FormData();
      data.append('userId',userId);
      data.append('address',address);
      data.append('pujaId',pujaId);
      data.append('dop',dop.value);
      data.append('smg',smg);
      data.append('total',total);
      console.log(data);
      data.append('booking_form','');

      let xhr= new XMLHttpRequest();
      xhr.open("POST","ajax/confirm_booking.php",true);
      
      xhr.onload = function(){ 
        //console.log(this.responseText); 
        if(this.responseText==1)
        {
          alert('Thank You for booking. You will be intimated soon');
        }
        else{
          alert(" Failed!, Server down ");
        }

      }
      
      xhr.send(data);
    });

  </script>
</html>

