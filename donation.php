<html>
<head>
  <title>Donate</title>
  <style type="text/css">
    * {
      font-family: 'Times New Roman', Times, serif;
      margin: 0;
    }
    .main-box{
      margin-bottom: 10px;
    }
    .head,
    .ac-head {
      margin: 8px;
      padding: 8px;
    }

    .head h1 {
      text-align: center;
    }

    .img {
      margin: 20px;
      display: flex;
      width: 95%;
      height: 300px;
    }
    .img img{
      width: 100%;
      object-fit: cover;
    }

    .ac-head h2 {
      color: black;
      text-align: center;
    }

    .para {
      line-height : 1.5;
      font-size : 20px;
      padding: 10px;
    }

    .table {
      display: flex;
      justify-content: center;
      padding: 10px 80px 10px 80px;
    }

    .table table {
      width: 100%;
      height: 100px;
      border-spacing: 0;
      text-align: center;
    }

    table,
    td,
    th {
      border: 1px solid #dddd;
    }

    th {
      font-size: 20px;
    }

    td {
      font-size: 18px;
    }

    td,
    th {
      padding: 0;
    }

    .button {
      display: flex;
      justify-content: center;
    }

    .button button {
      background: red;
      border: 2px solid red;
      width: 120px;
      height: 50px;
      border-radius: 10px;
      color: white;
      font-size: 20px;
    }

    .button button:hover {
      background: white;
      color: red;
      cursor: pointer;
    }

    /*-----------------------------------------*/
    /* The popup form - hidden by default */
    .donation-form {
      display: none;
      align-items: center;
      justify-content: center;
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      padding: 20px;
      z-index: 1;
    }

    /* Add styles to the form container */
    .form-container {
      border-radius: 15px;
      max-width: 350px;
      padding-top: 10px;
      padding-bottom: 10px;
      padding-left: 30px;
      padding-right: 30px;
      background-color: white;
      border: 3px solid #f1f1f1;
    }

    .form-container h1 {
      color: rgb(2, 169, 158);
      margin-bottom: 20px;
      text-align: center;
    }

    /* Full-width input fields */
    .form-container .input-box {
      width: 100%;
      background: #f1f1f1;
      margin: 5px 0 22px 0;
      border: none;
      border-radius: 15px;
    }

    .form-container input[type=text],
    .form-container input[type=number] {
      font-size: 18px;
      background: none;
      border: none;
      width: 90%;
      padding: 10px;
      outline: none;
    }
     /* Chrome, Safari, Edge, Opera */
    .form-container input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* Firefox */
    input[type=number] {
      border: none;
      outline: none;
    }

    /* Set a style for the submit/login button */
    .form-container .py-btn {
      background-color: rgb(2, 169, 158);
      color: white;
      font-size: 25px;
      padding: 16px 20px;
      border: none;
      cursor: pointer;
      width: 100%;
      margin-bottom: 10px;
      opacity: 0.8;
      border-radius: 15px;
    }

    /* Add a red background color to the cancel button */
    .cancel {
      top: 0;
      right: 0;
      float: right;
      font-size: 22px;
      height: 20px;
    }

    .cancel:hover,
    .cancel:focus {
      color: red;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <?php require 'inc/header.php'; ?>
  <!-- for account details -->
  <?php 
    $account_q = "SELECT * FROM `dona_ac` WHERE `srno`=?";
    $value = [1];
    $account_r = mysqli_fetch_assoc(select($account_q,$value,'i'));
  ?>

  <div class="main-box">
    <div class="head">
      <h1>Donation</h1>
    </div>
    <div class="img">
      <?php
        $details = selectAll('dona_frontend');
        $path=DONA_IMG_PATH;
        $row=mysqli_fetch_assoc($details);
          echo<<<data
            <img src="$path$row[image]">
          data;
      ?>
    </div>
    <div class="para">
      <?php echo $row['para']; ?>
      <p><b>Do not hand over cash to any person.</b></p>
    </div>
    <div class="ac-head">
      <h2>Account Detail</h2>
    </div>
    <div class="table">
      <table>
        <tr>
          <th>Name</th>
          <th>Account no.</th>
          <th>Branch</th>
          <th>IFSC code</th>
        </tr>
        <tr>
          <td><?php echo $account_r['name']; ?></td>
          <td><?php echo $account_r['ac_no']; ?></td>
          <td><?php echo $account_r['branch']; ?></td>
          <td><?php echo $account_r['ifsc_code']; ?></td>
        <tr>
      </table>
    </div>
    <div class="button">
      <button onclick="openform()">Donate</button>
    </div>
  </div>
  <div class="donation-form" id="donaform">
    <form method="POST" class="form-container">
      <span class="cancel" onclick="closeform()">&#10006;</span>
      <h1>Donate</h1>
      <label for="ph"><b>Name</b></label>
      <div class="input-box">
        <input type="text" placeholder="Enter your name" name="name" required>
      </div>

      <label for="email"><b>Email</b></label>
      <div class="input-box">
        <input type="text" placeholder="Enter Email" name="email">
      </div>

      <label for="rupee"><b>Amount</b></label>
      <div class="input-box">
        <span class="rupee">&#8377;</span>
        <input type="number" placeholder="Enter Amount" name="amount" step="any" min="0" oninput="check(this)" title="Amount can not be zero" required>
      </div>

      <button type="submit" name="send" class="py-btn">Send</button>
    </form>
  </div>
  <script>
    function check(input){
      if(input.value <= 0)
      {
        input.setCustomValidity('Amount must be greater than 0');
      }
    }
    function openform() {
      document.getElementById("donaform").style.display = "flex";
    }

    function closeform() {
      document.getElementById("donaform").style.display = "none";
    }
  </script>
  <!-- insert donation form data in DB -->
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
        $q="INSERT INTO `donation`(`name`, `email`, `amount`) VALUES (?,?,?)";
        $value=[$ft_data['name'],$ft_data['email'],$ft_data['amount']];
        $res = insert($q,$value,'ssi');
        if($res==1){
          echo"<script> alert('Thank you so much for this amount :)');</script>";
        }
        else{
          echo"<script> alert('Server Down! Try again later.');</script>";
        }
      }
    }
  ?>
  <?php include 'inc/footer.php'; ?>
</body>
</html>