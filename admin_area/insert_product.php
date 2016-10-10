<!DOCTYPE>
<?php
include("../includes/db.php");
?>

<html>

<head>
<title>insert product</title>
    <link rel="stylesheet" href="../styles/insert_product.css" media="all" />

    <!--<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>--> <!-- Script for the text area -->
    <!--<script>tinymce.init({ selector:'textarea' });</script>-->  <!-- Script for the text area -->
</head>

<body>

<form action="insert_product.php" method="post" enctype="multipart/form-data">

    <table id="table">

        <tr>
            <td colspan="7">
                <h2>insert product below</h2>
            </td>
        </tr>

        <tr>
            <td>Product Title</td>
            <td><input type="text" name="product_title" size="50" required/></td>
        </tr>
        <tr>
            <td>Product Category</td>
            <td>
                <select name="product_cat" required>
                    <option>select a Category</option>

                <?php
                // pulling the categories from the database to display within the categories drop down menu
                $get_cats = "select * from categories";

                $run_cats = mysqli_query($connect, $get_cats);      //while loop running to fetch data from database
                while ($row_cats = mysqli_fetch_array(($run_cats))){

                    $cat_id = $row_cats['cat_id'];               //local variable bringing in the data from the table
                    $cat_title = $row_cats['cat_title'];

                    echo "<option value='$cat_id'>$cat_title</option>";   // dynamic list
                }


                ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Product Brand</td>
            <td><select name="product_brand" required>
                    <option>select a Brand</option>

                    <?php
                    // pulling the categories from the database to display within the categories drop down menu
                    $get_brands = "select * from brands";

                    $run_brands = mysqli_query($connect, $get_brands);      //while loop running to fetch data from database
                    while ($row_brands = mysqli_fetch_array(($run_brands))){

                        $brand_id = $row_brands['brand_id'];               //local variable bringing in the data from the table
                        $brand_title = $row_brands['brand_title'];

                        echo "<option value='$brand_id'>$brand_title</option>";   // dynamic list
                    }


                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Product Image</td>
            <td><input type="file" name="product_image" required/></td>
        </tr>
        <tr>
            <td>Product Price</td>
            <td><input type="text" name="product_price" required/></td>
        </tr>
        <tr>
            <td>Product Description</td>
            <td><textarea name="product_desc" cols="20" rows="10"></textarea></td>
        </tr>
        <tr>
            <td>Product Keywords</td>
            <td><input type="text" name="product_keywords" size="50" /></td>
        </tr>
        <tr>
            <td colspan="7"><input type="submit" name="insert_post" value="insert now" /></td>
        </tr>


    </table>

</form>


</body>

</html>

<?php
// if something is active,
    if(isset($_POST['insert_post'])){  //insert_post calling to the button

        //getting text data from fields
        $product_title = $_POST['product_title'];
        $product_cat = $_POST['product_cat'];
        $product_brand = $_POST['product_brand'];
        $product_price = $_POST['product_price'];
        $product_desc = $_POST['product_desc'];
        $product_keywords = $_POST['product_keywords'];

        //getting image from the field
        $product_image = $_FILES['product_image']['name'];  // file ins
        $product_image_tmp = $_FILES['product_image']['tmp_name'];

        if(move_uploaded_file($product_image_tmp,"product_images/$product_image")){
            echo "file not uploaded";
        }else{
            echo "file uploaded";
        }



            // move the uploaded file to the images folder in admin


        $insert_product = "insert into products(product_cat,product_brand,product_title,product_price,product_desc,product_image,product_keywords) 
                                   VALUES ('$product_cat','$product_brand','$product_title','$product_price','$product_desc','$product_image','$product_keywords')";

        $insert_pro = mysqli_query($connect, $insert_product);

        if($insert_pro){

            echo "<script>alert('Product has been inserted')</script>"; //javascript alert
            //echo "<script>window.open('insert_product.php','_self')</script>"; // javascript to refresh the page

        }


    }






?>