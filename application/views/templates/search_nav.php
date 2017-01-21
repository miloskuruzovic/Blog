<div class="container content">
	<div class="row text-center">
		<ul class="breadcrumb">
			<li><a href=<?= base_url() ?>>Home</a></li>
			<li class="active"><?= $term ?></li> 
		</ul>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<ul class="list-group">
			<li class="list-group-item"><a href=<?= base_url() ."all" ?> class="list-group-item first-group-item">All Blog Posts</a>
				<ul class="list-group">
				<?php foreach ($categories as $category): ?>
					<li class="list-group-item"><a href=<?= base_url() ."cat/". $category['cat_id'] ?> class="list-group-item">
					<?= $category['cat_name'] ?>
					</a></li>
				<?php endforeach ?>
				</ul>
			</li>		  
			</ul>
			<ul class="list-group">
				<li class="list-group-item search-box">
					<?= form_open('search') ?>
					<div class="form-inline">
						<div class="form-group">
							<input id="term" name="term" class="form-control input-sm" type="text" required placeholder="Search...">
							<input class='btn btn-default' type="submit" name="submit" value="Go" />
						</div>
					</div>
					</form>
				</li>
			</ul>
<?php if (!isset($_SESSION['user_id'])): ?>
<!-- Trigger the modal with a button -->
<button type="button" class="btn btn-default login-btn" data-toggle="modal" data-target="#loginModal">Login</button>
	
	<a href=<?= base_url() ."user/register" ?> class="btn btn-default login-btn">Register</a>
	<hr>
	<span style="margin-left: 20px;"><?= isset($_SESSION['msg'])?$_SESSION['msg']:"" ?></span>
<?php else: ?>
	<span style="margin-left: 20px;"><?= isset($_SESSION['msg'])?$_SESSION['msg']:"" ?></span>
	<hr>
	<a href=<?= base_url() ."user/logout" ?> class="btn btn-default login-btn">Logout</a>
<?php endif ?>

<!-- Modal -->
<div id="loginModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
	<!-- Modal content-->
		<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Login</h4>
		</div>
		<div class="modal-body">
			<?= form_open('user/login') ?>
			<div class="form">
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input id="email" type="text" class="form-control" name="email" placeholder="Email">
						</div>
						<br>
						<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						<input id="password" type="password" class="form-control" name="password" placeholder="Password">
						</div>
				</div>
				<hr>
				<div class="input-group">
					<input class='btn btn-default' type="submit" name="submit" value="Login" />
				</div>
			</div>
			</form>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		</div>
		</div>
	</div>
</div>
<!-- end of modal -->
		</div>