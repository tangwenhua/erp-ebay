<?php
include "include/config.php";


$ordersn		= $_REQUEST['ordersn'];






	$sql		= "select * from ebay_order as a where ebay_user='$user'  and ebay_combine!='1' and ebay_ordersn ='$ordersn' ";
	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	for($i=0;$i<count($sql);$i++){
						
		$ebay_countryname	= $sql[$i]['ebay_countryname'];
		$ebay_id			= $sql[$i]['ebay_id'];
		$ebay_ordersn		= $sql[$i]['ebay_ordersn'];
		$ebay_account		= $sql[$i]['ebay_account'];
		
		
		
		$ebay_total			= $sql[$i]['ebay_total'];

		
		
							/* �����װ���ϺͶ��������� */
							$st	= "select * from ebay_orderdetail where ebay_ordersn='$ebay_ordersn'";
							
		
							
							$st = $dbcon->execute($st);
							$st	= $dbcon->getResultArray($st);
							
							
							


							
							$totalweight				= 0;
							$totalweight2				= 0;
								
							
							if(count($st)  == 1){
								
								/* ���㶩���е�����Ʒ���ĵ����� */
							
								
								
								
								$sku						=  $st[0]['sku'];
								$ebay_amount				=  $st[0]['ebay_amount'];
								
								/* ��ʼ����Ƿ�����ϲ�Ʒ */
								$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$goodssn'";
								$rr			= $dbcon->execute($rr);
								$rr 	 	= $dbcon->getResultArray($rr);
		
				
								if(count($rr) > 0){
			
									$goods_sncombine	= $rr[0]['goods_sncombine'];
									$goods_sncombine    = explode(',',$goods_sncombine);
					
					
					
									for($e=0;$e<count($goods_sncombine);$e++){
						
						
											$pline			= explode('*',$goods_sncombine[$e]);
											$goods_sn		= $pline[0];
											$goddscount     = $pline[1] * $ebay_amount;
						
											$ee			= "SELECT * FROM ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
											$ee			= $dbcon->execute($ee);
											$ee 	 	= $dbcon->getResultArray($ee);
											$ebay_packingmaterial		=  $ee[0]['ebay_packingmaterial'];			
											$goods_weight				=  $ee[0]['goods_weight'];					// ��Ʒ��������ѧ
											$capacity					=  $ee[0]['capacity'];						//��Ʒ����
											
											$ss					= "select * from ebay_packingmaterial where  model='$ebay_packingmaterial' and ebay_user ='$user' ";
											$ss					= $dbcon->execute($ss);
											$ss					= $dbcon->getResultArray($ss);
											$pweight			= $ss[0]['weight'];
											
											if($goddscount <= $capacity){
												$totalweight			+= $pweight*$goddscount + ($goods_weight * $goddscount);
											
											}else{
											
												// ���������ĵ�����   $ebay_amount ����sku��������� ebay_packingmaterial ���ĵ�����
												$totalweight2			+= $goods_weight*$ebay_amount + $pweight;
												
												
											}
											
									}
									$totalweight2			+= 0.6 * $pweight;
									
									
							}else{
						
				
								
								$ss							= "select * from ebay_goods where  goods_sn='$sku' and ebay_user ='$user' ";
								
						
								
								$ss							= $dbcon->execute($ss);
								$ss							= $dbcon->getResultArray($ss);
								$ebay_packingmaterial		=  $ss[0]['ebay_packingmaterial'];			
								$goods_weight				=  $ss[0]['goods_weight'];					// ��Ʒ��������ѧ
								$capacity					=  $ss[0]['capacity'];						//��Ʒ����
						
								
								$ss					= "select * from ebay_packingmaterial where  model='$ebay_packingmaterial' and ebay_user ='$user' ";
								$ss					= $dbcon->execute($ss);
								$ss					= $dbcon->getResultArray($ss);
								$pweight			= $ss[0]['weight'];
								
								
								
								
								if($ebay_amount <= $capacity){
									$totalweight			= $pweight + $goods_weight*$ebay_amount;
									
								}else{
									// ���������ĵ�����   $ebay_amount ����sku��������� ebay_packingmaterial ���ĵ�����
									$totalweight2			= $goods_weight*$ebay_amount + $pweight+ 0.6 * $pweight;
								}
								
								
								}
								

					
							
							
							}else{
								
								
								/* ���㶩���ж����Ʒ���ĵ����� */
								$totalweight				= 0;		
								$totalweight2				= 0;
								
								
								for($f=0;$f<count($st); $f++){
									
									
										
										
										$sku						=  $st[$f]['sku'];
										$ebay_amount				=  $st[$f]['ebay_amount'];
								
								/* ��ʼ����Ƿ�����ϲ�Ʒ */
								$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$goodssn'";
								$rr			= $dbcon->execute($rr);
								$rr 	 	= $dbcon->getResultArray($rr);
		
				
								if(count($rr) > 0){
			
									$goods_sncombine	= $rr[0]['goods_sncombine'];
									$goods_sncombine    = explode(',',$goods_sncombine);
					
					
					
									for($e=0;$e<count($goods_sncombine);$e++){
						
						
											$pline			= explode('*',$goods_sncombine[$e]);
											$goods_sn		= $pline[0];
											$goddscount     = $pline[1] * $ebay_amount;
						
											$ee			= "SELECT * FROM ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
											$ee			= $dbcon->execute($ee);
											$ee 	 	= $dbcon->getResultArray($ee);
											$ebay_packingmaterial		=  $ee[0]['ebay_packingmaterial'];			
											$goods_weight				=  $ee[0]['goods_weight'];					// ��Ʒ��������ѧ
											$capacity					=  $ee[0]['capacity'];						//��Ʒ����
											
											$ss					= "select * from ebay_packingmaterial where  model='$ebay_packingmaterial' and ebay_user ='$user' ";
											$ss					= $dbcon->execute($ss);
											$ss					= $dbcon->getResultArray($ss);
											$pweight			= $ss[0]['weight'];
											
											if($goddscount <= $capacity){
												$totalweight			+= $pweight + ($goods_weight * $goddscount);
											
											}else{
											
												// ���������ĵ�����   $ebay_amount ����sku��������� ebay_packingmaterial ���ĵ�����
												$totalweight2			+= $goods_weight*$ebay_amount + $pweight ;
												
												
												
											}
											
									}
									
									
							}else{
						
				
								
									$ss							= "select * from ebay_goods where  goods_sn='$sku' and ebay_user ='$user' ";
									$ss							= $dbcon->execute($ss);
									$ss							= $dbcon->getResultArray($ss);
									$ebay_packingmaterial		=  $ss[0]['ebay_packingmaterial'];			
									$goods_weight				=  $ss[0]['goods_weight'];					// ��Ʒ��������ѧ
									$capacity					=  $ss[0]['capacity'];						//��Ʒ����
									
									
									
									$ss					= "select * from ebay_packingmaterial where  model='$ebay_packingmaterial' and ebay_user ='$user' ";
									$ss					= $dbcon->execute($ss);
									$ss					= $dbcon->getResultArray($ss);
									$pweight			= $ss[0]['weight'];
									
									if($ebay_amount <= $capacity){
										$totalweight			+= $pweight + $goods_weight*$ebay_amount;
									
									}else{
										// ���������ĵ�����   $ebay_amount ����sku��������� ebay_packingmaterial ���ĵ�����
										$totalweight2			+= $goods_weight*$ebay_amount + $pweight;	
										
									}
									
								
								
								
								}
								
								

								
								}
							
								
								
								
								
							}
							
							
							$totalweight		= $totalweight2  + $totalweight;
							
		
							
							$fees								= calcshippingfee($totalweight,$ebay_countryname,$ebay_id,$ebay_account,$ebay_total);
				
							
							$ebay_carrier						= $fees[0];
							$fee								= $fees[1];
							$totalweight						= $fees[2];
							$bb						= "update ebay_order set ebay_carrier='$ebay_carrier',ordershipfee='$fee',orderweight ='$totalweight',packingtype ='$ebay_packingmaterial' where ebay_id ='$ebay_id' ";
							echo $bb;
							$dbcon->execute($bb);
							
							
			
							
								
								
								
								
							
						
							
							
							
						
						}
						

?>
