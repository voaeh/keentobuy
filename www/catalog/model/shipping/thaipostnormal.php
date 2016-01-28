<?php
class ModelShippingthaipostnormal extends Model {
	function getQuote($address) {
		$this->language->load('shipping/thaipostnormal');
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('thaipostnormal_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
	
		if (!$this->config->get('thaipostnormal_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();
	
		if ($status) {

           	$cost = 0;
					$cart_subtotal = $this->cart->getTotal();
					
					$rates = explode(',', $this->config->get('thaipostnormal_cost_std'));
					 // print_r($rates);
					foreach ($rates as $rate) {
  						$data = explode(':', $rate);

  					 	 //print_r($data);
						if ($cart_subtotal <= $data[0]) {
							if (isset($data[1])) {
    							$cost = $data[1];
							}
					
   							break;
  						}
					}
					
           //print_r($cost);
			$quote_data = array();
			
      		$quote_data['thaipostnormal'] = array(
        		'code'         => 'thaipostnormal.thaipostnormal',
        		'title'        => $this->language->get('text_description'),
        	 	'cost'         =>  $this->currency->format($cost),
        		'tax_class_id' => $this->config->get('thaipostnormal_tax_class_id'),
				'text'         => $this->currency->format($cost)
 
      		);

          

      		$method_data = array(
        		'code'       => 'thaipostnormal',
        		'title'      => $this->language->get('text_title'),
        		'quote'      => $quote_data,
				'sort_order' => $this->config->get('thaipostnormal_sort_order'),
        		'error'      => false
      		);
		}
	
		return $method_data;

 




	}




		
	 


}
?>