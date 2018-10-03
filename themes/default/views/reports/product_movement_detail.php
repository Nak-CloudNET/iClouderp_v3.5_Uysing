<?php
$v = "";
if ($this->input->post('from_date')) {
    $v .= "&from_date=" . $this->input->post('from_date');
}
?>
<script>
    $(document).ready(function () {
        var oTable = $('#CusData').dataTable({
            "aaSorting": [[1, "asc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('reports/getMovementAll').'/?v=1'.$v ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            "aoColumns": [{"mRender": fld}, null, null, null,{"mRender": decimalFormat}]
        }).fnSetFilteringDelay().dtFilter([
            {column_number: 0, filter_default_label: "[<?=lang('Date');?>]", filter_type: "text", data: []},
            {column_number: 1, filter_default_label: "[<?=lang('Type');?>]", filter_type: "text", data: []},
            {column_number: 2, filter_default_label: "[<?=lang('Num');?>]", filter_type: "text", data: []},
            {column_number: 3, filter_default_label: "[<?=lang('Item');?>]", filter_type: "text", data: []},
            {column_number: 4, filter_default_label: "[<?=lang('Qty');?>]", filter_type: "text", data: []},
        ], "footer");
    });
</script>
<?php

echo form_open('reports/suppliers_actions', 'id="action-form"');
?>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-users"></i><?= lang('Product_Movement_Detail'); ?></h2>

        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="toggle_up tip" title="<?= lang('hide_form') ?>">
                        <i class="icon fa fa-toggle-up"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0);" class="toggle_down tip" title="<?= lang('show_form') ?>">
                        <i class="icon fa fa-toggle-down"></i>
                    </a>
                </li>
                <li class="dropdown"><a href="#" id="pdf" data-action="export_pdf"  class="tip" title="<?= lang('download_pdf') ?>"><i
                                class="icon fa fa-file-pdf-o"></i></a></li>
                <li class="dropdown"><a href="#" id="excel" data-action="export_excel"  class="tip" title="<?= lang('download_xls') ?>"><i
                                class="icon fa fa-file-excel-o"></i></a></li>
                <li class="dropdown"><a href="#" id="image" class="tip" title="<?= lang('save_image') ?>"><i
                                class="icon fa fa-file-picture-o"></i></a></li>
            </ul>
        </div>
    </div>
    <div style="display: none;">
        <input type="hidden" name="form_action" value="" id="form_action"/>
        <?= form_submit('performAction', 'performAction', 'id="action-form-submit"') ?>
    </div>
    <?= form_close() ?>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?= lang('view_report_supplier'); ?></p>
                <div id="form">
                    <?php echo form_open('reports/product_movement_detail', 'id="action-form"'); ?>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <?= lang("As of Date", "from_date"); ?>
                                <?php echo form_input('from_date', (isset($_POST['from_date']) ? $_POST['from_date'] : $this->erp->hrsd($from_date2)), 'class="form-control date" id="from_date"'); ?>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="controls"> <?php echo form_submit('submit_report', $this->lang->line("submit"), 'class="btn btn-primary sub"'); ?> </div>
                    </div>
                    <?php echo form_close(); ?>

                </div>
                <div class="table-responsive">
                    <table id="CusData" cellpadding="0" cellspacing="0" border="0"
                           class="table table-bordered table-condensed table-hover table-striped reports-table">
                        <thead>
                        <tr class="primary">
                            <th><?= lang("Date"); ?></th>
                            <th><?= lang("Type"); ?></th>
                            <th><?= lang("Num"); ?></th>
                            <th><?= lang("Item"); ?></th>
                            <th><?= lang("Qty"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="5" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                        </tr>
                        </tbody>
                        <tfoot class="dtFilter">
                        <tr class="active">
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>

                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?= $assets ?>js/html2canvas.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#image').click(function (event) {
            event.preventDefault();
            html2canvas($('.box'), {
                onrendered: function (canvas) {
                    var img = canvas.toDataURL()
                    window.open(img);
                }
            });
            return false;
        });

        $('#form').hide();
        $('.toggle_down').click(function () {
            $("#form").slideDown();
            return false;
        });
        $('.toggle_up').click(function () {
            $("#form").slideUp();
            return false;
        });
    });
</script>