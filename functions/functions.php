<?php

$connect = mysqli_connect("localhost","root","","ecommerce");


//getting the categories
function getCats(){
    global $connect;

    $get_cats = "select * from categories";       //local variabe

    $run_cats = mysqli_query($connect, $get_cats);      //while loop running to fetch data from database
    while ($row_cats = mysqli_fetch_array(($run_cats))){

        $cat_id = $row_cats['cat_id'];               //local variable bringing in the data from the table
        $cat_title = $row_cats['cat_title'];

        echo "<li><a href='#'>$cat_title</a></li>";   // dynamic list
    }

}

//getting brands
function getBrands(){
    global $connect;

    $get_brands = "select * from brands";        //local variable

    $run_brands = mysqli_query($connect, $get_brands);      //while loop running to fetch data from database
    while ($row_brands = mysqli_fetch_array(($run_brands))){

        $brand_id = $row_brands['brand_id'];               //local variable bringing in the data from the table
        $brand_title = $row_brands['brand_title'];

        echo "<li><a href='#'>$brand_title</a></li>";   // dynamic list
    }

}

// gettign the products for the database
function getProduct(){
    global $connect;

    $get_Product = "select * from products order by RAND() LIMIT 0,6";

    $run_Product = mysqli_query($connect, $get_Product);

    while ($row_product = mysqli_fetch_array($run_Product)){

        $product_id = $row_product['product_id'];
        $product_cat = $row_product['product_cat'];
        $product_brand = $row_product['product_brand'];
        $product_title = $row_product['product_title'];
        $product_price = $row_product['product_price'];
        $product_image = $row_product['product_image'];

        echo "<div id='single_product'>
              <h3>$product_title</h3>
              </div>";

    }



}