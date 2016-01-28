<?php 
/*
  #file: catalog/model/total/payment_typechg.php
  #tested: Opencart v1.5.1.3
  #powered by fabiom7 - fabiome77@hotmail.it - copyright fabiom7 2012
*/
class ModelTotalPaymentTypeChg extends Model {
	public function getTotal(&$total_data, &$total, &$taxes) {
		
		if ($this->config->get('payment_typechg_status') && $this->cart->getSubTotal() && isset($this->session->data['payment_method']['code'])) {	
						
			if ($this->session->data['payment_method']['code'] == $this->config->get('payment_typechg_method') && $this->config->get('payment_typechg_charge') && $this->config->get('payment_typechg_description_' . $this->config->get('config_language_id'))) {
				
				$payments_methods = $this->config->get('payment_typechg_method');
				$payments_charges = $this->config->get('payment_typechg_charge');
				$fix_description = $this->config->get('payment_typechg_description_' . $this->config->get('config_language_id'));
				
				if (substr($payments_charges,0,1) == '%') {
					$payment_charge = $this->cart->getSubTotal() / 100 * substr($payments_charges,1);
				} else {
					$payment_charge = $payments_charges;
				}
				
				$total_data[] = array( 				
					'code'       => 'payment_typechg',
					'title'      => $fix_description,
					'text'       => $this->currency->format($payment_charge),
        			'value'      => $payment_charge,
					'sort_order' => $this->config->get('payment_typechg_sort_order')
				);
				
				$total += $payment_charge;
			}
		}
	}
}
?>