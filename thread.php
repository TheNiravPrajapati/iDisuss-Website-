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
    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `threads` WHERE thread_id = $id";
    $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result))
        {
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];


            $thread_user_id = $row['thread_user_id'];
            $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $posted_by = $row2['user_email'];
        } 
        
    ?>
    <?php 
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method =='POST')
    {
        // insert comment into database 
        $comment = $_POST['comment']; 
        $comment = str_replace("<", "&lt", $comment );
        $comment = str_replace(">", "&gt", $comment );
        $sno = $_POST['sno'];
        $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '$sno', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if($showAlert)
        {
            echo '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success</strong> Your comment has been added
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
        }
    }
    ?>
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4"><?php echo $title;?> </h1>
            <p class="lead">
                <?php echo  $desc; ?>
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
            <p> posted by : <b> <?php echo $posted_by;?></b></p>
        </div>
        <?php
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
        {
            echo '        
            <div class="container">
            <h1 class="py-2">Post a comment </h1>
        </div>
        <div class="container">
                <form action="'.$_SERVER["REQUEST_URI"].'" method="POST">
        <div class="form-floating">
            <textarea class="form-control" placeholder="textarea" id="comment" name="comment"></textarea>
            <label for="floatingTextarea form-lable">Type Your comment</label>
            <input type ="hidden" name ="sno" value="'.$_SESSION["sno"].'">
        </div>
        <button type="submit" class="btn btn-success">Post comment</button>
        </form>
    </div>';
    }
    else{
    echo '
    <div class="container">
        <h1 class="py-2">Post a comment</h1>
        <p class="lead">
            You are NOT Logged In . Please Login to able to Post comment
        </p>';
    }
    ?>

    </div>
    <?php
                $id = $_GET['threadid'];
                $sql = "SELECT * FROM `comments` WHERE thread_id = $id";
                $result = mysqli_query($conn, $sql);
                $noResult = true;
                while($row = mysqli_fetch_assoc($result))
                {
                    $noResult = false;
                    $id = $row['comment_id'];
                    $content = $row['comment_content'];
                    $comment_time = $row['comment_time'];
                    $thread_userid = $row['comment_by'];
                    $sql2 = "SELECT user_email FROM `users` WHERE sno= '$thread_userid'";
                    $result2 = mysqli_query($conn, $sql2);
                    $row2 = mysqli_fetch_assoc($result2);
                    echo '<div class="d-flex my-3 text-center">
                            <div class="flex-shrink-0">
                                <img src="img/default_user.png" width="60px" alt="user image ">
                            </div>
                            <div class="flex-grow-0 ms-3">
                                <p class="font-weight-bold my-0"><b>'.$row2['user_email'].' At '.$comment_time.'</b></p>
                                '.$content.'
                            </div>
                        </div>';
                } 
                if($noResult){
                    echo  '
                    <div class="jumbotron jumbotron-fulid">
                    <div class="container">
                        <h1 class="display-4">
                        No Comments Found 
                        </h1>
                        <p class="lead">
                        Be the first person to Comment 
                        </p>
                    </div>
                    </div>

                    ';
                }
            ?>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
    <?php include 'partials/_footer.php'?>
</body>

</html>