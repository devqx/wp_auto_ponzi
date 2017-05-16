<nav class="navbar navbar-inverse bg-faded" style="margin-bottom:65px">
  <ul class="nav navbar-nav">
    <li class="nav-item active">
      <a class="nav-link" href="<?php echo home_url('admin-dashboard');?>">Add New Receivers<span class="sr-only">(current)</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo home_url('admin-delete-user');?>">Delete A User</a>
    </li>

     <li class="nav-item">
      <a class="nav-link active" href="<?php echo home_url('admin-match-user');?>">Match A User</a>
    </li>
 
  </ul>
</nav>

<?php //var_export($data['all_receivers']);?>

<div class="col-md-8">
<form action="" method="POST">
    <div class="form-group">
    <label for="donator">Provide Username</label>
    <input type="text" name="donator" id="donator" class="form-control" placeholder="Provide Username Of User To Match"/>
    </div>

 <div class="form-group">
    <label for="receiver">Select Receiver </label>
        <select name="receiver" class="form-control">
        <option value="" selected>Choose Receiver</option>
        <?php foreach($data['all_receivers'] as $receivers){?>
        <option value="<?php $receivers['user_login'];?>"><?php echo $receivers['user_login'];?></option>
        <?php } ?>
        </select>
    </div>

    <div class="form-group">
    <input type="submit" class="btn btn-warning btn-active btn-block" class="form-control" name="match" value="Match User">
    </div>
</form>
</div>

