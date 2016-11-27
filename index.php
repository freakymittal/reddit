<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans|Ravi+Prakash" rel="stylesheet">

	<title>RedditIndia</title>
	<style>
		*{
			box-sizing: border-box;
		}
		a{
			cursor: pointer;
		}
		h1,h2,h3,h4,h5,h6{
			margin: 0;
		}
		a,a:link,a:visited{
			text-decoration: none;
		}
		body{
			margin: 0;
			background-color: #f2f2ea;
			min-height: 100vh;
		}
		.main{
			max-width: 700px;
			padding: 20px 0px;
			margin: 0 auto;
		}
		.container{
			background: #fff;
			display: flex;
		}
		.posts{
			padding: 40px;
			flex: 1;
		}
		.post{
			display: flex;
			justify-content: space-between;
			margin: 30px 0;
		}
		.post p{
			font-size: 12px;
		}
		.right{
			width: 40%;
			padding: 20px;
		}
		.right a{
			display: inline-block;
			padding: 10px;
			background: #ddd;
			margin: 5px ;
		}
		.tag{
			padding: 5px;
			background: #d05d05;
			color: #eee;
		}
		header{
			max-width: 1000px;
			margin: 0 auto;
		}
		header nav{
			height: 40px;
			border-radius: 5px;
			border-bottom: 1px solid #ddd;
			background: #e9e9e9;
		}
		header nav ul{
			list-style: none;
			display: flex;
			margin: 0;
			padding: 0;
		}
		header nav ul li a{
			display: block;
			padding: 15px 25px;
			text-transform: uppercase;
			font-family: 'Lato', sans-serif;
			letter-spacing: 1px;
			line-height: 10px;
			text-align: center;
			transition: 0.5s ease;
		}
		a,a:link,a:visited{
			color: #555;
		}
		header nav ul li a:hover{
			color: #fff;
		}
		header nav ul li{
			flex: 1;
			width: 50px;
			transition: 0.5s ease;
		}
		header nav ul li:hover{
			background-color: #555;
		}
		.controls{
			background-color: #4190E6;
			padding: 0 15px;
		}
		.controls ul{
			display: flex;
			font-family: 'sans-serif';
			font-size: 12px;
			justify-content: center;
			margin:0;
			padding: 0;
			list-style: none;
		}
		.controls ul li{
			width: 150px;
			
		}
		.controls ul li a{
			padding: 10px;
			text-align: center;
			display: block;
			color: #fff;
		}
		.controls ul .link {
			padding: 5px;
		}
		.controls ul .link a{
			border: 1px solid #dcedc8;
			padding: 5px;
		}
		.post:first-child, .post:last-child{
			margin: 0px;
		}
		.nav{
			display: flex;
			padding: 20px;
			height: 100px;
			justify-content: flex-start;
		}
		.nav img{
			height: 100%;
			flex: 1;
			margin: 0 10px;
		}
		.nav h2{
			margin: 20px 0px;
			font-family: 'Ravi Prakash', cursive;
			font-size: 32px;
			flex: 5;
			text-align: center;
			align-self: center;
		}
	</style>
</head>
<body>
<header>
<div class="nav">
	<img src="132.svg" alt="">
	<h2>Welcome to RedditIndia!</h2>
</div>

	<nav>
		<ul>
			<li><a href="#">Link1</a></li>
			<li><a href="#">Link2</a></li>
			<li><a href="#">Link3</a></li>
			<li><a href="#">Link4</a></li>
		</ul>
	</nav>
	
</header>
	<div class="main">
			<div class="controls">
				<ul>
<!-- 					<li><a href="#">Recently Updated</a></li>
					<li><a href="#">Start Date</a></li>
					<li><a href="#">Most Replies</a></li>
					<li><a href="#">Most Viewed</a></li> -->
					<li class="link"><a href="addlink.php">Add a Link</a></li>
					<li class="link">
		<a href="addpost.php">Add a post</a></li>
				</ul>
			</div>
			<div class="container">

	<div class="posts">

<?php
include_once("connect.php");
function ago($seconds){
	$year = 86400*365;
	$month = 86400*30;
	$day = 86400;
	$hour = 3600;
	$minute = 60;
	if($seconds > 2 * $year)
		return printf("%d years", round($seconds/$year));
	elseif($seconds > $year)
		return print("1 year");
	elseif($seconds > 2 * $month)
		return printf("%d months", round($seconds/$month));
	elseif($seconds > $month)
		return print("1 month");
	elseif($seconds > 2 * $day)
		return printf("%d day", round($seconds/$day));
	elseif($seconds > $day)
		return print("1 day");
	elseif($seconds > 2 * $hour)
		return printf("%d hour", round($seconds/$hour));
	elseif($seconds > $hour)
		return print("1 hour");
	elseif($seconds > 2 * $minute)
		return printf("%d minutes", round($seconds/$minute));
	elseif($seconds > $minute)
		return print("1 minute");
	else return printf("%d seconds", $seconds);
}
   
   	$result = mysqli_query($connection, "SELECT * from Posts ORDER BY timeOfSubmission DESC");
   	while($row = mysqli_fetch_assoc($result)){
   		?>

   		<div class="post">
   		<div>
   			<h4>
   				<?php if($row['Tag'] != ""){ ?>
   					<span class="tag"><?php echo $row['Tag'] ?></span> 
   				<?php } if($row['isLink']){ ?> 

   				<a target="_blank" href="<?php echo $row['Txt']; ?>"><?php echo $row['Title']; ?></a>
   				<?php } else {?>
   				<a target="_blank" href="post.php?id=<?php echo $row['SNo']; ?>"><?php echo $row['Title']; ?></a><?php }?>
   			</h4>
   			<p>Submitted <?php ago(time()-strtotime($row['timeOfSubmission'])); echo " ago by ".$row['Name']; ?></p>
   		</div>
   			<p><a target="_blank" href="post.php?id=<?php echo $row['SNo']; ?>"><span class="noofcomments">Comments : <?php echo $row['noOfComments']; ?> </span></a></p>
   		</div>
   		<?php
   	}
?>
	</div>
	<!-- <div class="right">
		<a href="addlink.php">Add a Link</a>
		<a href="addpost.php">Add a post</a>
	</div> -->
</div>

	</div>

</body>
</html>