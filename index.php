<?php
	require_once ('classN11.php');
	$n11Params = [
		'appKey' => 'd83ed152-e469-412d-9c15-488f8747b514',
        'appSecret' => 'Kn86DDsZjHnR1otQ',
	];
	
	$n11 = new N11($n11Params);
	
	//* N11 Sipariş Listesi
	$orderList  = $n11->orderList (
	[
		"productId"=>'',
		"status"=> 'Completed', 
		"buyerName"=> '',
		"orderNumber"=> '',
		"productSellerCode" =>'',
		"recipient"=> '',
		"period"=>[
			"startDate"=> '01/01/2021',
			"endDate"=> ''     
		] ,  
        "sortForUpdateDate" => '',     
        'pagingData' =>[ 
                'currentPage' => 0,
                'pageSize'    => 100
                ]      
	]                
	);

	//var_dump($orderList);
    //print_r($orderList);

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