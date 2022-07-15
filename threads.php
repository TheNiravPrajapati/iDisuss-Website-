<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iDisuss - coding forum </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>
    <?php include 'partials/_header.php' ?>
    <?php include 'partials/_dbconnect.php' ?>
    <?php
    $id = $_GET['catid'];
    $sql = "SELECT * FROM `categories` WHERE category_id = $id";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result))
        {
            $catname = $row['category_name'];
            $catdesc = $row['category_discription'];
        } 
    ?>
    <?php 
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method =='POST')
    {
        // insert thread into database 
        $th_title = $_POST['title']; 
        $th_desc =  $_POST['desc'];

        $th_title = str_replace("<", "&lt", $th_title );
        $th_title = str_replace(">", "&gt", $th_title );

        $th_desc = str_replace("<", "&lt", $th_desc );
        $th_desc = str_replace(">", "&gt", $th_desc );

        $sno = $_POST['sno'];
        $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`,`thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$sno', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if($showAlert)
        {
            echo'
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success</strong> Your Thread has been addded please wait for community 
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
        }
    }
    ?>
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catname ;?> Forums </h1>
            <p class="lead">
                <?php echo  $catdesc; ?>
            </p>
            <hr class="my-4">
            <p>This is a pear to pear forum for sharing knowledge with eachother<br>
                No Spam / Advertising / Self-promote in the forums is not allowed . <br>
                Do not post copyright-infringing material.<br>
                Do not post “offensive” posts, links or images.<br>
                Do not cross post questions. <br>
                Do not PM users asking for help. <br>
                Remain respectful of other members at all times.<br>
            </p>
            <p class="btn btn-success btn-lg" href="#" roles="button">Learn more</p>
        </div>
        <?php
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
        {
        echo '<div class="container">
            <h1 class="py-2">Start a Discussion</h1>
            <div class="container">
                <form action="'.$_SERVER["REQUEST_URI"].'" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Problem title</label>
                        <input type="text" class="form-control" id="title" name="title">
                        <div id="emailHelp" class="form-text">Keep your title as crisp as short as possible </div>
                    </div>
                    <div class="form-floating">
                    
                    <textarea class="form-control" placeholder="textarea" id="desc" name="desc"></textarea>
                    <div id="emailHelp" class="form-text">Elabroate Your Concern</div>
                    <input type ="hidden" name ="sno" value="'.$_SESSION["sno"].'">
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>';
        }
        else{
            echo '
            <div class="container">
            <h1 class="py-2">Start a Discussion</h1>
                <p  class ="lead">
                    You are NOT Logged In . Please Login to able start discusion
                </p>
            </div>' ;
        }
            ?>

            <?php
                $id = $_GET['catid'];
                $sql = "SELECT * FROM `threads` WHERE thread_cat_id = $id";
                $result = mysqli_query($conn, $sql);
                $noResult = true;
                while($row = mysqli_fetch_assoc($result))
                {
                    $noResult = false;
                    $id = $row['thread_id'];
                    $title = $row['thread_title'];
                    $desc = $row['thread_desc'];
                    $threadtime = $row['timestamp'];
                    $thread_userid = $row['thread_user_id'];
                    $sql2 = "SELECT user_email FROM `users` WHERE sno= $thread_userid";
                    $result2 = mysqli_query($conn, $sql2);
                    $row2 = mysqli_fetch_assoc($result2);
                    echo '<div class="d-flex my-3">
                        <div class="flex-shrink-0">
                            <img src="img/default_user.png" width="60px" alt="user image ">
                        </div>
                        <div class="flex-grow-1 ms-3">
                        <p class = "font-weight-bold my-0"><b>'.$row2['user_email'].' at '. $threadtime.'</b></p>
                            <h5 class="mt-0"><a href="../forum/thread.php?threadid='.$id.'">'.$title.'</a></h5>
                            '.$desc.'
                        </div>
                    </div>';
                } 
                if($noResult){
                    echo  '
                    <div class="jumbotron jumbotron-fulid">
                    <div class="container">
                        <h1 class="display-4">
                        No Threads Found 
                        </h1>
                        <p class="lead">
                        Be the first person to ask a question 
                        </p>
                    </div>
                    </div>

                    ';
                }
            ?>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
    <?php include 'partials/_footer.php'?>
</body>

</html>