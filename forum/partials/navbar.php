<?php
session_start();
include 'dbconnect.php';

echo'      
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container-fluid ">
  <a class="navbar-brand" href="/forum/index.php">iDiscuss</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="/forum/index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php">About</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Top Categories
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
        $sql="SELECT category_name,category_id FROM `categories` LIMIT 5";
        $result=mysqli_query($conn,$sql); 

    while($row=mysqli_fetch_assoc($result)){
          echo '<li><a class="dropdown-item" href="threads.php?catid='.$row["category_id"].'">'.$row['category_name'].'</a></li>';
    }
        echo '</ul>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contact.php">Contact</a>
      </li>
    </ul>';

    
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
  echo '<form class="d-flex"  name="search" method="get" action="search.php">
  <input class="form-control me-2 mx-2" name="search" type="search" placeholder="Search" aria-label="Search">
  <button class="btn btn-success mx-2" type="submit">Search</button>
  
 <p class="text-light my-2 mx-1">Weclome </p>
 <p class="text-light my-2 mx-1">'.$_SESSION['username'].'</p>
 <a href="/forum/partials/_logout.php" class="btn btn-outline-success mx-2">LogOut<a>

 </form>';
}else{
  
  echo '<form class="d-flex">
    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
    <button class="btn btn-success" type="submit">Search</button>
  </form>
  <div class="mx-2">
      <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#loginmodal">Login</button>
      <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#signupmodal">SignUp</button>
  </div>';
}

  
echo ' </div>
 </div>
</nav>';

include 'partials/_loginmodal.php';
include 'partials/_signupModal.php';
if(isset($_GET['signup']) && $_GET['signup']=="true"){
  echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
  <strong>Success!</strong> You can now login to iDisccuss.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
?>