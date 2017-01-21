<div class="container content">
	<div class="row text-center">
		<ul class="breadcrumb">
			<li><a href=<?= base_url() ?>>Home</a></li>
			<li class="disabled">Categories</li>
		</ul>
	</div>
	<div class="row text-center">
	<?php foreach ($categories as $category): ?>		
		<div class="col-sm-6 cat-display">
			<a href=<?= base_url() ."cat/". $category['cat_id'] ?>>
				<?= $category['cat_name'] ?>
			</a>
		</div>		
	<?php endforeach ?>
		
	</div>
</div>