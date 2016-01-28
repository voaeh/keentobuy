<?php 
/* 
  #file: admin/controller/total/payment_typechg.php
  #tested: Opencart v1.5.1.3
  #powered by fabiom7 - fabiome77@hotmail.it - copyright fabiom7 2012
*/
class ControllerTotalPaymentTypeChg extends Controller {
	private $error = array(); 
	 
	public function index() {
	
		$this->load->language('total/payment_typechg');

		$this->document->setTitle($this->language->get('heading_title'));
				
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('payment_typechg', $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_none'] = $this->language->get('text_none');
		
		$data['entry_fix'] = $this->language->get('entry_fix');
		$data['entry_method'] = $this->language->get('entry_method');
		$data['entry_charge'] = $this->language->get('entry_charge');
		$data['entry_description'] = $this->language->get('entry_description');
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
			'href'      => $this->url->link('total/payment_typechg', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$data['action'] = $this->url->link('total/payment_typechg', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['payment_typechg_method'])) {
			$data['payment_typechg_method'] = $this->request->post['payment_typechg_method'];
		} else {
			$data['payment_typechg_method'] = $this->config->get('payment_typechg_method');
		}

		if (isset($this->request->post['payment_typechg_charge'])) {
			$data['payment_typechg_charge'] = $this->request->post['payment_typechg_charge'];
		} else {
			$data['payment_typechg_charge'] = $this->config->get('payment_typechg_charge');
		}
		
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		foreach ($languages as $language) { $description = 'payment_typechg_description_' . $language['language_id'];
			if (isset($this->request->post[$description])) {
				$data[$description] = $this->request->post[$description];
			} else {
				$data[$description] = $this->config->get($description);
			}
		}
		$data['languages'] = $languages;
		
		if (isset($this->request->post['payment_typechg_status'])) {
			$data['payment_typechg_status'] = $this->request->post['payment_typechg_status'];
		} else {
			$data['payment_typechg_status'] = $this->config->get('payment_typechg_status');
		}

		if (isset($this->request->post['payment_typechg_sort_order'])) {
			$data['payment_typechg_sort_order'] = $this->request->post['payment_typechg_sort_order'];
		} else {
			$data['payment_typechg_sort_order'] = $this->config->get('payment_typechg_sort_order');
		}
		
		$this->load->model('setting/extension');
		$payments = $this->model_setting_extension->getInstalled('payment');
		$payments_files = glob(DIR_APPLICATION . 'controller/payment/*.php');
		
		if ($payments_files) {
			foreach ($payments_files as $file) {
				$payment = basename($file, '.php');
				$this->load->language('payment/' . $payment);
				if (in_array($payment, $payments)) {
					$this->data['payments'][] = array(
						'hname' => $this->language->get('heading_title'),
						'fname' => $payment
					);
				}
			}
		}
		
		$this->template = 'total/payment_typechg.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'total/payment_typechg')) {
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