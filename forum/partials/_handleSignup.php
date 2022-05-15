<?php
$showError="false";

if($_SERVER['REQUEST_METHOD']=="POST"){
include 'dbconnect.php';
 $user_email=$_POST['signupEmail'];
 $pass=$_POST['signupPassword'];
 $cpass=$_POST['signupcPassword'];
//  Check wether this email exists
$existsSql="SELECT * FROM `users` WHERE user_email='$user_email'";
$result=mysqli_query($conn,$existsSql); 
$num_rows=mysqli_num_rows($result);
if($num_rows>0){
    $showError="Username already assigned";
}else{
    if($pass==$cpass){
        $hash=password_hash($pass,PASSWORD_DEFAULT);
        $sql="INSERT INTO `users` (`user_email`, `user_password`, `timestamp`) VALUES ('$user_email', '$hash', current_timestamp())";
        $result=mysqli_query($conn,$sql); 
        if($result){
            $showAlert=true;
            header("Location: /forum/index.php?signup=true");
            exit();
        }       
    }else{
        $showError="Password do not match";
        
    }
}
header("Location: /forum/index.php?signup=false&error=$showError");
}
?>