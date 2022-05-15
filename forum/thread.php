<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Welcome to IDiscuss-Coding Forums</title>
</head>

<body>

    <?php include 'partials/dbconnect.php';?>
    <?php include 'partials/navbar.php';?>
    <?php

    $id=$_GET['threadid'];
    $sql="SELECT * FROM `threads` WHERE thread_id=$id";
    $result=mysqli_query($conn,$sql); 
    while($row=mysqli_fetch_assoc($result)){
        $threadtitle=$row['thread_title'];
        $desc=$row['thread_desc'];
        $userid=$row['thread_user_id'];
        $sql2="SELECT user_email FROM `users` WHERE sno='$userid'";
        $result2=mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($result2);
    }

   
    ?>

    <?php
    $show_alert=false;
    $method=$_SERVER['REQUEST_METHOD'];
    if($method=='POST'){
        // insert questions into db
        $cm_content=$_POST['comment'];
        $cm_content = str_replace("<", "&lt;", $cm_content);
        $cm_content = str_replace(">", "&gt;", $cm_content); 
        $sno=$_POST['sno'];
        $sql="INSERT INTO `comments` ( `commment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ( '$cm_content', '$id', '$sno', current_timestamp());";
        $result=mysqli_query($conn,$sql);
        $show_alert=true;
        if($show_alert){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Your comment has been added! 
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        } 
    }
    ?>
    <div class="container my-4" ></div>
    <!-- Category container starts here -->
    <div class="container my-4 card">
        <div class="jumbotron">
            <h1 class="display-4"><?php echo $threadtitle?></h1>
            <p class="lead"><?php echo $desc?> </p>
            <hr class="my-4">
            <p>This is a peer to peer forum. No Spam / Advertising / Self-promote in the forums is not allowed. Do not
                post copyright-infringing material. Do not post “offensive” posts, links or images. Do not cross post
                questions. Remain respectful of other members at all times.</p>
            <p>Posted by: <b><?php echo $row2['user_email']?></b></p>

        </div>

    </div>
    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        echo'<div class="container">
        <h2>Post a Comment</h2>
        <form  action="'.$_SERVER['REQUEST_URI'].'" method="post">
                
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Type Your Comment:</label>
                    <textarea class="form-control" id="comment"  name="comment" rows="3"></textarea>
                    <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
                </div>
                <button type="submit" class="btn btn-primary">Post Comment</button>
            </form>
        </div>
        ';
    }else{
        echo'
        <div class="container">
        <h2>Post a Comment</h2>
        <p class="lead">You are not logged in. Please login to post a comment!</p>
        </div>
        ';
        
    }

    ?>
    <div class="container my-4">
    <h1>Discussions</h1>
        
  <?php
    $id=$_GET['threadid'];
    $sql="SELECT * FROM `comments` WHERE thread_id=$id";
    $result=mysqli_query($conn,$sql); 
    $noresult=true;
    while($row=mysqli_fetch_assoc($result)){
        $commentid=$row['comment_id'];
        $content=$row['commment_content'];
        $commenttime=$row['comment_time'];
        $thread_user_id=$row['comment_by'];
        $sql2="SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
        $result2=mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($result2);
    
        $noresult=false;
        echo' <div class="container my-3">
        <img  src="user.png" width="34px" class="mr-3" alt="">
        <span class="fw-bold my-0">'.$row2['user_email'].' at '.$commenttime.'</span>
        <div class="media-body"> 
        
            '.$content.'
        </div>
    </div>';
    }
    if($noresult){
        echo '<div class="card">
        <div class="container">
            <p class="display-5 text-muted">No Comments Found</p>
            <p class="lead"> Be the first person to comment to this question</p>
        </div>
     </div> ';
    }
    ?>       
   </div>
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