<?php echo $header; ?>
<?php 
/* 
  #file: admin/view/template/total/payment_typechg.tpl
  #tested: Opencart v1.5.1.3
  #powered by fabiom7 - fabiome77@hotmail.it copyright fabiom7 2012
*/
?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/total.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><?php echo $entry_fix; ?></td>      
      		<td>
				<table class="list">
					<thead>
                      <tr>
						<td class="left"><?php echo $entry_method; ?></td>
						<td class="left"><?php echo $entry_charge; ?></td>
						<td class="left"><?php echo $entry_description; ?></td>
                      </tr>
					</thead>
					<tbody>
                      <tr>
						<td class="left"><select name="payment_typechg_method">
                  			<?php foreach ($payments as $payment) { ?>
                  			<?php  if ($payment['fname'] != $payment_typechg_method) { ?>
                  			<option value="<?php echo $payment['fname']; ?>"><?php echo $payment['hname']; ?></option>
                  			<?php } else { ?>
                  			<option value="<?php echo $payment['fname']; ?>" selected="selected"><?php echo $payment['hname']; ?></option>
                  			<?php } ?>
                  			<?php } ?>
                          </select></td>
						<td class="left"><input name="payment_typechg_charge" value="<?php echo $payment_typechg_charge; ?>" /></td>
                        <td class="left"><?php foreach ($languages as $language) { ?>
                          <input name="payment_typechg_description_<?php echo $language['language_id']; ?>" value="<?php echo isset(${'payment_typechg_description_' . $language['language_id']}) ? ${'payment_typechg_description_' . $language['language_id']} : ''; ?>"> <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /><br /><br /><?php } ?></td>
					</tr>
                  </tbody>
                </table></td>                  
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="payment_typechg_status">
                <?php if ($payment_typechg_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_sort_order; ?></td>
            <td><input type="text" name="payment_typechg_sort_order" value="<?php echo $payment_typechg_sort_order; ?>" size="1" /></td>
          </tr>
        </table>
      </form>
      <p style="text-align:right;"><a href="http://www.opencart.com/index.php?route=extension/extension&filter_username=fabiom7" target="_blank"><?php echo $modid; ?></a><br /><a href="http://www.fabiom7.com" target="_blank">powered by fabiom7</a></p>
    </div>
  </div>
</div>
<?php echo $footer; ?> 