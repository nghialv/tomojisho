<?php
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
  <?php
    echo $this->Html->script('jquery');
	  echo $this->Html->script('tomojisho');
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
		<div id="content">
      <h1 align="center">TOMOJISHO</h1>
      <p>The feature of your friend</p>

      <div id="box1"></div><br>
	    <p>Q: which of your friend does this feature match with?</p><br>

      <div id="box2"></div>
	    <div id="box3"></div>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
		</div>
	</div>
</body>
</html>
