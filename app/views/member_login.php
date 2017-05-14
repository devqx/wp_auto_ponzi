
<form action="<?php echo wp_login_url();?>" method="POST" class='col-md-8'>
<h3> Provide Your Username and Password To Login </h3>

<div class="form-group">
  <label for="username">Username</label>
  <input type="text" name="log" id="username" class="form-control" placeholder="" >
</div>

<div class="form-group">
  <label for="password">Password</label>
  <input type="password" name="pwd" id="password" class="form-control" placeholder="" >
</div>

<div class="form-group">
  <input type="submit" name="submited" id="submit_login" class="form-control" value="Login" >
</div>

