<div class="container content">
	<div class="row">
		<div class="col-sm-12 add-form">
			<?= validation_errors(); ?>
			<?= form_open_multipart('blog/add_post') ?>
			<div class="form-group">
				<label for='title'>Title</label>
				<input id="title" name="title" class="form-control" type="text" required >
			</div>
			<div class="form-group">
				<label for='category'>Category</label>
				<select class="form-control" id="category" name="category" required>
					<?php foreach ($categories as $category): ?>
						<option value="<?= $category['cat_id'] ?>"><?= $category['cat_name'] ?></option>
					<?php endforeach ?>
				</select>
			</div>
			<div class="form-group">
				<label for='tags'>Tags (insert separated by "-")</label>
				<input id="tags" name="tags" class="form-control" type="text" required >
			</div>			
			<div class="form-group">
				<label for="blog_post">New Post</label>
				<textarea class="form-control" rows="10" id="blog_post" name="blog_post" required ></textarea>		
			</div>
			<div class="form-group">
				<label for="img">Slika:</label>
				<input type="file" name="img" id="img" class="form-control">
			</div>
			<div class="form-group">
				<input class='btn btn-default' type="submit" name="submit" value="Create Blog Post" />
			</div>	
			</form>
		</div>
	</div>
</div>