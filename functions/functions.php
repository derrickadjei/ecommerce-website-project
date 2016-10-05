<?php
/**
 * Created by PhpStorm.
 * User: derrickadjie
 * Date: 04/10/2016
 * Time: 14:33
 */

$connect = mysqli_connect("localhost","root","","ecommerce");


//getting the categories
function getCats(){
    global $connect;

    $get_cats = "select * from categories";

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

    $get_brands = "select * from brands";

    $run_brands = mysqli_query($connect, $get_brands);      //while loop running to fetch data from database
    while ($row_brands = mysqli_fetch_array(($run_brands))){

        $brand_id = $row_brands['brand_id'];               //local variable bringing in the data from the table
        $brand_title = $row_brands['brand_title'];

        echo "<li><a href='#'>$brand_title</a></li>";   // dynamic list
    }

}