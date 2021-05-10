<?php 
 function UserRegister($username, $emailid, $password){  
            global $db, $adminUserId; 
            $password = md5($password);  

            $valArray = array('uname'=>$username,'email'=>$emailid,'password'=>$password,'uType'=>'u');

			$user = $db->insert('tbl_users', $valArray)->getLastInsertId();

            return $user;  
               
        }  
 function Login($emailid, $password){  
	global $db, $adminUserId; 
    $query = "SELECT * FROM tbl_users WHERE email = '".$emailid."' AND password = '".md5($password)."' AND uType='u'";
    $result = $db->pdoQuery($query)->result();
      
    if ($result)   
    {  
   
        $_SESSION['login'] = true;  
        $_SESSION['uid'] = $result['id'];  
        $_SESSION['username'] = $result['uname'];  
        $_SESSION['email'] = $result['email'];  
        return TRUE;  
    }  
    else  
    {  
        return FALSE;  
    }  
}  

function adminLogin($uname, $password){
	global $db, $adminUserId; 
    $query = "SELECT * FROM tbl_users WHERE uname = '".$uname."' AND password = '".md5($password)."' AND uType='a'";
    $result = $db->pdoQuery($query)->result();
      
    if ($result)   
    {  
        $_SESSION['login'] = true;  
        $_SESSION['adminId'] = $result['id'];  
        $_SESSION['username'] = 'admin';   
        return TRUE;  
    }  
    else  
    {  
        return FALSE;  
    }  
}
 function isUserExist($emailid){  
    global $db, $adminUserId;

    $query = "SELECT * FROM tbl_users WHERE email = '".$emailid."'";
    $result = $db->pdoQuery($query)->result();
    if($result){
    	 return true; 
    	}else{
    		return false;  
    	}
  
}  

 function addCategory($category){  
    global $db, $adminUserId; 

    $valArray = array('category'=>$category);

	$cat = $db->insert('tbl_category', $valArray)->getLastInsertId();

    return $cat;  
       
} 

 function editCategory($category,$category_id){  
    global $db, $adminUserId; 
    $db->update('tbl_category', array("category"=>$category),array("id"=>$category_id));
    return true;		
} 
function deleteCategory($category_id){  
    global $db, $adminUserId; 
    $db->update('tbl_category', array("status"=>'d'),array("id"=>$category_id));
} 

function getCategories(){
	global $db, $adminUserId; 
	$query = "SELECT * FROM tbl_category WHERE status = 'a'";
    $result = $db->pdoQuery($query)->results();

    $table_html = '';
    // echo "<pre>";print_r($result);exit;
    foreach ($result as $key => $value) {
    	$table_html .= '<tr id="row_'.$value['id'].'"><th scope="row">'.$value['id'].'</th><td id="'.$value['id'].'_val">'.$value['category'].'</td><td class="edit_cat" id="'.$value['id'].'_edit"><i class="fa fa-edit"></i></td><td class="del_cat" id="'.$value['id'].'_delete"><i class="fa fa-trash" aria-hidden="true"></i></td></tr>';
    }

    return $table_html;
}

function getSelectCategory(){
	global $db, $adminUserId; 
	$query = "SELECT * FROM tbl_category WHERE status = 'a'";
    $result = $db->pdoQuery($query)->results();

    $html = '';
    foreach ($result as $key => $value) {
    	$html .= '<option value="'.$value['id'].'">'.$value['category'].'</option>';
    }

    return $html;
}

 function addProduct($category, $product ,$price,$image){  
    global $db, $adminUserId; 

    $target_dir = "uploads/";
    $flag = 1;
	$target_file = $target_dir . basename($image["image"]["name"]);
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	
	// Check if image file is a actual image or fake image
	$check = getimagesize($image["image"]["tmp_name"]);
	if($check == false) {
	  	$flag = 0;	 
	 }

	 // check the file type
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) { // 
		  $flag = 0;
	}
	  if ($flag == 0) { // if error then return
		return false;
	  }

	  // upload the file 
  	move_uploaded_file($image["image"]["tmp_name"], $target_file);

  	// insert the record on file upload 
	$valArray = array('cat_id'=>$category,'product_name'=>$product,'price'=>$price,'image'=>$image["image"]["name"]);

	$prod = $db->insert('tbl_products', $valArray)->getLastInsertId();
	return true;  
	
} 

 function editProduct($product_id,$category, $product ,$price,$old_image,$image){  
    global $db, $adminUserId; 

     // echo "<pre>";print_r($image);exit;
    if(!empty($image)){
	    $target_dir = "uploads/";
	    $flag = 1;
		$target_file = $target_dir . basename($image["image_new"]["name"]);
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		
		// Check if image file is a actual image or fake image
		$check = getimagesize($image["image_new"]["tmp_name"]);
		if($check == false) {
		  	$flag = 0;	 
		 }

		 // check the file type
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) { // 
			  $flag = 0;
		}
		  if ($flag == 0) { // if error then return
			return false;
		  }

		 // upload the file in case new uploaded
  	
  		unlink($target_dir.$old_image);
  		move_uploaded_file($image["image_new"]["tmp_name"], $target_file);
  		$uploadedImage = $image["image_new"]["name"];
  		$valArray = array('cat_id'=>$category,'product_name'=>$product,'price'=>$price,'image'=>$image["image_new"]["name"]);
  	}else{ //else just update other records
  		$valArray = array('cat_id'=>$category,'product_name'=>$product,'price'=>$price);
  	}

	$prod = $db->update('tbl_products', $valArray,array("id"=>$product_id));
	return true;  
	
} 

function getProducts(){
	global $db, $adminUserId; 
	$query = "SELECT * FROM tbl_products WHERE status = 'a'";
    $result = $db->pdoQuery($query)->results();

    $table_html = '';
    // echo "<pre>";print_r($result);exit;
    foreach ($result as $key => $value) {
    	$category = $db->pdoQuery("SELECT id,category FROM tbl_category WHERE id = '".$value['cat_id']."'")->result();
    	$image = '<img src="'.SITE_URL.'uploads/'.$value['image'].'" alt="'.$value['product_name'].'" width="100" height="100">';
    	$old_image = $value['image'];

    	$table_html .= '<tr id="row_'.$value['id'].'">
    				<th scope="row">'.$value['id'].'</th>
    				<td id="'.$value['cat_id'].'_val" data-attr="'.$category['id'].'">'.$category['category'].'</td>
    				<td id="'.$value['id'].'_prod">'.$value['product_name'].'</td>
    				<td id="'.$value['id'].'_image" data-attr="'.$old_image.'">'.$image.'</td>
    				<td id="'.$value['id'].'_price">'.$value['price'].'</td>
    				<td class="edit_prod" id="'.$value['id'].'_edit"><i class="fa fa-edit"></i></td>
    				<td class="del_prod" id="'.$value['id'].'_delete"><i class="fa fa-trash" aria-hidden="true"></i></td></tr>';
    }

    return $table_html;
}

function deleteProduct($prod_id){  
    global $db, $adminUserId; 
    $db->update('tbl_products', array("status"=>'d'),array("id"=>$prod_id));
} 

function getallProducts(){
	global $db, $adminUserId; 
	$query = "SELECT * FROM tbl_products WHERE status = 'a'";
    $result = $db->pdoQuery($query)->results();

    $table_html = '';
    // $item_quantity = '<select></select>';
    foreach ($result as $key => $value) {
    	$category = $db->pdoQuery("SELECT id,category FROM tbl_category WHERE id = '".$value['cat_id']."'")->result();
    	$image = '<img src="'.SITE_URL.'uploads/'.$value['image'].'" alt="'.$value['product_name'].'" width="100" height="100">';
    	$old_image = $value['image'];

    	$table_html .= '<tr id="row_'.$value['id'].'">
    				<td id="'.$value['cat_id'].'_val" data-attr="'.$category['id'].'">'.$category['category'].'</td>
    				<td>'.$value['product_name'].'</td>
    				<td data-attr="'.$old_image.'">'.$image.'</td>
    				<td>'.$value['price'].'</td>
    				<td><input type="checkbox" id="'.$value['id'].'_prod" name="products" value="'.$value['id'].'"></td></tr>';
    }

    return $table_html;

}

function addToCart($products){
	global $db, $adminUserId; 
	$userId = $_SESSION['uid'];
		    
	if($products){
		foreach ($products as $key => $value) {
			$productQry = $db->pdoQuery("SELECT * FROM tbl_products WHERE status = 'a' AND id='".$value."'")->result();

			$checkInCart = $db->pdoQuery("SELECT * FROM tbl_cart WHERE prod_id='".$value."' AND user_id ='".$userId."'")->result();

			if($checkInCart){
				$quatity = $checkInCart['quatity'] + 1;
				$valArray = array('quatity'=>$quatity);

    			$prod = $db->update('tbl_cart',$valArray,array("id"=>$checkInCart['id']));

			}else{
    			$valArray = array('prod_id'=>$value,'prod_price'=>$productQry['price'],'user_id'=>$userId);
				$prod = $db->insert('tbl_cart', $valArray)->getLastInsertId();
			}
		}
	}
	return true;
}

function getCartItems(){
	global $db, $adminUserId; 
	$userId = $_SESSION['uid'];

	$query = "SELECT * FROM tbl_cart WHERE user_id= '". $userId."'";
    $result = $db->pdoQuery($query)->results();

    $table_html = '';
    $cart_value = $price = 0;
    foreach ($result as $key => $value) {
    	$price = $value['prod_price'] * $value['quatity'];
    	$cart_value = $cart_value + $price;
    	$product = $db->pdoQuery("SELECT * FROM tbl_products WHERE id = '".$value['prod_id']."'")->result();

    	$category = $db->pdoQuery("SELECT id,category FROM tbl_category WHERE id = '".$product['cat_id']."'")->result();
    	$image = '<img src="'.SITE_URL.'uploads/'.$product['image'].'" alt="'.$product['product_name'].'" width="100" height="100">';
    	
    	$table_html .= '<tr id="row_'.$value['id'].'">
    				<td id="'.$product['cat_id'].'_val" data-attr="'.$category['id'].'">'.$category['category'].'</td>
    				<td>'.$product['product_name'].'</td>
    				<td>'.$image.'</td>
    				<td>'.$value['prod_price'].'</td>
    				<td>'.$value['quatity'].'</td>
    				<td class="del_item" id="'.$value['id'].'_delete"><i class="fa fa-trash" aria-hidden="true"></i></td></tr>';
    }
    	$table_html .= '<tr><td></td><td></td><td></td><td colspan="5" id="total" data-attr="'.$price.'">Checkout Total: '.$cart_value .'</td></tr>';

    return $table_html;
}

function deleteItem($item_id){
	global $db, $adminUserId; 
	$aWhere=array("id"=>$item_id);
	$db->delete('tbl_cart',$aWhere);
}

function cartCheckout($address,$total){
	global $db, $adminUserId; 
	$userId = $_SESSION['uid'];

	$query = "SELECT * FROM tbl_cart WHERE user_id= '". $userId."'";
    $result = $db->pdoQuery($query)->results();


    if($result){

    	$valArray = array('user_id'=>$userId,'order_address'=>$address,'order_total'=>$total,'createdDate'=>date('Y-m-d H:i:s'));
		$orderId = $db->insert('tbl_orders', $valArray)->getLastInsertId();
		$cart_value =0;
		foreach ($result as $key => $value) {
			# code...
	    	$price = $value['prod_price'] * $value['quatity'];
	    	$cart_value = $cart_value + $price;
	    	$product = $db->pdoQuery("SELECT * FROM tbl_products WHERE id = '".$value['prod_id']."'")->result();

	    	$category = $db->pdoQuery("SELECT id,category FROM tbl_category WHERE id = '".$product['cat_id']."'")->result();

	    	$valArray = array('order_id'=>$orderId,'order_item'=>$product['id'],'item_price'=>$price,'item_quantity' => $value['quatity']);
			$prod = $db->insert('tbl_order_items', $valArray)->getLastInsertId();
			deleteItem($value['id']);
		}

    }
}
?>