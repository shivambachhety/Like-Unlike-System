<?php
	include('connect.php');
	session_start();
	if (!isset($_SESSION['userid']) ||(trim ($_SESSION['userid']) == '')) {
	header('location:index.php');
    exit();
	}
	
	$uquery=mysqli_query($conn,"select * from `user` where userid='".$_SESSION['userid']."'");
	$urow=mysqli_fetch_assoc($uquery);
?>
<!DOCTYPE html>
<html>
<head>
<title>Like/Unlike System</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
body { padding-top: px;
    text-align: center;}
.post {
	width: 30%;
	margin: 10px auto;
	border: 1px solid #cbcbcb;
    padding: 5px 10px 0px 10px;
}    
h1   {color: green;}    
h2   {color: blue;}
.like {
   background-image: url(like.png);
    background-color: hsl(0, 0%, 97%);
    background-repeat: no-repeat; 
    background-position: 4px 5px;
    border: none;           
    cursor: pointer;       
    height: 30px;          
    padding-left: 24px;    
    vertical-align: middle;
    color: hsl(0, 0%, 33%);
    border-color: hsl(0, 0%, 60%);
    -webkit-box-shadow: inset 0 1px 0 hsl(0, 100%, 100%),0 1px 0 hsla(0, 0%, 0%, .08);
    box-shadow: inset 0 1px 0 hsl(0, 100%, 100%),0 1px 0 hsla(0, 0%, 0%, .08);
 
}

.unlike {
 background-image: url(unlike.png);
    background-color: hsl(0, 0%, 97%);
    background-repeat: no-repeat; 
    background-position: 4px 6px;
    border: none;           
    cursor: pointer;       
    height: 30px;          
    padding-left: 30px;    
    vertical-align: middle;
    color: hsl(0, 0%, 33%);
    border-color: hsl(0, 0%, 60%);
    -webkit-box-shadow: inset 0 1px 0 hsl(0, 100%, 100%),0 1px 0 hsla(0, 0%, 0%, .08);
    box-shadow: inset 0 1px 0 hsl(0, 100%, 100%),0 1px 0 hsla(0, 0%, 0%, .08);

    }
</style>
<body>
<div>
	<h1>Welcome, <?php echo $urow['your_name']; ?> <a href="logout.php">Logout</a></h1>
	<h2>Posts</h2>
	<?php
		$query=mysqli_query($conn,"select * from `post`");
		while($row=mysqli_fetch_array($query)){
			?>
				<div class="post">
				<?php echo $row['post_text']; ?><br>
				<div>
					
						<?php
							$query1=mysqli_query($conn,"select * from `like` where postid='".$row['postid']."' and userid='".$_SESSION['userid']."'");
							if (mysqli_num_rows($query1)>0){
								?>
                                <button value="<?php echo $row['postid']; ?>" class="unlike">Unlike</button>
								<?php
							}
							else{
								?>
								<button value="<?php echo $row['postid']; ?>" class="like">Like</button>
								<?php
							}
						?>
					<span id="show_like<?php echo $row['postid']; ?>">
						<?php
							$query3=mysqli_query($conn,"select * from `like` where postid='".$row['postid']."'");
							echo mysqli_num_rows($query3);
						?>
					</span>
					<hr>
				</div>
				</div><br>
			<?php
		}
	?>
</div>

<script src = "jquery-3.1.1.js"></script>	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type = "text/javascript">
        $(document).ready(function(){
		$(document).on('click', '.like', function(){
			var id=$(this).val();
			var $this = $(this);
			$this.toggleClass('like');
          	if($this.hasClass('like')){
				$this.text('Like'); 
			} else {
				$this.text('Unlike');
				$this.addClass("unlike"); 
			}
				$.ajax({
					type: "POST",
					url: "like.php",
					data: {
						id: id,
						like: 1,
					},
					success: function(){
						showLike(id);
					}
				});
		});
		
		$(document).on('click', '.unlike', function(){
			var id=$(this).val();
			var $this = $(this);
            $this.toggleClass('unlike');
 			if($this.hasClass('unlike')){
				$this.text('Unlike');
			} else {
				$this.text('Like');
				$this.addClass("like");
			}
				$.ajax({
					type: "POST",
					url: "like.php",
					data: {
						id: id,
						like: 1,
					},
					success: function(){
						showLike(id);
					}
				});
		});
		
	});
	
	function showLike(id){
		$.ajax({
			url: 'show_like.php',
			type: 'POST',
			async: false,
			data:{
				id: id,
				showlike: 1
			},
			success: function(response){
				$('#show_like'+id).html(response);
				
			}
		});
	}
	
</script>
</body>
</html>