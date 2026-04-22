
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Aradhna</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="style/homestyle.css">
</head>
<body>
    <?php include 'inc/header.php'; ?>
    <!-- carousal -->
    <div class="slideshow-container">
        <?php
            $details = selectAll('carousel');
            $path=CARSL_IMG_PATH;
            while($row=mysqli_fetch_assoc($details))
            {
                // $path$row[image] -- path is img address, row is name of img, [image] is name of img column in database
                echo<<<data
                    <div class="mySlides fade">
                        <img src="$path$row[image]">          
                    </div>
                data;
            }
        ?>
    </div>
    <!-- javascript for carousal -->
    <script>
        let slideIndex = 0;
        showSlides();

        function showSlides() {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > slides.length) { slideIndex = 1 }
            slides[slideIndex - 1].style.display = "block";
            setTimeout(showSlides, 2000); // Change image every 2 seconds
        }
    </script>

    <!-- marquee -->
    <div class="heading-card">
        <div class="c1">
            <h2>Latest<span>>>></span></h2>
            <?php
                $details = selectAll('headline');
                while($row=mysqli_fetch_assoc($details))
                {
                    echo<<<data
                        <marquee onmouseover="this.stop();" onmouseout="this.start();" direction="left" scrollamount=8>
                        $row[latest]</marquee>
                    data;
                }
            ?>
        </div>
    </div>
    
    <!-- booking cards  -->
    <div class="g-head">
        <h3>Our <span>Puja</span></h3>
    </div>
    <div class="booking-list">
        <div class="wrapper-b"> 
            <ul class="carousel"> 
                <?php
                     $login=0;
                     if(isset($_SESSION['login']) && $_SESSION['login']==true)
                     {
                        $login=1;
                     }
                    $details = selectAll('puja');
                    $path=PUJA_IMG_PATH;
                    while($row=mysqli_fetch_assoc($details))
                    {
                        echo<<<data
                            <li class="l-card"> 
                                <div class="card">
                                    <div class="card-img">
                                        <img src="$path$row[image]">
                                    </div>
                                    <h2>$row[puja_name]</h2>
                                    <p class="price"><span>&#8377;</span>$row[price]</p>
                                    <p class="puja-desc">$row[description]</p>
                                    <div class="btn"><button class="b-btn" onclick="checkLogin($login,$row[id])">Book Now</button>
                                        <a href="puja_details.php?id=$row[id]">More Details</a>
                                    </div>
                                </div>
                            </li> 
                        data;
                    }
                ?>
            </ul> 
        </div>
        <div class="more-btn"><a href="booking.php"><button>More>></button></a></div>
    </div> 
    <script>
        document.addEventListener("DOMContentLoaded", function() { 
        const carousel = document.querySelector(".carousel"); 
        const arrowBtns = document.querySelectorAll(".wrapper-b i"); 
        const wrapper_b = document.querySelector(".wrapper-b"); 

        const firstCard = carousel.querySelector(".l-card"); 
        const firstCardWidth = firstCard.offsetWidth; 

        let isDragging = false, 
            startX, 
            startScrollLeft, 
            timeoutId; 

        const dragStart = (e) => { 
            isDragging = true; 
            carousel.classList.add("dragging"); 
            startX = e.pageX; 
            startScrollLeft = carousel.scrollLeft; 
        }; 

        const dragging = (e) => { 
            if (!isDragging) return; 
        
            // Calculate the new scroll position 
            const newScrollLeft = startScrollLeft - (e.pageX - startX); 
        
            // Check if the new scroll position exceeds 
            // the carousel boundaries 
            if (newScrollLeft <= 0 || newScrollLeft >= 
                carousel.scrollWidth - carousel.offsetWidth) { 
                
                // If so, prevent further dragging 
                isDragging = false; 
                return; 
            } 
        
            // Otherwise, update the scroll position of the carousel 
            carousel.scrollLeft = newScrollLeft; 
        }; 

        const dragStop = () => { 
            isDragging = false; 
            carousel.classList.remove("dragging"); 
        }; 

        const autoPlay = () => { 
        
            // Return if window is smaller than 800 
            if (window.innerWidth < 800) return; 
            
            // Calculate the total width of all cards 
            const totalCardWidth = carousel.scrollWidth; 
            
            // Calculate the maximum scroll position 
            const maxScrollLeft = totalCardWidth - carousel.offsetWidth; 
            
            // If the carousel is at the end, stop autoplay 
            if (carousel.scrollLeft >= maxScrollLeft) return; 
            
            // Autoplay the carousel after every 2500ms 
            timeoutId = setTimeout(() => 
                carousel.scrollLeft += firstCardWidth, 2500); 
        }; 

        carousel.addEventListener("mousedown", dragStart); 
        carousel.addEventListener("mousemove", dragging); 
        document.addEventListener("mouseup", dragStop); 
        wrapper_b.addEventListener("mouseenter", () => 
            clearTimeout(timeoutId)); 
        wrapper_b.addEventListener("mouseleave", autoPlay); 

        // // Add event listeners for the arrow buttons to 
        // // scroll the carousel left and right 
        // arrowBtns.forEach(btn => { 
        // 	btn.addEventListener("click", () => { 
        // 		carousel.scrollLeft += btn.id === "left" ? 
        // 			-firstCardWidth : firstCardWidth; 
        // 	}); 
        // }); 
        }); 

    </script>
    <!-- gallery slider -->
    <div class="g-head">
        <h3>Gallery</h3>
    </div>
    <div class="gallery-list">
        <div class="wrapper-b"> 
            <ul class="carousel"> 
                <?php
                    $details = selectAll('gallery');
                    $path=GAL_IMG_PATH;
                    while($row=mysqli_fetch_assoc($details))
                    {
                        echo<<<data
                            <li class="l-card"> 
                                <div class="g-card">
                                    <div class="g-card-img">
                                        <img src="$path$row[image]">
                                    </div>
                                </div>
                            </li> 
                        data;
                    }
                ?>
            </ul> 
        </div>
        <div class="more-btn"><a href="gallery.php"><button>More>></button></a></div>
    </div> 
    <!-- Pujari slider -->
    <div class="g-head">
        <h3>Our <span>Pujari's</span></h3>
    </div>
    <div class="gallery-list">
        <div class="wrapper-b"> 
            <ul class="carousel"> 
                <?php
                    $details = selectAll('pujari_detail');
                    $path=IMG_PATH;
                    while($row=mysqli_fetch_assoc($details))
                    {
                        echo<<<data
                            <li class="l-card"> 
                                <div class="p-slider-card">
                                    <div class="p-card">
                                        <img src="$path$row[picture]">
                                        <h4>$row[pujari_name]</h4>
                                    </div>
                                </div>
                            </li> 
                        data;
                    }
                ?>
            </ul> 
        </div>
        
    </div>
    <!-- footer of the page -->
    <?php require("inc/footer.php"); ?>
</body>

</html>