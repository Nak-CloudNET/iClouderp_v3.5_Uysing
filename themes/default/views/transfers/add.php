<?php
//$this->erp->print_arrays($default_wh);
?>
<script type="text/javascript">
    <?php if ($this->session->userdata('remove_tols')) { ?>
        if (__getItem('toitems')) {
            __removeItem('toitems');
        }
        if (__getItem('toshipping')) {
            __removeItem('toshipping');
        }
        if (__getItem('toref')) {
            __removeItem('toref');
        }
        if (__getItem('biller_id')) {
            __removeItem('biller_id');
        }
        if (__getItem('to_warehouse')) {
            __removeItem('to_warehouse');
        }
        if (__getItem('tonote')) {
            __removeItem('tonote');
        }
        if (__getItem('from_warehouse')) {
            __removeItem('from_warehouse');
        }
        if (__getItem('todate')) {
            __removeItem('todate');
        }
        if (__getItem('tostatus')) {
            __removeItem('tostatus');
        }
<?php
        $this->session->set_userdata('remove_tols', 0);
	    }
?>
    var count = 1, an = 1, product_variant = 0, shipping = 0, product_tax = 0, total = 0, tax_rates = <?php echo json_encode($tax_rates); ?>, toitems = {}, audio_success = new Audio('<?= $assets ?>sounds/sound2.mp3'), audio_error = new Audio('<?= $assets ?>sounds/sound3.mp3');
    $(document).ready(function () {

        $('#biller_id').change(function () {
            billerChange();
            $("#from_warehouse").select2().empty();
            //$("#to_warehouse").select2().empty();
        });
        var $biller = $("#biller_id");
        $(window).load(function () {
            billerChange();
        });

		function billerChange(){
            var id = $biller.val();
            $("#from_warehouse").empty();
            //$("#to_warehouse").empty();
            $.ajax({
                url: '<?= base_url() ?>auth/getWarehouseByProject/' + id,
                dataType: 'json',
                success: function (result) {
                    <?php if ($Owner || $Admin) { ?>
                    __setItem('default_warehouse', '<?= $Settings->default_warehouse; ?>');
                    <?php } else { ?>
                    __setItem('default_warehouse', '<?= $default_wh[0] ?>');
                    <?php } ?>
                    var default_warehouse = __getItem('default_warehouse');

                    if (result == null || result == '') {
                        console.log(result);
                    } else {
                        $.each(result, function (i, val) {
                            var b_id = val.id;
                            var code = val.code;
                            var name = val.name;
                            var opt = '<option value="' + b_id + '">' + code + '-' + name + '</option>';
                            $("#from_warehouse").append(opt);
                        });
                    }

                    if (from_warehouse = __getItem('from_warehouse')) {
                        $('#from_warehouse').select2("val", from_warehouse);
                    } else {
                        $("#from_warehouse").select2("val", default_warehouse);
                    }

                }
            });

			$.ajax({
				url: '<?= base_url() ?>sales/getReferenceByProject/to/'+id,
				dataType: 'json',
				success: function(data){
					$("#ref").val(data);
					$("#temp_reference_no").val(data);
				}
			});
		}

        var $warehouse = $('#from_warehouse');
        $warehouse.change(function (e) {
            __setItem('from_warehouse', $(this).val());
        });

        if (!__getItem('todate')) {
            $("#todate").datetimepicker({
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
        }
        $(document).on('change', '#todate', function (e) {
            __setItem('todate', $(this).val());
        });
        if (todate = __getItem('todate')) {
            $('#todate').val(todate);
        }

        ItemnTotals();
        $("#add_item").autocomplete({
            source: function (request, response) {
                if (!$('#from_warehouse').val()) {
                    $('#add_item').val('').removeClass('ui-autocomplete-loading');
                    bootbox.alert('<?=lang('select_above');?>');
                    $('#add_item').focus();
                    return false;
                }
                $.ajax({
                    type: 'get',
                    url: '<?= site_url('transfers/suggestions'); ?>',
                    dataType: "json",
                    data: {
                        term: request.term,
                        warehouse_id: $("#from_warehouse").val()
                    },
                    success: function (data) {
                        response(data);
                        // $('#to_warehouse').select2("readonly", true);
                        // $('#from_warehouse').select2("readonly", true);
                        // $('#biller_id').select2("readonly", true);
                    }
                });
            },
            minLength: 1,
            autoFocus: false,
            delay: 200,
            response: function (event, ui) {

                if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                    // if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                    //audio_error.play();
                    if ($('#from_warehouse').val()) {
                        bootbox.alert('<?= lang('no_match_found') ?>', function () {
                            $('#add_item').focus();
                        });
                    } else {
                        bootbox.alert('<?= lang('please_select_warehouse') ?>', function () {
                            $('#add_item').focus();
                        });
                    }
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
                    //bootbox.alert('<?= lang('no_match_found') ?>', function () {
                    //$('#add_item').focus();
                    //});
                    $(this).removeClass('ui-autocomplete-loading');
                    // $(this).val('');
                }
            },
            select: function (event, ui) {
                event.preventDefault();
                if (ui.item.id !== 0) {
                    var row = add_transfer_item(ui.item);
                    if (row)
                        $(this).val('');
                }
            }
        });
        $('#add_item').bind('keypress', function (e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $(this).autocomplete("search");
            }
        });

        var to_warehouse;
        $('#to_warehouse').on("select2-focus", function (e) {
            to_warehouse = $(this).val();
        }).on("select2-close", function (e) {
            if ($(this).val() != '' && $(this).val() == $('#from_warehouse').val()) {
                $(this).select2('val', to_warehouse);
                bootbox.alert('<?= lang('please_select_different_warehouse') ?>');
            }
        });
        var from_warehouse;
        $('#from_warehouse').on("select2-focus", function (e) {
            from_warehouse = $(this).val();
        }).on("select2-close", function (e) {
            if ($(this).val() == '' && $(this).val() == $('#to_warehouse').val()) {
                $(this).select2('val', from_warehouse);
                bootbox.alert('<?= lang('please_select_different_warehouse') ?>');
            }
        });
		$("#ref").attr('readonly', true);
		$('#ref_st').on('ifChanged', function() {
		  if ($(this).is(':checked')) {
            $("#ref").attr('readonly', false);
			$("#ref").val("");
		  }else{
			$("#ref").prop('disabled', true);
			var temp = $("#temp_reference_no").val();
			$("#ref").val(temp);
			
		  }
		});
		
	});
</script>

<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-plus"></i><?= lang('add_product_transfer'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?php echo lang('enter_info'); ?></p>
                <?php
                $attrib = array('data-toggle' => 'validator', 'role' => 'form');
                echo form_open_multipart("transfers/add", $attrib)
                ?>

                <div class="row">
                    <div class="col-lg-12">

                        <?php if ($Owner || $Admin || $Settings->allow_change_date == 1) { ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?= lang("date", "todate"); ?>
                                    <?php echo form_input('date', (isset($_POST['date']) ? $_POST['date'] : ""), 'class="form-control input-tip datetime" id="todate" required="required"'); ?>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang('authorize_by', 'authorize_by'); ?>
                                <?php
                                
                                    foreach ($AllUsers as $AU) {
                                        $users[$AU->id] = $AU->username;
                                    }
                              
                                echo form_dropdown('authorize_id', $users,'', 'class="form-control"  required  id="authorize_id" placeholder="' . lang("select") . ' ' . lang("authorize_id") . '" style="width:100%"')
                                ?>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang('employee', 'employee'); ?>
                                <?php
                                
                                    foreach ($employees as $epm) {
                                        $em[$epm->id] = $epm->fullname;
                                    }
                              
                                echo form_dropdown('employee_id', $em,'', 'class="form-control"    id="employee_id" placeholder="' . lang("select") . ' ' . lang("employee") . '" style="width:100%"')
                                ?>                                
                            </div>
                        </div>

                        <div class="col-md-4">
							<?= lang("reference_no", "ref"); ?>
							<div style="float:left;width:100%;">
								<div class="form-group">
									<div class="input-group">   
										<?php echo form_input('reference_no', (isset($_POST['reference_no']) ? $_POST['reference_no'] : $reference_no), 'class="form-control input-tip" id="ref"'); ?>
										<input type="hidden"  name="temp_reference_no"  id="temp_reference_no" value="<?= $reference_no ?>" />					
										<div class="input-group-addon no-print" style="padding: 2px 5px;background-color:white;">
											<input type="checkbox" name="ref_status" id="ref_st" value="1" style="margin-top:3px;background-color:white">
										</div>
									</div>
								</div>
							</div>
						</div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <?php
                                $default_biller = JSON_decode($this->session->userdata('biller_id'));
                                if ($Owner || $Admin || !$this->session->userdata('biller_id')) {
                                    echo get_dropdown_project('biller', 'biller_id');
                                } else {
                                    echo get_dropdown_project('biller', 'biller_id', $default_biller[0]);
                                }
                                ?>
                            </div>
                        </div>

                        <!--
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("status", "status") ?>
                                <?php
                        $status = array('completed' => lang('completed'), 'requested' => lang('requested'));

                        echo form_dropdown('status', $status, '', 'class="form-control"    id="tostatus" placeholder="' . lang("select") . ' ' . lang("status") . '" style="width:100%"')
                        ?>
                            </div>
                        </div>
                        -->

                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("document", "document") ?>
                                <input id="document2" type="file" name="document2" data-show-upload="false"  data-show-preview="false" class="form-control file">
                            </div>
                        </div>					
						
                        <div class="col-md-12">
                            <div class="panel panel-warning">
                                <div
                                    class="panel-heading"><?= lang('please_select_these_before_adding_product') ?></div>
                                <div class="panel-body" style="padding: 5px;">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?= lang("from_warehouse", "from_warehouse"); ?>
                                            <?php /*
											$wh[''] = '';
											foreach ($warehouses as $warehouse) {
												$wh[$warehouse->id] = $warehouse->name;
											}
											echo form_dropdown('from_warehouse', $wh, (isset($_POST['from_warehouse']) ? $_POST['from_warehouse'] : ''), 'id="from_warehouse" class="form-control input-tip select" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("from_warehouse") . '" required="required" style="width:100%;" ');
                                            */ ?>

                                            <?php
                                            if ($Owner || $Admin || !$this->session->userdata('warehouse_id')) {
                                                $wh[""] = "";
                                                foreach ($warehouses as $warehouse) {
                                                    $wh[$warehouse->id] = $warehouse->code . '-' . $warehouse->name;
                                                }

                                                echo form_dropdown('from_warehouse', $wh, (isset($_POST['from_warehouse']) ? $_POST['from_warehouse'] : ($Settings->default_warehouse)), 'class="form-control"   required  id="from_warehouse" placeholder="' . lang("select") . ' ' . lang("from_warehouse") . '" style="width:100%"');
                                            } else {

                                                $whu[''] = '';
                                                foreach ($warehouses_by_user as $warehouse_by_user) {
                                                    $whu[$warehouse_by_user->id] = $warehouse_by_user->code . '-' . $warehouse_by_user->name;
                                                }
                                                $default_wh = explode(',', $this->session->userdata('warehouse_id'));
                                                echo form_dropdown('from_warehouse', $whu, (isset($_POST['from_warehouse']) ? $_POST['from_warehouse'] : $default_wh[0]), 'id="from_warehouse" class="form-control input-tip select" data-placeholder="' . lang("select") . ' ' . lang("from_warehouse") . '" style="width:100%;" ');
                                            }
                                            ?>
                                        </div>
                                    </div>
									<div class="col-md-4">
										<div class="form-group">
											<?= lang("To_Site", "to_Site"); ?>
											<?php 
											$t_wh[''] = '';
											foreach ($to_warehouse as $warehouse) {
												$t_wh[$warehouse->id] = $warehouse->name;
											}
											echo form_dropdown('to_warehouse', $t_wh, (isset($_POST['to_warehouse']) ? $_POST['to_warehouse'] : ''), 'id="to_warehouse" class="form-control input-tip select" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("to_warehouse") . '" required="required" style="width:100%;" ');
											?>
										</div>
										
									</div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="col-md-12" id="sticker">
                            <div class="well well-sm">
                                <div class="form-group" style="margin-bottom:0;">
                                    <div class="input-group wide-tip">
                                        <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                                            <i class="fa fa-2x fa-barcode addIcon"></i></div>
                                        <?php echo form_input('add_item', '', 'class="form-control input-lg" id="add_item" placeholder="' . $this->lang->line("add_product_to_order") . '"'); ?>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="col-md-12">
                            <div class="control-group table-group">
                                <label class="table-label"><?= lang("order_items"); ?></label>

                                <div class="controls table-controls">
                                    <table id="toTable"
                                           class="table items table-striped table-bordered table-condensed table-hover">
                                        <thead>
                                        <tr>
                                            <th class="col-md-5"><?= lang("product_name") . " (" . $this->lang->line("product_code") . ")"; ?></th>
                                            <?php
                                            if ($Settings->product_expiry) {
                                                echo '<th class="col-md-2">' . $this->lang->line("expiry_date") . '</th>';
                                            }
                                            ?>
											<th class="col-md-2"><?= lang("QOH"); ?></th>
                                            <th class="col-md-2"><?= lang("quantity"); ?></th>
                                            <th class="col-md-3"><?= lang("unit"); ?></th>
                                            <th style="width: 1px !important; text-align: center;">
												<i class="fa fa-trash-o" style="opacity:0.5; filter:alpha(opacity=50);"></i>
											</th>
                                        </tr>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot></tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="from-group">
                                <?= lang("note", "tonote"); ?>
                                <?php echo form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : ""), 'id="tonote" class="form-control" style="margin-top: 10px; height: 100px;"'); ?>
                            </div>

                            <div class="from-group">
								<?php echo form_submit('add_transfer', $this->lang->line("submit"), 'class="btn btn-primary" id="add_transfer" style="padding: 6px 15px; margin:15px 0;"'); ?>
                                <button type="button" class="btn btn-danger" id="reset">
									<?= lang('reset') ?>
								</button>
                            </div>
                        </div>

                    </div>
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
                    <div class="form-group">
                        <label for="pquantity" class="col-sm-4 control-label"><?= lang('quantity') ?></label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="pquantity">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="poption" class="col-sm-4 control-label"><?= lang('product_option') ?></label>

                        <div class="col-sm-8">
                            <div id="poptions-div"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pprice" class="col-sm-4 control-label"><?= lang('cost') ?></label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="pprice">
                        </div>
                    </div>
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
