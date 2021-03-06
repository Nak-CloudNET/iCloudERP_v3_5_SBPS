
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('add_customer_group'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo form_open("system_settings/add_customer_group", $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <div class="form-group">
                <label for="name"><?php echo $this->lang->line("group_name"); ?></label>

                <div
                    class="controls"> <?php echo form_input('name', '', 'class="form-control" id="name" required="required"'); ?> </div>
            </div>
            <div class="form-group group_price" >
                <label for="percent"><?php echo $this->lang->line("group_percentage"); ?></label>

                <div
                    class="controls"> <?php echo form_input('percent', '0', 'class="form-control" id="percent" required="required"'); ?> </div>
            </div>
			
						<div class="form-group">
				<input type="checkbox" id="makeup_cost" class="form-control" name="makeup_cost" value="1" <?php echo set_checkbox('makeup_cost', '1', $customer_group->makeup_cost==1?TRUE:FALSE); ?>>
				<?= lang("makeup_cost", "makeup_cost"); ?>
			</div>
			<div id="attrs"></div>
		   <div id="attr-con" <?= $this->input->post('attributes') ? '' : 'style="display:none;"'; ?>>
					<div class="form-group" id="ui" style="margin-bottom: 0;">
						<div class="input-group">
							
							<select multiple="multiple" id="category" class="form-control" name="category[]">
							 <?php 
							  $i=1;
							  foreach ($categories as $category) {
								echo "<option value='0#".$category->id ."#".addslashes($category->name)."' arr_cate_id=".$category->id ." arr_subcate='0'>".addslashes($category->name)."</option>";
								$i++;
							  }
							  
							  foreach($sub_categories as $sub_category)
							  {
								echo "<option value='".$sub_category->id ."#".$category->id ."#".addslashes($sub_category->name)."' arr_cate_id=".$sub_category->category_id ." arr_subcate=".$sub_category->id .">".addslashes($sub_category->name)."</option>";
								$i++;
							  }
							 
							 ?>
							</select>
							<div class="input-group-addon" style="padding: 2px 5px;">
								<a href="#" id="addAttributes">
									<i class="fa fa-2x fa-plus-circle" id="addIcon"></i>
								</a>
							</div>
						</div>
						<div style="clear:both;"></div>
					</div>
					
					<div class="table-responsive">
						<table id="attrTable" class="table table-bordered table-condensed table-striped" style="margin-bottom: 0; margin-top: 10px;">
							<thead>
							<tr class="active">
								<th><?= lang('name') ?></th>
								<!--<th><?= lang('warehouse') ?></th>-->
								<th><?= lang('percent') ?></th>
								<!--<th><?= lang('quantity') ?></th>
								<th><?= lang('cost') ?></th>-->
								
								<th><i class="fa fa-times attr-remove-all"></i></th>
							</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
			</div>
			
        </div>
        <div class="modal-footer">
            <?php echo form_submit('add_customer_group', lang('add_customer_group'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<?= $modal_js ?>

<script type="text/javascript">
	
	$(document).on('ifChecked', '#makeup_cost', function (e) {
		$('.group_price').slideUp();
		$('#attr-con').slideDown();
	});
	$(document).on('ifUnchecked', '#makeup_cost', function (e) {
		$('.group_price').css("display","");
		$(".select-tags").select2("val", "");
		$('#attr-con').slideUp();
		
	});
	
	$('#addAttributes').click(function (e) {
            e.preventDefault();
            var attrs_val = $('#category').val()+'';
            var attrs     = attrs_val.split(',');
			
		    for (var i in attrs) {
                if (attrs[i] !== '') {
				  var cate = attrs[i].split('#');
				  $('#attrTable').show().append('<tr class="attr"><td><input type="hidden" name="arr_cate_name[]"  value="' + cate[2] + '"><input type="hidden" name="arr_cate[]"  value="' + cate[1] + '"><input type="hidden" name="arr_sub[]"  value="' + cate[0] + '"><span>' + cate[2] + '</span></td><td class="form-control"><input type="text" name="percent_tag[]" value=""><span></span></td><td class="text-center"><i class="fa fa-times delAttr"></i></td></tr>');
                }
            } 
    });
	
		//=====================Related Strap=========================
	$(document).on('ifChecked', '#related_strap', function (e) {
		$('#strap-con').slideDown();
		$('.group_price').css("display","none");
	});
	$(document).on('ifUnchecked', '#related_strap', function (e) {
		$(".select-strap").select2("val", "");
		$('.attr-remove-all').trigger('click');
		$('#strap-con').slideUp();
	});
	//=====================end===================================
	$(document).on('click', '.delAttr', function () {
		$(this).closest("tr").remove();
	});
	$(document).on('click', '.attr-remove-all', function () {
		$('#attrTable tbody').empty();
		$('#attrTable').hide();
	});
	
</script>