<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset='utf-8'>
	<title>Delete player</title>
	<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src='/assets/js/jquery.tablesorter.js'></script>
</head>
<body>
	<div class='container'>
		<form role='form' class='col-md-4 col-xs-6' action="<?php echo site_url('stats_controller/delete_player'); ?>" method='post' style='margin-top:20px;'>
			<select multiple class='form-control' name='select'>
				<?php 
					foreach($users as $user)
					{
				?> 		<option value= '<?php echo ($user['first_name']); ?>' ><?php echo ($user['first_name']); ?></option><?php
					}
				?>
			</select>
			<button class='btn btn-danger' type='submit'>Delete Player</button>
		</form>
	</div>
</body>
</html>