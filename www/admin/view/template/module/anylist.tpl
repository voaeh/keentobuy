<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="container-fluid">
        <table id="module" class="table table-striped table-bordered table-hover" style="width:100%;">
          <thead>
            <tr>
              <th class="left"><?php echo $entry_title; ?></th>
              <th class="left"><?php echo $entry_selection; ?></th>
              <th class="left"><?php echo $entry_dimension; ?></th>
              <th class="left"><?php echo $entry_limit; ?></th>
              <th class="left"><?php echo $entry_filter; ?></th>
              <th class="left"><?php echo $entry_status; ?></th>
              <th></th>
            </tr>
          </thead>
          <?php $module_row = 0; ?>
          
          <?php foreach ($rows as $row) { ?>
            <?php echo $row; $module_row++; ?>
          <?php } ?>
          <tfoot>
            <tr>
              <td colspan="6" class="right"></td><td class="left"><button class="btn btn-primary" title="" data-toggle="tooltip" onclick="addModule();" type="button" data-original-title="Add Module"><i class="fa fa-plus-circle"></i></button>
            </tr>
          </tfoot>
        </table>
    </div>
</form>
</div>

<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addHandlers(module) {
    $('input[name=\'category_'+module+'\']').autocomplete({
        'Module': module,
    	'source': function(request, response) {
    		$.ajax({
    		    Module: this.Module,
    			url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
    			dataType: 'json',			
    			success: function(json) {
    				response($.map(json, function(item) {
    					return {
    						label: item['name'],
    						value: item['category_id']
    					}
    				}));
    			}
    		});
    	},
    	'select': function(item) {
    		$('#category_'+this.Module).val('');
    		$('#anylist-category_' + this.Module + '_' + item['value']).remove();
    		$('#anylist-category_'+this.Module ).append('<div id="anylist-category_' + this.Module + '_' + item['value'] + '"><i style="cursor: pointer;" class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="anylist_module['+this.Module+'][category][]" value="' + item['value'] + '" /></div>');
            $('#category_remove_'+this.Module + '_' +item['value']).click( function() { $(this).parent().remove();} );
            	
    	}
    });

    $('#product_'+module).autocomplete({
        'Module': module,
    	'source': function(request, response) {
    		$.ajax({
    			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
    			dataType: 'json',
    			success: function(json) {
    				response($.map(json, function(item) {
    					return {
    						label: item['name'],
    						value: item['product_id']
    					}
    				}));
    			}
    		});
    	},
    	'select': function(item) {
    		$('#product_'+this.Module).val('');
    		$('#anylist-products-product_'+this.Module + '_' + item['value']).remove();
    		$('#anylist-products_'+this.Module ).append('<div id="anylist-products-product_' + this.Module + '_' + item['value'] + '"><i style="cursor: pointer;" class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="anylist_module['+this.Module+'][products][]" value="' + item['value'] + '" /></div>');
           
    	}
    });


    $('.date').datetimepicker({pickTime: false, dateFormat: 'yy-mm-dd'});
    $('.datetime').datetimepicker({
    	dateFormat: 'yy-mm-dd',
    	timeFormat: 'hh:mm'
    });



    $('#anylist-products_'+module).delegate('.fa-minus-circle', 'click', function() {$(this).parent().remove();});
    $('#anylist-category_'+module).delegate('.fa-minus-circle', 'click', function() {$(this).parent().remove();});


}


function addModule() {	
        module_row++;
		$.ajax({
		    'Module': module_row,
			url: 'index.php?route=module/anylist/addRow&Module='+module_row+'&token=<?php echo $token; ?>',
			success: function(response) {		
                $('#module tfoot').before(response);	
                addHandlers(this.Module);
            }
		});

}



// handle initial rows
for(i=1; i<=module_row; i++) {
        addHandlers(i);
}


//--></script> 
<?php echo $footer; ?>