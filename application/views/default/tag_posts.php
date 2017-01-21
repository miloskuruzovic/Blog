
		<div class="col-sm-8">
			<?php foreach ($posts as $key=>$post): ?>
				<div class="post">
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
</div>