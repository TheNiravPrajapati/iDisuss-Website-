<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iDisuss - coding forum </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <style>
    #maincontainer {
        min-height: 80vh;
    }
    </style>
</head>

<body>
    <?php include 'partials/_header.php' ?>
    <?php include 'partials/_dbconnect.php' ?>
    <!-- search result  -->



    
    <div class="container my-3" id="maincontainer">
        <h1 class="py-2">Search Result For "<?php echo $_GET['search'];?>"</h1>
            <div class="result">
            <?php
                $noresults=true;
                $query = $_GET['search'];
                $sql = "SELECT * FROM `threads` WHERE MATCH (thread_title, thread_desc) against ('$query')";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($result))
                {
                    $title = $row['thread_title'];
                    $desc = $row['thread_desc']; 
                    $threadid = $row['thread_id']; 
                    $url = "thread.php?threadid=".$threadid;
                    $noresults = false;   

                    echo '
                    <h4> <a href="'.$url.'" class="text-dark"> '.$title.'</a></h4>
                    <div>
                        <p>
                        '.$desc.'
                        </p>
                    </div>
                    ';
                }
                if($noresults)
                {
                    echo'
                    <div class="jumbotron jumbotron-fulid">
                        <div class="container my-3">
                            <h1 class="display-4">
                            No Results Found 
                            </h1>
                            <p class="lead">
                            suggestions :
                            Make sure that all words are spelled correctly <br>
                            try different keyword <br>
                            try more general keywords <br>
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