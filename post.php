<?php
include_once("connect.php");
$post = array();
$comments = array();
$postid = "Hello";
if(isset($_GET['id'])){
   $postid = $_GET['id'];  
   $result = mysqli_query($connection, "SELECT * from Posts WHERE SNo='$postid'");
      while($row = mysqli_fetch_assoc($result)){
         $post[] = $row;
      }
}
if(isset($_POST['id'])){
       $postid = $_POST['id'];
       if(isset($_POST['submitcomment'])){
         $name = "Anonymous";
         if("" != trim($_POST['name'])){
            $name = $_POST['name'];
         }
         $comment = $_POST['comment'];
         $result = mysqli_query($connection, "INSERT INTO Comment(Post_id, Comment, Name, timeOfComment) VALUES('$postid', '$comment', '$name', now())");
         $result = mysqli_query($connection, "UPDATE Posts SET noOfComments=noOfComments+1 WHERE SNo='$postid'");
   }
}
if(isset($postid) && ($postid != "Hello")){
   $comments_result = mysqli_query($connection, "SELECT * from Comment WHERE Post_id='$postid' ORDER BY timeOfComment DESC");
      while($row = mysqli_fetch_assoc($comments_result)){
         $comments[] = $row;
      }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title><?php echo $post[0]['Title']; ?></title>
   <script src="sharer.min.js"></script>
   <style>
      .commentor{
         font-weight: bold;
      }
      textarea, input[type="text"]{
         display: inline-block;
      }
      input[type="submit"]{
         display: block;
         border: none;
         padding: 10px 15px;
      }
      button { 
         display: inline-block;
         margin: 10px;
      }
   </style>
</head>
<body>
	<div class="post">
		<h3>
      <?php if($post[0]['isLink']){ ?>
         <a href="<?php echo $post[0]['Txt']; ?>">
            <?php echo $post[0]['Title']; ?>
         </a>
         <?php } else{ ?>
         <?php echo $post[0]['Title']; }?>
      </h3>
      <?php if(!$post[0]['isLink']){ ?>
		<p><?php echo $post[0]['Txt']; ?></p><?php }?>
		<p>Submitted by <?php echo $post[0]['Name']; ?></p>
   </div>
   <button class="sharer button" data-sharer="twitter" data-title="<?php echo $post[0]['Title']; ?>" data-hashtags="RedditIndia">Share on Twitter</button>
<button class="sharer button" data-sharer="facebook">Share on Facebook</button>
<button class="sharer button" data-sharer="whatsapp" data-title="<?php echo $post[0]['Title']; ?>">Share on Whatsapp</button>
<button class="sharer button" data-sharer="reddit">Share on Reddit</button>

 <!-- Go to www.addthis.com/dashboard to customize your tools --> <div class="addthis_inline_share_toolbox"></div>

   <form action="post.php?id=<?php echo $postid; ?>" method="post" id="comment">
    <textarea name="comment" cols="30" rows="10" placeholder="Add a Comment" onkeypress="return runScript(event)"></textarea>
      <input type="text" name="name" placeholder="Name">
     
      <input type="hidden" name="id" value="<?php echo $postid; ?>">
      <input type="submit" id="submitcomment" valud="Send" name="submitcomment"/>
   </form>
   <div class="comments" style="height: 400px; overflow: scroll;">
      <?php
      foreach ($comments as $comment){
         ?>
         <div class="comment">
            <p class="commenttext"><?php echo $comment['Comment']; ?>
               <span class="commentor"> - <?php echo $comment['Name']; ?></span>
            </p>
         </div>
         <?php
      }
      ?>
   </div>
   <!-- Go to www.addthis.com/dashboard to customize your tools --> <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5833eb2956b98a2d"></script> 
   <script>
      function runScript(e){
         if(e.keyCode ==13){
            document.getElementById('submitcomment').click();
         }
      }
      (function(){
         elements = document.getElementsByClassName('sharer')
         for (var i=0; i<elements.length; i++){
            elements[i].setAttribute('data-url',window.location.href);
         }
      })();
   </script>
</body>
</html>