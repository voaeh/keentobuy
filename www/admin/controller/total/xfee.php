<?php 
class ControllerTotalXfee extends Controller { 
	private $error = array(); 
	 
	public function index() { 
		$this->language->load('total/xfee');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('xfee', $this->request->post);
		
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_none'] = $this->language->get('text_none');
		
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_cost'] = $this->language->get('entry_cost');
		$data['entry_cost'] = $this->language->get('entry_cost');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_tax'] = $this->language->get('entry_tax');
		
		$data['tab_fee'] = $this->language->get('tab_fee');
		$data['tab_general'] = $this->language->get('tab_general');
		$data['text_all'] = $this->language->get('text_all');
		$data['entry_order_total'] = $this->language->get('entry_order_total');
		
		
		$data['entry_payment'] = $this->language->get('entry_payment');
		$data['entry_shipping'] = $this->language->get('entry_shipping');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
					
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

   		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),      		
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_total'),
			'href'      => $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('total/xfee', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$data['action'] = $this->url->link('total/xfee', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL');

		for($i=1;$i<=10;$i++)
		 {
				if (isset($this->request->post['xfee_cost'.$i])) {
					$data['xfee_cost'.$i] = $this->request->post['xfee_cost'.$i];
				} else {
					$data['xfee_cost'.$i] = $this->config->get('xfee_cost'.$i);
				}
				
				if (isset($this->request->post['xfee_name'.$i])) {
					$data['xfee_name'.$i] = $this->request->post['xfee_name'.$i];
				} else {
					$data['xfee_name'.$i] = $this->config->get('xfee_name'.$i);
				}
				
				if (isset($this->request->post['xfee_free'.$i])) {
					$data['xfee_free'.$i] = $this->request->post['xfee_free'.$i];
				} else {
					$data['xfee_free'.$i] = $this->config->get('xfee_free'.$i);
				}
		
				if (isset($this->request->post['xfee_tax_class_id'.$i])) {
					$data['xfee_tax_class_id'.$i] = $this->request->post['xfee_tax_class_id'.$i];
				} else {
					$data['xfee_tax_class_id'.$i] = $this->config->get('xfee_tax_class_id'.$i);
				}
		
				if (isset($this->request->post['xfee_geo_zone_id'.$i])) {
					$data['xfee_geo_zone_id'.$i] = $this->request->post['xfee_geo_zone_id'.$i];
				} else {
					$data['xfee_geo_zone_id'.$i] = $this->config->get('xfee_geo_zone_id'.$i);
				}
				
				if (isset($this->request->post['xfee_status'.$i])) {
					$data['xfee_status'.$i] = $this->request->post['xfee_status'.$i];
				} else {
					$data['xfee_status'.$i] = $this->config->get('xfee_status'.$i);
				}
				
				if (isset($this->request->post['xfee_shipping'.$i])) {
					$data['xfee_shipping'.$i] = $this->request->post['xfee_shipping'.$i];
				} else {
					$data['xfee_shipping'.$i] = $this->config->get('xfee_shipping'.$i);
				}
				
				if (isset($this->request->post['xfee_payment'.$i])) {
					$data['xfee_payment'.$i] = $this->request->post['xfee_payment'.$i];
				} else {
					$data['xfee_payment'.$i] = $this->config->get('xfee_payment'.$i);
				}
				
				if (isset($this->request->post['xfee_total'.$i])) {
					$data['xfee_total'.$i] = $this->request->post['xfee_total'.$i];
				} else {
					$data['xfee_total'.$i] = $this->config->get('xfee_total'.$i);
				}
				
				if (isset($this->request->post['xfee_sort_order'.$i])) {
					$data['xfee_sort_order'.$i] = $this->request->post['xfee_sort_order'.$i];
				} else {
					$data['xfee_sort_order'.$i] = $this->config->get('xfee_sort_order'.$i);
				}
		 }	
		 
		 if (isset($this->request->post['xfee_status'])) {
					$data['xfee_status'] = $this->request->post['xfee_status'];
				} else {
					$data['xfee_status'] = $this->config->get('xfee_status');
				}
		if (isset($this->request->post['xfee_sort_order'])) {
					$data['xfee_sort_order'] = $this->request->post['xfee_sort_order'];
				} else {
					$data['xfee_sort_order'] = $this->config->get('xfee_sort_order');
				}						

		$this->load->model('localisation/tax_class');
		
		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
		
		$this->load->model('localisation/geo_zone');
		
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		$shipping_mods=array();
		$xshipping_installed=false;
		$result=$this->db->query("select * from " . DB_PREFIX . "extension where type='shipping'");
		if($result->rows){
		  foreach($result->rows as $row){
		     $shipping_mods[$row['code']]=$this->getModuleName($row['code'],$row['type']);  
			 if($row['code']=='xshippingpro')$xshipping_installed=true;
		  }
		}
		
		$data['shipping_mods'] = $shipping_mods;
		
		/*For X-Shipping Pro*/
		   if($xshipping_installed){
			   $language_id=$this->config->get('config_language_id');
			   $xshippingpro=$this->config->get('xshippingpro');
			   if($xshippingpro)
			   $xshippingpro=unserialize($xshippingpro);
			
			   if(!isset($xshippingpro['name']))$xshippingpro['name']=array();
			   if(!is_array($xshippingpro['name']))$xshippingpro['name']=array();
			   
			   $xshippingpro_methods=array();
			   foreach($xshippingpro['name'] as $no_of_tab=>$names){
				  
				   if(isset($names[$language_id]) && $names[$language_id]){
					  $code = 'xshippingpro'.'.xshippingpro'.$no_of_tab;
					  $xshippingpro_methods[$code]=$names[$language_id];
					}
			   }
	         $data['xshippingpro_methods'] = $xshippingpro_methods;
		   }
		/*End of X-shipping Pro*/
		
		
		$payment_mods=array();
		$result=$this->db->query("select * from " . DB_PREFIX . "extension where type='payment'");
		if($result->rows){
		  foreach($result->rows as $row){
		     $payment_mods[$row['code']]=$this->getModuleName($row['code'],$row['type']);  
		  }
		}
		
		$data['payment_mods'] = $payment_mods;
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('total/xfee.tpl', $data));
				
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'total/xfee')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
	
	function getModuleName($code,$type)
	{
	   if(!$code) return '';
	   
	   $this->language->load($type.'/'.$code);
	   return $this->language->get('heading_title');
	}
}
?>