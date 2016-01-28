<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data"  class="form-horizontal">
 
  
 <fieldset>
 <legend><?php echo $subhead; ?></legend>

<div class="form-group required">
  <label class="col-sm-2 control-label" for="input-firstname"><?php echo $entry_name ?></label>
    <div class="col-sm-10">
      <input type="text" name="name" value="" placeholder="<?php echo $entry_name ?>" id="input-name" class="form-control" />
      <?php if ($error_name) { ?>
      <div class="text-danger"><?php echo $error_name; ?></div>
      <?php } ?>
    </div>
</div>

<div class="form-group required">
  <label class="col-sm-2 control-label" for="input-orderno"><?php echo $text_orderno; ?></label>
    <div class="col-sm-10">
      <input type="text" name="orderno" value="" placeholder="<?php echo $text_orderno; ?>" id="input-orderno" class="form-control" />
      <?php if ($error_orderno) { ?>
      <div class="text-danger"><?php echo $error_orderno; ?></div>
      <?php } ?>
    </div>
</div>

<div class="form-group required">
  <label class="col-sm-2 control-label" for="input-amount_paid"><?php echo $text_amount_paid; ?></label>
    <div class="col-sm-10">
      <input type="text" name="amount_paid" value="<?php echo $amount_paid; ?>" placeholder="<?php echo $amount_paid; ?>" id="input-amount_paid" class="form-control" />
      <?php if ($error_amount_paid) { ?>
      <div class="text-danger"><?php echo $error_amount_paid; ?></div>
      <?php } ?>
    </div>
</div>

<fieldset>
<legend><?php echo $text_bank_account; ?></legend>
  <div class="form-group required">
  <label class="col-sm-2 control-label"><?php echo $text_bank_account; ?></label>
      <div class="col-sm-10">
          <?php echo $text_listbank_account; ?>
          <?php if ($error_bank) { ?>
          <div class="text-danger"><?php echo $error_bank; ?></div>
          <?php } ?>
      </div>
  </div>
</fieldset>
      
<div class="form-group required">
  <label class="col-sm-2 control-label"><?php echo $text_transfer_date; ?></label>
  <div class="col-sm-10">
    <input type="text" name="transfer_date" value="<?php echo $transfer_date; ?>" class="form-control" id="date" style="width:150px;" />
    <?php if ($error_transfer_date) { ?>
      <div class="text-danger"><?php echo $error_transfer_date; ?></div>
      <?php } ?>
  </div>
</div>

<div class="form-group required">
  <label class="col-sm-2 control-label"><?php echo $text_transfer_time; ?></label>
  <div class="col-sm-10">
    <input type="text" name="transfer_time" value="<?php echo $transfer_time; ?>" class="form-control" id="time" style="width:150px;" />
    <?php if ($error_transfer_time) { ?>
      <div class="text-danger"><?php echo $error_transfer_time; ?></div>
      <?php } ?>
  </div>
</div>


<div class="form-group required">
  <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
    <div class="col-sm-10">
      <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
      <?php if ($error_email) { ?>
      <div class="text-danger"><?php echo $error_email; ?></div>
      <?php } ?>
    </div>
</div>

<div class="form-group">
  <label class="col-sm-2 control-label"><?php echo $text_file; ?></label>
  <div class="col-sm-10">
  <input type="file" name="file" id="input-file" class="form-control" />
  </div>
</div>

<div class="form-group">
  <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_enquiry; ?></label>
  <div class="col-sm-10">
    <textarea name="enquiry" rows="8" class="form-control"><?php echo $enquiry; ?></textarea>
  </div>
</div>

    <div class="pull-right"><input type="submit" value="<?php echo $button_continue; ?>" class="btn btn-primary" /></div>

</fieldset>

  </form>

      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script type="text/javascript" src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/datetimepicker/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#date').datepicker({dateFormat: 'yy-mm-dd'});

  $('#time').timepicker();
});
//--></script> 
