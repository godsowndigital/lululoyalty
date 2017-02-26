<?php
header('Access-Control-Allow-Origin: *');
include("../lulu_classes.php");
$lulu=new Lulu;
$array=array();
$retrive=array();
$selectvouchers=$lulu->select("voucher_list","*",NULL,"voucher_status='1'","voucher_id DESC");
if(is_array($selectvouchers))
{
	foreach($selectvouchers as $vouchers){
		$resultarray=array();
		$resultarray['voucherid']=$vouchers['voucher_id'];
		$resultarray['title']=$vouchers['voucher_title'];
		$resultarray['vouchervalue']=$vouchers['voucher_grossvalue'];
		$resultarray['vouchercount']=$vouchers['voucher_count'];
		$resultarray['voucherdesc']=$vouchers['voucher_desc'];
		if($vouchers['voucher_image']!='')
		{
			$voucherimage="http://mobileguruji.in/lulumall/backend/loyaltyimages/".$vouchers['voucher_image'];
		}
		else
		{
			$store=new Lulu;
			$selectstoreimage=$store->select("stores","storelogo",NULL,"store_title='".$vouchers['voucher_brand']."'");
			foreach($selectstoreimage as $image);
			if(substr($image['storelogo'],0,31)=='http://mobileguruji.in/lulumall')
			{
				$voucherimage=$image['storelogo'];
			}else{
			  $voucherimage="http://mobileguruji.in/lulumall/brandlogo/".$image['storelogo'];

			}
		}
		$resultarray['voucherimage']=$voucherimage;
		$resultarray['expiry']=date('d M, Y',$vouchers['voucher_enddate']);
		array_push($retrive,$resultarray);
	}
}
$array['vouchers']=$retrive;
echo json_encode($array);	

?>