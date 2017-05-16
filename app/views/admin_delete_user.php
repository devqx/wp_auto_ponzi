<nav class="navbar navbar-inverse bg-faded" style="margin-bottom:65px">
  <ul class="nav navbar-nav">
    <li class="nav-item active">
      <a class="nav-link" href="<?php echo home_url('admin-dashboard');?>">Add New Receivers<span class="sr-only">(current)</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo home_url('admin-delete-user');?>">Delete A User</a>
    </li>
 
  </ul>
</nav>

<div class="col-md-8">
<form action="" method="POST">
    <div class="form-group">
    <label for="user_id">Provide Username</label>
    <input type="text" name="user_id" id="user_id" class="form-control" placeholder="Provide Username Of User To Delete"/>
    </div>

    <div class="form-group">
    <input type="submit" class="btn btn-warning btn-active btn-block" class="form-control" name="delete" value="Delete User">
    </div>
</form>
</div>
