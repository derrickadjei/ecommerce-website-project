<?php

$connect = mysqli_connect("localhost","root","","ecommerce");


//get IP address function to get the user IP address... (taken from the internet phpfi.com)
function getIp() {
    $ip = $_SERVER['REMOTE_ADDR'];

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    return $ip;
}


//function to post to the  cart table
function cart(){

    global $connect;

    if(isset($_GET['add_cart'])){

        $ip= getIp();
        $pro_id = $_GET['add_cart'];
        $check_pro = "select * from cart where ip_add ='$ip' AND p_id='$pro_id'";

        $run_check = mysqli_query($connect, $check_pro);

        if(mysqli_num_rows($run_check) > 0){

            echo"";
        }

        else{

            $insert_pro = "insert into cart (p_id,ip_add) values ('$pro_id','$ip')";

            $run_pro = mysqli_query($connect, $insert_pro);

            echo "<script>window.open('index.php','_SELF')</script>";

        }

    }

}


function total_items(){

    if(isset($_GET['add_cart'])) {
        global $connect;
        $ip = getIP();

        $get_items = "select * from cart where ip_add='$ip'";
        $run_items = mysqli_query($connect, $get_items);
        $count_items = mysqli_num_rows($run_items);
    }
    else {
        global $connect;
        $ip = getIP();

        $get_items = "select * from cart where ip_add='$ip'";
        $run_items = mysqli_query($connect, $get_items);
        $count_items = mysqli_num_rows($run_items);
    }

    echo "$count_items";

}


function total_price(){

    $total = 0;

    global $connect;

    $ip = getIp();

    $select_price = "select * from cart where ip_add='$ip'";

    $run_price = mysqli_query($connect, $select_price);



    while($p_price = mysqli_fetch_array($run_price)) {   // to bring us detail from the table to use any coloumn

        $pro_id = $p_price['p_id'];

        $pro_price = "select * from products where product_id='$pro_id'";

        $run_pro_price = mysqli_query($connect, $pro_price);

        while ($pp_price = mysqli_fetch_array($run_pro_price)) {

            $product_price = array($pp_price['product_price']); // all values to be stored in the array

            $values = array_sum($product_price); //using aray_sum to calculate product_price

            $total += $values;


        }

    }
   echo "£". $total;

}


//getting the categories
function getCats(){
    global $connect;

    $get_cats = "select * from categories";       //local variabe

    $run_cats = mysqli_query($connect, $get_cats);      //while loop running to fetch data from database
    while ($row_cats = mysqli_fetch_array(($run_cats))){

        $cat_id = $row_cats['cat_id'];               //local variable bringing in the data from the table
        $cat_title = $row_cats['cat_title'];

        echo "<li><a href='index.php?cat=$cat_id'>$cat_title</a></li>";   // dynamic list
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

        echo "<li><a href='index.php?brand=$brand_id'>$brand_title</a></li>";   // dynamic list
    }

}

// getting the products for the database
function getProduct(){

    if(!isset($_GET['cat'])) {

        if(!isset($_GET['brand'])){
            global $connect;

            $get_Product = "select * from products order by RAND() LIMIT 0,6";

            $run_Product = mysqli_query($connect, $get_Product);

            while ($row_product = mysqli_fetch_array($run_Product)) {

                $product_id = $row_product['product_id'];
                $product_cat = $row_product['product_cat'];
                $product_brand = $row_product['product_brand'];
                $product_title = $row_product['product_title'];
                $product_price = $row_product['product_price'];
                $product_image = $row_product['product_image'];

                echo "<div id='single_product'>
              <h3>$product_title</h3>
              <img src='../admin_area/product_images/$product_image'/> 
              <p>Price: £ $product_price</p>
              
              <a href='details.php?product_id=$product_id'>Details</a> <!-- ?product_id will allow to add the product details to the details page-->
              
              
              <a href='index.php?add_cart=$product_id'><button>Add to cart</button></a> <!-- ?product_id will allow to add the product details to the cart-->
              
              
              
              </div>
              
              ";

                //looking for the image to display
            }
        }
    }
}

// product details page
function product_details(){
    global $connect;

    if(isset($_GET['product_id'])) {

        $product_id = $_GET['product_id']; // get ID from the get method and pass this to the local variable $product ID

        $get_Product = "select * from products where product_id=$product_id";

        $run_Product = mysqli_query($connect, $get_Product);

        while ($row_product = mysqli_fetch_array($run_Product)) {

            $product_id = $row_product['product_id'];
            $product_title = $row_product['product_title'];
            $product_price = $row_product['product_price'];
            $product_image = $row_product['product_image'];
            $product_desc =  $row_product['product_desc'];

            echo "<div id='single_product'>
              <h3>$product_title</h3>
              <img src='../admin_area/product_images/$product_image'/> 
              
              <p>£ $product_price</p>
              
              <p>$product_desc</p>
              
              <a href='index.php?'>Go back</a> <!-- ?product_id will allow to add the product details to the details page-->
              
              
              <a href='index.php?product_id=$product_id'><button>Add to cart</button></a> <!-- ?product_id will allow to add the product details to the cart-->
              
              
              
              </div>
              
              ";

            //looking for the image to display
        }
    }
}

//getting the category products
function getCatProduct(){

    if(isset($_GET['cat'])) {

        $cat_id = $_GET['cat'];

            global $connect;

            $get_cat_pro = "select * from products where product_cat='$cat_id'";

            $run_cat_pro = mysqli_query($connect, $get_cat_pro);

            $count_cat_pro = mysqli_num_rows($run_cat_pro); // counting  how many items are in category


        if($count_cat_pro == 0){  // checking to see if there is anything in this category

            echo "No products in this category";
        }

            while ($row_cat_pro = mysqli_fetch_array($run_cat_pro)) {

                $product_id = $row_cat_pro['product_id'];
                $product_cat = $row_cat_pro['product_cat'];
                $product_brand = $row_cat_pro['product_brand'];
                $product_title = $row_cat_pro['product_title'];
                $product_price = $row_cat_pro['product_price'];
                $product_image = $row_cat_pro['product_image'];


                echo "<div id='single_product'>
                      <h3>$product_title</h3>
                      <img src='../admin_area/product_images/$product_image'/> 
                      <p>£ $product_price</p>
                      
                      <a href='details.php?product_id=$product_id'>Details</a> <!-- ?product_id will allow to add the product details to the details page-->
                      
                      
                      <a href='index.php?product_id=$product_id'><button>Add to cart</button></a> <!-- ?product_id will allow to add the product details to the cart-->
                      
                      
                      
                      </div>
                      
                      ";

                //looking for the image to display
            }


    }
}

//
function getBrandProduct(){

        if(isset($_GET['brand'])){

            $brand_id= $_GET['brand'];

            global $connect;

            $get_brand_pro = "select * from products where product_brand='$brand_id'";

            $run_brand_pro = mysqli_query($connect, $get_brand_pro);


            $count_brand_pro = mysqli_num_rows($run_brand_pro); // counting  how many items are in category


            if($count_brand_pro == 0){  // checking to see if there is anything in this category

                echo "No products in this category";
            }

            while ($row_brand_pro = mysqli_fetch_array($run_brand_pro)) {

                $product_id = $row_brand_pro['product_id'];
                $product_cat = $row_brand_pro['product_cat'];
                $product_brand = $row_brand_pro['product_brand'];
                $product_title = $row_brand_pro['product_title'];
                $product_price = $row_brand_pro['product_price'];
                $product_image = $row_brand_pro['product_image'];

                echo "<div id='single_product'>
              <h3>$product_title</h3>
              <img src='../admin_area/product_images/$product_image'/> 
              <p>£ $product_price</p>
              
              <a href='details.php?product_id=$product_id'>Details</a> <!-- ?product_id will allow to add the product details to the details page-->
              
              
              <a href='index.php?product_id=$product_id'><button>Add to cart</button></a> <!-- ?product_id will allow to add the product details to the cart-->
              
              
              
              </div>
              
              ";

                //looking for the image to display
            }
        }
}

// getting all products
function allProduct(){

    if(!isset($_GET['cat'])) {

        if(!isset($_GET['brand'])){
            global $connect;

            $get_Product = "select * from products ";

            $run_Product = mysqli_query($connect, $get_Product);

            while ($row_product = mysqli_fetch_array($run_Product)) {

                $product_id = $row_product['product_id'];
                $product_cat = $row_product['product_cat'];
                $product_brand = $row_product['product_brand'];
                $product_title = $row_product['product_title'];
                $product_price = $row_product['product_price'];
                $product_image = $row_product['product_image'];

                echo "<div id='single_product'>
              <h3>$product_title</h3>
              <img src='../admin_area/product_images/$product_image'/> 
              <p>£ $product_price</p>
              
              <a href='details.php?product_id=$product_id'>Details</a> <!-- ?product_id will allow to add the product details to the details page-->
              
              
              <a href='index.php?product_id=$product_id'><button>Add to cart</button></a> <!-- ?product_id will allow to add the product details to the cart-->
              
              
              
              </div>
              
              ";

                //looking for the image to display
            }
        }
    }
}

// search product function
function searchProduct(){
    global $connect;

    if(isset($_GET['search'])) {

        $search_query = $_GET['user_query'];


            $get_Product = "select * from products where product_keywords like '%$search_query%' ";

            $run_Product = mysqli_query($connect, $get_Product);

            while ($row_product = mysqli_fetch_array($run_Product)) {

                $product_id = $row_product['product_id'];
                $product_cat = $row_product['product_cat'];
                $product_brand = $row_product['product_brand'];
                $product_title = $row_product['product_title'];
                $product_price = $row_product['product_price'];
                $product_image = $row_product['product_image'];

                echo "<div id='single_product'>
              <h3>$product_title</h3>
              <img src='../admin_area/product_images/$product_image'/> 
              <p>£ $product_price</p>
              
              <a href='details.php?product_id=$product_id'>Details</a> <!-- ?product_id will allow to add the product details to the details page-->
              
              
              <a href='index.php?product_id=$product_id'><button>Add to cart</button></a> <!-- ?product_id will allow to add the product details to the cart-->
              
              
              
              </div>
              
              ";

                //looking for the image to display
            }

    }
}