<?php
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
  <?php
    echo $this->Html->script('jquery');
	  echo $this->Html->script('jquery.colorbox-min');
  ?>
  <title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body id="tomojisho-app">
	<div id="container">
    <div id="app-header">
      <img src="../img/logo1.png"/>
      <hr>
    </div>
		<div id="content">
			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
      <p>By Tomojisho team</p>
		</div>
	</div>
  <div id="popup-background"></div>
</body>
</html>
