<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/homestyle.css">
    <title>Gallery</title>
</head>
<body>
<?php include 'inc/header.php'; ?>
    <div class="g-container">
        <div class="g-head">
            <h3>Photo<span>Gallery</span></h3>
        </div>
        <div class="full-img" id="fullIimg">
            <span onclick="closeImg()">X</span>
            <img src="image/gallery/d1.webp" id="fimg">
        </div>
        <div class="photo-gallery">
            <?php
                $details = selectAll('gallery');
                $path=GAL_IMG_PATH;
                while($row=mysqli_fetch_assoc($details))
                {
                    echo<<<data
                        <img src="$path$row[image]" onclick="openImg(this.src)">
                    data;
                }
            ?>
        </div>
    </div>
    <?php include 'inc/footer.php'; ?>

</body>
</html>
  <!-- js for model -->
<script>
    var fullImgbox= document.getElementById("fullIimg");
    var fullImg = document.getElementById("fimg");

    function openImg(pic){
        fullImgbox.style.display = "flex";
        fullImg.src = pic;
    }
    function closeImg()
    {
        fullImgbox.style.display = "none";
    }

</script>