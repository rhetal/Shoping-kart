<?php  
    include_once('config.php');  
    if(!($_SESSION['adminId'])){  
        header("Location:admin-login.php");  
    }  

    $getProducts = getProducts();
    $category_value = getSelectCategory();


    if(isset($_POST['submitProduct'])){ 

        $category = $_POST['category']; 
        $product = $_POST['product']; 
        $price = $_POST['price']; 
        $image = $_FILES; 
        if( $category != '' || $price != '' || $product != '' || !empty($image)){
            $prod = addProduct($category, $product ,$price,$image);  
             if ($prod) {  
               header("location:product.php");  
               $_POST = array();
               $_FILES = array();

            } else {  
                echo "<script>alert('Please enter Category')</script>";  
            }  
        }else{
            echo "<script>alert('Please fill all the details')</script>";  
        }
       
    }  
   
    if(isset($_POST['submitProductEdit'])){ 

        $product_id = $_POST['product_id']; 
        $product = $_POST['product_name']; 
        $price = $_POST['price_new']; 
        $image = $_FILES; 
        $old_image =  $_POST['old_image']; 
        $category_name = $_POST['category_name']; 
        // echo "<pre>";print_r($_FILES);exit;
        if( $category_name != '' || $price != '' || $product != ''){
            $prod = editProduct($product_id,$category_name, $product ,$price,$old_image,$image);  
            if ($prod) {  
               header("location:product.php");  
               $_POST = array();
               $_FILES = array();
            } else {  
                echo "<script>alert('Issue Updating Product')</script>";  
            }  
        }else{
            echo "<script>alert('Please fill all the details')</script>";  
        }
    }  

    if(isset($_POST['action']) && $_POST['action'] == 'deleteProduct'){ 
        $prod_id = $_POST['id']; 
        $prod = deleteProduct($prod_id);  
    }  

    

?>  
<!DOCTYPE html>  
 <html lang="en" class="no-js">  
 <head>  
        <meta charset="UTF-8" />  
        <title>Add Product</title>
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/jquery-ui.min.js"></script>

    </head>  
    <body>  
        <div class="container">  
            <header>  
                <button><a href="<?php echo SITE_URL.'admin-home.php';?>">HOME</a></button>  ><h1>ADD Product</h1>  
            </header>  
            <section>               
                <div id="container_demo" >  
                    <a class="hiddenanchor" id="toregister"></a>  
                    <a class="hiddenanchor" id="tologin"></a>  
                    <div id="wrapper">  
                        <div class="animate form">  
                           <form name="productForm" method="post" action="" enctype="multipart/form-data"> 
                                <p>   
                                    <label for="category" class="category" data-icon="u">Category</label>  
                                    <select name="category">
                                        <?php echo $category_value; ?>
                                    </select>
                                </p> 
                                 <p>   
                                    <label for="product" class="product" data-icon="u">Product</label>  
                                    <input id="product" name="product" required="required" type="text" /> 
                                </p> 
                                 <p>   
                                   <label for="myfile">Prodct Image:</label>
                                    <input type="file" id="image" name="image"  required="required"> 
                                </p> 
                                 <p>   
                                    <label for="price" class="price" data-icon="u">Price</label>  
                                    <input id="price" name="price" required="required" type="number"/>  
                                </p> 
                                <p class="category button">   
                                    <input type="submit" name="submitProduct" value="Submit" />   
                                </p>   
                            </form>  
                        </div>
                    </div>  
                </div>  

                <table class="table">
			  <thead>
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">Category</th>
			      <th scope="col">Product</th>
                  <th scope="col">Product Image</th>
                  <th scope="col">Price</th>
                  <th scope="col"></th>
			      <th scope="col"></th>
			    </tr>
			  </thead>
			  <tbody>
			   <?php  echo  $getProducts; ?>
			    
			  </tbody>
			</table>
				<form id="editForm" name="category_edit" method="post" action="" style="display:none" enctype="multipart/form-data">  
                    <h1>Edit Product</h1>   
                    <p>   
                        <label for="category" class="category" data-icon="u">Category</label>  
                        <select name="category_name" id="category_name">
                            <?php echo $category_value; ?>
                        </select>
                    </p> 
                     <p>   
                        <label for="product" class="product" data-icon="u">Product</label>  
                        <input id="product_name" name="product_name" required="required" type="text" /> 
                    </p> 
                     <p>   
                       <label for="myfile">Prodct Image:</label>
                        <input type="file" id="image_new" name="image_new" > 
                    </p> 
                     <p>   
                        <label for="price" class="price" data-icon="u">Price</label>  
                        <input id="price_new" name="price_new" required="required" type="number"/>  
                    </p> 

                    <p>   
                        <input id="product_id" name="product_id" value=""  type="hidden" />   
                        <input id="old_image" name="old_image" value=""  type="hidden" />   
                    </p> 
                    <p class="category button">   
                        <input type="submit" name="submitProductEdit" value="Edit Product" /> 
                        <input type="submit" name="cancel" value="Cancel" id="cancel"/>   
                    </p>   
                </form>  

            </section>  
        </div>  
    </body>  
</html>  

<script type="text/javascript">

$(document).on('click','#cancel',function(){
    $('#editForm').hide();
});

$(document).on('click','.edit_prod',function(){
	var attrId = $(this).attr('id');
	var data =  attrId.split("_");
	var ID = data[0];
    var category = $('#'+ID+'_val').attr('data-attr');
    var old_image = $('#'+ID+'_image').attr('data-attr');
    var product = $('#'+ID+'_prod').text();
	var price = $('#'+ID+'_price').text();

	$('#product_id').val(ID);
    $('#category_name').val(category);
    $('#product_name').val(product);
    $('#price_new').val(price);
	$('#old_image').val(old_image);
	$('#editForm').removeAttr('style');
	// console.log(category);
	return;
});

$(document).on('click','.del_prod',function(){
	var attrId = $(this).attr('id');
	var data =  attrId.split("_");
	var ID = data[0];
	console.log(data);
	$.ajax({
       url:"product.php",
       type:"POST",
       data:{id:ID,action:'deleteProduct'},       
       success:function()
       {	
       	 alert('Product Deleted Succesfully');
       	 $('#row_'+ID).remove();
	       // location.reload();
     
       }
    });			
});

   	 
</script>