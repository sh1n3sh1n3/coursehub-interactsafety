<?php include('session.php'); 
$sale = $conn->query("SELECT * FROM sale WHERE id='".$_GET['id']."'")->fetch_assoc();
$users = $conn->query("SELECT * FROM users WHERE id='".$sale['user']."'")->fetch_assoc();
$information = $conn->query("SELECT * FROM information WHERE id='1'")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Interact Safety - Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

<div class="page-content container">
    <div class="page-header text-blue-d2">
        <h3 class="page-title text-secondary-d1" style="width:100%">
            <span style="float:left"><span class="text-600 text-90">Invoice No : </span>
            <small class="page-info">
                 <?php echo $sale['invoiceno']; ?>
            </small><br>
            <span class="text-600 text-90">Order No : </span>
            <small class="page-info">
                 <?php echo $sale['orderno']; ?>
            </small></span>
            <span style="float:right"><span class="text-600 text-90">Payment ID : </span>
            <small class="page-info">
                 <?php echo $sale['paymentid']; ?>
            </small></span><br>
            <span style="float:right"><span class="text-600 text-90">Issue Date:</span> <?php echo date('M d, Y', strtotime($sale['date'])); ?></span>
        </h3>

        <div class="page-tools" style="position:absolute;right:20px">
            <div class="action-buttons">
                <a class="btn bg-white btn-light mx-1px text-95" href="#" id="printbtn" data-title="Print">
                    <i class="mr-1 fa fa-print text-primary-m1 text-120 w-2"></i>
                    Print
                </a>
            </div>
        </div>
    </div>

    <div class="container px-0">
        <div class="row mt-4">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center text-150">
                            <span class="text-default-d3"><img src="../assets/images/cs-logo.png" alt="" width="190px"></span>
                        </div>
                    </div>
                </div>
                <!-- .row -->

                <hr class="row brc-default-l1 mx-n1 mb-4" />

                <div class="row">
                    <div class="col-sm-6">
                        <div>
                            <span class="text-sm text-grey-m2 align-middle">To:</span>
                            <span class="text-600 text-110 text-blue align-middle"><?php echo $sale['name']; ?></span>
                        </div>
                        <div class="text-grey-m2">
                            <div class="my-1">
                                <span class="text-600 text-90">Address - </span><?php echo $sale['address1']; ?>, <?php echo $sale['address2']; ?><br>
                                <?php echo $sale['city']; ?>, <?php echo $sale['state']; ?>, <?php echo $sale['country']; ?>
                            </div>
                            <div class="my-1"><span class="text-600 text-90">Contact No. - </span> <b class="text-600"><?php echo $sale['phone']; ?></b></div>
                            <div class="my-1"><span class="text-600 text-90">Email - </span> <b class="text-600"><?php echo $sale['email']; ?></b></div>
                        </div>
                    </div>
                    <!-- /.col -->

                    <div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                        <hr class="d-sm-none" />
                        <div class="text-grey-m2">

                            <div class="my-2" style="text-transform:none"><span class="text-600 text-90"></span><?php echo $information['invoiceadd']; ?> </div>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>

                <div class="mt-4">
                    
                    <div class="row border-b-2 brc-default-l2"></div>

                    <!-- or use a table instead -->
                    
            <div class="table-responsive">
                <table class="table table-striped table-borderless border-0 border-b-2 brc-default-l1">
                    <thead class="bg-none bgc-default-tp1" style="background-color:rgba(121,169,197,.92)!important">
                        <tr class="text-white">
                            <th>#</th>
                            <th>Description</th>
                            <th>MRP</th>
                            <th>Price</th>
                            <th>Discount</th>
                        </tr>
                    </thead>

                    <tbody class="text-95 text-secondary-d3">
                        <tr></tr>
						<?php $count=0; $total = $shipping = $tax = $amount = 0;
						$sale_part = $conn->query("SELECT * FROM sale_part WHERE orderid='".$_GET['id']."'");
						if($sale_part->num_rows > 0) { 
						while($fetchsale = $sale_part->fetch_assoc()) { $count++;
						$total += $fetchsale['total'];
						$shipping += $fetchsale['shipping'];
						$tax += $fetchsale['tax'];
						$amount += $fetchsale['amount'];
						$mrp += $fetchsale['mrp'];
						$course = $conn->query("SELECT * FROM courses WHERE id='".$fetchsale['course']."'")->fetch_assoc();
						if($fetchsale['tag'] == 'renew') {$tag = '<span style="color:red;text-transform:uppercase;font-weight:bold">('.$fetchsale['tag'].')</span>'; } else {$tag='';}
						?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $course['title'].$tag; ?></td>
                            <td>$<?php echo number_format($fetchsale['mrp'], 2); ?></td>
                            <td>$<?php echo number_format($fetchsale['amount'], 2); ?></td>
                            <td>$<?php echo number_format($fetchsale['mrp'] - $fetchsale['amount'], 2); ?></td>
                        </tr> 
						<?php } } ?>
                    </tbody>
                </table>
            </div>
                    <div class="row mt-3">
                        <div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0">
                        </div>

                        <div class="col-12 col-sm-5 text-grey text-90 order-first order-sm-last">
                            <div class="row my-2">
                                <div class="col-7 text-right">
                                    MRP Total
                                </div>
                                <div class="col-5">
                                    <span class="text-120 text-secondary-d1">$<?php echo $mrp; ?></span>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-7 text-right">
                                    Sub Total
                                </div>
                                <div class="col-5">
                                    <span class="text-120 text-secondary-d1">$<?php echo $amount; ?></span>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-7 text-right">
                                    Savings On MRP
                                </div>
                                <div class="col-5">
                                    <span class="text-120 text-secondary-d1">$<?php echo $mrp - $amount; ?></span>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-7 text-right">
                                    Coupon Discount 
                                </div>
                                <div class="col-5">
                                    <span class="text-110 text-secondary-d1">$<?php echo $sale['discount']; ?></span>
                                </div>
                            </div>
                            <div class="row my-2 align-items-center bgc-primary-l3 p-2">
                                <div class="col-7 text-right">
                                    Total Amount
                                </div>
                                <div class="col-5">
                                    <span class="text-150 text-success-d3 opacity-2">$<?php echo $sale['paidamount']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr />

                    <div>
                        <p class="text-secondary-d1 text-105"><center>Thank you for your order.</center></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
body{
    margin-top:20px;
    color: #484b51;
}
.text-secondary-d1 {
    color: #728299!important;
}
.page-header {
    margin: 0 0 1rem;
    padding-bottom: 1rem;
    padding-top: .5rem;
    border-bottom: 1px dotted #e2e2e2;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-pack: justify;
    justify-content: space-between;
    -ms-flex-align: center;
    align-items: center;
}
.page-title {
    padding: 0;
    margin: 0;
    font-size: 1.75rem;
    font-weight: 300;
}
.brc-default-l1 {
    border-color: #dce9f0!important;
}

.ml-n1, .mx-n1 {
    margin-left: -.25rem!important;
}
.mr-n1, .mx-n1 {
    margin-right: -.25rem!important;
}
.mb-4, .my-4 {
    margin-bottom: 1.5rem!important;
}

hr {
    margin-top: 1rem;
    margin-bottom: 1rem;
    border: 0;
    border-top: 1px solid rgba(0,0,0,.1);
}

.text-grey-m2 {
    color: #888a8d!important;
}

.text-success-m2 {
    color: #86bd68!important;
}

.font-bolder, .text-600 {
    font-weight: 600!important;
}

.text-110 {
    font-size: 110%!important;
}
.text-blue {
    color: #478fcc!important;
}
.pb-25, .py-25 {
    padding-bottom: .75rem!important;
}

.pt-25, .py-25 {
    padding-top: .75rem!important;
}
.bgc-default-tp1 {
    background-color: rgba(121,169,197,.92)!important;
}
.bgc-default-l4, .bgc-h-default-l4:hover {
    background-color: #f3f8fa!important;
}
.page-header .page-tools {
    -ms-flex-item-align: end;
    align-self: flex-end;
}

.btn-light {
    color: #757984;
    background-color: #f5f6f9;
    border-color: #dddfe4;
}
.w-2 {
    width: 1rem;
}

.text-120 {
    font-size: 120%!important;
}
.text-primary-m1 {
    color: #4087d4!important;
}

.text-danger-m1 {
    color: #dd4949!important;
}
.text-blue-m2 {
    color: #68a3d5!important;
}
.text-150 {
    font-size: 150%!important;
}
.text-60 {
    font-size: 60%!important;
}
.text-grey-m1 {
    color: #7b7d81!important;
}
.align-bottom {
    vertical-align: bottom!important;
}</style>

<script>
	$( document ).ready(function() {
		$("#printbtn").click(function(){
			$("#printbtn").css('display','none');		
			window.print();
			
		});
	});
</script>
</body>
</html>