<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice&nbsp;<?= $invs->reference_no ?></title>
    <link href="<?php echo $assets ?>styles/theme.css" rel="stylesheet">
    <link href="<?php echo $assets ?>styles/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $assets ?>styles/custome.css" rel="stylesheet">
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<style>
    .container {
        width: 100%;
        margin: 20px auto;
        padding: 10px;
        font-size: 14px;
        /*box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);*/
        position: relative;
    }

    .title-header tr {
        border: 1px solid #000 !important;
    }

    .border td, .border th {
        border: 1px solid #000 !important;
        border-top: 1px solid #000 !important;
    }

    @media print {

        .container {
            width: 95% !important;
            margin: 0 auto !important;
        }

        .container .col-xs-12 {
            margin-top: 20px !important;
        }

        .pageBreak {
            page-break-after: always;
            -webkit-page-break-after: always;
        }

        .customer_label {
            padding-left: 0 !important;
        }

        tbody {
            display: table-row-group;
            -webkit-print-color-adjust: exact;
        }

        .print td {
            color: white !important;
            background: #444 !important;

        }

        tfoot {
            display: table-footer-group;
            -webkit-display: table-footer-group;
            page-break-after: always;
        }

        .invoice_label {
            padding-left: 0 !important;
        }

        #footer {
            bottom: 10px !important;
        }

        #note {
            max-width: 95% !important;
            margin: 0 auto !important;
            border-radius: 5px 5px 5px 5px !important;
            margin-left: 26px !important;
        }

        .col-xs-12, .col-sm-12 {
            padding-left: 1px;
            padding-right: 1px;
            margin-left: 0px;
            margin-right: 0px;
        }

        table {
            border-collapse: collapse;
        }

        #footer {
            position: fixed !important;
            bottom: 10px !important;
        }

        #footer .col-sm-4 {
            padding-left: 0 !important;
            margin-left: -5px !important;
        }
        .cus_tb td,.tb_cus th{
            font-size: 12px!important;
        }
    }

    body {
        font-size: 12px !important;
        font-family: "Khmer OS System";
        -moz-font-family: "Khmer OS System";
    }

    .header {
        font-family: "Khmer OS Muol Light";
        -moz-font-family: "Khmer OS System";
        font-size: 18px;
    }

    .table > thead > tr > th, .table > thead > tr > td, tbody > tr > th, .table > tfoot > tr > th, .table > tbody > tr > td, .table > tfoot > tr > td {
        padding: 5px;
    }

    .title {
        font-family: "Khmer OS Muol Light";
        -mox-font-family: "Khmer OS Muol Light";
        font-size: 15px;
    }

    h4 {
        margin-top: 0px;
        margin-bottom: 0px;
    }

    .noPadding tr {
        padding: 0px 0px;
        margin-top: 0px;
        margin-bottom: 0px;
        border: none;
    }

    .noPadding tr td {
        padding: 0px;
        margin-top: 0px;
        margin-bottom: 0px;
        /*border: 1px solid red;*/
    }

    .border-foot td{
        border: 1px solid black !important;
    }

    thead tr th {
        font-weight: normal;
        text-align: center;
    }

    .table {
        margin-bottom: 60px;
    }
    @page {

    }


</style>
<script>
    $(document).ready(function () {
        $("#hide").click(function () {
            $(".myhide").toggle();
        });
    });
</script>
<body>
<div class="container" style="width: 821px;margin: 0 auto;">
    <div class="col-xs-12"
    <?php
    $cols = 6;
    if ($discount != 0) {
        $cols = 7;
    }
    ?>
    <div class="row">
        <table class="table">
            <thead>
            <tr class="thead" style="border-left:none;border-right: none;border-top:none;">
                <th colspan="9"
                    style="border-left:none;border-right: none;border-top:none;border-bottom: 1px solid #000 !important;">
                    <div class="row" style="margin-top: 0px !important;">
                        <div class="col-sm-3 col-xs-3 " style="margin-top: 0px !important; ">
                            <?php if (!empty($biller->logo)) { ?>
                                <img class="img-responsive myhide"
                                     src="<?= base_url() ?>assets/uploads/logos/<?= $biller->logo; ?>" id="hidedlo"
                                     style="width: 140px; margin-left: 25px;margin-top: -10px;"/>
                            <?php } ?>
                        </div>
                        <div class="col-sm-7 col-xs-7 company_addr " style="margin-top: -20px !important;margin-left: -30px;line-height: 14px">
                            <div class="myhide">
                                <center>
                                    <?php if ($biller->company) { ?>
                                        <h3 class="header"><?= $biller->company ?></h3>
                                    <?php } ?>

                                    <div style="margin-top: 15px;">
                                        <?php if (!empty($biller->vat_no)) { ?>
                                            <p>លេខអត្តសញ្ញាណកម្ម អតប (VAT No):&nbsp;<?= $biller->vat_no; ?></p>
                                        <?php } ?>

                                        <?php if (!empty($biller->address)) { ?>
                                            <p style="margin-top:-10px !important;font-size: 13px">
                                                &nbsp;<?= $biller->address; ?></p>
                                        <?php } ?>

                                        <?php if (!empty($biller->phone)) { ?>
                                            <p style="margin-top:-10px ;font-size: 13px">Tel:
                                                &nbsp;<?= $biller->phone; ?>
                                            <?php if (!empty($biller->email)) { ?>
                                                , Email :&nbsp;<?= $biller->email; ?>
                                            <?php } ?>
                                            </p>
                                        <?php } ?>
                                    </div>

                                </center>
                            </div>
                            <div class="invoice" style="">
                                <center>
<!--                                    <h4 class="title">វិក្កយបត្រ</h4>-->
                                    <h4 class="title" style="margin-top: 3px;"><b>STOCK USING ISSUE FORM</b></h4>
                                </center>

                            </div>
                        </div>

                        <div class="col-sm-2 col-xs-2 pull-right">
                            <div class="row">
                                <button type="button" class="btn btn-xs btn-default no-print pull-right"
                                        style="margin-right:15px;" onclick="window.print();">
                                    <i class="fa fa-print"></i> <?= lang('print'); ?>
                                </button>
                            </div>
                            <div class="row">
                                <button type="button" class="btn btn-xs btn-default no-print pull-right " id="hide"
                                        style="margin-right:15px;" onclick="">
                                    <i class="fa"></i> <?= lang('Hide/Show_header'); ?>
                                </button>
                            </div>

                        </div>
                    </div>
                    <br>
                    <div class="row" style="text-align: left;">
                        <div class="col-sm-7 col-xs-7">
                            <table>
                                <?php
//                                $this->erp->print_arrays($invs);

//                               $this->erp->print_arrays($getProject);
                                $proj='';
                                foreach($getProject as $prj){
                                    if($prj->company){
                                        $proj=$prj->company;
                                    }
                                }
                                if (!empty($invs->authorize_name)) {
                                    ?>
                                    <tr>
                                        <td><h4><b>Information</b></h4></td>
                                    </tr>
                                    <tr>
                                        <td>Project</td>
                                        <td>:</td>
                                        <td><?= $proj  ?></td>
                                    </tr>
                                    <tr>
                                        <td>Authorize Name</td>
                                        <td>: </td>
                                        <td> <?= $invs->authorize_name ?></td>
                                    </tr>
                                <?php } ?>

                                    <tr>
                                        <td>Employee Name</td>
                                        <td>: </td>
                                        <td> <?= $invs->first_name.' '.$invs->last_name ?></td>
                                    </tr>


                            </table>
                        </div>
<!--                        --><?php //$this->erp->print_arrays($invs); ?>
                        <div class="col-sm-5 col-xs-5">
                            <table class="noPadding" >
                                <tr>
                                    <td><h4><b>Reference</b></h4></td>
                                </tr>
                                <tr>
                                    <td style="width: 45%;">Reference No</td>
                                    <td style="width: 5%;">:</td>
                                    <td style="width: 50%;"><?= $invs->reference_no ?></td>
                                </tr>
                                <tr>
                                    <td>Date</td>
                                    <td>:</td>
                                    <td><?= $this->erp->hrld($invs->date); ?></td>
                                </tr>
                                <tr>
                                    <td>Warehouse</td>
                                    <td>:</td>
                                    <td><?= $invs->warehouse_name; ?></td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>:</td>
                                    <?php
                                    $addr=str_replace('<p>','',$invs->w_address) ;
                                    $addr=str_replace('</p>','',$addr) ;

                                    ?>
                                    <td><?= $addr ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </th>
            </tr>

            <tr class="border thead print tb_cus " style="">
                <th><?= strtoupper(lang('no')) ?></th>
                <th><?= strtoupper(lang('products_code')) ?></th>
                <th width="35%"><?= strtoupper(lang('products_name')) ?></th>
                <th><?= strtoupper(lang('description')) ?></th>
                <th><?= strtoupper(lang('unit')) ?></th>
                <th><?= strtoupper(lang('quantity')) ?></th>
            </tr>
            </thead>
            <tbody class="table-striped cus_tb" style="">
            <?php
            $i = 1;
            $erow = 1;
            $total = 0;
            foreach ($stock_item as $si) {
                echo '
                    <tr class="border">
                        <td style="text-align:center;">' . $i . '</td>
                        <td>' . $si->code . '</td>
                        <td>' . $si->product_name . ' </td>
                        <td>' . $si->description . '</td>
                        <td style="text-align:center;">' . $si->unit_name . '</td>
                        <td style="text-align:center;">' . $this->erp->formatNumber($si->qty_by_unit) . '</td>
                    </tr>     
                    ';
                $total += $si->qty_by_unit;
                $i++;
                $erow++;

            }
            ?>
            <?php
            if ($erow < 7) {
                $k = 7 - $erow;
                for ($j = 1; $j <= $k; $j++) {
                    echo '<tr class="border">
                            <td style="text-align: center; vertical-align: middle">&nbsp;</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>';
                    $i++;
                }
            }
             $note=str_replace('<p>','',$invs->note);
             $note=str_replace('</p>','',$note);
            ?>

            <tr class="border-foot">
                <td colspan="6" style="text-align: left; ">
                    <b>Note: </b><span style="font-size: 12px"><?= $note ?></span></td>

            </tr>
            </tbody>
        </table>

        <div id="footer" class="row">
            <div class="col-lg-3 col-sm-3 col-xs-3" style="text-align:center">
                <hr style="border: 0.5px solid #000; width: 80%">
                <p style=" margin-top: -20px !important"><b><?= lang("Stock Controller"); ?></b></p>
            </div>
            <div class="col-lg-3 col-sm-3 col-xs-3 " style="text-align:center">
                <hr style="border: 0.5px solid #000; width: 80%">
                <p style=" margin-top: -20px !important"><b><?= lang("Foreman"); ?></b></p>
            </div>
            <div class="col-lg-3 col-sm-3 col-xs-3" style="text-align:center">
                <hr style="border: 0.5px solid #000; width: 80%">
                <p style=" margin-top: -20px !important"><b><?= lang("Driver"); ?></b></p>
            </div>
            <div class="col-lg-3 col-sm-3 col-xs-3" style="text-align:center">
                <hr style="border: 0.5px solid #000; width: 80%">
                <p style=" margin-top: -20px !important"><b><?= lang("Manager"); ?></b></p>
            </div>
        </div>
    </div>
    <div style="width: 821px;margin: 20px">
        <a class="btn btn-warning no-print" href="<?= site_url('products/view_enter_using_stock'); ?>"
           style="border-radius: 0">
            <i class="fa fa-hand-o-left" aria-hidden="true"></i>&nbsp;<?= lang("Back"); ?>
        </a>
    </div>
</div>
</body>
</html>