
<?php
include('../includes/connect.php'); 
if(isset($_POST['insert_cat'])){
$category_title=$_POST['cat_title'];
// select data from database
$select_query="Select * from `categories` where category_title='$category_title'"; 
$result_select=mysqli_query($con, $select_query); 
$number=mysqli_num_rows($result_select);
if($number>0){
    echo "<script> alert(' this category is present inside the database')</script>";
}
$insert_query="insert into `categories` (category_title) values ('$category_title')"; 
$result=mysqli_query($con, $insert_query);
if($result) {
    echo "<script> alert('Category has been inserted successfully')</script>";
}
}

?>
<form action="" method="post" class="mb-2"> 
<div class="input-group w-90 mb-2">
<span class="input-group-text bg-info" id="basic-addon1">
    <i class="fa-solid fa-receipt"></i></span>
<input type="text" class="form-control" name="cat_title" placeholder="Insert categories" aria-label="Categories"
aria-describedby="basic-addon1">    
</div>
<div class="input-group w-10 mb-2 m-auto">
<!-- <input type="submit" class="form-control bg-info" name="insert_cat" value="Insert Categories"> -->
<button class="bg-info p-2 my-3 border-0">Insert Categories</button>
</div>
</form>