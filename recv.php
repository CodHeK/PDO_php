<?php
	
	session_start();
	if(!isset($_SESSION['user'])) {
		echo '<script language="javascript">';
				echo 'alert("First Login!");';
				echo '</script>';
				header("Location:login.php");
		exit();
	}
	else {
		//$sendname = $_SESSION['tomsgs'];
    //echo $id;
		$name = $_SESSION['user'];
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Recieved Messages</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta http-equiv="refresh" content="60" > 
  <link href="https://fonts.googleapis.com/css?family=Changa:200|Source+Sans+Pro:200" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <style type="text/css">
    body {
      font-family: 'Source Sans Pro', sans-serif;
      font-weight: 700;
      background-color: rgb(220, 198, 224);
    }
    .cont {
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 20px 0 rgba(0, 0, 0, 0.4);
      background-color: rgb(238, 238, 238);
      font-weight: 700;
    }
    .navbar {
      background-color: rgb(103, 65, 114);
    }
    hr {
        border: 1px solid black;
    }
  </style>
</head>
<body>
		<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#" style="color: white;margin-left: 7%;font-weight: 700;">PDOphp</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php" style="color: white;font-weight: 700;">LOG OUT</a></li>
         <!--  <li><a href="users.php">ALL AUTHORS</a></li> -->
        <li><a href="welcome.php" style="color: white;font-weight: 700;">ALL POSTS</a></li>
        <li><a href="addpost.php" style="color: white;font-weight: 700;"> ADD POST</a></li>
        <li><a href="sent.php" style="color: white;font-weight: 700;">SENT MSG</a></li>
        <li><a href="recv.php" style="color: white;font-weight: 700;">RECV MSG</a></li>
        <li style="color: black;font-weight: 700;border: 1px solid black;background-color: black;"><a href="profile.php" style="color: white;font-weight: 700;"><?php echo $name ?></a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<div id="content" class="container">
    <h1>Revcived Messages</h1>
    <hr>
    <br>
    <?php 
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "pdologin";
        $tbname = "messages";

        try {

            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("SELECT * FROM $tbname WHERE tomsg = '$name' ORDER BY id DESC");

            $stmt->execute();

            
            $results = $stmt->fetchAll();

            if($results != NULL) {
                  
                foreach($results as $rows) {
                  echo '<br>';
                  echo '<div class="container">';
                  echo '<div class="cont" style="border:1px solid black;border-radius:10px;">';
                  echo '<h3 style="font-family: Source Sans Pro;font-weight: 700;color: black;margin-left:2%;font-size:30px;">From:&nbsp&nbsp', $rows['frommsg'], '</h3>';
                  echo '<hr style="margin-left:2%;width:93%;border:0.5px solid black;">';
                  echo '<p class="jumbotron" style="font-family: Source Sans Pro;color:black;width:92%;margin-left:2%;font-size:25px;overflow-x:auto;overflow-y:auto;">',$rows['msgbody'],'</p>';
                  echo '<a href="message.php?user=' .$rows['tomsg']. '&sendto=' .$rows['frommsg']. '" class="btn btn-default" style="text-decoration:none;margin-left:2%;background-color: rgb(103, 65, 114);color:white;font-weight:700;">REPLY</a>','<br><br>';
                  echo '</div>';
                  echo '</div>';
                  echo '<br>';
               }
            }
            else {
              echo '<br>';
              echo '<h3 style="font-weight:700;font-family:Source Sans Pro;text-align:center;">No messages yet !</h3>';
            }
        }
        catch(PDOException $e){
              echo '<script language="javascript">';
              echo '$sql . "<br>" . $e->getMessage();';
              echo '</script>';   
              header("Refresh: 1; url=login.php");
        }

        $conn = null;

    ?>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.js"></script>
</body>
</html>