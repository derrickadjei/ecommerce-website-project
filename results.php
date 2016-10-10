<!DOCTYPE>

<?php
include("functions/functions.php"); // connecting to the functions page
?>

<html>

<head>
    <title>My Online Shop</title>
    <link rel="stylesheet" href="styles/style.css" media="all" />
</head>


<body>

<!-- main container starts here-->
<div class="main_wrapper">

    <div class = header_wrapper>
        <!--<img id="banner" src="images/banner.gif" />
        <img id="logo" src="images/logo.gif" />-->

    </div>

    <!-- navigation bar -->
    <div class="menu_bar">
        <ul id="menu">
            <li><a href="index.php">home</a> </li>
            <li><a href="all_products.php">All products</a> </li>
            <li><a href="customer/my_account.php">My Account</a> </li>
            <li><a href="#">Sign up</a> </li>
            <li><a href="cart.php">shopping cart</a></li>
            <li><a href="#">contact us</a></li>
        </ul>

        <div id="form">
            <form method="get" action="results.php" enctype="multipart/form-data">
                <input type="text" name="user_query" placeholder="search a product" />
                <input type="submit" name="search" value="Search" />
            </form>

        </div>

    </div>

    <!-- content area -->
    <div class="content_wrapper">
        <div id="sidebar">
            <div id="sidebar_titles">categories</div>
            <ul id="cats">
                <?php
                getCats();  //category Function
                ?>
            </ul>

            <div id="sidebar_titles">Brands</div>
            <ul id="cats">
                <?php
                getBrands(); //brands function
                ?>
            </ul>
        </div>



        <div id="content_area">

            <div id="shopping_cart">

                <span>Welcome To tekkers! shopping cart: - total items: total price: <a href="cart.php">go to cart</a> </span>



            </div>


            <div id="product_box">

               <?php

               searchProduct()
               ?>

            </div>



        </div>
    </div>


    <!-- footer-->
    <div id="footer">
        <div id="footer_text"> Online tech site project 2016. Derrick Adjie &copy;</div>
    </div>

</div>

</body>

</html>
