<?php
class ControllerShippingthaipostnormal extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->language->load('shipping/thaipostnormal');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('thaipostnormal', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');
       
		$this->data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_none'] = $this->language->get('text_none');
	 
		$this->data['entry_cost_std'] = $this->language->get('entry_cost_std');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		 
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
$this->data['text_reference_detail'] = $this->language->get('text_reference_detail');
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_shipping'),
			'href'      => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('shipping/thaipostnormal', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('shipping/thaipostnormal', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');
		
		 

	
		if (isset($this->request->post['thaipostnormal_cost_std'])) {
			$this->data['thaipostnormal_cost_std'] = $this->request->post['thaipostnormal_reg_cost_std'];
		} else {
			$this->data['thaipostnormal_cost_std'] = $this->config->get('thaipostnormal_cost_std');
		}

 
		
		$this->load->model('localisation/tax_class');
		
		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['thaipost_geo_zone_id'])) {
			$this->data['thaipost_geo_zone_id'] = $this->request->post['thaipost_geo_zone_id'];
		} else {
			$this->data['thaipost_geo_zone_id'] = $this->config->get('thaipost_geo_zone_id');
		}
		
		$this->load->model('localisation/geo_zone');
		
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post['thaipostnormal_status'])) {
			$this->data['thaipostnormal_status'] = $this->request->post['thaipostnormal_status'];
		} else {
			$this->data['thaipostnormal_status'] = $this->config->get('thaipostnormal_status');
		}
		
		if (isset($this->request->post['thaipostnormal_sort_order'])) {
			$this->data['thaipostnormal_sort_order'] = $this->request->post['thaipostnormal_sort_order'];
		} else {
			$this->data['thaipostnormal_sort_order'] = $this->config->get('thaipostnormal_sort_order');
		}				

   		
		

		$this->template = 'shipping/thaipostnormal.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/thaipostnormal')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>