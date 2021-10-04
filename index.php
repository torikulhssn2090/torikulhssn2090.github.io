<?php 
error_reporting(0);
set_time_limit(0);

include("config.php");

$keyword = 	"";
$keyword =	strtolower(trim(strip_tags($_GET["keyword"])));

$search = 	"";
$search =	$_GET["search"];

$region = 	"";
$region =	$_GET["region"];
if($region == "") $region = "com_EBAY-US";

$region_array = explode("_",$region);
$aregion = $region_array[0];
$eregion = $region_array[1];	


$cat = 	"";
$cat =	$_GET["cat"];
if($cat == "") $cat = "Electronics_172282_293";

$cat_array = explode("_",$cat);
$aindex = $cat_array[0];
$acat = $cat_array[1];
$ecat = $cat_array[2];	


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>Amazon Ebay Affiliate Shop Script</title>
	<link href='http://fonts.googleapis.com/css?family=Aldrich' rel='stylesheet' type='text/css'>   
	<link href="bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function() {	
	$('#atab0').click(function(){
		$("#tab0").show(); 
		$("#tab1").hide();
	    $("#litab0").addClass("active");
	    $("#litabAll").removeClass("active");
	    $("#litab1").removeClass("active");	    		
	});
	$('#atab1').click(function(){
		$("#tab0").hide(); 
		$("#tab1").show();
	    $("#litab0").removeClass("active");
	    $("#litabAll").removeClass("active");
	    $("#litab1").addClass("active");		
	});	

	$('#atabAll').click(function(){
		$("#tab0").show(); 
		$("#tab1").show();
	    $("#litab0").removeClass("active");
	    $("#litabAll").addClass("active");
	    $("#litab1").removeClass("active");		
	});
	});	
	</script>
</head>

<body>

<h2>Amazon Ebay Affiliate Shop Script</h2>

<form id="formSubmit" class="form-wrapper" action="index.php" method="get">
	<input type="text" id="search" name="keyword" <?php if($keyword != "") echo 'value="'.$keyword.'"'; ?> placeholder="Search by product name or keyword..." required>
	<select name="region" id="select">
	<optgroup label="Select Locale">
	<?php foreach ($loc as $key => $value){
		$selectedloc = ($value == $region) ? 'selected="selected"':'';
		echo '<option value="'.$value.'" '.$selectedloc.'>'.$key.'</option>';
		
	}
	
	?>
	</optgroup>
	</select>
	<input type="submit" value="go" name="search" id="submit">
</form>
<div style="width:1000px;">
<div id="categories" class="col-xs-12 col-sm-12 col-md-3 col-lg-3">

	<div class="panel panel-default">
		<div class="panel-heading">
			<h4><i class="icon-th-list"></i> Categories</h4>
		</div>
		<div class="panel-body" style="text-align:left;">
			<ul class="select-xs hidden-xs nav nav-list">
				<?php foreach ($cats as $key => $value){
					$activecat = ($value == $cat && $keyword == "") ? 'class="liactive"':'';
					echo '<li '.$activecat.'><a href="index.php?cat='.$value.'&region='.$region.'">'.$key.'</a></li>';
					
				}
				
				?>			
							
			</ul>
		</div>
	</div>

</div>



<div class="row" style="width:750px; float:right;">
									
	<div id="myTabs" class="tabbable">
	  	<ul class="nav nav-tabs">
		    <li id="litabAll" class="active"><a title="All" id="atabAll">All</a></li>
		    <li id="litab0"><a title="eBay" id="atab0">eBay</a></li>
		    <li id="litab1"><a title="Amazon" id="atab1">Amazon</a></li>
		</ul>
	  	<div class="tab-content">
  			<div id="tab0" class="tab-pane active">
	  			<div class="row">
		  			
		  				<?php 
			  				if($search != "" && $keyword != ""){
		
								$econtent = file_get_contents("http://svcs.ebay.com/services/search/FindingService/v1?OPERATION-NAME=findItemsByKeywords&SERVICE-VERSION=1.0.0&SECURITY-APPNAME=$your_ebay_app_id&RESPONSE-DATA-FORMAT=JSON&REST-PAYLOAD&affiliate.networkId=9&affiliate.trackingId=$your_ebay_affiliate_tracking_id&affiliate.customId=$your_ebay_affiliate_custom_id&paginationInput.entriesPerPage=100&paginationInput.pageNumber=1&GLOBAL-ID=$eregion&keywords=".urlencode($keyword));
								$eresults = json_decode($econtent,true);
	
								foreach($eresults['findItemsByKeywordsResponse'][0]['searchResult'][0]['item'] as $result){
							
								  $title = isset($result['title'][0]) ? $result['title'][0] : "";
								  $img = isset($result['galleryURL'][0]) ? $result['galleryURL'][0] : "";
								  $url = isset($result['viewItemURL'][0]) ? $result['viewItemURL'][0] : "";
								  $price = isset($result['sellingStatus'][0]['currentPrice'][0]["__value__"]) ? $result['sellingStatus'][0]['currentPrice'][0]["__value__"]." ".$result['sellingStatus'][0]['currentPrice'][0]["@currencyId"] : "";

								  echo '<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 product fade in"><div class="thumbnail"><img class="img-responsive" src="'.$img.'"><h3 class="text-overflow hideOverflow">'.$title.'</h3><div class="caption"><h3>'.$title.'</h3><div class="row"><div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><p class="lead">'.$price.'</p></div><div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><a class="btn btn-success btn-block" target="_blank" href="'.$url.'">Buy</a></div></div></div></div></div>';
								}								
		
								
							}else{
								
								$econtent = file_get_contents("http://svcs.ebay.com/services/search/FindingService/v1?OPERATION-NAME=findItemsByCategory&SERVICE-VERSION=1.0.0&SECURITY-APPNAME=$your_ebay_app_id&RESPONSE-DATA-FORMAT=JSON&REST-PAYLOAD&affiliate.networkId=9&affiliate.trackingId=$your_ebay_affiliate_tracking_id&affiliate.customId=$your_ebay_affiliate_custom_id&paginationInput.entriesPerPage=100&paginationInput.pageNumber=1&GLOBAL-ID=$eregion&categoryId=".$ecat);
								$eresults = json_decode($econtent,true);
								$l = 0;
								foreach($eresults['findItemsByCategoryResponse'][0]['searchResult'][0]['item'] as $result){
							
								  $title = isset($result['title'][0]) ? $result['title'][0] : "";
								  $img = isset($result['galleryURL'][0]) ? $result['galleryURL'][0] : "";
								  $url = isset($result['viewItemURL'][0]) ? $result['viewItemURL'][0] : "";
								  $price = isset($result['sellingStatus'][0]['currentPrice'][0]["__value__"]) ? $result['sellingStatus'][0]['currentPrice'][0]["__value__"]." ".$result['sellingStatus'][0]['currentPrice'][0]["@currencyId"] : "";

								  echo '<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 product fade in"><div class="thumbnail"><img class="img-responsive" src="'.$img.'"><h3 class="text-overflow hideOverflow">'.$title.'</h3><div class="caption"><h3>'.$title.'</h3><div class="row"><div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><p class="lead">'.$price.'</p></div><div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><a class="btn btn-success btn-block" target="_blank" href="'.$url.'">Buy</a></div></div></div></div></div>';
								  
								}								
								
							}
		  				?>
		  				
		  			
	  			</div>
  			</div>
  			
  			<div id="tab1" class="tab-pane active">
	  			<div class="row">
		  			
		  				<?php 
			  				if($search != "" && $keyword != ""){
								
								for($i=1;$i<=5;$i++){
									$params = array('Operation'=>"ItemSearch",'Service'=>"AWSECommerceService",'ItemPage'=>$i,'ResponseGroup'=>"Medium,OfferFull", 'SearchIndex'=>"All", 'Keywords'=>$keyword);	
									
									$acontent = file_get_contents_curl(aws_signed_request($aregion, $params, YOUR_AWS_ACCESS_KEY_ID, YOUR_AWS_SECRET_ACCESS_KEY, YOUR_ASSOCIATE_TAG, $version='2011-08-01'));
									$xml = simplexml_load_string($acontent);
									$json = json_encode($xml); 
									$aresults = json_decode($json,true);	

									foreach ($aresults['Items']['Item'] as $result) {
								
									  $url = $result['DetailPageURL'];
									  $img = $result['MediumImage']['URL'];
									  $lprice = $result['ItemAttributes']['ListPrice']['FormattedPrice'];
									  $title = $result['ItemAttributes']['Title'];
									  $offprice = $result['Offers']['Offer']['OfferListing']['Price']['FormattedPrice'];
									  if($offprice == "") $price = $lprice;
									  else $price = $offprice;
	
									  echo '<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 product fade in"><div class="thumbnail"><img class="img-responsive" src="'.$img.'"><h3 class="text-overflow hideOverflow">'.$title.'</h3><div class="caption"><h3>'.$title.'</h3><div class="row"><div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><p class="lead">'.$price.'</p></div><div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><a class="btn btn-success btn-block" target="_blank" href="'.$url.'">Buy</a></div></div></div></div></div>';
									}
								if(!isset($aresults['Items']['Item'])) break;									
								}
								
							}else{
								
								for($i=1;$i<=5;$i++){
									$params = array('Operation'=>"ItemSearch",'Service'=>"AWSECommerceService",'ItemPage'=>$i,'ResponseGroup'=>"Medium,OfferFull", 'SearchIndex'=>$aindex, 'BrowseNode'=>$acat);	
									
									$acontent = file_get_contents_curl(aws_signed_request($aregion, $params, YOUR_AWS_ACCESS_KEY_ID, YOUR_AWS_SECRET_ACCESS_KEY, YOUR_ASSOCIATE_TAG, $version='2011-08-01'));
									$xml = simplexml_load_string($acontent);
									$json = json_encode($xml); 
									$aresults = json_decode($json,true);	

									foreach ($aresults['Items']['Item'] as $result) {
								
									  $url = $result['DetailPageURL'];
									  $img = $result['MediumImage']['URL'];
									  $lprice = $result['ItemAttributes']['ListPrice']['FormattedPrice'];
									  $title = $result['ItemAttributes']['Title'];
									  $offprice = $result['Offers']['Offer']['OfferListing']['Price']['FormattedPrice'];
									  if($offprice == "") $price = $lprice;
									  else $price = $offprice;
	
									  echo '<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 product fade in"><div class="thumbnail"><img class="img-responsive" src="'.$img.'"><h3 class="text-overflow hideOverflow">'.$title.'</h3><div class="caption"><h3>'.$title.'</h3><div class="row"><div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><p class="lead">'.$price.'</p></div><div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><a class="btn btn-success btn-block" target="_blank" href="'.$url.'">Buy</a></div></div></div></div></div>';
									}
								if(!isset($aresults['Items']['Item'])) break;									
								}								
								
							}
		  				?>
		  				
		  			
	  			</div>
  			</div>  			
  			
  			  								  	
		</div>
	</div>

</div>
</div>
</body>
</html>