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

<?php echo do_shortcode('[admin-add-receiver]');?>