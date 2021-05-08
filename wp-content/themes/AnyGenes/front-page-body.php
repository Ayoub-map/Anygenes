<div class="container">
	<div class="row">
		<div class="col-md-10 offset-md-1">
			 <?php while (have_posts()) : the_post(); ?>
             <?php   //the_title() ?>
             <?php  the_content() ?>
	       	 <?php endwhile; ?>
		</div>
	</div>
</div>