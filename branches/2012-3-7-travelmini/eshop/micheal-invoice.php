<?php
	session_start();
	$ch = $_GET['ch'];
	$contant = $_SESSION['invoice'][$ch];
	$subtotal = 0;
	$taxtotal = 0;
	$ship = 0 ;
	$total = 0;
	foreach ($contant['ship'] as $key => $value) {
		$ship = $ship + $value;
	}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Travel Mini Invoice</title>
	<!-- <link rel="stylesheet" type="text/css" href="style.css" media="all"> -->
	<style type="text/css">
	    /*#printable { display: none; }*/
	    @media print
	    {
	        #non-printable { display: none; }
	        #printable { display: block; }
	    }

	    /* =Reset default browser CSS. 
	    -------------------------------------------------------------- */
	    body,li,ul,div,span,table,tr,td,h4,h5,a,label,img{
	    	margin:0px;
	    	padding:0px;
	    }

	    a{
	    	text-decoration:none;
	    }

	    label{
	    	font-weight:bold;
	    	color:#222;
	    }

	    li{
	    	list-style:none;
	    }

	    body{
	    	width:100%;
	    	color:#333;
	    	font-size:12px;
	    }

	    /* =main CSS. 
	    -------------------------------------------------------------- */
	    /*header*/
	    #non-printable,#printable{
	    	width:100%;
	    }

	    #non-printable{
	    	text-align:center;
	    	height:50px;
	    	line-height:50px;
	    }

	    #non-printable a{
	    	padding:5px;
	    	background:#D45037;
	    	color:#fff;
	    }

	    #non-printable a:hover{
	    	background:#BC4832;
	    }

	    #printable{
	    	/*background:green;*/
	    }

	    #header,#info,#desc{
	    	width:80%;
	    	margin:auto;
	    	overflow: hidden;
	    }

	    #header{
	    	position: relative;
	    	/*background:red;*/
	    	padding-bottom:10px;
	    	border-bottom:1px solid #ddd;
	    }
	    #header img{
	    	float:left
	    }

	    #header #idndate{
	    	position: absolute;
	    	right:0;
	    	bottom:5px;
	    }

	    span#invoice-id{
	    	margin-right:10px;
	    }

	    /*info*/
	    #info{
	    	padding:10px 0px;
	    	border-bottom:1px solid #ddd;
	    }

	    #mini-info{
	    	float:left;
	    	width:49%;
	    }

	    #send-info{
	    	float:right;
	    	width:49%;
	    }

	    .address-info{
	    	/*margin:5px;*/
	    }

	    .address-info li{
	    	margin:5px 0px;
	    }

	    .address-info li div{
	    	margin:5px 0px;
	    	/*background:#f5f5f5;*/
	    	padding:3px 0px;
	    }

	    #fixed-info{
	    	margin:10px 0px;
	    	font-weight:bold;
	    }

	    #desc{
	    	background:#f5f5f5;
	    	margin-bottom:20px;
	    }

	    #desc table{
	    	width:100%;
	    }

	    #table-header{
	    	/*background:#ddd;*/
	    	font-weight:bold;
	    }

	    tr{
	    	height:30px;
	    	line-height:30px;
	    }
	    .col{
	    	text-align:center;
	    }

	    .calitem{
	    	font-weight:bold;
	    	text-indent:20px;
	    }

    </style>
</head>
<body>
	<div id="non-printable">
		<a href="javascript:window.print();">Print this invoice</a>
	</div>
	<div id="printable">
		<!-- something to print -->
		<div id="header">
			<div id="logo">
				<img src="http://www.travelmini.com.au/wp-content/uploads/2012/01/travel-mini-transparent-medium.png" alt="">
			</div>
			<div id="idndate">
				<label for="invoice-id">Invoice Id :</label>
				<span id="invoice-id"><?php  echo $contant ['transid'] ?></span>
				<label for="invoice-num">Invoice Date:</label>
				<span id="invoice-num"><?php  echo $contant ['edited'] ?></span>
			</div>
		</div>
		<div id="info">
			<div id="mini-info">
				<h4>Travel Mini</h4>
				<ul class="address-info">
					<li>
						<div class="address">84 Wonga Road</div>
					</li>
					<li>
						<span class="suburb">Ringwood North, </span>
						<span>Victoria, </span>
						<span>3134</span>
					</li>
					<li>Australia</li>
				</ul>

				<ul id="fixed-info">
					<li>sales@travelmini.com.au</li>
					<li>www.travelmini.com.ai</li>
					<li>ABN 69 304 659 020</li>
				</ul>
			</div>

			<div id="send-info">
				<h4>Send To </h4>
				<ul class="address-info">
					<li>
						<div class="address"><?php  echo $contant ['address'] ?></div>
					</li>
					<li>
						<span class="suburb"><?php  echo $contant ['city'] ?>, </span>
						<span><?php  echo $contant ['state'] ?>, </span>
						<span><?php  echo $contant ['zip'] ?></span>
					</li>
					<li>Australia</li>
				</ul>
			</div>
		</div>
		<div id="desc">
			<table>
				<tr id="table-header">
					<td>Description</td>
					<td class="col" align="center" width="100">Qty</td>
					<td class="col" align="center" width="100">Unit Price</td>
					<td class="col" align="center" width="100">Amount</td>
				</tr>

				<!-- start only need to edit this tr -->
				<?php 
					foreach($contant ['product'] as $product){
							$subtotal = $subtotal +$product['item_amt']*$product['item_qty'] ;
							$taxtotal = $taxtotal +$product['tax_amt'];
				?>
				<tr class="item">
					<td class="item-name"><?php  echo $product['optname'] ?></td>
					<td class="item-qty col"><?php  echo $product['item_qty'] ?></td>
					<td class="item-unit-price col">$<?php  echo number_format($product['item_amt'], 2, '.', ''); ?></td>
					<td class="item-amount col">$<?php  echo  number_format($product['item_amt']*$product['item_qty'], 2, '.', ''); ?></td> 
				</tr>

				<?php  } 
					$total = $subtotal + $taxtotal +$ship;
				?>
				<!-- end only need to edit this tr -->

				<!-- calculate -->
				<tr id="sub-total">
					<td></td>
					<td></td>
					<td class="calitem">Sub Total:</td>
					<td class="col">$<?php  echo number_format($subtotal , 2, '.', '') ;?></td>
				</tr>
				<tr id="gst">
					<td></td>
					<td></td>
					<td class="calitem">GST:</td>
					<td class="col">$<?php  echo number_format($taxtotal , 2, '.', '') ;?></td>
				</tr>
				<tr id="shipping">
					<td></td>
					<td></td>
					<td class="calitem">Shipping:</td>
					<td class="col">$<?php  echo number_format($ship , 2, '.', '') ; ?></td>
				</tr>
				<tr id="total">
					<td></td>
					<td></td>
					<td class="calitem">Total:</td>
					<td class="col">$<?php  echo number_format($total , 2, '.', '') ;?></td>
				</tr>
			</table>
		</div>
	</div>
	
</body>
</html>