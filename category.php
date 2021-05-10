<?php  
    include_once('config.php');  
     if(!($_SESSION['adminId'])){  
        header("Location:admin-login.php");  
    }  
    $category_value = getCategories();

    if(isset($_POST['category_name']) && $_POST['category_name'] != '' && isset($_POST['submitCategory'])){ 

        $category_name = $_POST['category_name']; 
        // echo "<pre>";print_r($category_name);exit;
        $cat = addCategory($category_name);  
        if ($cat) {  
           header("location:category.php");  
           $_POST = array();
        } else {  
            echo "<script>alert('Please enter Category')</script>";  
        }  
    }  
   
    if(isset($_POST['category_name']) && $_POST['category_name'] != '' && isset($_POST['submitCategoryEdit'])){ 

        $category_name = $_POST['category_name']; 
        $category_id = $_POST['category_id']; 
        // echo "<pre>";print_r($category_name);exit;
        $cat = editCategory($category_name,$category_id);  
        if ($cat) {  
           header("location:category.php");  
           $_POST = array();
        } else {  
            echo "<script>alert('Issue Updating Category')</script>";  
        }  
    }  

    if(isset($_POST['action']) && $_POST['action'] == 'deleteCategory'){ 
        $category_id = $_POST['id']; 
        $cat = deleteCategory($category_id);  
    }  

    

?>  
<!DOCTYPE html>  
 <html lang="en" class="no-js">  
 <head>  
        <meta charset="UTF-8" />  
        <title>Add Category</title>
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
                <button><a href="<?php echo SITE_URL.'admin-home.php';?>">HOME</a></button>  > <h1>ADD category </h1>  
            </header>  
            <section>               
                <div id="container_demo" >  
                    <a class="hiddenanchor" id="toregister"></a>  
                    <a class="hiddenanchor" id="tologin"></a>  
                    <div id="wrapper">  
                        <div id="categoryForm" class="animate form">  
                           <form name="category" method="post" action=""> 
                                <p>   
                                    <label for="category" class="category" data-icon="u">category</label>  
                                    <input id="category" name="category_name" required="required" type="text" />  
                                </p> 
                                <p class="category button">   
                                    <input type="submit" name="submitCategory" value="Submit" />   
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
			      <th scope="col"></th>
			      <th scope="col"></th>
			    </tr>
			  </thead>
			  <tbody>
			   <?php echo  $category_value; ?>
			    
			  </tbody>
			</table>
				<form id="editForm" name="category_edit" method="post" action="" style="display:none">  
                    <h1>Edit Category</h1>   
                    <p>   
                        <label for="category" class="category" data-icon="u">category</label>  
                        <input id="category_name" name="category_name"  required="required" type="text" /> 
                        <input id="category_id" name="category_id" value=""  type="hidden" />   
                    </p> 
                    <p class="category button">   
                        <input type="submit" name="submitCategoryEdit" value="Edit Category" />   
                    </p>   
                </form>  

            </section>  
        </div>  
    </body>  
</html>  

<script type="text/javascript">

$(document).on('click','.edit_cat',function(){
	var attrId = $(this).attr('id');
	var data =  attrId.split("_");
	var ID = data[0];
	var category = $('#'+ID+'_val').text();
	$('#category_id').val(ID);
	$('#category_name').val(category);
	$('#editForm').removeAttr('style');
	console.log(category);
	return;
});

$(document).on('click','.del_cat',function(){
	var attrId = $(this).attr('id');
	var data =  attrId.split("_");
	var ID = data[0];
	console.log(data);
	$.ajax({
       url:"category.php",
       type:"POST",
       data:{id:ID,action:'deleteCategory'},       
       success:function()
       {	
       	 alert('Category Deleted Succesfully');
       	 $('#row_'+ID).remove();
	       // location.reload();
     
       }
    });			
});

   	 
</script>