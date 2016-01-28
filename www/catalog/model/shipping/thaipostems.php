<?php
class ModelShippingthaipostems extends Model {
	function getQuote($address) {
		$this->language->load('shipping/thaipostems');
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('thaipostems_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
	
		if (!$this->config->get('thaipostems_geo_zone_id')) {
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
					
					$rates = explode(',', $this->config->get('thaipostems_cost_ems'));
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
			
      		$quote_data['thaipostems'] = array(
        		'code'         => 'thaipostems.thaipostems',
        		'title'        => $this->language->get('text_description'),
        	 	'cost'         =>  $this->currency->format($cost),
        		'tax_class_id' => $this->config->get('thaipostems_tax_class_id'),
				'text'         => $this->currency->format($cost)
 
      		);

          

      		$method_data = array(
        		'code'       => 'thaipostems',
        		'title'      => $this->language->get('text_title'),
        		'quote'      => $quote_data,
				'sort_order' => $this->config->get('thaipostems_sort_order'),
        		'error'      => false
      		);
		}
	
		return $method_data;

 




	}




		
	 


}
?>