<?php


if(isset($_POST) && !empty($_FILES['image']['name'])){


   $name = $_FILES['image']['name'];
   list($txt, $ext) = explode(".", $name);
   $image_name = time().".".$ext;
   $tmp = $_FILES['image']['tmp_name'];


   if(move_uploaded_file($tmp, 'uploads/'.$image_name)){
      echo "<img width='300px' src='uploads/".$image_name."' class='preview'>";
   }else{
      echo "image uploading failed";
   }
}else{
   echo "Please select image";
}


