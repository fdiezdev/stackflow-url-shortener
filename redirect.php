<?php 
    session_start();
    
    $data = $_GET['to'];
    
    require 'database_s.php';

    $query = "SELECT * FROM redirections WHERE route='".$data."'";
    if($result = mysqli_query($enlace, $query)) {
        if(mysqli_num_rows($result)>= 1) {
            $date = getdate();
            $dd = $date['mday'];
            $mm = $date['mon'];
            $yy = $date['year'];
            $data_date = $dd."-".$mm."-".$yy;
            $add_record = "INSERT INTO records (dd, mm, yy, route) VALUES ('".$dd."', '".$mm."', '".$yy."', '".$data."')";
            if($record = mysqli_query($enlace, $add_record)) {
                $_SESSION['id']=$data_date;
                header("Location: check.php?href=".$data."");
            }
        }
        else {
            $message = "Sorry, we couldn't find that link :( <br><br>";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>StackFlow</title>
    <link rel="stylesheet" href="assets/css/style-mas.css">
</head>
<body>
    <center>
        <div class="logo">
            <p><span>Stack</span>Flow</p>
        </div>
        <?php if(!empty($message)): ?>
            <?= $message ?>
        <?php endif; ?>
        <div class="loader"></div>
    </center>
</body>
</html>
</body>
</html>