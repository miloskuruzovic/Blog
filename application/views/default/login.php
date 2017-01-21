<div class="container content">
	<div class="row">
		<div class="col-sm-2">
			
		</div>
		<div class="col-sm-10">
			<?= validation_errors(); ?>
			<?= form_open('user/login') ?>
			<div class="form-group">
				<label for='email'>Email</label>
				<input id="email" name="email" class="form-control" type="text" required >
			</div>				
			<div class="form-group">
				<label for="password">Password</label>
				<input id="password" name="password" class="form-control" type="password" required >		
			</div>
			<div class="form-group">
				<input class='btn btn-default' type="submit" name="submit" value="Login" />
			</div>	
			</form>
		</div>
	</div>
</div>