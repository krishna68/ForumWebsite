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
    $id=$_GET['catid'];
    $sql="SELECT * FROM `categories` WHERE category_id=$id";
    $result=mysqli_query($conn,$sql); 
    while($row=mysqli_fetch_assoc($result)){
        $catname=$row['category_name'];
        $catdesc=$row['category_description'];
    }


    ?>

    <?php
    $show_alert=false;
    $method=$_SERVER['REQUEST_METHOD'];
    if($method=='POST'){
        // insert questions into db
        $th_title=$_POST['title'];
        $th_desc=$_POST['desc'];

        $th_title = str_replace("<", "&lt;", $th_title);
        $th_title = str_replace(">", "&gt;", $th_title); 

        $th_desc = str_replace("<", "&lt;", $th_desc);
        $th_desc = str_replace(">", "&gt;", $th_desc); 
        
        $sno=$_SESSION['sno'];
        $sql="INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `dt`) VALUES ('$th_title', '$th_desc', '$id', '$sno', current_timestamp());";
        $result=mysqli_query($conn,$sql);
        $show_alert=true;
        if($show_alert){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Your problem has been added to our forum! Please wait for comunity to respond to it.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        } 
    }
    ?>

    <div class="container my-4"></div>
    <!-- Category container starts here -->
    <div class="container card my-4">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catname?> Forums</h1>
            <p class="lead"><?php echo $catdesc?> </p>
            <hr class="my-4">
            <p>This is a peer to peer forum. No Spam / Advertising / Self-promote in the forums is not allowed. Do not
                post copyright-infringing material. Do not post “offensive” posts, links or images. Do not cross post
                questions. Remain respectful of other members at all times.</p>
            <a class="btn btn-success btn-lg my-1" href="#" role="button">Learn more</a>

        </div>

    </div>

    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        echo'
        <div class="container">
    <h1>Start the discussion</h1>
    <form  action="'.$_SERVER['REQUEST_URI'].'" method="post">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Enter Your Problem Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">Keep the title as short and crisp as possible.</div>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Ellaborate your problem:</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
        ';
    }else{
        echo'
        <div class="container">
    <h1>Start the discussion</h1>
    <p class="lead">You are not logged in. Please login to start a discussion</p>
    </div>
        ';
    }
    ?>
    
    <div class="container my-4">
        <h1>Browse Questions</h1>
        <?php
    $id=$_GET['catid'];
    $sql="SELECT * FROM `threads` WHERE thread_cat_id=$id";
    $result=mysqli_query($conn,$sql); 
    $noresult=true;
    while($row=mysqli_fetch_assoc($result)){
        $noresult=false;
        $threadtitle=$row['thread_title'];
        $threaddesc=$row['thread_desc'];
        $threadid=$row['thread_id'];
        $threadtime=$row['dt'];
        $thread_user_id=$row['thread_user_id'];
        $sql2="SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
        $result2=mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($result2);

        echo' <div class="container my-4 ">
        
        <img  src="user.png" width="34px" class="mr-3" alt="">
        <span class="fw-bold mt-0"><a class="text-dark" href="thread.php?threadid='.$threadid.'">'.$threadtitle.'</a></span>
        
    
        <div class="media-body my-1">
        
            
            '.$threaddesc.'
            <p class="fw-bold my-0">Asked by '.$row2['user_email'].' at '.$threadtime.'</p>
        </div>
    </div>';
    
    }
    if($noresult){
        echo '<div class="card">
        <div class="container">
            <p class="display-5 text-muted">No Threads Found</p>
            <p class="lead"> Be the first person to ask a question</p>
        </div>
     </div> ';
    }

    ?>

        

        <!-- Tempelate for media object -->
        <!-- <div class="media my-3">
            <img src="user.png" width="34px" class="mr-3" alt="">
            <div class="media-body">
                <h5 class="mt-0">Media heading</h5>
                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus
                odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate
                fringilla. Donec lacinia congue felis in faucibus.
            </div>
        </div> -->

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