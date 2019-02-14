<?php
  session_start();

  require 'database.php';

  if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT id, email, password FROM users WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = null;

    if (count($results) > 0) {
      $user = $results;
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>StackFlow</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>
    
    <?php if(!empty($user)): ?>
    <?php require 'partials/header.php' ?>
    <div class="container py-5">
      <?php
        require 'database_s.php';

        $find = "SELECT * FROM redirections WHERE owner='".$user['email']."'";
        if($result = mysqli_query($enlace, $find)){
          if(mysqli_num_rows($result) >= 1)
          {
            $fila = mysqli_fetch_array($result);
            $num = 0;
            foreach($result as $nota)
            {
              $num++;
              echo "
                <div class='card mb-4'>
                  <div class='card-header'>
                    <span>URL N° $num</span>
                    <form action='delete_route.php' method='POST'>
                      <input type='hidden' name='route_id' value='".$nota['route']."'>
                      <button type='submit' class='btn btn-sm btn-danger'><i class='far fa-trash-alt'></i></button>
                    </form>
                  </div>
                  <div class='card-body'>
                    <p><span class='text-primary'>Link:</span> https://www.stackflow.com/redirect.php?to=".$nota['route']."</p>
                    <p><span class='text-primary'>Forwards to:</span> ".$nota['heading']."</p>
                  </div>
                  <div class='card-footer'>
              ";
              $views = "SELECT * FROM records WHERE route='".$nota['route']."'";
              if($views_controller = mysqli_query($enlace, $views))
              {
                if(mysqli_num_rows($views_controller)>=1)
                {
                  $views_number = 0;
                  foreach($views_controller as $vies){
                    $views_number++;
                  }
                  echo "<i class='fas fa-directions'></i>&nbsp;".$views_number;
                } else {
                  echo "This link has not redirected anyone 😢";
                }
              }
              echo "</div></div>";
              
            }
          } else {
            echo "You dont have verifiers, yet🌌!<br><br> <a href='new_forwarder.php' class='btn btn-outline-info'>Create one</a>";
          }
        }

        
        
      ?>
    </div>
    
    <?php else: ?>
      <h1 class="mt-5 text-center">Stack<b>Flow</b></h1>
      <p class="text-center">make sure that there are no 🤖 on your links</p>
      <div class="p-2"></div>
      <center>
      <a href="login.php" class="btn btn-lg btn-outline-primary">Login</a> or <a href="signup.php" class="btn btn-lg btn-outline-info">Sign Up</a>
      </center>
      <div class="p-4"></div>
      <div class="container">
      <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-12">
          <center>
          <div class="card">
            <div class="card-header">
              Free
            </div>
            <div class="card-body">
              <h2>$ 0</h2>
              <ul>
                <li>5 links</li>
                <li>60 redirections/<sub>mo</sub></li>
              </ul>
            </div>
          </div>
          </center>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
          <center>
          <div class="card">
            <div class="card-header">
              Pro
            </div>
            <div class="card-body">
              <h2>$ 7<sup>99</sup></h2>
              <ul>
                <li>15 links</li>
                <li>100 redirections/<sub>mo</sub></li>
              </ul>
            </div>
          </div>
          </center>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
          <center>
          <div class="card">
            <div class="card-header">
              Business
            </div>
            <div class="card-body">
              <h2>$ 12<sup>99</sup></h2>
              <ul>
                <li>15 links</li>
                <li>100 redirections/<sub>mo</sub></li>
              </ul>
            </div>
          </div>
          </center>
        </div>
      </div>
      </div>
    <?php endif; ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="assets/js/bootstrap.min.js"></script>
  </body>
</html>
