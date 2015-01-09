<?php
	//include our library and start drawing the page
	require_once("../php_include/functions.php");
	$page_name = "training";
	print_header($page_name, false);
	print_navbar();
?>
<div class="container">
	<div class="row">
	<div class="col-lg-8">
	<?php
		$limit = 5;
		$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
		if ($db = get_db()) {
			$query = "SELECT * FROM `training_posts` WHERE `visible`='1' AND `is_disabled`='0';";
			$result = $db->query($query);
			$count = $result->num_rows;
			$query = "SELECT * FROM `training_posts` WHERE `visible`='1' AND `is_disabled`='0' ORDER BY `publish_time` DESC LIMIT $offset,$limit;";
			$index = 0;
			if ($result = $db->query($query)) {
				while ($row = $result->fetch_assoc()) {
					$query = "SELECT `first_name`, `last_name` FROM `user_info` WHERE `id`='".$row['created_by']."';";
					$asoc = $db->query($query)->fetch_assoc();
					$name = $asoc['first_name'].' '.$asoc['last_name'];
				
					echo '<div class="row">';
					echo '	<div class="col-lg-12">';
					if($index > 0) 
						echo '<hr>';
					echo '		<a href="post?id='.$row['id'].'"><h3>'.htmlspecialchars($row['title']).'</h3></a>';
					echo '		<h4>'.htmlspecialchars($row['sub_title']).'</h4>';
					echo '		<h5>Published At '.$row['publish_time'].'</h5>';// By <a href="/contact/user?id='.$row['created_by'].'">'.$name.'</a></h5>';
					//echo '		<hr>';
					//echo '		<span id="disp-content">'.$row['content'].'</span>';
					echo '	</div>';
					echo '</div>';
					$index++;
				}

				if ($count > $offset + $limit || $offset) {
					echo '<hr><div class="row">';
					echo '	<div class="col-sm-12">';
					if ($count > $offset + $limit) {
						echo '	<span style="float:right;"><a href="?offset='.($offset+5).'"><button type="button" class="btn btn-default btn-sm">Older Posts&raquo;</button></a></span>';
					}
					if ($offset) {
						echo '<a href="?offset='.($offset-5).'"><button type="button" class="btn btn-default btn-sm">&laquo; Newer Posts</button></a>';
					}
					echo '	</div>';
					echo '</div>';
				}	
			}					
			$db->close();
		} else {
			echo "<p>DB Error.</p>";
		}
	?>	
	</div>
	</div>
	<?php
		print_footnote();
	?>

</div><!-- /.container -->
<?php 
	//print the footer	
	print_footer();
?>
