<script src="<?= $assets ?>js/jquery.validate.min.js"></script>
<style>
	.form-group .select2-container {
	  position: relative;
	  z-index: 2;
	  float: left;
	  width: 100%;
	  margin-bottom: 0;
	  display: table;
	  table-layout: fixed;
	}
	.select2-result.select2-result-unselectable.select2-disabled {
		display: none;
	}
</style>

<script type="text/javascript">
    var count = 1, an = 1, product_variant = 0, DT = <?= $Settings->default_tax_rate ?>,
        product_tax = 0, invoice_tax = 0, total_discount = 0, total = 0, allow_discount = <?= ($Owner || $Admin || $this->session->userdata('allow_discount')) ? 1 : 0; ?>,
        tax_rates = <?php echo json_encode($tax_rates); ?>;

    $(document).ready(function () {
		var test2 = '<?=$this->session->userdata('remove_s2');?>';
		if (test2 == '1') {

				if (__getItem('slitems')) {
					__removeItem('slitems');
				}
				if (__getItem('sldiscount')) {
					__removeItem('sldiscount');
				}
				if (__getItem('sltax2')) {
					__removeItem('sltax2');
				}
				if (__getItem('slshipping')) {
					__removeItem('slshipping');
				}
				if (__getItem('slarea')) {
					__removeItem('slarea');
				}
				if (__getItem('slref')) {
					__removeItem('slref');
				}
				if (__getItem('slwarehouse')) {
					__removeItem('slwarehouse');
				}
				if (__getItem('slnote')) {
					__removeItem('slnote');
				}
				if (__getItem('slinnote')) {
					__removeItem('slinnote');
				}
				if (__getItem('slcustomer')) {
					__removeItem('slcustomer');
				}
				if (__getItem('slcurrency')) {
					__removeItem('slcurrency');
				}
				 if (__getItem('sldate')) {
					__removeItem('sldate');
				}
				if (__getItem('slstatus')) {
					__removeItem('slstatus');
				}
				if (__getItem('slbiller')) {
					__removeItem('slbiller');
				}
				if (__getItem('gift_card_no')) {
					__removeItem('gift_card_no');
				}
				 if (__getItem('slsale_status')) {
                __removeItem('slsale_status');
            }
			if (__getItem('slpayment_status')) {
                __removeItem('slpayment_status');
            }
            if (__getItem('paid_by')) {
                __removeItem('paid_by');
            }
            if (__getItem('amount_1')) {
                __removeItem('amount_1');
            }
            if (__getItem('paid_by_1')) {
                __removeItem('paid_by_1');
            }
            if (__getItem('pcc_holder_1')) {
                __removeItem('pcc_holder_1');
            }
            if (__getItem('pcc_type_1')) {
                __removeItem('pcc_type_1');
            }
            if (__getItem('pcc_month_1')) {
                __removeItem('pcc_month_1');
            }
            if (__getItem('pcc_year_1')) {
                __removeItem('pcc_year_1');
            }
            if (__getItem('pcc_no_1')) {
                __removeItem('pcc_no_1');
            }
            if (__getItem('cheque_no_1')) {
                __removeItem('cheque_no_1');
            }
            if (__getItem('payment_note_1')) {
                __removeItem('payment_note_1');
            }
            if (__getItem('slpayment_term')) {
                __removeItem('slpayment_term');
            }
			if (__getItem('sale_orer_id')) {
                __removeItem('sale_orer_id');
            }
			if (__getItem('paid')) {
                __removeItem('paid');
            }
			if (__getItem('grand_total')) {
                __removeItem('grand_total');
            }
			if (__getItem('payment_deposit')) {
                __removeItem('payment_deposit');
            }
			<?=$this->session->set_userdata('remove_s2', '0');?>
		}
        <?php if(isset($sale_order_id) || isset($delivery_id)) { ?>
		//alert('<?= $sale_order->customer_id ?>');
		__setItem('sale_orer_id', '<?= $sale_order_id ?>');
        __setItem('sldate', '<?= $this->erp->hrld($sale_order->date) ?>');
        __setItem('slcustomer', '<?= $sale_order->customer_id ?>');
        __setItem('slbiller', '<?= $sale_order->biller_id ?>');
        __setItem('slwarehouse', '<?= $sale_order->warehouse_id ?>');
		<?php if(isset($quote)){ ?>
        __setItem('slnote', '<?= str_replace(array("\r", "\n"), "", $this->erp->decode_html($quote->note)); ?>');
		<?php } ?>
        __setItem('sldiscount', '<?= $sale_order->order_discount_id ?>');
        __setItem('sltax2', '<?= $sale_order->order_tax_id ?>');
        __setItem('slshipping', '<?= $sale_order->shipping ?>');
		__setItem('bill_to', '<?= $sale_order->bill_to ?>');
		__setItem('paid', '<?= $sale_order->paid ?>');
		__setItem('po', '<?= $sale_order->po ?>');
		__setItem('slpayment_status', '<?= $sale_order->payment_status ?>');
		__setItem('delivery_by', '<?= $sale_order->delivery_by ?>');
		__setItem('slarea', '<?= $sale_order->group_areas_id ?>');
		//__setItem('payment_status', '<?= $sale_order->payment_status ?>');
        __setItem('slitems', JSON.stringify(<?= $sale_order_items; ?>));
		__setItem('payment_deposit', JSON.stringify(<?= (isset($payment_deposit)?$payment_deposit:""); ?>));
		__setItem('sale_order_ref', '<?= $sale_order->reference_no ?>');
		__setItem('grand_total', '<?= $sale_order->grand_total ?>');
		__setItem('saleman', '<?= $sale_order->saleman_by ?>');


		<?php if(isset($sale_order_id)) { ?>
			$('#slnote').val('<?=$sale_order->note?>');
			$('#slinnote').val('<?=$sale_order->staff_note?>');
		<?php  } ?>

		$("#slbiller").prop('readonly', true);
		$("#saleman").prop('readonly', true);
		$("#slarea").prop('readonly', true);
		$("#so_ref").show();
		$("#so_deposit").hide();

        <?php }else if(isset($quote_ID)){ ?>
			__setItem('quote_ID', '<?= $quote_ID ?>');
			__setItem('sldate', '<?= $this->erp->hrld($quotes->date) ?>');
			__setItem('slshipping', '<?= $quotes->shipping ?>');
			__setItem('sldiscount', '<?= $quotes->order_discount_id ?>');
			__setItem('sltax2', '<?= $quotes->order_tax_id ?>');
			__setItem('slbiller', '<?= $quotes->biller_id ?>');
			__setItem('slcustomer', '<?= $quotes->customer_id ?>');
			__setItem('slwarehouse', '<?= $quotes->warehouse_id ?>');
			__setItem('quote_order_ref', '<?= $quotes->reference_no ?>');
			__setItem('slitems', JSON.stringify(<?= $sale_order_items; ?>));
			$("#slbiller").prop('readonly', true);
			$("#saleman").prop('readonly', true);
			$("#slarea").prop('readonly', true);
			$("#qu_ref").show();

		<?php }else { ?>
			$("#so_deposit").show();
		<?php } ?>

		<?php if(isset($delivery_id)){ ?>
			__setItem('slsale_status','pending');
		<?php }else{ ?>
			__setItem('slsale_status','completed');
		<?php } ?>


        <?php if($this->input->get('customer')) { ?>
        if (!__getItem('slitems')) {
            __setItem('slcustomer', <?=$this->input->get('customer');?>);
        }
        <?php } ?>
        <?php
            if (isset($sale_order->date) != NULL) {
                $sale_order = $sale_order->date;
            } else {
                $sale_order = NULL;
            }
        ?>
        if (!__getItem('sldate')) {
            $("#sldate").datetimepicker({
                format: site.dateFormats.js_ldate,
                fontAwesome: true,
                language: 'erp',
                weekStart: 1,
                todayBtn: 1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                forceParse: 0
            }).datetimepicker('update', new Date());
        }else {
			$("#sldate").datetimepicker({
                format: site.dateFormats.js_ldate,
                fontAwesome: true,
                language: 'erp',
                weekStart: 1,
                todayBtn: 1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                forceParse: 0
            }).datetimepicker('update', '<?= $sale_order ?>');
		}

        $(document).on('change', '#sldate', function (e) {
            __setItem('sldate', $(this).val());
        });
        if (sldate = __getItem('sldate')) {
            $('#sldate').val(sldate);
        }

		if (slsale_status = __getItem('slsale_status')) {
            $('#slsale_status').val(slsale_status);
        }

		<?php if(isset($so_deposit)){ ?>
            if(__getItem('slpayment_status') == 'partial' || __getItem('slpayment_status') == 'paid') {
                __setItem('paid_by_1', 'deposit');
                var payment_status = __getItem('slpayment_status');
                $('#slpayment_status').val(payment_status);
                $('#payments').css('display', 'block');
                $("#dp_details").html('<?=$this->erp->formatDecimal($so_deposit->deposit_amt);?>');
                $(".paid_by").trigger("change");

                $(".amount").val('<?=$so_deposit->deposit_amt;?>');
                $("#payment_note_1").val('<?=$so_deposit->note;?>');
            }
		<?php } ?>

		 $(document).on('change', '#slarea', function (e) {
            __setItem('#slarea', '<?= (isset($sale_order->group_areas_id)?$sale_order->group_areas_id:"") ?>');
        });
		if(quote_ID = __getItem('quote_ID')){
			$("#quote_id").val(quote_ID);
		}
		if (bill_to = __getItem('bill_to')) {
            $('#bill_to').val(bill_to);
        }
		if (po = __getItem('po')) {
            $('#po').val(po);
        }

        if (group_area = __getItem('slarea')) {
            $('#slarea').val(group_area);
        }

		if (delivery_by = __getItem('delivery_by')) {
            $('#delivery_by').val(delivery_by);
        }
		if (so_reference_no = __getItem('sale_order_ref')) {
            $('#soref').val(so_reference_no);
        }
		if (quote_reference_no = __getItem('quote_order_ref')) {
            $('#quref').val(quote_reference_no);
        }
        $(document).on('change', '#slbiller', function (e) {
            __setItem('slbiller', $(this).val());
            billerChange();
        });
        if (slbiller = __getItem('slbiller')) {
            $('#slbiller').val(slbiller);
        }

		if (!__getItem('slrefnote')) {
            __setItem('slrefnote', '<?=$slnumber?>');
        }


        if (!__getItem('sltax2')) {
            __setItem('sltax2', <?=$Settings->default_tax_rate2;?>);
        }
        ItemnTotals();
        $('.bootbox').on('hidden.bs.modal', function (e) {
            $('#add_item').focus();
        });

        $('#payment_date').datetimepicker({
            format: site.dateFormats.js_ldate,
            fontAwesome: true,
            language: 'erp',
            todayBtn: 1,
            autoclose: 1,
            minView: 2
        }).datetimepicker('update', new Date());

        $("#add_item").autocomplete({
            source: function (request, response) {
                if (!$('#slcustomer').val()) {
                    $('#add_item').val('').removeClass('ui-autocomplete-loading');
                    bootbox.alert('<?=lang('select_above');?>');
                    $('#add_item').focus();
                    return false;
                }
				//var pid = '<?=$this->input->get('pid')?>';
                var test = request.term;
				if($.isNumeric(test)){
					$.ajax({
						type: 'get',
						url: '<?= site_url('sales/suggests'); ?>',
						dataType: "json",
						data: {
							term: request.term,
							warehouse_id: $("#slwarehouse").val(),
							customer_id: $("#slcustomer").val(),
                            category_id: $("#category").val()
						},
						success: function (data) {
							response(data);
						}
					});
				}else{
					$.ajax({
						type: 'get',
						url: '<?= site_url('sales/suggestionsSale'); ?>',
						dataType: "json",
						data: {
							term: request.term,
							warehouse_id: $("#slwarehouse").val(),
                            customer_id: $("#slcustomer").val(),
                            category_id: $("#category").val()
						},
						success: function (data) {
							response(data);
						}
					});
				}
            },
            minLength: 1,
            autoFocus: false,
            delay: 200,
            response: function (event, ui) {
                if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                    //audio_error.play();
                    bootbox.alert('<?= lang('no_match_found') ?>', function () {
                        $('#add_item').focus();
                    });
                    $(this).removeClass('ui-autocomplete-loading');
                    $(this).removeClass('ui-autocomplete-loading');
                    // $(this).val('');
                }
                else if (ui.content.length == 1 && ui.content[0].id != 0) {
                    ui.item = ui.content[0];
                    $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                    $(this).autocomplete('close');
                    $(this).removeClass('ui-autocomplete-loading');
                }
                else if (ui.content.length == 1 && ui.content[0].id == 0) {
                    //audio_error.play();
                    bootbox.alert('<?= lang('no_match_found') ?>', function () {
                        $('#add_item').focus();
                    });
                    $(this).removeClass('ui-autocomplete-loading');
                    // $(this).val('');
                }
            },
            select: function (event, ui) {
                event.preventDefault();

                if (ui.item.id !== 0) {
					var product_type = ui.item.row.type;
					if (product_type == 'digital') {
						$.ajax({
							type: 'get',
							url: '<?= site_url('sales/getDigitalPro'); ?>',
							dataType: "json",
							data: {
								id: ui.item.item_id
							},
							success: function (result) {
								$.each( result, function(key, value) {
									var row = add_invoice_item(value);
									if (row)
										$(this).val('');
								});
							}
						});
						$(this).val('');
					} else {
						var row = add_invoice_item(ui.item);
						if (row)
							$(this).val('');
					}

                } else {
                    //audio_error.play();
                    bootbox.alert('<?= lang('no_match_found') ?>');
                }
            }
        });

        $(document).on('change', '#gift_card_no', function () {
            var cn = $(this).val() ? $(this).val() : '';
            if (cn != '') {
                $.ajax({
                    type: "get", async: false,
                    url: site.base_url + "sales/validate_gift_card/" + cn,
                    dataType: "json",
                    success: function (data) {
                        if (data === false) {
                            $('#gift_card_no').parent('.form-group').addClass('has-error');
                            bootbox.alert('<?=lang('incorrect_gift_card')?>');
                        } else if (data.customer_id !== null && data.customer_id !== $('#slcustomer').val()) {
                            $('#gift_card_no').parent('.form-group').addClass('has-error');
                            bootbox.alert('<?=lang('gift_card_not_for_customer')?>');

                        } else {
                            $('#gc_details').html('<small>Card No: ' + data.card_no + '<br>Value: ' + data.value + ' - Balance: ' + data.balance + '</small>');
                            $('#gift_card_no').parent('.form-group').removeClass('has-error');
                        }
                    }
                });
            }
        });

		$('#add_item').bind('keypress', function (e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $(this).autocomplete("search");
            }
        });
    });


</script>

<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-plus"></i><?= lang('add_sale'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?php echo lang('enter_info'); ?></p>
                <?php
                $attrib = array('data-toggle' => 'validator', 'role' => 'form','id' => 'form');

                if (isset($quote_id)) {
                   echo form_open_multipart("sales/add/0/0/".$quote_id, $attrib);
                }else if(isset($sale_order_id)) {
					echo form_open_multipart("sales/add/".$sale_order_id, $attrib);
				}else{
					echo form_open_multipart("sales/add", $attrib);
				}
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <?php if ($Owner || $Admin || $Settings->allow_change_date == 1) { ?>
                            <div class="col-md-4">
                                <div class="form-group">
									<?= lang("date", "sldate"); ?>
									<div class="controls">
										 <?php echo form_input('date', (isset($_POST['date']) ? $_POST['date'] : ""), 'class="form-control input-tip datetime" id="sldate" required="required"'); ?>
									</div>
								</div>
                            </div>
                        <?php } ?>

						<div class="col-md-4">
							<?= lang("reference_no", "slref"); ?>
                            <div class="form-group">
                                <div class="input-group">
                                        <?php echo form_input('reference_no', $reference?$reference:"",'  class="form-control input-tip" id="slref"'); ?>
                                        <input type="hidden"  name="temp_reference_no"  id="temp_reference_no" value="<?= $reference?$reference:"" ?>" />
                                        <input type="hidden"  name="quote_id"  id="quote_id" value="" />
                                        <div class="input-group-addon no-print" style="padding: 2px 5px;background-color:white;">
                                            <input type="checkbox" name="ref_status" id="ref_st" value="1" style="margin-top:3px;">
                                        </div>
                                </div>
                            </div>
                        </div>

						<div class="col-md-4" id="so_ref" style="display:none;">
							<div class="form-group">
								<?= lang("so_no", "soref"); ?>
								<?php echo form_input('so_reference_no', (isset($refer)?$refer: $sale_order->reference_no), 'class="form-control input-tip" id="soref" readonly '); ?>
								<?php echo form_hidden('delivery_id_update',(isset($delivery_id)?$delivery_id:0) , 'class="form-control input-tip" id="delivery_id_update"'); ?>
								<?php echo form_hidden('so_id', (isset($sale_order->sale_id)?$sale_order->sale_id:0), 'class="form-control input-tip" id="so_id"'); ?>
								<?php echo form_hidden('d_type', $type, 'class="form-control input-tip" id="d_type"'); ?>
								<?php echo form_hidden('type_id', $type_id, 'class="form-control input-tip" id="type_id"'); ?>
							</div>
						</div>
						<div class="col-md-4" id="so_deposit" style="display:none;">
							<div class="form-group">
								<?= lang("so_no", "sono"); ?>
								<?php
								$so[""] = "";
								if ($so_nos != NULL) {
                                    foreach ($so_nos as $so_no) {
                                        $so[$so_no->id] = $so_no->reference_no;
                                    }
                                }
								echo form_dropdown('sono', $so, (isset($_POST['sono']) ? $_POST['sono'] : ''), 'id="sono" data-placeholder="' . lang("select") . ' ' . lang("so_no") . '" class="form-control input-tip select" style="width:100%;"');
								?>
							</div>
						</div>



						<div class="col-md-4" id="qu_ref" style="display:none;">
							<div class="form-group">
								<?= lang("quotation_no", "quref"); ?>
								<?php echo form_input('quote_reference_no','', 'class="form-control input-tip" id="quref" readonly '); ?>
							</div>
						</div>
                        <div class="clearfix"></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php
                                $default_biller = JSON_decode($this->session->userdata('biller_id'));
                                if ($Owner || $Admin || !$this->session->userdata('biller_id')) {
                                    echo get_dropdown_project('biller', 'slbiller');
                                } else {
                                    echo get_dropdown_project('biller', 'slbiller', $default_biller[0]);
                                }
                                ?>
                            </div>
                        </div>

                        <div class="clearfix"></div><br/>
                        <div class="col-md-12">
                            <div class="panel panel-warning">
                                <div
                                    class="panel-heading"><?= lang('please_select_these_before_adding_product') ?></div>
                                <div class="panel-body" style="padding: 5px;">
									<?php if($setting->credit_limit == 1) {?>
										<input type="hidden" id="credit_limit"/>
										<input type="hidden" id="cust_balance"/>
										<input type="hidden" id="hide_grand"/>
									<?php }?>
                                    <?php if ($Owner || $Admin || !$this->session->userdata('warehouse_id')) { ?>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?= lang("warehouse", "slwarehouse"); ?>
                                                <?php
                                                 $wh[''] = '';
                                                foreach ($warehouses as $warehouse) {
                                                    $wh[$warehouse->id] = $warehouse->name;
                                                }
                                                echo form_dropdown('warehouse', $wh, (isset($_POST['warehouse']) ? $_POST['warehouse'] : $Settings->default_warehouse), 'id="slwarehouse" class="form-control input-tip select" data-placeholder="' . lang("select") . ' ' . lang("warehouse") . '" required="required" style="width:100%;" ');
                                                ?>
                                            </div>
                                        </div>
                                    <?php } else if($this->session->userdata('warehouse_id')){ ?>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?= lang("warehouse", "slwarehouse"); ?>
                                                <?php
                                                 $wh[''] = '';
                                                foreach ($warehouses as $warehouse) {
                                                    $wh[$warehouse->id] = $warehouse->name;
                                                }
                                                echo form_dropdown('warehouse', '', (isset($_POST['warehouse']) ? $_POST['warehouse'] : $this->session->userdata('warehouse_id')), 'id="slwarehouse" class="form-control input-tip select" data-placeholder="' . lang("select") . ' ' . lang("warehouse") . '" required="required" style="width:100%;" ');
                                                ?>
                                            </div>
                                        </div>
                                    <?php } ?>

									<div class="col-md-4">
										<div class="form-group">
										<?= lang("saleman", "saleman"); ?>
										<select name="saleman" id="saleman" class="form-control saleman">
											<?php
												foreach($agencies as $agency){
													if($this->session->userdata('username') == $agency->username){
														echo '<option value="'.$this->session->userdata('user_id').'" selected>'.lang($this->session->userdata('username')).'</option>';
													}else{
														echo '<option value="'.$agency->id.'">'.$agency->username.'</option>';
													}
												}
											?>
										</select>
										<?php
										/*$sm[''] = '';
										foreach($agencies as $agency){
											$sm[$agency->id] = $agency->username;
										}
										echo form_dropdown('saleman', $sm, (isset($_POST['saleman']) ? $_POST['saleman'] : ''), 'id="slsaleman" class="form-control input-tip select" data-placeholder="' . lang("select") . ' ' . lang("saleman") . '" style="width:100%;" ');*/
										?>
										</div>
                                    </div>
									<div class="col-md-4">
										<div class="form-group">
											<?= lang("group_area", "group_area"); ?>
											<?php
											 $ar[''] = '';
											foreach ($areas as $area) {
												$ar[$area->areas_g_code] = $area->areas_group;
											}
											echo form_dropdown('area',$ar, (isset($_POST['area']) ? $_POST['area'] : ''), 'id="slarea" class="form-control input-tip select" data-placeholder="' . lang("select") . ' ' . lang("group_area") . '" required="required" style="width:100%;" ');
											?>
										</div>
                                    </div>

									<?php if($setting->bill_to == 1) { ?>
									<div class="col-md-4">
										<div class="form-group">
											<?= lang("bill_to", "bill_to"); ?>
											<?php echo form_input('bill_to', '', 'class="form-control input-tip" id="bill_to"'); ?>
										</div>
									</div>
									<?php } ?>

									<?php if($setting->show_po) { ?>
									<div class="col-md-4">
										<div class="form-group">
											<?= lang("po", "po"); ?>
											<?php echo form_input('po', '', 'class="form-control input-tip" id="po"'); ?>
										</div>
									</div>
									<?php } ?>

									<div class="col-md-4">
                                        <div class="form-group">
                                            <?= lang("customer", "slcustomer"); ?>
                                            <?php if ($Owner || $Admin || $GP['customers-add']) { ?><div class="input-group"><?php } ?>
                                                <?php
                                                echo form_input('customer_1', (isset($_POST['customer']) ? $_POST['customer'] : (isset($sale_order->company_name)?$sale_order->company_name:$this->input->get('customer'))), 'id="slcustomer" data-placeholder="' . lang("select") . ' ' . lang("customer") . '" required="required" class="form-control input-tip" style="min-width:100%;"');
                                                ?>
                                                <?php if ($Owner || $Admin || $GP['customers-add']) { ?>

												<div class="input-group-addon no-print" style="padding: 2px 5px; border-left: 0;">
													<a href="#" id="view-customer" class="external" data-toggle="modal" data-target="#myModal">
														<i class="fa fa-2x fa-user" id="addIcon"></i>
													</a>
												</div>

                                                <div class="input-group-addon no-print" style="padding: 2px 5px;"><a
                                                        href="<?= site_url('customers/add/sale'); ?>" id="add-customer"
                                                        class="external" data-toggle="modal" data-target="#myModal"><i
                                                            class="fa fa-2x fa-plus-circle" id="addIcon"></i></a></div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?= lang("category_name", "category_name"); ?>
                                            <?php
                                            $cate[''] = lang('all');
                                            foreach ($categories as $category) {
                                                $cate[$category->id] = $category->name;
                                            }
                                            echo form_dropdown('category', $cate, (isset($_POST['category']) ? $_POST['category'] : ''), 'id="category" class="form-control input-tip select" data-placeholder="' . lang("select") . ' ' . lang("category") . '" style="width:100%;" ');
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12" id="sticker">
                            <div class="well well-sm">
                                <div class="form-group" style="margin-bottom:0;">
                                    <div class="input-group wide-tip">
                                        <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                                            <i class="fa fa-2x fa-barcode addIcon"></i></div>
                                        <?php

										if($this->input->get('addsales')){

											$q = $this->db->get_where('erp_products',array('id'=>$this->input->get('addsales')),1);
											$pcode = $q->row()->code;

										}
										echo form_input('add_item',(isset($pcode)?$pcode:''), 'class="form-control input-lg" id="add_item" placeholder="' . lang("add_product_to_order") . '"'); ?>
                                        <?php if ($Owner || $Admin || $GP['products-add']) { ?>
                                        <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                                            <a href="#" id="addManually" class="tip" title="<?= lang('add_product_manually') ?>">
                                                <i class="fa fa-2x fa-plus-circle addIcon" id="addIcon"></i>
                                            </a>
											<a href="<?= site_url('sales/add');?>" class="gos" ></a>
                                        </div>
                                        <?php } if ($Owner || $Admin || $GP['sales-add_gift_card']) { ?>
                                        <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                                            <a href="#" id="sellGiftCard" class="tip" title="<?= lang('sell_gift_card') ?>">
                                               <i class="fa fa-2x fa-credit-card addIcon" id="addIcon"></i>
                                            </a>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="control-group table-group">
                                <label class="table-label"><?= lang("order_items"); ?> *</label>

                                <div class="controls table-controls table-responsive">
                                    <table id="slTable"
                                           class="table items table-striped table-bordered table-condensed table-hover">
                                        <thead>
                                        <tr>
											<th class=""><?= lang("no"); ?></th>
											<?php if($setting->show_code == 1 && $setting->separate_code == 1) { ?>
												<th class="col-md-2"><?= lang("product_code"); ?></th>
												<th class="col-md-4"><?= lang("product_name"); ?></th>
											<?php } ?>
                                            <?php if($setting->show_code == 1 && $setting->separate_code == 0) { ?>
												<th class="col-md-4"><?= lang("product_name") . " (" . lang("product_code") . ")"; ?></th>
											<?php } ?>
											<?php if($setting->show_code == 0) { ?>
												<th class="col-md-4"><?= lang("product_name"); ?></th>
											<?php } ?>
                                            <?php
                                            if ($Settings->product_serial) {
                                                echo '<th class="col-md-2">' . lang("serial_no") . '</th>';
                                            }
                                            ?>
                                            <?php if ($Owner || $Admin || $GP['sales-price']) { ?>
                                                <th class="col-md-1"><?= lang("unit_price"); ?></th>
                                            <?php } ?>
                                            <th class="col-md-1"><?= lang("quantity"); ?></th>

                                            <th class="col-md-1"><?= lang("qoh"); ?></th>
                                            <?php
                                            if ($Settings->product_discount || ($Owner || $Admin || $this->session->userdata('allow_discount'))) {
                                                echo '<th class="col-md-1">' . lang("discount") . '</th>';
                                            }
                                            ?>
                                            <?php
                                            if ($Settings->tax1) {
                                                echo '<th class="col-md-1">' . lang("product_tax") . '</th>';
                                            }
                                            ?>
                                            <th>
                                                <?= lang("subtotal"); ?>
                                                (<span class="currency"><?= $default_currency->code ?></span>)
                                            </th>
                                            <th style="width: 30px !important; text-align: center;">
                                                <i class="fa fa-trash-o" style="opacity:0.5; filter:alpha(opacity=50);"></i>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot></tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

						<div class="col-sm-12">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= lang("order_discount", "sldiscount"); ?>
                                    <?php echo form_input('order_discount', '', 'class="form-control input-tip" id="sldiscount"'); ?>
                                </div>
                            </div>

							<div class="col-sm-4">
								<div class="form-group">
									<?= lang("shipping", "slshipping"); ?>
									<?php echo form_input('shipping', '', 'class="form-control input-tip" id="slshipping"'); ?>

								</div>
							</div>

							<?php if ($Settings->tax2) { ?>
								<div class="col-sm-4">
									<div class="form-group">
										<?= lang("order_tax", "sltax2"); ?>
										<?php
										$tr[""] = "";
										foreach ($tax_rates as $tax) {
											$tr[$tax->id] = $tax->name;
										}
										echo form_dropdown('order_tax', $tr, (isset($_POST['order_tax']) ? $_POST['order_tax'] : $Settings->default_tax_rate2), 'id="sltax2" data-placeholder="' . lang("select") . ' ' . lang("order_tax") . '" class="form-control input-tip select" style="width:100%;"');
										?>
									</div>
								</div>
							<?php } ?>

						</div>
						<div class="col-sm-12">

							<div class="col-sm-4">
								<div class="form-group">
									<?= lang("delivery_by", "delivery_by"); ?>
									<?php
										$driver[''] = '';
										foreach($drivers as $dr) {
											$driver[$dr->id] = $dr->name;
										}
										echo form_dropdown('delivery_by', $driver, '', 'class="form-control input-tip" id="delivery_by"');
									?>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<?= lang("payment_term", "slpayment_term"); ?>
									<?php
										$ptr[""] = "";
										foreach ($payment_term as $term) {
											$ptr[$term->id] = $term->description;
										}
										echo form_dropdown('payment_term', $ptr,isset($sale_order->payment_term)?$sale_order->payment_term:"", 'id="slpayment_term" data-placeholder="' . lang("payment_term_tip") .  '" class="form-control input-tip select" style="width:100%;"');
										//echo form_input('payment_term',$ptr,'11', 'class="form-control tip" data-trigger="focus" data-placement="top" title="' . lang('payment_term_tip') . '" id="slpayment_term"'); ?>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<?= lang("document", "document") ?>
									<input id="document" type="file" name="document" data-show-upload="false" data-show-preview="false" class="form-control file">
									<input type="hidden" value="<?=(isset($sale_order->attachment)?$sale_order->attachment:"")?>" name="attachment">
									<?php if(!empty($sale_order->attachment)){?>
									<a target="_blank" href="<?php echo $this->config->base_url()?>files/<?=$sale_order->attachment?>"
										class="btn btn-primary pull-left"><i class="fa fa-download"></i> Download  File</a>
									<?php } ?>
								</div>
							</div>
							<?php
								if(isset($delivery_id)){
									echo '<input type="hidden" name="sale_status" id="slsale_status" value="pending" required="required" />';
								}else{
									echo '<input type="hidden" name="sale_status" id="slsale_status" value="completed" required="required" />';
								}
							?>
						</div>
						<div class="clearfix"></div>
                        <div id="payments" style="display: none;">
                            <div class="col-md-12">
                                <div class="well well-sm well_1">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4" id="pay_ref" style="display:none">
                                                <div class="form-group">
                                                    <?= lang("payment_reference_no", "payment_reference_no"); ?>
                                                    <?= form_input('payment_reference_no', (isset($_POST['payment_reference_no']) ? $_POST['payment_reference_no'] : $payment_ref), 'class="form-control tip" id="payment_reference_no" required="required"'); ?>
													<input type="hidden" name="type" value="sdfsdf">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="payment">
                                                    <div class="form-group ngc">
                                                        <?= lang("amount", "amount_1"); ?>
                                                        <input name="amount-paid" value="" type="text" id="amount_1" class="pa form-control kb-pad amount" readonly />
                                                    </div>
                                                    <div class="form-group gc" style="display: none;">
                                                        <?= lang("gift_card_no", "gift_card_no"); ?>
                                                        <input name="gift_card_no" type="text" id="gift_card_no"
                                                               class="pa form-control kb-pad"/>
                                                        <div id="gc_details"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4" style="display:none">
                                                <div class="form-group">
                                                    <?= lang("paying_by", "paid_by_1"); ?>
                                                    <select name="paid_by" id="paid_by_1" class="form-control paid_by">
														<option value="cash"><?= lang("cash"); ?></option>
														<option value="western union"><?= lang("Western_Union"); ?></option>
														<option value="bank transfer"><?= lang("Bank_Transfer"); ?></option>
														<option value="cheque"><?= lang("cheque"); ?></option>
														<option value="other"><?= lang("other"); ?></option>
														<option value="deposit"><?= lang("deposit"); ?></option>
														<option value="depreciation"><?= lang("loan"); ?></option>
														 <option value="gift_card"><?= lang("gift_card"); ?></option>
                                                    </select>
                                                </div>
                                            </div>
											<!--
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <?= lang("payment_date", "payment_date"); ?>
                                                    <?php echo form_input('payment_date', (isset($_POST['payment_date']) ? $_POST['payment_date'] : ""), 'class="form-control input-tip datetime" id="payment_date" required="required"'); ?>
                                                </div>
                                            </div>
											-->
                                        </div>
										<div class="row" style="display:none">
											<div class="col-sm-4" id="bank_acc">
												<div class="form-group">
													<?= lang("bank_account", "bank_account_1"); ?>
													<?php $bank = array('' => '');
													foreach($bankAccounts as $bankAcc) {
														$bank[$bankAcc->accountcode] = $bankAcc->accountcode . ' | '. $bankAcc->accountname;
													}
													echo form_dropdown('bank_account', $bank, '', 'id="bank_account_1" class="ba form-control kb-pad bank_account" required="required"');
													?>
												</div>
											</div>
										</div>
                                        <div class="clearfix"></div>
                                        <div class="pcc_1" style="display:none;">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input name="pcc_no" type="text" id="pcc_no_1"
                                                               class="form-control" placeholder="<?= lang('cc_no') ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input name="pcc_holder" type="text" id="pcc_holder_1"
                                                               class="form-control"
                                                               placeholder="<?= lang('cc_holder') ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <select name="pcc_type" id="pcc_type_1"
                                                                class="form-control pcc_type"
                                                                placeholder="<?= lang('card_type') ?>">
                                                            <option value="Visa"><?= lang("Visa"); ?></option>
                                                            <option
                                                                value="MasterCard"><?= lang("MasterCard"); ?></option>
                                                            <option value="Amex"><?= lang("Amex"); ?></option>
                                                            <option value="Discover"><?= lang("Discover"); ?></option>
                                                        </select>
                                                        <!-- <input type="text" id="pcc_type_1" class="form-control" placeholder="<?= lang('card_type') ?>" />-->
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input name="pcc_month" type="text" id="pcc_month_1"
                                                               class="form-control" placeholder="<?= lang('month') ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">

                                                        <input name="pcc_year" type="text" id="pcc_year_1"
                                                               class="form-control" placeholder="<?= lang('year') ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">

                                                        <input name="pcc_ccv" type="text" id="pcc_cvv2_1"
                                                               class="form-control" placeholder="<?= lang('cvv2') ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

										<div class="form-group dp" style="display: block;">
											<!--
											<?= lang("customer", "customer1"); ?>
													<?php
													$customers1[] = array();
													foreach($customers as $customer){
														$customers1[$customer->id] = $customer->name;
													}
												echo form_dropdown('customer', $customers1, '' , 'class="form-control" id="customer1"');
											?>
											-->
											<?= lang("deposit_amount", "deposit_amount"); ?>

											<div id="dp_details"></div>
										</div>

										<!-- loan add by chin -->
										<div class="depreciation_1" style="display:none;">
											<div class="form-group">
												<?= lang("depre_term", "depreciation_1"); ?>
											</div>
											<div class="row">
												<div class="col-md-3">
													<div class="form-group">
														<input name="depreciation_rate1" type="text" id="depreciation_rate_1"
															   class="form-control depreciation_rate1"
															   placeholder="<?= lang('rate (%)') ?>"/>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">

														<input name="depreciation_term" type="text" id="depreciation_term_1"
															   class="form-control kb-pad" value=""
															   placeholder="<?= lang('term (month)') ?>"/>
														<input type="hidden" id="current_date" class="current_date" class="current_date[]" value="<?php echo date('m/d/Y'); ?>" />
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<select name="depreciation_type" id="depreciation_type_1"
																class="form-control depreciation_type"
																placeholder="<?= lang('payment type') ?>">
															<option value=""> &nbsp; </option>
															<option value="1"><?= lang("Normal"); ?></option>
															<option value="2"><?= lang("Custom"); ?></option>
															<option value="3"><?= lang("Fixed"); ?></option>
															<option value="4"><?= lang("Normal(Fixed)"); ?></option>
														</select>
														<!-- <input type="text" id="pcc_type_1" class="form-control" placeholder="<?= lang('card_type') ?>" />-->
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group" id="print_" style="display:none">
														<button type="button" class="btn btn-primary col-md-12 print_depre" id="print_depre" style="margin-bottom:5px;"><i class="fa fa-print"> &nbsp; </i>
															<?= lang('Print') ?>
														</button>
														<button type="button" class="btn btn-primary col-md-12 export_depre" id="export_depre" style="margin-bottom:5px;"><i class="fa fa-file-excel-o"> &nbsp; </i>
																<?= lang('export') ?>
															</button>
														<div style="clear:both; height:15px;"></div>
													</div>
												 </div>
											</div>
											<div class="form-group">

												<div class="dep_tbl" style="display:none;">
													<table border="1" width="100%" class="table table-bordered table-condensed tbl_dep" id="tbl_dep">
														<tbody>

														</tbody>
													</table>
													<table id="export_tbl" width="70%" style="display:none;">

													</table>
												</div>
											</div>
										</div>
										<!-- end loan -->

                                        <div class="pcheque_1" style="display:none;">
                                            <div class="form-group"><?= lang("cheque_no", "cheque_no_1"); ?>
                                                <input name="cheque_no" type="text" id="cheque_no_1"
                                                       class="form-control cheque_no"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?= lang('payment_note', 'payment_note_1'); ?>
                                            <textarea name="payment_note" id="payment_note_1"
                                                      class="pa form-control kb-text payment_note"></textarea>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="total_items" value="" id="total_items" required="required"/>
						<input type="hidden" id="exchange_rate" value="<?= isset($exchange_rate->rate) ?>">

                        <div class="row" id="bt">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?= lang("sale_note", "slnote"); ?><span id="slnote_span"></span>
                                        <div id="note">
                                        <?php if ($this->session->userdata('group_id') == 11) { ?>
                                        	<?php echo form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : ""), 'class="form-control" id="slnote" style="margin-top: 10px; height: 100px;" required="required"'); ?>
                                        <?php } else { ?>
											<?php echo form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : ""), 'class="form-control" id="slnote" style="margin-top: 10px; height: 100px;"'); ?>
                                        <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="general_saleman" value="<?= $this->session->userdata('group_id') ?>">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?= lang("staff_note", "slinnote"); ?>
                                        <?php echo form_textarea('staff_note', (isset($_POST['staff_note']) ? $_POST['staff_note'] : ""), 'class="form-control" id="slinnote" style="margin-top: 10px; height: 100px;"'); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="fprom-group">
								<?php echo form_submit('add_sale', lang("submit"), 'id="add_sale" class="btn btn-primary" style="padding: 6px 15px; margin:15px 0; display:none;"'); ?>
                                <button type="button" class="btn btn-primary" id="before_sub"><?= lang('submit') ?></button>
                                <button type="button" class="btn btn-danger" id="reset"><?= lang('reset') ?></button>
							</div>
                        </div>
                    </div>
                </div>
                <div id="bottom-total" class="well well-sm" style="margin-bottom: 0;">
                    <table class="table table-bordered table-condensed totals" style="margin-bottom:25px;">
                        <tr class="warning">
                            <td><?= lang('items') ?> <span class="totals_val pull-right" id="titems">0</span></td>
                            <td><?= lang('total') ?> <span class="totals_val pull-right" id="total">0.00</span></td>
                            <?php if ($Owner || $Admin || $this->session->userdata('allow_discount')) { ?>
                            <td><?= lang('order_discount') ?> <span class="totals_val pull-right" id="tds">0.00</span></td>
                            <?php }?>
                            <td><?= lang('shipping') ?> <span class="totals_val pull-right" id="tship">0.00</span></td>
                            <?php if ($Settings->tax2) { ?>
                                <td><?= lang('order_tax') ?> <span class="totals_val pull-right" id="ttax2">0.00</span></td>
                            <?php } ?>
                            <td><?= lang('grand_total') ?> <span class="totals_val pull-right" id="gtotal">0.00</span></td>
                        </tr>
                    </table>
                </div>

                <?php echo form_close(); ?>

            </div>

        </div>
    </div>
</div>

<div class="modal" id="prModal" tabindex="-1" role="dialog" aria-labelledby="prModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i
                            class="fa fa-2x">&times;</i></span><span class="sr-only"><?=lang('close');?></span></button>
                <h4 class="modal-title" id="prModalLabel"></h4>
            </div>
            <div class="modal-body" id="pr_popover_content">
                <form class="form-horizontal" role="form">
                    <?php if ($Settings->tax1) { ?>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?= lang('product_tax') ?></label>
                            <div class="col-sm-8">
                                <?php
                                $tr[""] = "";
                                foreach ($tax_rates as $tax) {
                                    $tr[$tax->id] = $tax->name;
                                }
                                echo form_dropdown('ptax', $tr, "", 'id="ptax" class="form-control pos-input-tip" style="width:100%;"');
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($Settings->product_serial) { ?>
                        <div class="form-group">
                            <label for="pserial" class="col-sm-4 control-label"><?= lang('serial_no') ?></label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="pserial">
                            </div>
                        </div>
                    <?php } ?>
                    <!--<div class="form-group" id="dvpiece">
                        <label for="piece" id="lbpiece" class="col-sm-4 control-label"><? /*= lang('piece') */ ?></label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="piece">
                        </div>
                    </div>
					<div class="form-group" id="dvwpiece" >
                        <label for="wpiece" class="col-sm-4 control-label"><? /*= lang('wpiece') */ ?></label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="wpiece">
                        </div>
                    </div>-->
                    <div class="form-group">
                        <label for="pquantity" class="col-sm-4 control-label"><?= lang('quantity') ?></label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="pquantity">
							<input type="hidden" class="form-control" id="request_quantity">
							<input type="hidden" class="form-control" id="cur_stock_qty">
                        </div>
                    </div>
					<div class="form-group">
                        <label for="expdates" class="col-sm-4 control-label"><?= lang('expdates') ?></label>

                        <div class="col-sm-8">
                            <div id="expdates-div"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="poption" class="col-sm-4 control-label"><?= lang('product_option') ?></label>

                        <div class="col-sm-8">
                            <div id="poptions-div"></div>
                        </div>
                    </div>
					<div class="form-group">
                        <label for="pgroup_prices" class="col-sm-4 control-label"><?= lang('group_price') ?></label>

                        <div class="col-sm-8">
                            <div id="pgroup_prices-div"></div>
                        </div>
                    </div>
					<?php if ($Settings->product_discount || ($Owner || $Admin || $this->session->userdata('allow_discount'))) { ?>
                        <div class="form-group">
                            <label for="pdiscount"
                                   class="col-sm-4 control-label"><?= lang('product_discount') ?></label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="pdiscount">
                            </div>
                        </div>
                    <?php } ?>
					<?php if ($Owner || $Admin || $GP['sales-price']) { ?>
                    <div class="form-group">
                        <label for="pprice" class="col-sm-4 control-label"><?= lang('unit_price') ?></label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="pprice">
							<input type="hidden" class="form-control" id="own_rate">
							<input type="hidden" class="form-control" id="setting_rate">
                        </div>
                    </div>
					<?php } ?>
					<div class="form-group">
                        <label for="pnote" class="col-sm-4 control-label"><?= lang('product_note') ?></label>

                        <div class="col-sm-8">
                            <input type="hidden" class="form-control"  id="pprice">
                            <input type="text" class="form-control kb-pad" id="pnote">
                        </div>
                    </div>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th style="width:25%;"><?= lang('net_unit_price'); ?></th>
                            <th style="width:25%;"><span id="net_price"></span></th>
                            <th style="width:25%;"><?= lang('product_tax'); ?></th>
                            <th style="width:25%;"><span id="pro_tax"></span></th>
                        </tr>
                    </table>
                    <input type="hidden" id="punit_price" value=""/>
                    <input type="hidden" id="old_tax" value=""/>
                    <input type="hidden" id="old_qty" value=""/>
                    <input type="hidden" id="old_price" value=""/>
                    <input type="hidden" id="row_id" value=""/>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="editItem"><?= lang('submit') ?></button>
            </div>
        </div>
    </div>
</div>

<!-- Add Product Manually -->
<div class="modal fade in" id="mModal" tabindex="-1" role="dialog" aria-labelledby="mModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i
                            class="fa fa-2x">&times;</i></span><span class="sr-only"><?=lang('close');?></span></button>
                <h4 class="modal-title" id="mModalLabel"><?= lang('add_product_manually') ?></h4>
            </div>
            <div class="modal-body" id="pr_popover_content">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="mcode" class="col-sm-4 control-label"><?= lang('product_code') ?> *</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control kb-text" id="mcode">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mname" class="col-sm-4 control-label"><?= lang('product_name') ?> *</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control kb-text" id="mname">
                        </div>
                    </div>
                    <?php if ($Settings->tax1) { ?>
                        <div class="form-group">
                            <label for="mtax" class="col-sm-4 control-label"><?= lang('product_tax') ?> *</label>

                            <div class="col-sm-8">
                                <?php
                                $tr[""] = "";
                                foreach ($tax_rates as $tax) {
                                    $tr[$tax->id] = $tax->name;
                                }
                                echo form_dropdown('mtax', $tr, "", 'id="mtax" class="form-control pos-input-tip" style="width:100%;"');
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="mquantity" class="col-sm-4 control-label"><?= lang('quantity') ?> *</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control kb-pad" id="mquantity">
                        </div>
                    </div>
                    <?php if ($Settings->product_discount) { ?>
                        <div class="form-group">
                            <label for="mdiscount"
                                   class="col-sm-4 control-label"><?= lang('product_discount') ?></label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control kb-pad" id="mdiscount">
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="mprice" class="col-sm-4 control-label"><?= lang('unit_price') ?> *</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control kb-pad" id="mprice">
                        </div>
                    </div>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th style="width:25%;"><?= lang('net_unit_price'); ?></th>
                            <th style="width:25%;"><span id="mnet_price"></span></th>
                            <th style="width:25%;"><?= lang('product_tax'); ?></th>
                            <th style="width:25%;"><span id="mpro_tax"></span></th>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="addItemManually"><?= lang('submit') ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="gcModal" tabindex="-1" role="dialog" aria-labelledby="mModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                        class="fa fa-2x">&times;</i></button>
                <h4 class="modal-title" id="myModalLabel"><?= lang('sell_gift_card'); ?></h4>
            </div>
            <div class="modal-body">
                <p><?= lang('enter_info'); ?></p>

                <div class="alert alert-danger gcerror-con" style="display: none;">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <span id="gcerror"></span>
                </div>
                <div class="form-group">
                    <?= lang("card_no", "gccard_no"); ?> *
                    <div class="input-group">
                        <?php echo form_input('gccard_no', '', 'class="form-control" id="gccard_no"'); ?>
                        <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;"><a href="#"
                                                                                                           id="genNo"><i
                                    class="fa fa-cogs"></i></a></div>
                    </div>
                </div>
                <input type="hidden" name="gcname" value="<?= lang('gift_card') ?>" id="gcname"/>

                <div class="form-group">
                    <?= lang("value", "gcvalue"); ?> *
                    <?php echo form_input('gcvalue', '', 'class="form-control" id="gcvalue"'); ?>
                </div>
                <div class="form-group">
                    <?= lang("price", "gcprice"); ?> *
                    <?php echo form_input('gcprice', '', 'class="form-control" id="gcprice"'); ?>
                </div>
                <div class="form-group">
                    <?= lang("customer", "gccustomer"); ?>
                    <?php echo form_input('gccustomer', '', 'class="form-control" id="gccustomer"'); ?>
                </div>
                <div class="form-group">
                    <?= lang("expiry_date", "gcexpiry"); ?>
                    <?php echo form_input('gcexpiry', $this->erp->hrsd(date("Y-m-d", strtotime("+2 year"))), 'class="form-control date" id="gcexpiry"'); ?>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="addGiftCard" class="btn btn-primary"><?= lang('sell_gift_card') ?></button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	var $biller = $("#slbiller");
		$(window).load(function(){
		$('#paid_by_1').select2().trigger("change");
		$('#slpayment_status').trigger('change');
		$('#amount_1').trigger('change');
		billerChange();

		});

	$("#slref").attr('readonly','readonly');
	$('#ref_st').on('ifChanged', function() {
	  if ($(this).is(':checked')) {
		$("#slref").prop('readonly', false);
		$("#slref").val("");
	  }else{
		$("#slref").prop('readonly', true);
		var temp = $("#temp_reference_no").val();
		$("#slref").val(temp);

	  }
	});


    $(document).ready(function () {
		 $("#subcategory").select2("destroy").empty().attr("placeholder", "<?= lang('select_category_to_load') ?>").select2({
            placeholder: "<?= lang('select_category_to_load') ?>", data: [
                {id: '', text: '<?= lang('select_category_to_load') ?>'}
            ]
        });
		$('#category').change(function () {
            var v = $(this).val();
            $('#modal-loading').show();
            if (v) {
                $.ajax({
                    type: "get",
                    async: false,
                    url: "<?= site_url('products/getSubCategories') ?>/" + v,
                    dataType: "json",
                    success: function (scdata) {
                        if (scdata != null) {
                            $("#subcategory").select2("destroy").empty().attr("placeholder", "<?= lang('select_subcategory') ?>").select2({
                                placeholder: "<?= lang('select_category_to_load') ?>",
                                data: scdata
                            });
                        }else{
							$("#subcategory").select2("destroy").empty().attr("placeholder", "<?= lang('select_subcategory') ?>").select2({
                                placeholder: "<?= lang('select_category_to_load') ?>",
                                data: 'not found'
                            });
						}
                    },
                    error: function () {
                        bootbox.alert('<?= lang('ajax_error') ?>');
                        $('#modal-loading').hide();
                    }
                });
            } else {
                $("#subcategory").select2("destroy").empty().attr("placeholder", "<?= lang('select_category_to_load') ?>").select2({
                    placeholder: "<?= lang('select_category_to_load') ?>",
                    data: [{id: '', text: '<?= lang('select_category_to_load') ?>'}]
                });
            }
            $('#modal-loading').hide();
        });

        $('#gccustomer').select2({
            minimumInputLength: 1,
            ajax: {
                url: site.base_url + "customers/suggestions",
                dataType: 'json',
                quietMillis: 15,
                data: function (term, page) {
                    return {
                        term: term,
                        limit: 10
                    };
                },
                results: function (data, page) {
                    if (data.results != null) {
                        return {results: data.results};
                    } else {
                        return {results: [{id: '', text: 'No Match Found'}]};
                    }
                }
            }
        });
        $('#genNo').click(function () {
            var no = generateCardNo();
            $(this).parent().parent('.input-group').children('input').val(no);
            return false;
        });

		$('#view-customer').click(function(){
            $('#myModal').modal({remote: site.base_url + 'customers/view/' + $("input[name=customer_1]").val()});
            $('#myModal').modal('show');
        });

		$('#before_sub').click(function (e) {
            e.preventDefault();
            var message = '';
            var help = false;
            $('.qty_rec').each(function () {
                var tr = $(this).closest('tr');
                var order_qty = tr.find('.psoqty').val() - 0;
                var received_qty = $(this).val() - 0;
                var oh_qty = tr.find('.qty_oh').val() - 0;
                var qty_balance = oh_qty - (received_qty + order_qty);
                if (qty_balance < 0) {
                    var product_name = $(this).parent().parent().closest('tr').find('.rname').val();
                    if (order_qty > 0) {
                        message += '- ' + product_name + ' : Sale = ' + formatDecimal(received_qty) + ', Ordered = ' + formatDecimal(order_qty) + ', QOH = ' + formatDecimal(oh_qty) + ' !\n';
                        help = true;
                    } else {
                        message += '- ' + product_name + ' : Sale = ' + formatDecimal(received_qty) + ', QOH = ' + formatDecimal(oh_qty) + ' !\n';
                        help = true;
                    }
                }
            });
            if (help) {
                message += "\n Do you want to continue your sale order? \n";
                message += "Press \"OK\" is continue and \"Cancel\" is recheck!!!";
                var result = confirm(message);
                if (result) {
                    //return false;
                } else {
                    return false;
                }
            }

            <?php if($setting->credit_limit == 1) {?>
            var payment_status = $("#slpayment_status").val();
            if (payment_status == 'due' || payment_status == 'partial') {
                var customer_id = $('#slcustomer').val();
                var c_balance = __getItem('cust_balance');
                var c_limit = __getItem('credit_limit');
                var cust_balance = $('#total_balance').val() - 0;
                cust_balance += parseFloat(c_balance);
                if (c_limit >= 0 && c_limit < cust_balance) {
                    if (confirm("This customer has over credit limit (" + (cust_balance - c_limit) + "$)!\n Your Balance is " + cust_balance + "$\n Your Credit Balance is " + parseFloat(c_limit) + "$\n Click (OK) if you want to continue  Or Click (Cancel) if you want to Cancel Adding.") == true) {

                    } else {

                        return false;
                    }

                }
            }
			<?php } ?>
			var GP = '<?= $GP['sales-discount'];?>';
            var Owner = '<?= $Owner?>';
            var Admin = '<?= $Admin?>';
            var user_log = '<?= $this->session->userdata('user_id');?>';
            if(Owner || Admin || (GP == 1)){
                $('#add_sale').trigger('click');
            }else{
                var val = '';
                $('.sdiscount').each(function(){
                    var parent = $(this).parent().parent();
                    var value  = parent.find('.sdiscount').text();
                    if(value != 0){
                        val = value;
                    }
                });
                if(val == ''){
                    $('#add_sale').trigger('click');
                }else{
                    bootbox.prompt("Please insert password", function(result){
                        $.ajax({
                            type: 'get',
                            url: '<?= site_url('auth/checkPassDiscount'); ?>',
                            dataType: "json",
                            data: {
                                password: result
                            },
                            success: function (data) {
                                if(data == 1){
                                    $('#add_sale').trigger('click');
                                }else{
                                    alert('Incorrect passord');
                                }
                            }
                        });
                    });
                }
            }

        });

    });

    var $biller = $("#slbiller");
    $(window).load(function(){
        //billerChange();
    });

	function billerChange(){
        var id = $biller.val();
        var admin = '<?= $Admin?>';
        var owner = '<?= $Owner?>';
        $("#slwarehouse").empty();

            $.ajax({
            url: '<?= base_url() ?>auth/getWarehouseByProject/'+id,
            dataType: 'json',
            success: function(result){
                var the_same_ware = false;
                var default_ware  = "<?=$Settings->default_warehouse;?>";
                $.each(result, function(i,val){
                    var b_id = val.id;
                    var code = val.code;
                    var name = val.name;
                    var opt = '<option value="' + b_id + '">' +code+'-'+ name + '</option>';
                    $("#slwarehouse").append(opt);
                    if (default_ware == b_id) {
                        the_same_ware = true;
                    }
                });

                if (slwarehouse = __getItem('slwarehouse')) {
                    $('#slwarehouse').select2("val", slwarehouse);
                } else {
                    if (owner || admin) {
                        if (the_same_ware == true) {
                            $("#slwarehouse").select2("val", "<?=$Settings->default_warehouse;?>");
                        } else {
                            var opt_first = $('#slwarehouse option:first-child').val();
                            $("#slwarehouse").select2("val", opt_first);
                        }
                    } else {
                        var opt_first = $('#slwarehouse option:first-child').val();
                        $("#slwarehouse").select2("val", opt_first);
                    }
                }
            }
        });

		$.ajax({
            url: '<?= base_url() ?>sales/getReferenceByProject/so/'+id,
            dataType: 'json',
            success: function(data){
                $("#slref").val(data);
				$("#temp_reference_no").val(data);
            }
        });

    }

    var $warehouse = $('#slwarehouse');
		$warehouse.change(function (e) {
			__setItem('slwarehouse', $(this).val());
    });


		$('#print_depre').click(function () {
			PopupPayments();
		});

		$('#export_depre').click(function () {
			var customer_id = $('#slcustomer').val();
			var customer_name = '';
			var customer_address = '';
			var customer_tel ='';
			var customer_mail = '';

			$.ajax({
				type: "get",
				url: "<?= site_url('sales/getCustomerInfo'); ?>",
				data: {customer_id: customer_id},
				dataType: "html",
				async: false,
				success: function (data) {
					var obj = jQuery.parseJSON(data);
					customer_name = obj.company;
					customer_address = obj.address+', '+obj.city+', '+obj.state;
					customer_tel = obj.phone;
					customer_mail = obj.email;
				}
			});
			var issued_date = $('.current_date').val();
			var myexport = '<tbody>';
				myexport+= 		'<tr><td colspan="7" style="vertical-align:middle;"><center><h4 style="font-family:Verdana,Geneva,sans-serif; font-weight:bold;"><?= lang("loan_amortization_schedule") ?></h4></center></td></tr>';
				myexport+=		'<tr>';
				myexport+=			'<td colspan="2" width="25%"  style="padding-left:50px;"><?= lang('issued_date') ?></td>';
				myexport+=			'<td colspan="2" width="25%"><?= lang(": ") ?>'+ issued_date +'</td>';
				myexport+=			'<td colspan="3" width="50%">&nbsp;</td>';
				myexport+=		'</tr>';
				myexport+=		'<tr>';
				myexport+=			'<td colspan="2" style="padding-left:50px;"><?= lang('customer') ?></td>';
				myexport+=			'<td colspan="2"><?= lang(": ") ?>'+ customer_name +'</td>';
				myexport+=			'<td style="text-align:right; padding-right:30px;"><?= lang('address') ?></td>';
				myexport+=			'<td colspan="2"><?= lang(": ") ?>'+ customer_address +'</td>';
				myexport+=		'</tr>'+
								'<tr>'+
									'<td colspan="2" style="padding-left:50px;"><?= lang('tel') ?></td>'+
									'<td colspan="2"><?= lang(": ") ?>'+ customer_tel +'</td>'+
									'<td style="text-align:right; padding-right:30px;"><?= lang('email') ?></td>'+
									'<td colspan="2"><?= lang(": ") ?>'+ customer_mail +'</td>'+
								'</tr>';
				myexport+=		'<tr style="height:50px; vertical-align:middle;">'+
									'<th class="td_bor_style"><?= lang('No') ?></th>'+
									'<th class="td_bor_style td_align_center"><?= lang('item_code') ?></th>'+
									'<th colspan="2" class="td_bor_style"><?= lang('decription') ?></th>'+
									'<th class="td_bor_style"><?= lang('unit_price') ?></th>'+
									'<th class="td_bor_style"><?= lang('qty') ?></th>'+
									'<th class="td_bor_botton"><?= lang('amount') ?></th>'+
								  '</tr>';
			var type = $('#depreciation_type_1').val();
			var no = 0;
			var total_amt = 0;
			var total_amount = $('#total_balance').val()-0;
			var us_down = $('#amount_1').val()-0;
			var down_pay = us_down;
			var interest_rate = Number($('#depreciation_rate_1').val()-0);
			var term_ = Number($('#depreciation_term_1').val()-0);
			$('.rcode').each(function(){
				no += 1;
				var parent = $(this).parent().parent();
				var unit_price = parent.find('.realuprice').val();
				var qtt = parent.find('.rquantity').val();
				var amt = unit_price * qtt;
				total_amt += amt;
					myexport +=	'<tr>'+
									'<td class="td_color_light td_align_center" align="center">'+ no +'</td>'+
									'<td class="td_color_light">'+ parent.find('.rcode').val() +'</td>'+
									'<td colspan="2" class="td_color_light td_align_center">'+ parent.find('.rname').val() +'</td>'+
									'<td class="td_color_light td_align_right" align="right">$ &nbsp;'+ formatMoney(unit_price) +'</td>'+
									'<td class="td_color_light" align="right">'+ qtt +'</td>'+
									'<td class="td_color_bottom_light td_align_right" align="right">$ &nbsp;'+ formatMoney(amt) +'</td>'+
								'</tr>';
			});
			var loan_amount = total_amt;
			//if(type != 4){
				loan_amount = total_amt - down_pay;
			//}
				if(down_pay != 0 || down_pay != ''){
			myexport+=			'<tr>'+
									'<td colspan="6" style="text-align:right; padding:5px;"><?= lang('total_amount') ?></td>'+
									'<td class="td_align_right" align="right"><b>$ &nbsp;'+ formatMoney(total_amt) +'</b></td>'+
								'</tr>';
			myexport+=			'<tr>'+
									'<td colspan="6" style="text-align:right; padding:5px;"><?= lang('down_payment') ?></td>'+
									'<td class="td_align_right" align="right"><b>$ &nbsp;'+ formatMoney(down_pay) +'</b></td>'+
								'</tr>';
				}
			myexport+=			'<tr>'+
									'<td colspan="6" style="text-align:right; padding:5px;"><?= lang('loan_amount') ?></td>'+
									'<td class="td_align_right" align="right"><b>$ &nbsp;'+ formatMoney(loan_amount) +'</b></td>'+
								'</tr>'+
								'<tr>'+
									'<td colspan="6" style="text-align:right; padding:5px;"><?= lang('interest_rate_per_month') ?></td>'+
									'<td class="td_align_right" align="right"><b>'+ formatMoney(interest_rate/12) +'&nbsp; %</b></td>'+
								'</tr>';
			myexport+=			'<tr><td colspan="7" style="height:70px; vertical-align:middle; text-align:center; font-weight:bold; font-size:14px;"><?= lang('payment_term')?></td></tr>';
			myexport+=			'<tr style="height:50px; vertical-align:middle;">'+
									'<th width="10%" class="td_bor_style"><?= lang('Pmt No.') ?></th>'+
									'<th width="15%" class="td_bor_style"><?= lang('payment_date') ?></th>';
									if(type == 2){
			myexport+=				'<th width="10%" class="td_bor_style"><?= lang('rate') ?></th>';
			myexport+=				'<th width="10%" class="td_bor_style"><?= lang('percentage') ?></th>';
			myexport+=				'<th width="10%" class="td_bor_style"><?= lang('payment') ?></th>'+
									'<th width="15%" class="td_bor_style"><?= lang('total_payment') ?></th>';
									}else{
			myexport+=				'<th width="10%" class="td_bor_style"><?= lang('interest') ?></th>'+
									'<th width="10%" class="td_bor_style"><?= lang('principle') ?></th>'+
									'<th width="15%" class="td_bor_style"><?= lang('total_payment') ?></th>';
									}
			myexport+=				'<th width="10%" class="td_bor_style"><?= lang('balance') ?></th>'+
									'<th width="25%" class="td_bor_botton"><?= lang('note') ?></th>'+
								  '</tr>';
			var k = 0;
			var total_interest = 0;
			var total_princ = 0;
			var amount_total_pay = 0;
			var total_pay_ = 0;
			$('.dep_tbl .no').each(function(){
				k += 1;
				var tr = $(this).parent().parent();
				var balance = formatMoney(tr.find('.balance').val()-0);
			if(type == 2){
				total_interest += Number(tr.find('.rate').val()-0);
				total_princ += Number(tr.find('.percentage').val()-0);
				amount_total_pay += Number(tr.find('.total_payment').val()-0);
			}else{
				total_interest += Number(tr.find('.interest').val()-0);
				total_princ += Number(tr.find('.principle').val()-0);
			}
				total_pay_ += Number(tr.find('.payment_amt').val()-0);
			myexport+=			'<tr>'+
									'<td class="td_color_light td_align_center" align="center">'+ k +'</td>'+
									'<td class="td_color_light td_align_center" align="center">'+ tr.find('.dateline').val() +'</td>';
				if(type == 2){
			myexport+=				'<td class="td_color_light td_align_center" align="right">$ &nbsp;'+ formatMoney(tr.find('.rate').val()-0) +'</td>';
			myexport+=				'<td class="td_color_light td_align_center" align="right">$ &nbsp;'+ formatMoney(tr.find('.percentage').val()-0) +'</td>';
			myexport+=				'<td class="td_color_light td_align_center" align="right">$ &nbsp;'+ formatMoney(tr.find('.payment_amt').val()-0) +'</td>';
			myexport+=				'<td class="td_color_light td_align_center" align="right">$ &nbsp;'+ formatMoney(tr.find('.total_payment').val()-0) +'</td>';
				}else{
			myexport+=				'<td class="td_color_light td_align_center" align="right">$ &nbsp;'+ formatMoney(tr.find('.interest').val()-0) +'</td>';
			myexport+=				'<td class="td_color_light td_align_center" align="right">$ &nbsp;'+ formatMoney(tr.find('.principle').val()-0) +'</td>';
			myexport+=				'<td class="td_color_light td_align_center" align="right">$ &nbsp;'+ formatMoney(tr.find('.payment_amt').val()-0) +'</td>';
				}
			myexport+=				'<td class="td_color_light td_align_right" align="right">$ &nbsp;'+ balance +'</td>'+
									'<td class="td_color_bottom_light" style="padding-left:20px;">'+ tr.find('.note_1').val() +'</td>'+
								'</tr>';
			});
			if(type == 2){
			myexport+=			'<tr>'+
									'<td style="text-align:right; padding:5px;"><b> Total </b></td>'+
									'<td style="text-align:right; padding:5px;"> &nbsp; </td>'+
									'<td style="text-align:right; padding:5px;"><b>$ &nbsp;'+ formatMoney(total_princ) +'</b></td>'+
									'<td style="text-align:right; padding:5px;"><b>$ &nbsp;'+ formatMoney(total_pay_) +'</b></td>'+
									'<td style="text-align:right; padding:5px;"><b>$ &nbsp;'+ formatMoney(amount_total_pay) +'</b></td>'+
									'<td style="text-align:right; padding:5px;"> &nbsp; </td>'+
									'<td style="text-align:right; padding:5px;"> &nbsp; </td>'+
								'</tr>';
			}else{
			myexport+=			'<tr>'+
									'<td style="text-align:right; padding:5px; border-top:1px solid black;"><b> Total </b></td>'+
									'<td style="text-align:right; padding:5px; border-top:1px solid black;"> &nbsp; </td>'+
									'<td style="text-align:right; padding:5px; border-top:1px solid black;"><b>$ &nbsp;'+ formatMoney(total_interest) +'</b></td>'+
									'<td style="text-align:right; padding:5px; border-top:1px solid black;"><b>$ &nbsp;'+ formatDecimal(total_princ) +'</b></td>'+
									'<td style="text-align:right; padding:5px; border-top:1px solid black;"><b>$ &nbsp;'+ formatMoney(total_pay_) +'</b></td>'+
									'<td style="text-align:right; padding:5px; border-top:1px solid black;"> &nbsp; </td>'+
									'<td style="text-align:right; padding:5px;"> &nbsp; </td>'+
								'</tr>';
			}
			myexport+= '</tbody>';
			$('#export_tbl').append(myexport);
			var htmltable= document.getElementById('export_tbl');
			var html = htmltable.outerHTML;
			window.open('data:application/vnd.ms-excel,' + encodeURIComponent(html));
		});


		function PopupPayments() {
			var customer_id = $('#slcustomer').val();
			var customer_name = '';
			var customer_address = '';
			var customer_tel ='';
			var customer_mail = '';

			$.ajax({
				type: "get",
				url: "<?= site_url('sales/getCustomerInfo'); ?>",
				data: {customer_id: customer_id},
				dataType: "html",
				async: false,
				success: function (data) {
					var obj = jQuery.parseJSON(data);
					customer_name = obj.company;
					customer_address = obj.address+', '+obj.city+', '+obj.state;
					customer_tel = obj.phone;
					customer_mail = obj.email;

					//alert(customer_name +"|"+customer_address+"|"+customer_tel+"|"+customer_mail);
				}
			});


			var mywindow = window.open('', 'erp_pos_print', 'height=auto,max-width=480,min-width=250px');
			mywindow.document.write('<html><head><title>Print</title>');
			mywindow.document.write('<link rel="stylesheet" href="<?= $assets ?>styles/helpers/bootstrap.min.css" type="text/css" />');
			mywindow.document.write('</head><body >');
			mywindow.document.write('<center>');
			var issued_date = $('.current_date').val();

			mywindow.document.write("<center><h4 style='font-family:Verdana,Geneva,sans-serif;'>Loan Amortization Schedule</h4></center><br/>");
			mywindow.document.write('<table class="table-condensed" style="width:95%; font-family:Verdana,Geneva,sans-serif; font-size:12px; padding-bottom:10px;">'+
										'<tr>'+
											'<td><?= lang('Issued Date ') ?><?= lang(": ") ?>'+ issued_date +'</td>'+
										'</tr>'+
										'<tr>'+
											'<td style="width:50% !important;"><?= lang('customer') ?> <?= lang(": ") ?>'+ customer_name +'</td>'+
											'<td style="width:50% !important;"><?= lang('address') ?> <?= lang(": ") ?>'+ customer_address +'</td>'+
										'</tr>'+
										'<tr>'+
											'<td style="width:50% !important;"><?= lang('tel') ?> <?= lang(": ") ?>'+ customer_tel +'</td>'+
											'<td style="width:50% !important;"><?= lang('email') ?> <?= lang(": ") ?>'+ customer_mail +'</td>'+
										'</tr>'+
									'</table><br/>'
								  );
			mywindow.document.write('<table border="2px" class="table table-bordered table-condensed table_shape" style="width:95%; font-family:Verdana,Geneva,sans-serif; font-size:12px; border-collapse:collapse;">'+
										'<thead>'+
											 '<tr>'+
												'<th width="5%" class="td_bor_style"><?= lang('No') ?></th>'+
												'<th width="15%" class="td_bor_style td_align_center"><?= lang('Item Code') ?></th>'+
												'<th width="45%" class="td_bor_style"><?= lang('Decription') ?></th>'+
												'<th width="10%" class="td_bor_style"><?= lang('Unit Price') ?></th>'+
												'<th width="10%" class="td_bor_style"><?= lang('Qty') ?></th>'+
												'<th width="15%" class="td_bor_botton"><?= lang('Amount') ?></th>'+
											  '</tr>'+
										'</thead>'+
											'<tbody>');
											var type = $('#depreciation_type_1').val();
											var no = 0;
											var total_amt = 0;
											var total_amount = $('#total_balance').val()-0;
											var us_down = $('#amount_1').val()-0;
											var down_pay = us_down;
											var interest_rate = Number($('#depreciation_rate_1').val()-0);
											var term_ = Number($('#depreciation_term_1').val()-0);
											$('.rcode').each(function(){
												no += 1;
												var parent = $(this).parent().parent();
												var unit_price = parent.find('.realuprice').val();
												var qtt = parent.find('.rquantity').val();
												var amt = unit_price * qtt;
												total_amt += amt;
			mywindow.document.write(			'<tr>'+
													'<td class="td_color_light td_align_center" >'+ no +'</td>'+
													'<td class="td_color_light">'+ parent.find('.rcode').val() +'</td>'+
													'<td class="td_color_light td_align_center">'+ parent.find('.rname').val() +'</td>'+
													'<td class="td_color_light td_align_right">$ '+ formatMoney(unit_price) +'</td>'+
													'<td class="td_color_light td_align_center">'+ qtt +'</td>'+
													'<td class="td_color_bottom_light td_align_right">$ '+ formatMoney(amt) +'</td>'+
												'</tr>');
											});
											var loan_amount = total_amt;
											//if(type != 4){
												loan_amount = total_amt - down_pay;
											//}
												if(down_pay != 0 || down_pay != ''){
			mywindow.document.write(			'<tr>'+
													'<td colspan="5" style="text-align:right; padding:5px;"><?= lang('Total Amount') ?></td>'+
													'<td class="td_align_right"><b>$ '+ formatMoney(total_amt) +'</b></td>'+
												'</tr>');
			mywindow.document.write(			'<tr>'+
													'<td colspan="5" style="text-align:right; padding:5px;"><?= lang('Down Payment') ?></td>'+
													'<td class="td_align_right"><b>$ '+ formatMoney(down_pay) +'</b></td>'+
												'</tr>');
												}
			mywindow.document.write(			'<tr>'+
													'<td colspan="5" style="text-align:right; padding:5px;"><?= lang('Loan Amount') ?></td>'+
													'<td class="td_align_right"><b>$ '+ formatMoney(loan_amount) +'</b></td>'+
												'</tr>'+
													'<td colspan="5" style="text-align:right; padding:5px;"><?= lang('interest_rate_per_month') ?></td>'+
													'<td class="td_align_right"><b>'+ formatDecimal(interest_rate/12) +' %</b></td>'+
												'</tr>');
			mywindow.document.write(		'</tbody>'+
									'</table><br/>'
									);
			mywindow.document.write('<div class="payment_term"><b><?= lang('Payment Term')?></b></div>');
			mywindow.document.write('<table border="2px" class="table table-bordered table-condensed table_shape" style="width:95%; font-family:Verdana,Geneva,sans-serif; font-size:12px; border-collapse:collapse;">'+
										 '<thead>'+
											  '<tr>'+
												'<th width="10%" class="td_bor_style"><?= lang('Pmt No.') ?></th>'+
												'<th width="15%" class="td_bor_style"><?= lang('Payment Date') ?></th>'
									);
											if(type == 2){
			mywindow.document.write(			'<th width="10%" class="td_bor_style"><?= lang('Rate') ?></th>');
			mywindow.document.write(			'<th width="10%" class="td_bor_style"><?= lang('Percentage') ?></th>');
			mywindow.document.write(			'<th width="10%" class="td_bor_style"><?= lang('Payment') ?></th>'+
												'<th width="15%" class="td_bor_style"><?= lang('Total Payment') ?></th>'
									);
											}else{
			mywindow.document.write(			'<th width="10%" class="td_bor_style"><?= lang('Interest') ?></th>'+
												'<th width="10%" class="td_bor_style"><?= lang('Principle') ?></th>'+
												'<th width="15%" class="td_bor_style"><?= lang('Total Payment') ?></th>'
									);
											}
			mywindow.document.write(			'<th width="10%" class="td_bor_style"><?= lang('Balance') ?></th>'+
												'<th width="25%" class="td_bor_botton"><?= lang('Note') ?></th>'+
											  '</tr>'+
										'</thead>'+
										'<tbody>');
										var k = 0;
										var total_interest = 0;
										var total_princ = 0;
										var amount_total_pay = 0;
										var total_pay_ = 0;
										$('.dep_tbl .no').each(function(){
											k += 1;
											var tr = $(this).parent().parent();
											var balance = formatMoney(tr.find('.balance').val()-0);
										if(type == 2){
											total_interest += Number(tr.find('.rate').val()-0);
											total_princ += Number(tr.find('.percentage').val()-0);
											amount_total_pay += Number(tr.find('.total_payment').val()-0);
										}else{
											total_interest += Number(tr.find('.interest').val()-0);
											total_princ += Number(tr.find('.principle').val()-0);
										}
											total_pay_ += Number(tr.find('.payment_amt').val()-0);
			mywindow.document.write(		'<tr>'+
													'<td class="td_color_light td_align_center">'+ k +'</td>'+
													'<td class="td_color_light td_align_center">'+ tr.find('.dateline').val() +'</td>'
													);
											if(type == 2){
			mywindow.document.write(				'<td class="td_color_light td_align_center">$ '+ formatMoney(tr.find('.rate').val()-0) +'</td>');
			mywindow.document.write(				'<td class="td_color_light td_align_center">$ '+ formatMoney(tr.find('.percentage').val()-0) +'</td>');
			mywindow.document.write(				'<td class="td_color_light td_align_center">$ '+ formatMoney(tr.find('.payment_amt').val()-0) +'</td>');
			mywindow.document.write(				'<td class="td_color_light td_align_center">$ '+ formatMoney(tr.find('.total_payment').val()-0) +'</td>');
											}else{
			mywindow.document.write(				'<td class="td_color_light td_align_center">$ '+ formatMoney(tr.find('.interest').val()-0) +'</td>');
			mywindow.document.write(				'<td class="td_color_light td_align_center">$ '+ formatMoney(tr.find('.principle').val()-0) +'</td>');
			mywindow.document.write(				'<td class="td_color_light td_align_center">$ '+ formatMoney(tr.find('.payment_amt').val()-0) +'</td>');
											}
			mywindow.document.write(				'<td class="td_color_light td_align_right">$ '+ balance +'</td>'+
													'<td class="td_color_bottom_light">'+ tr.find('.note_1').val() +'</td>'+
												'</tr>');
										});
										if(type == 2){
			mywindow.document.write(			'<tr>'+
													'<td style="text-align:right; padding:5px;" colspan="2"><b> Total </b></td>'+
													'<td style="text-align:left; padding:5px;"> &nbsp; </td>'+
													'<td style="text-align:left; padding:5px;"><b>$ '+ formatMoney(total_princ) +'</b></td>'+
													'<td style="text-align:left; padding:5px;"><b>$ '+ formatMoney(total_pay_) +'</b></td>'+
													'<td style="text-align:left; padding:5px;"><b>$ '+ formatMoney(amount_total_pay) +'</b></td>'+
													'<td style="text-align:left; padding:5px;"> &nbsp; </td>'+
													'<td style="text-align:left; padding:5px;"> &nbsp; </td>'+
												'</tr>');
										}else{
			mywindow.document.write(			'<tr>'+
													'<td style="text-align:right; padding:5px;"><b> Total </b></td>'+
													'<td style="text-align:left; padding:5px;"> &nbsp; </td>'+
													'<td style="text-align:left; padding:5px;"><b>$ '+ formatMoney(total_interest) +'</b></td>'+
													'<td style="text-align:left; padding:5px;"><b>$ '+ formatMoney(total_princ) +'</b></td>'+
													'<td style="text-align:left; padding:5px;"><b>$ '+ formatMoney(total_pay_) +'</b></td>'+
													'<td style="text-align:left; padding:5px;"> &nbsp; </td>'+
													'<td style="text-align:left; padding:5px;"> &nbsp; </td>'+
												'</tr>');
										}
			mywindow.document.write(	'</tbody>'+
									'</table>'
									);

			mywindow.document.write('</center>');
			mywindow.document.write('</body></html>');
			mywindow.print();
			//mywindow.close();
			return true;
		}

</script>
<script type="text/javascript">
   $(document).ready(function () {
        $("#slcustomer").select2("destroy").empty().attr("placeholder", "<?= lang('select_customer_to_load') ?>").select2({
            placeholder: "<?= lang('select_area_to_load') ?>", data: [
                {id: '', text: '<?= lang('select_area_to_load') ?>'}
            ]
        });

        $('#slarea').change(function () {
           var v = $(this).val();
            $('#modal-loading').show();
            if (v) {
                $.ajax({
                    type: "get",
                    async: false,
                    url: "<?= site_url('sales/getCustomersByArea') ?>/" + v,
                    dataType: "json",
                    success: function (scdata) {
                        if (scdata != null) {
                            $("#slcustomer").select2("destroy").empty().attr("placeholder", "<?= lang('select_customer') ?>").select2({
                                placeholder: "<?= lang('select_category_to_load') ?>",
                                data: scdata
                            });
                        }else{

							$("#slcustomer").select2("destroy").empty().attr("placeholder", "<?= lang('select_customer') ?>").select2({
                                placeholder: "<?= lang('select_category_to_load') ?>",
                                data: 'not found'
                            });
						}
                    },
                    error: function () {
                        bootbox.alert('<?= lang('ajax_error') ?>');
                        $('#modal-loading').hide();
                    }
                });
            } else {
                $("#slcustomer").select2("destroy").empty().attr("placeholder", "<?= lang('select_area_to_load') ?>").select2({
                    placeholder: "<?= lang('select_area_to_load') ?>",
                    data: [{id: '', text: '<?= lang('select_area_to_load') ?>'}]
                });
            }
            $('#modal-loading').hide();
        }).trigger('change');

    });

	$(window).load(function(){
		var al = '<?php echo $this->input->get('addsales');?>';
		//$("slarea").trigger('change');
		if(al){
			var test = $("#add_item").val();

				$.ajax({
					type: 'get',
					url: '<?= site_url('sales/suggestionsSale'); ?>',
					dataType: "json",
					data: {
						term: test,
						warehouse_id: $("#slwarehouse").val(),
						customer_id: $("#slcustomer").val()
					},
					success: function (data) {
						  for(var i = 0; i < data.length; i++){
							comment = data[i];
							add_invoice_item(comment);
						  }
						 $("#add_item").val('');
						var url = $(".gos").attr('href');
						window.location.href = url;
					}
				});


		}
    });



</script>
