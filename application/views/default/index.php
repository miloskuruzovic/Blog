
		<div class="col-sm-9 post text-justify post-intro">
			<h3>CodeIgniter Blog</h3>
			<img src="<?= base_url() .'img/blog.jpg' ?>" class="img img-responsive img-thumbnail intro-img">
			<p>This is a blog developed using <a href="https://codeigniter.com/" target="_blank">CodeIgniter PHP Framework</a>, built mainly for practice and testing purposes. With minimal styling and most of the content being just dummy text, main focus was on simple, but neat, back-end logic. Enjoy reading and blogging! </p>
			<p>CodeIgniter version used: <strong>3.1.3</strong></p>
			<p>Developed by: <a href="https://ttfu.in.rs/" target="_blank">TTFU</a></p>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
		</div>
	</div>
	<hr>
	<div class="row">
		<?php foreach ($posts as $key=>$post): ?>
		<div class="col-sm-4 post">
			<h3><?= $post['post_title'] ?></h3>
			<p>
			<?php foreach ($previews as $i=>$preview): ?>
				<?php if ($i == $key): ?>
					<?= $preview ?>
				<?php endif ?>
			<?php endforeach ?>
			
			<?= anchor('posts/'.$post['post_slug'], 'read more...') ?>
			</p>
			<p>
				<small>Created at: <?= $post['post_created'] ?></small> 
				<strong>Author : <?= $post['username'] ?></strong>
			</p>
		</div>
		<?php endforeach ?>
	</div>
</div>
