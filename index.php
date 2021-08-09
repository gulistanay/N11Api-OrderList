<?php

//Gülistan Ay - Github: https://github.com/gulistanay
	require_once ('classN11.php');
	$n11Params = [
		'appKey' => '******************', 	//You should enter your n11 api key
        'appSecret' => '***************',     		//You should enter your n11 api secret
	];
	
	$n11 = new N11($n11Params);
	
	//* N11 Sipariş Listesi
	$orderList  = $n11->orderList (
	[
		"productId"=>'',
		"status"=> 'Completed',   //Pulls out completed orders. For other options you can use the documentation
		"buyerName"=> '',
		"orderNumber"=> '',
		"productSellerCode" =>'',
		"recipient"=> '',
		"period"=>[
			"startDate"=> '01/01/2021',   //Optionel - You can leave the date blank
			"endDate"=> ''     
		] ,  
        "sortForUpdateDate" => '',     
        'pagingData' =>[ 
                'currentPage' => 0,    //first page
                'pageSize'    => 100
                ]      
	]                
	);

	
    //print_r($orderList);  //If you want to see the content in local, you can activate it.

    $array = json_decode(json_encode($orderList), true);


    function array_to_xml( $data, &$xml_data ) {
        foreach( $data as $key => $value ) {
            if( is_array($value) ) {
                if( is_numeric($key) ){
                    $key = 'item'.$key; 
                }
                $subnode = $xml_data->addChild($key);
                array_to_xml($value, $subnode);
            } else {
                $xml_data->addChild("$key",htmlspecialchars("$value"));
            }
         }
    }

     try {
        $xml_data = new SimpleXMLElement('<?xml version="1.0"?> <data></data>');
    
        array_to_xml($array,$xml_data);
        
        $result = $xml_data->asXML('D:/N11ApiXmlDosyasi.xml');
        echo ("Xml dosyası oluşturuldu.");

     } catch (\Throwable $th) {
         echo ("Xml dosyası oluşturulurken hata oluştu!");
         return $th;
     }
    
  
?>
