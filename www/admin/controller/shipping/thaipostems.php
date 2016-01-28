<?php
class ControllerShippingthaipostems extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->language->load('shipping/thaipostems');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('thaipostems', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_none'] = $this->language->get('text_none');
	 
		$data['entry_cost_ems'] = $this->language->get('entry_cost_ems');


		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_sort_hut'] = $this->language->get('entry_sort_hut');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
        $data['text_reference_detail'] = $this->language->get('text_reference_detail');
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
       		'text'      => $this->language->get('text_shipping'),
			'href'      => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('shipping/thaipostems', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$data['action'] = $this->url->link('shipping/thaipostems', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');
		
		 

	
		if (isset($this->request->post['thaipostems_cost_ems'])) {
			$data['thaipostems_cost_ems'] = $this->request->post['thaipostems_cost_ems'];
		} else {
			$data['thaipostems_cost_ems'] = $this->config->get('thaipostems_cost_ems');
		}


		if (isset($this->request->post['thaipostems_tax_class_id'])) {
			$data['thaipostems_tax_class_id'] = $this->request->post['thaipostems_tax_class_id'];
		} else {
			$data['thaipostems_tax_class_id'] = $this->config->get('thaipostems_tax_class_id');
		}
		
		$this->load->model('localisation/tax_class');
		
		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['thaipostems_geo_zone_id'])) {
			$data['thaipostems_geo_zone_id'] = $this->request->post['thaipostems_geo_zone_id'];
		} else {
			$data['thaipostems_geo_zone_id'] = $this->config->get('thaipostems_geo_zone_id');
		}
		
		$this->load->model('localisation/geo_zone');
		
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post['thaipostems_status'])) {
			$data['thaipostems_status'] = $this->request->post['thaipostems_status'];
		} else {
			$data['thaipostems_status'] = $this->config->get('thaipostems_status');
		}
		
		if (isset($this->request->post['thaipostems_sort_order'])) {
			$data['thaipostems_sort_order'] = $this->request->post['thaipostems_sort_order'];
		} else {
			$data['thaipostems_sort_order'] = $this->config->get('thaipostems_sort_order');
		}				

   		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('shipping/thaipostems.tpl', $data));

	}
	

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/thaipostems')) {
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