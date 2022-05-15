<?php
$showError="false";
if($_SERVER['REQUEST_METHOD']=="POST"){
include 'dbconnect.php';
$email=$_POST['loginEmail'];
$pass=$_POST['loginPassword'];
$sql="SELECT * FROM `users` WHERE user_email='$email'";
$result=mysqli_query($conn,$sql); 
$num_rows=mysqli_num_rows($result);
if($num_rows==1){
    $row=mysqli_fetch_assoc($result);
    if(password_verify($pass,$row['user_password'])){
    session_start();
    $_SESSION['loggedin']=true;
    $_SESSION['username']=$email;
    $_SESSION['sno']=$row['sno'];
    echo "Logged in";
    
}

header("Location: /forum/index.php");
exit();
}
}
?>