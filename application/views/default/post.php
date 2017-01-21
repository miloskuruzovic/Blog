<div class="container content">	
	<div class="row">
	<h2 class="post-h2"><?= $post->post_title ?></h2>
	<?php if (file_exists("./img/posts/" . $post->post_id . ".jpg")): ?>
		<div class="col-sm-12">
			<img src=<?= base_url() ."img/posts/".$post->post_id.".jpg" ?> class="img-circle cover-img img-responsive">
		</div>
	<?php endif ?>
	</div>
	<div class="row">
	<p class="post-text"><?= $post->post_content ?></p>
	<?php foreach ($tags as $tag): ?>
		<code><a href=<?= base_url() ."tag/". $tag; ?>><?= $tag ?></a></code>
	<?php endforeach ?>
	<hr>
	<?php if ($next !='end'): ?>
		<span style="float: left;margin-bottom: 20px">
			<?= anchor('/posts/'.$next , '<span class="glyphicon glyphicon-chevron-left"></span> Newer Post'); ?>
		</span>
	<?php endif ?>
	<?php if ($prev !='end'): ?>
		<span style="float: right;margin-bottom: 20px">
			<?= anchor('/posts/'.$prev , 'Older Post <span class="glyphicon glyphicon-chevron-right"></span>'); ?>
		</span>
	<?php endif ?>
	
	<hr style="clear: both;">
	<?= anchor('/all/', 'All posts'); ?>
	</div>
	<div class="row comments">
		<h3>Comments:</h3>
		<hr>
		<div class="col-sm-5">
			<?php if (isset($_SESSION['user_id'])): ?>
				<?= form_open(base_url()."comments/add/".explode('/', uri_string())[1]) ?>
				<div class="form-group">
					<span style="float: left;">Hello <?= $_SESSION['username'] ?>!</span>
					<label for="comment">Comment: </label>
					<textarea class="form-control" rows="10" id="comment" name="comment" required ></textarea>
				</div>
				<div class="form-group">
					<input class='btn btn-default' type="submit" name="submit" value="Leave Comment" />
				</div>
				</form>
			<?php else: ?>
				<?= "You have to be logged in if you want to leave a comment!"?>
			<?php endif ?>
		</div>
		<div class="col-sm-7">
			<?php foreach ($comments as $comment): ?>
				<p class="comment">
					<?= $comment->comment_content ?>
					<br>
					<small>Comment by:</small>
					<strong><?= $comment->username ?></strong>
				</p>
				<hr>
			<?php endforeach ?>
		</div>
	</div>
</div>