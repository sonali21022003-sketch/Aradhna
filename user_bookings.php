<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User-bookings</title>
</head>
<body>
    <?php include "inc/header.php"; 
        if(!(isset($_SESSION['login']) && $_SESSION['login']==true))
        {
        redirect('home.php');
        }
    ?>
   
    <div class="g-head">
        <h3>Bookings By User</h3>
    </div>
    <div class="s-nav">
        <a href="home.php">Home</a><span>>>>
    </div>	
    
    <div class="container">
        <div class=noti-cont>
            <?php
                $query="SELECT bo.*,up.*,pj.*,pt.*,bo.srno as bosrno,pt.srno as pjsrno FROM `bookings` bo 
                INNER JOIN `userpanel` up ON bo.userId=up.srno
                INNER JOIN `puja` pj ON bo.pujaId=pj.id
                INNER JOIN `pujari_detail` pt ON bo.pujariId=pt.srno
                WHERE `acpt_rej`=1 AND `userId`=$_SESSION[uId] AND `paid`='pending'
                ORDER BY bo.srno DESC" ;
                $res = mysqli_query($con,$query);
            
                while($data = mysqli_fetch_assoc($res))
                {
                    echo<<< tbdata
                    <div class="p-d-card wd-60">
                        <h4>Hi $data[name] </h4>
                        <h5 style="color:green">Your booking has been confirmed On .</h5>
                        <p class="pj-head fs">Puja Name: <span class="pj-val">$data[puja_name]</span></p>
                        <p class="pj-head fs">Pujari Name: <span class="pj-val">$data[pujari_name] </span>
                        Contact no:<span class="pj-val">$data[mobile1] , $data[mobile2]</span></p>
                        <p class="pj-head fs">On Date: <spna class="pj-val">$data[dop]</span></p>
                        <p class="pj-head fs">Timings: <span class="pj-val">$data[timing]</span></p>
                        <p class="pj-head fs">Venue: <soan class="pj-val">$data[venue]</span></p>
                        <p style="font-size:22px">Please pay the amount of $data[total_amt].</p>
                        <button class="p-btn" data-target="#pay-modal" onclick=pass_id($data[bosrno],$data[total_amt])>Pay</button>
                    </div>
                    tbdata;
                }
            ?>
        </div>
       <h2 align-items="center" margin="10px">Your Histroy</h2>
        <div class="table-container">
            <div class="table-div">
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>#</th> 
                            <th>Puja Name</th>
                            <th>Date of Puja</th>
                            <th>Venue</th>
                            <th>Total Amount</th>
                            <th>Date & Time</th>
                            <th>Accepted/Rejected</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $query="SELECT bo.*,pj.* FROM `bookings` bo 
                            INNER JOIN `puja` pj ON bo.pujaId=pj.id
                            WHERE bo.userId=$_SESSION[uId]
                            ORDER BY bo.srno DESC" ;

                            $i=1;
                            $res = mysqli_query($con,$query);
                            //if(mysqli_fetch_assoc($res)<=0)
                            // {
                            //     echo<<< data
                            //         <tr>
                            //             <td></td><td></td><td></td>
                            //             <td> No history is available .</td><td></td>
                            //         </tr>
                            //     data;
                            // }
                            while($data = mysqli_fetch_assoc($res))
                            {
                                
                                $dop = date("d-m-Y",strtotime($data['dop']));
                                if($data['acpt_rej']==1){$a='Accepted';} else if($data['acpt_rej']==NULL){$a='Pending';} else{$a='Rejected';}
                                echo<<< tbdata
                                    <tr>
                                        <td>$i</td>
                                        <td>$data[puja_name]</td>
                                        <td>$dop</td>
                                        <td>$data[venue]</td>
                                        <td><span>&#8377;</span>$data[total_amt]</td>
                                        <td>$data[c_date]</td>
                                        <td>$a</td>
                                    </tr>
                                tbdata;
                                $i++;
                            }
                        ?>
                    
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Payment model -->
        <div id="pay-modal" class="edit" onclick="dis(this.id)">
            <div class="main" style="margin-top:unset">
                <!-- <span class="cls" >&times;</span> -->
                <h1 style="color:black">Edit</h1>
                <form method="POST" id="pay-form">
                    <label for="rupee"><b>Amount</b> <span class="rupee">&#8377;</span></label>
                    <div class="input-box">
                        <input type="number" placeholder="Enter Amount" name="amount" id="amt_pay" readonly required>
                    </div>
                  
                    <div class="wrap">
                        <button type="submit" id="booksrno" style="background-color:black" name="pay">Submit</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <!-- js for model -->
    <script>
        const button =document.querySelectorAll("[data-target]");
        button.forEach((btns) => {
            btns.addEventListener("click",() =>{
                document.querySelector(btns.dataset.target).classList.add("active");
            });
        });
        function dis(a){
            const modal= document.getElementById(a);
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.classList.remove("active");
                }
            }
        }
        function pass_id(id,amt)
        {
            document.getElementById("booksrno").value=id;
            document.getElementById("amt_pay").value = amt;
        }
    </script>
    
    <!-- update payment in booking form data in DB -->
    <?php 
        if(isset($_POST['pay']))
        {
        $ft_data = filteration($_POST);
        //print_r(json_encode($ft_data));
            $q="UPDATE `bookings` SET `paid`='paid' WHERE `srno`='$ft_data[pay]'";
            $res = mysqli_query($con,$q);
            if($res==1){
            echo"<script> alert('Your booking is Confirmed. Thank you for using our services');</script>";
            }
        }
    ?>
    <?php include "inc/footer.php"; ?>
</body>
</html>