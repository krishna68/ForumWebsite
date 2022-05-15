<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
    #main-container {
        min-height: 85vh;
    }
    </style>
    <title>Welcome to IDiscuss-Coding Forums</title>
</head>

<body>

    <?php include'partials/dbconnect.php';?>
    <?php include'partials/navbar.php';?>


    <!-- Search results  -->
    <div class="container my-3 " id="main-container">
        <h1 class="py-3">Search Results for <em>"<?php echo $_GET['search']?>"</em></h1>


     <?php
     $noresults=true;
    $query = $_GET["search"];
    $sql="SELECT * FROM threads WHERE MATCH(thread_title, thread_desc) AGAINST ('$query')";
    $result=mysqli_query($conn,$sql); 
    while($row=mysqli_fetch_assoc($result)){
        $noresults=false;
        $threadtitle=$row['thread_title'];
        $desc=$row['thread_desc'];
        $threadid=$row['thread_id'];
        $threadtime=$row['dt'];
        $thread_user_id=$row['thread_user_id'];
        $sql2="SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
        $result2=mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($result2);
        // Display the search results;
        echo'<div class="container my-4 ">
        
        <img  src="user.png" width="34px" class="mr-3" alt="">
        <span class="fw-bold mt-0"><a class="text-dark" href="thread.php?threadid='.$threadid.'">'.$threadtitle.'</a></span>
        
    
        <div class="media-body my-1">
         
            '.$desc.'
            <p class="fw-bold my-0">Asked by '.$row2['user_email'].' at '.$threadtime.'</p>
        </div>
    </div>';
    }

    if($noresults){
        echo'<div class="card">
        <div class="container">
            <p class="display-5 text-muted">No Results Found</p>
            <p class="lead"> Suggestions: <ul>
            <li>Make sure that all words are spelled correctly.</li>
            <li>Try different keywords.</li>
            <li>Try more general keywords. </li></ul></p>
        </div>
     </div>';
    }
     ?>   
        
    

    </div>

    <!-- Ends -->
    <?php include 'partials/footer.php'?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>