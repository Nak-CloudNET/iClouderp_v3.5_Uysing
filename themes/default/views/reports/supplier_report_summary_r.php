

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sale by item Detail</title>

    <link href="<?php echo $assets ?>styles/bootstrap.min.css" rel="stylesheet">


    <style>
        .table tbody td{
            /*border: 1px solid #a4b0be;*/
            /*padding: 0px 0px 0px 10px !important;*/
            /*padding-left: 5px;*/
        }

        .header tr{
            width: 100%;
            text-align: center;

        }
        .btn1{
            color: #0e90d2;
        }

        .line_op{
            position: relative;
            text-align: right;
        }
        .line_op:after{
            position: absolute;
            content: '';
            width: 80%;
            border-top: 1px solid black ;
            top: 0px;
            right: 0px;
        }
        .lp{
            position: relative;
            text-align: right;
        }
        .lp:after{
            position: absolute;
            content: '';
            width: 80%;
            /*border-bottom: 3px double black ;*/
            /*buttom: -150px;*/
            border-bottom-style: double;
            right: 0px;
            height: 90%;
            /*background: red;*/
        }
        .lp:before{
            position: absolute;
            content: '';
            width: 80%;
            border-bottom: 1px solid black ;
            top:0%;
            right: 0px;
            /*height: 0%;*/
        }
        .btn{
            padding: 2px 20px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#form').hide();
            <?php if ($this->input->post('customer')) { ?>
            $('#customer').val(<?= $this->input->post('customer') ?>).select2({
                minimumInputLength: 1,
                data: [],
                initSelection: function (element, callback) {
                    $.ajax({
                        type: "get", async: false,
                        url: site.base_url + "customers/suggestions/" + $(element).val(),
                        dataType: "json",
                        success: function (data) {
                            callback(data.results[0]);
                        }
                    });
                },
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
                };
            $('#customer').val(<?= $this->input->post('customer') ?>);
        })


            <?php } ?>

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

</head>
<body>

    <div class="box">
        <div class="box-header">
            <h2 class="blue"><i class="fa-fw fa fa-users"></i><?= lang('Supplier_Report_Sammary'); ?></h2>
            <div class="box-icon">
                <ul class="btn-tasks">
                    <li class="dropdown"><a href="#" class="toggle_up tip" title="<?= lang('hide_form') ?>"><i
                                    class="icon fa fa-toggle-up"></i></a></li>
                    <li class="dropdown"><a href="#" class="toggle_down tip" title="<?= lang('show_form') ?>"><i
                                    class="icon fa fa-toggle-down"></i></a></li>
                    <?php if ($Owner || $Admin || $GP['sales-export']) { ?>
                        <li class="dropdown"><a href="#" id="pdf" data-action="export_pdf"  class="tip" title="<?= lang('download_pdf') ?>"><i
                                        class="icon fa fa-file-pdf-o"></i></a></li>
                        <li class="dropdown"><a href="#" id="excel" data-action="export_excel"  class="tip" title="<?= lang('download_xls') ?>"><i
                                        class="icon fa fa-file-excel-o"></i></a></li>
                        <li class="dropdown"><a href="#" id="image" class="tip" title="<?= lang('save_image') ?>"><i
                                        class="icon fa fa-file-picture-o"></i></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="box-content">
            <div class="row">
                <div class="col-lg-12">
                    <p class="introtext"><?= lang('list_results'); ?></p>
                    <div id="form">

                        <?php //$this->erp->print_arrays($supplier);
                        echo form_open("reports/supplier_report_summary_r"); ?>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="supplier"><?= lang("supplier"); ?></label>
                                    <?php
                                    $p_c='';
                                    $pr[0] = $this->lang->line("all");;
                                    foreach ($supplier as $su) {
                                        $pr[$su->id] = $su->company;
                                        // $pr1[$product->id]=$product->code;
                                    }
                                    echo form_dropdown('supplier', $pr, (isset($_POST['supplier']) ? $_POST['supplier'] : ""), 'class="form-control" id="supplier" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("supplier") . '"');
                                    ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="reference_no"><?= lang("reference_no"); ?></label>
                                    <?php echo form_input('reference_no', (isset($_POST['reference_no']) ? $_POST['reference_no'] : ""), 'class="form-control tip" id="reference_no"'); ?>

                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="biller"><?= lang("biller"); ?></label>
                                    <?php
                                    $bl["0"] = lang('all');
                                    foreach ($billers as $biller) {
                                        $bl[$biller->id] = $biller->company != '-' ? $biller->company : $biller->name;
                                    }
                                    echo form_dropdown('biller', $bl, (isset($_POST['biller']) ? $_POST['biller'] : ""), 'class="form-control" id="biller" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("biller") . '"');
                                    ?>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= lang("start_date", "start_date"); ?>
                                    <?php echo form_input('start_date', (isset($_POST['start_date']) ? $_POST['start_date'] : ""), 'class="form-control datetime" id="start_date"'); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= lang("end_date", "end_date"); ?>
                                    <?php echo form_input('end_date', (isset($_POST['end_date']) ? $_POST['end_date'] : ""), 'class="form-control datetime" id="end_date"'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div
                                    class="controls"> <?php echo form_submit('submit_sale_report', $this->lang->line("submit"), 'class="btn btn-primary"'); ?> </div>
                        </div>
                        <?php echo form_close(); ?>

                    </div>
                </div>



    <br>

    <table class="table table-bordered table-striped table-hover" >
        <thead>
        <tr>

            <td>Supplier</td>
            <td>Qty</td>
            <td>Amount</td>
            <td>Action</td>

        </tr>
        </thead>
        <tbody>

        <?php
        $qty=0;
        $total_qty_footer = 0;
        $total_amt_footer =0 ;
//        $this->erp->print_arrays($suppliers);
        foreach ($suppliers as $cu){
            $total_qty_footer+=$cu->total_qty;
            $total_amt_footer+=$cu->g_total;
        ?>
        <tr>
            <td><?php echo $cu->supplier;?></td>
            <td style="text-align: right"><?= $this->erp->formatNumber($cu->total_qty);?>&nbsp;</td>
            <td style="text-align: right"><?=  $this->erp->formatMoney($cu->g_total); ?>&nbsp;</td>
            <td class="text-center" style="padding: 2px"> <a href="reports/suppliers_detail_r?p_c=<?= $cu->supplier_id ?>" class="btn btn-primary">View Detail</a></td>

        </tr>

            <?php  }
            $total_qty_footer += $item->qty;
            $total_amt_footer +=$item->amt;
            ?>
        <tr class="total-item2">

            <td><b>Total</b></td>
            <td class="line_op1 lp"><?= $this->erp->formatNumber($total_qty_footer); ?></td>
            <td class="line_op1 lp"><?= $this->erp->formatMoney($total_amt_footer) ;?> &nbsp;</td>
            <td></td>

        </tr>

        </tbody>
    </table>
            </div>
        </div>

</body>
</html>