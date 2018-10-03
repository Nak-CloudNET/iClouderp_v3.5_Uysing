<?php //$this->erp->print_arrays($rows) ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice&nbsp;<?= $invs->reference_no ?></title>
    <link href="<?php echo $assets ?>styles/theme.css" rel="stylesheet">
    <link href="<?php echo $assets ?>styles/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $assets ?>styles/custome.css" rel="stylesheet">

</head>
<style>
    .container {
        width: 100%;
        margin: 20px auto;
        padding: 10px;
        font-size: 14px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
        position:relative;
    }
    .title-header tr{
        border: 1px solid #000 !important;
    }
    .border td,.border th{
        border: 1px solid #000 !important;
        border-top: 1px solid #000 !important;
    }

    @media print {
        .print th{
            color:white !important;
            background: #444 !important;

        }
        .pageBreak {
            page-break-after: always;
            -webkit-page-break-after: always;
        }

        .customer_label {
            padding-left: 0 !important;
        }
        tbody{
            display:table-row-group;
        }
        thead {
            display: table-header-group;
            overflow: visible !important;
        }
        thead tr{
            break:inside: auto;
            clear:both;
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
        #note{
            max-width: 95% !important;
            margin: 0 auto !important;
            border-radius: 5px 5px 5px 5px !important;
            margin-left: 26px !important;
        }
        .col-xs-12, .col-sm-12{
            padding-left:1px;
            padding-right:1px;
            margin-left:0px;
            margin-right:0px;
        }
        table {border-collapse: collapse;}
        tr {
            page-break-inside: avoid;
            -webkit-page-break-inside: avoid;
        }
    }

    body{
        font-size: 12px !important;
        font-family: "Khmer OS System";
        -moz-font-family: "Khmer OS System";
    }
    .header{
        font-family:"Khmer OS Muol Light";
        -moz-font-family: "Khmer OS System";
        font-size: 18px;
    }

    .table > thead > tr > th,.table > thead > tr > td, tbody > tr > th, .table > tfoot > tr > th, .table > tbody > tr > td, .table > tfoot > tr > td{
        padding:5px;
    }
    .title{
        font-family:"Khmer OS Muol Light";
        -mox-font-family:"Khmer OS Muol Light";
        font-size: 15px;
    }
    h4{
        margin-top: 0px;
        margin-bottom: 0px;
    }
    .noPadding tr{
        padding: 0px 0px;
        margin-top: 0px;
        margin-bottom: 0px;
        border: none;
    }
    .noPadding tr td{
        padding: 0px;
        margin-top: 0px;
        margin-bottom: 0px;
        border:1px solid white;
    }
    .border-foot td{
        border: 1px solid #000 !important;
    }
    thead tr th{
        font-weight: normal;
        text-align: center;
    }

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $("#hide").click(function(){
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
        <div class="row" style="margin-top: 0px !important;">
            <div class="col-sm-3 col-xs-3 " style="margin-top: 0px !important;">
                <?php if(!empty($billers->logo)) { ?>
                    <img class="img-responsive myhide" src="<?= base_url() ?>assets/uploads/logos/<?= $billers->logo; ?>"id="hidedlo" style="width: 140px; margin-left: 25px;margin-top: -10px;" />
                <?php } ?>
            </div>
            <div  class="col-sm-7 col-xs-7 company_addr "  style="margin-top: -20px !important;">
                <div class="myhide">
                    <center >
                        <?php if($billers->company) { ?>
                            <h3 class="header"><?= $billers->company ?></h3>
                        <?php } ?>
                        <div style="margin-top: 15px;">
                            <?php if(!empty($billers->vat_no)) { ?>
                                <p>លេខអត្តសញ្ញាណកម្ម អតប (VAT No):&nbsp;<?= $billers->vat_no; ?></p>
                            <?php } ?>

                            <?php if(!empty($billers->address)) { ?>
                                <p style="margin-top:-10px !important;">អាសយដ្ឋាន ៖ &nbsp;<?= $billers->address; ?></p>
                            <?php } ?>

                            <?php if(!empty($billers->phone)) { ?>
                                <p style="margin-top:-10px ;">ទូរស័ព្ទលេខ (Tel):&nbsp;<?= $billers->phone; ?></p>
                            <?php } ?>

                            <?php if(!empty($billers->email)) { ?>
                                <p style="margin-top:-10px !important;">សារអេឡិចត្រូនិច (E-mail):&nbsp;<?= $billers->email; ?></p>
                            <?php } ?>
                        </div>

                    </center>
                </div>
                <div class="invoice" style="margin-top:20px;">
                    <center>
                        <h4 class="title">វិក្កយបត្រ​ស្នើរទិញ</h4>
                        <h4 class="title" style="margin-top: 3px;">Purchase Request</h4>
                    </center>

                </div>
            </div>
            <div class="col-sm-2 col-xs-2 pull-right">
                <div class="row">
                    <button type="button" class="btn btn-xs btn-default no-print pull-right" style="margin-right:15px;" onclick="window.print();">
                        <i class="fa fa-print"></i> <?= lang('print'); ?>
                    </button>
                </div>
                <div class="row">
                    <button type="button" class="btn btn-xs btn-default no-print pull-right " id="hide" style="margin-right:15px;" onclick="">
                        <i class="fa"></i> <?= lang('Hide/Show_header'); ?>
                    </button>
                </div>

            </div>
        </div>
        <div class="row" style="text-align: left;">
            <div class="col-sm-7 col-xs-7">
                <table >
                    <?php

                    if(!empty($supplier->company)) { ?>
                        <tr>
                            <td style="width: 25%;">អ្នកផ្គត់ផ្គង់ / Supplier</td>
                            <td style="width: 5%;">:</td>
                            <td style="width: 30%;"><?= $supplier->company ?></td>
                        </tr>
                    <?php } ?>
                    <?php if(!empty($supplier->address_kh || $supplier->address)) { ?>
                        <tr>
                            <td>អាសយដ្ឋាន / Address </td>
                            <td>:</td>
                            <?php if(!empty($supplier->address_kh)) { ?>
                                <td><?= $supplier->address_kh?></td>
                            <?php }else { ?>
                                <td><?= $supplier->address ?></td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                    <?php if(!empty($supplier->address_kh || $supplier->address)) { ?>
                        <tr>
                            <td>ទូរស័ព្ទលេខ (Tel)</td>
                            <td>:</td>
                            <td><?= $supplier->phone ?></td>
                        </tr>
                    <?php } ?>
                    <?php if(!empty($supplier->vat_no)) { ?>
                        <tr>
                            <td style="width: 20% !important">លេខអត្តសញ្ញាណកម្ម អតប </td>
                            <td>:</td>
                            <td><?= $supplier->vat_no ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <div class="col-sm-5 col-xs-5">
                <table class="noPadding" border="none" style="margin-left: 35px">
                    <tr>
                        <td style="width: 45%;">លេខរៀង / N<sup>o</sup></sup></td>
                        <td style="width: 5%;">:</td>
                        <td style="width: 50%;"><?= $invs->reference_no ?></td>
                    </tr>
                    <tr>
                        <td>កាលបរិច្ឆេទ / Date</td>
                        <td>:</td>
                        <td><?= $this->erp->hrld($invs->date); ?></td>
                    </tr>
                    <?php if ($invs->payment_term) { ?>
                        <tr>
                            <td>រយៈពេលបង់ប្រាក់ </td>
                            <td>:</td>
                            <td><?= $invs->payment_term ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30% !important">កាលបរិច្ឆេទនៃការបង់ប្រាក់ </td>
                            <td>:</td>
                            <td><?= $this->erp->hrsd($invs->due_date) ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div><br>
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <table class="table">
                    <thead>
                    <tr class="border thead print" style="background-color: #444 !important; color: #FFF !important;">
                        <th>ល.រ<br /><?= strtoupper(lang('no')) ?></th>
                        <th>កូដ<br /><?= strtoupper(lang('Code')) ?></th>
                        <th>បរិយាយមុខទំនិញ<br /><?= strtoupper(lang('description')) ?></th>
                        <th>ខ្នាត<br /><?= strtoupper(lang('unit')) ?></th>
                        <?php
                        $t_piece=0;
                        $w_piece=0;
                        $tax=0;
                        $dis=0;
                        foreach ($rows as $row) {
                            $t_piece += $row->piece;
                            $w_piece += $row->wpiece;
                            $dis+=$row->item_discount;
                            $tax+=$row->item_tax;
                        }
//                      echo '$tp='.$t_piece.'---$wp='.$w_piece;
//                        $this->erp->print_arrays($rows);
                        if($t_piece>0 || $w_piece>0 ){ ?>
                            <th>ចំនួនដើម<br /><?= strtoupper(lang('Piece')) ?></th>
                            <th>ទំងន់<br /><?= strtoupper(lang('w/piecs')) ?></th>
                        <?php } ?>
                        <th width="8%">ចំនួន<br /><?= strtoupper(lang('qty')) ?></th>
                        <th width="10%">តម្លៃ<br /><?= strtoupper(lang('cost')) ?></th>

                        <?php if ($dis>0) { ?>
                            <th>បញ្ចុះតម្លៃ<br /><?= strtoupper(lang('discount')) ?></th>
                        <?php } ?>
                        <?php if ($tax >0) { ?>
                            <th style="width: 10%">ពន្ធទំនិញ<br /><?= strtoupper(lang('tax')) ?></th>
                        <?php } ?>
                        <th>តម្លៃសរុប<br /><?= strtoupper(lang('subtotal')) ?></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php

                    $no = 1;
                    $erow = 1;
                    $totalRow = 0;
                    $total_piece = 0;
                    //$this->erp->print_arrays($rows);
                    foreach ($rows as $row) {
                        //$this->erp->print_arrays($row);
                        $free = lang('free');
                        $product_unit = '';
                        $total = 0;
                        $total_piece+=$row->piece;
                        if($row->variant){
                            $product_unit = $row->variant;
                        }else{
                            $product_unit = $row->uname;
                        }
                        $product_name_setting;
                        if($setting->show_code == 0) {
                            $product_name_setting = $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : '');
                        }else {
                            if($setting->separate_code == 0) {
                                $product_name_setting = $row->product_name . " (" . $row->product_code . ")" . ($row->variant ? ' (' . $row->variant . ')' : '');
                            }else {
                                $product_name_setting = $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : '');
                            }
                        }
                        ?>
                        <tr class="border">
                            <td style="vertical-align: middle; text-align: center"><?php echo $no ?></td>
                            <td style="vertical-align: middle;">
                                <?=$row->product_code;?>
                            </td>
                            <td style="vertical-align: middle;">
                                <?=$row->product_name;?>
                            </td>

                            <td style="vertical-align: middle; text-align: center">
                                <?= $product_unit?$product_unit:$row->pro_unit; ?>
                            </td>
                            <?php if($total_piece !=0){ ?>
                                <td style="vertical-align: middle; text-align: center">
                                    <?=$row->piece?round($row->quantity,2):'';?>
                                </td>
                                <td style="vertical-align: middle; text-align: center">
                                    <?=$row->wpiece?round($row->wpiece,2):'';?>
                                </td>
                            <?php } ?>

                            <td style="vertical-align: middle; text-align: center">
                                <?= $row->piece?round($row->piece,2):round($row->quantity,2);?>
                            </td>
                            <td style="vertical-align: middle; text-align: right">
                                <?= $row->unitcost_ton!=0?$this->erp->formatMoney($row->unitcost_ton):$this->erp->formatMoney($row->unit_cost); ?>
                            </td>
                            <?php if ($dis>0) {?>
                                <td style="vertical-align: middle; text-align: center">
                                    <?php
                                    if(strpos($row->discount,"%")){
                                        echo "<small style='font-size: 10px;'>(".$row->discount.")</small>" ;
                                    }
                                    echo $this->erp->formatMoney($row->item_discount);
                                    ?>
                                </td>
                            <?php } ?>
                            <?php if ($tax >0) {?>
                                <td style="vertical-align: middle; text-align: center">
                                    <?=$this->erp->formatMoney($row->item_tax);?></td>
                            <?php } ?>
                            <td style="vertical-align: middle; text-align: right"><?= $this->erp->formatMoney($row->subtotal);?>
                            </td>
                        </tr>

                        <?php
                        $no++;
                        $erow++;
                        $totalRow++;
//                    if ($totalRow % 25 == 0) {
//                        echo '<tr class="pageBreak"></tr>';
//                    }
                        $discount=$row->item_discount;
                    }

                    ?>
                    <?php
                    if($erow<16){
                        $k=16 - $erow;
                        for($j=1;$j<=$k;$j++) {
                            echo  '<tr class="border">
                                    <td height="" style="text-align: center; vertical-align: middle">'.$no.'</td>
                                    <td></td>
                                    <td></td>';
                            if($t_piece>0){
                                echo '<td></td>
                                          <td></td>';
                            }
                            if($dis > 0){
                                echo '<td></td>';
                            }
                            if($tax > 0){
                                echo '<td></td>';
                            }
                            echo '<td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>';
                            $no++;
                        }
                    }
                    ?>
                    <?php

                    $row = 1;
                    $col =2;
                    if ($dis> 0) {
                        $col++;
                    }
                    if($tax>0){
                        $col++;
                    }
                    if ($invs->grand_total != $invs->total) {
                        $row++;
                    }
                    if ($invs->order_discount != 0) {
                        $row++;

                    }
                    if($total_piece>0){

                        $col+=2;
                    }
                    if ($invs->shipping != 0) {
                        $row++;

                    }
                    if ($invs->order_tax != 0) {
                        $row++;

                    }
                    if($invs->paid != 0 && $invs->deposit != 0) {
                        $row += 4;
                    }elseif ($invs->paid != 0 && $invs->deposit == 0) {
                        $row += 3;
                    }elseif ($invs->paid == 0 && $invs->deposit != 0) {
                        $row += 3;
                    }

                    ?>

                    <?php
                    if ($invs->grand_total != $invs->total) { ?>
                        <tr class="border-foot">
                            <td rowspan = "<?= $row; ?>" colspan="4" style="border-left: 1px solid #FFF !important; border-bottom: 1px solid #FFF !important;">
                                <?php if (!empty($invs->invoice_footer)) { ?>
                                    <p ><strong><u>Note:</u></strong></p>
                                    <p style="margin-top:-5px !important; line-height: 2"><?= $invs->invoice_footer ?></p>
                                <?php } ?>
                            </td>
                            <td colspan="<?= $col; ?>" style="text-align: right; font-weight: bold;">សរុប​ / <?= strtoupper(lang('total')) ?>
                                (<?= $default_currency->code; ?>)
                            </td>
                            <td align="right"><?= $this->erp->formatMoney($invs->total); ?></td>
                        </tr>
                    <?php } ?>

                    <?php if ($invs->order_discount != 0) : ?>
                        <tr class="border-foot">
                            <td colspan="<?= $col; ?>" style="text-align: right; font-weight: bold;">បញ្ចុះតម្លៃ / <?= strtoupper(lang('order_discount')) ?></td>
                            <td align="right">
                                <small style="font-size: 10px">
                                    (<?php
                                    if(strpos($invs->order_discount_id,"%")){
                                        echo $invs->order_discount_id;
                                    }else{
                                        echo $invs->order_discount_id.'%';
                                    }
                                    ?>)
                                </small>
                                <?php echo $this->erp->formatMoney($invs->order_discount); ?></td>
                        </tr>
                    <?php endif; ?>

                    <?php if ($invs->shipping != 0) : ?>
                        <tr class="border-foot">
                            <td colspan="<?= $col; ?>" style="text-align: right; font-weight: bold;">ដឹកជញ្ជូន / <?= strtoupper(lang('shipping')) ?></td>
                            <td align="right"><?php echo $this->erp->formatMoney($invs->shipping); ?></td>
                        </tr>
                    <?php endif; ?>

                    <?php if ($invs->order_tax != 0) : ?>
                        <tr class="border-foot">
                            <td colspan="<?= $col; ?>" style="text-align: right; font-weight: bold;">ពន្ធអាករ / <?= strtoupper(lang('order_tax')) ?></td>
                            <td align="right"><?= $this->erp->formatMoney($invs->order_tax); ?></td>
                        </tr>
                    <?php endif; ?>

                    <tr class="border-foot">
                        <?php if ($invs->grand_total == $invs->total) { ?>
                            <td rowspan="<?= $row; ?>" colspan="4" style="border-left: 1px solid #FFF !important; border-bottom: 1px solid #FFF !important;">
                                <?php if (!empty($invs->invoice_footer)) { ?>
                                    <p><strong><u>Note:</u></strong></p>
                                    <p><?= $invs->invoice_footer ?></p>
                                <?php } ?>
                            </td>
                        <?php } ?>
                        <td colspan="<?= $col; ?>" style="text-align: right; font-weight: bold;">សរុបរួម / <?= strtoupper(lang('total_amount')) ?>
                            (<?= $default_currency->code; ?>)
                        </td>
                        <td align="right"><?= $this->erp->formatMoney($invs->grand_total); ?></td>
                    </tr>
                    <?php if($invs->paid != 0 || $invs->deposit != 0){ ?>
                        <?php if($invs->deposit != 0) { ?>
                            <tr class="border-foot">
                                <td colspan="<?= $col; ?>" style="text-align: right; font-weight: bold;">បានកក់ / <?= strtoupper(lang('deposit')) ?>
                                    (<?= $default_currency->code; ?>)
                                </td>
                                <td align="right"><?php echo $this->erp->formatMoney($invs->deposit); ?></td>
                            </tr>
                        <?php } ?>
                        <?php if($invs->paid != 0) { ?>
                            <tr class="border-foot">
                                <td colspan="<?= $col; ?>" style="text-align: right; font-weight: bold;">បានបង់ / <?= strtoupper(lang('paid')) ?>
                                    (<?= $default_currency->code; ?>)
                                </td>
                                <td align="right"><?php echo $this->erp->formatMoney($invs->paid - $invs->deposit); ?></td>
                            </tr>
                        <?php } ?>
                        <tr class="border-foot">
                            <td colspan="<?= $col; ?>" style="text-align: right; font-weight: bold;">នៅខ្វះ / <?= strtoupper(lang('balance')) ?>
                                (<?= $default_currency->code; ?>)
                            </td>
                            <td align="right">
                                <?= $this->erp->formatMoney($invs->grand_total - (($invs->paid - $invs->deposit) + $invs->deposit)); ?></td>
                        </tr>
                    <?php } ?>

                    </tbody>
                    <tfoot class="tfoot">
                    <tr>
                        <th colspan="9">
                            <?php if(trim(htmlspecialchars_decode($invs->note))){ ?>
                                <div style="border-radius: 5px 5px 5px 5px;border:1px solid black;height: auto;" id="note" class="col-md-12 col-xs-12">
                                    <p style="margin-left: 10px;margin-top:10px;"><?php echo strip_tags(htmlspecialchars_decode($invs->note)); ?></p>
                                </div>
                                <br><br><br><br>
                            <?php } ?>
                            <div class="clear-both">
                                <div style="width:100%;height:80px"></div>
                            </div>
                            <div id="footer" class="row" >
                                <div class="col-sm-4 col-xs-4">
                                    <center>
                                        <hr style="margin:0; border:1px solid #000; width: 80%">
                                        <p style=" margin-top: 4px !important">ហត្ថលេខា និងឈ្មោះអ្នកស្នើរសំុ</p>
                                        <p style="margin-top:-10px;">Prepared's Signature & Name</p>
                                    </center>
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                    <center>
                                        
                                        <p style="margin-top: 4px !important"></p>
                                        <p style="margin-top:-10px;"></p>
                                    </center>
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                    <center>
                                        <hr style="margin:0; border:1px solid #000; width: 80%">
                                        <p style=" margin-top: 4px !important">ហត្ថលេខា និងឈ្មោះអ្នកអនុញ្ញាតិ</p>
                                        <p style="margin-top:-10px; ">Customer's Signature & Name</p>
                                    </center>
                                </div>
                            </div>
                        </th>
                    </tr>
                    </tfoot>

                </table>
            </div>
        </div>
    </div>




    <div style="width: 821px;margin: 20px">
        <a class="btn btn-warning no-print" href="<?= site_url('purchases_request'); ?>" style="border-radius: 0">
            <i class="fa fa-hand-o-left" aria-hidden="true"></i>&nbsp;<?= lang("back"); ?>
        </a>
    </div>
</div>

</body>
</html>