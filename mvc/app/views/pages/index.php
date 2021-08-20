<?php
get_template_part('header');
foreach($data as $d):?>
	<div>
		<h1><?php echo $d->title?></h1>
		<p><?php echo $d->content?></p>
		<p> by: <?php echo $d->author?></p>
</div>
<?php endforeach; 
get_template_part('footer');



