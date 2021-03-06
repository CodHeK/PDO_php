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
		$id = $_SESSION['id'];
		$name = $_SESSION['user'];
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>MyProfile</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="https://fonts.googleapis.com/css?family=Changa:200|Source+Sans+Pro:200" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
   <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.js"></script>
  <style type="text/css">
    body {
      font-family: 'Source Sans Pro', sans-serif;
      font-weight: 700;
      background-color: rgb(220, 198, 224);
    }
    #cont {
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 20px 0 rgba(0, 0, 0, 0.4);
      background-color: rgb(238, 238, 238);
      font-weight: 700;
    }
    .navbar {
      background-color: rgb(103, 65, 114)
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
        <!--   <li><a href="users.php">ALL AUTHORS</a></li> -->
        <li><a href="welcome.php" style="color: white;font-weight: 700;">ALL POSTS</a></li>
        <li><a href="sent.php" style="color: white;font-weight: 700;">SENT MSG</a></li>
        <li><a href="recv.php" style="color: white;font-weight: 700;">RECV MSG</a></li>
        <li><a href="addpost.php" style="color: white;font-weight: 700;">ADD POST</a></li>
        <li style="color: black;font-weight: 700;border: 1px solid black;background-color: black;"><a href="profile.php" style="color: white;font-weight: 700;"><?php echo $name ?></a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div id="content1" class="container">
    <h1>Post's Added by you</h1>
    <hr>
    <br>
    <?php 
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "pdologin";
        $tbname = "posts";
        $tbname1 = "comments";

        try {

            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("SELECT * FROM $tbname WHERE name = '$name' ORDER BY id DESC");

            $stmt1 = $conn->prepare("SELECT * FROM $tbname1");

            $stmt->execute();

            $stmt1->execute();

            
            $results = $stmt->fetchAll();

             $results1 = $stmt1->fetchAll();

            if($results != NULL) {
                  
                foreach($results as $rows) {
                  echo '<br>';
                  echo '<div class="container">';
                  echo '<div id="cont" style="border:1px solid black;border-radius:10px;">';
                  echo '<a href="postdelete.php?id=' .$rows['id']. '&user=' .$rows['user']. '" id="cross" style="text-decoration:none;color:#c0c0c0;float:right;font-size:20px;margin-right:1%;"><i class="fa fa-times" aria-hidden="true"></i></a>';
                  echo '<h3 style="font-family: Source Sans Pro;font-weight: 700;color: black;margin-left:2%;font-size:30px;">', $rows['title'], '&nbsp&nbsp&nbsp&nbsp<a href="postedit.php?id=' .$rows['id']. '&user=' .$rows['user']. '" style="text-decoration:none;color:black;font-size:20px;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></h3>';
                  echo '<hr style="margin-left:2%;width:93%;border:0.5px solid black;">';
                  echo '<h4 style = "font-family: Source Sans Pro;color: black;margin-left:2%;">By,  <b> &nbsp',$rows['name'],'&nbsp</b> on  <b>&nbsp',$rows['dater'], '&nbsp</b></h4>', '<br>';
                  echo '<p class="jumbotron" style="font-family: Source Sans Pro;color:black;width:92%;margin-left:2%;font-size:25px;overflow-x:auto;overflow-y:auto;border:0.5px solid black;">',$rows['body'],'</p>';
                  echo '<h4 style="margin-left:2%;"><b>COMMENTS:</b></h4>';
                  echo '<hr style="margin-left:2%;width:92%;">';
                  foreach($results1 as $comm) {
                    if($comm['postid'] == $rows['id']) {
                      $idd = $comm['postid'];
                      $stmt2 = $conn->prepare("SELECT * FROM $tbname1 WHERE postid = '$idd' ORDER BY id DESC");
                      $stmt2->execute();

                      echo '<h4 style="margin-left:2%;"><b>',$comm['name'], ':</b>&nbsp&nbsp' , $comm['comment'], '</h4>';
                  }
                  }
                  echo '<br>';
                  echo '<a href="#" style="text-decoration:none;font-size:25px;color:black;margin-left:2.5%;"><i class="fa fa-heart" aria-hidden="true"></i></a>&nbsp&nbsp&nbsp&nbsp<b style="font-size:20px;">', $rows['likes'], '</b><br>';
                  echo '</div>';
                  echo '</div>';
                  echo '<br>';
               }
            }
            else {
              echo '<br>';
              echo '<h3 style="font-weight:700;font-family:Source Sans Pro;text-align:center;">No posts added by you yet !</h3>';
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
</body>
</html>