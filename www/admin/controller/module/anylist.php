<?php
class ControllerModuleAnylist extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('module/anylist');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		$this->load->model('catalog/product');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('anylist', array( 'anylist_status'=>1, 'anylist_module' => $this->request->post['anylist_module']));		
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
        
        $data = array();
				
		$data['heading_title'] = $this->language->get('heading_title');
        
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_selection'] = $this->language->get('entry_selection');
		$data['entry_dimension'] = $this->language->get('entry_dimension');
		$data['entry_limit'] = $this->language->get('entry_limit');
		$data['entry_filter'] = $this->language->get('entry_filter');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_add_module'] = $this->language->get('button_add_module');

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['dimension'])) {
			$data['error_dimension'] = $this->error['dimension'];
		} else {
			$data['error_dimension'] = array();
		}
				
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/anylist', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$data['action'] = $this->url->link('module/anylist', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['token'] = $this->session->data['token'];
		$data['modules'] = array();
		
		if (isset($this->request->post['anylist_module'])) {
			$data['modules'] = $this->request->post['anylist_module'];
		} elseif ($this->config->get('anylist_module')) { 
			$data['modules'] = $this->config->get('anylist_module');
		}	
				
        $data['rows']=array();
        $i=0;
        foreach($data['modules'] as $module) { $data['rows'][] = $this->addRow(++$i,$module); }

		$data['prodfields'] = array();
		//  GET product table structure
		$p = $this->model_catalog_product->getProducts(array('start'=>0,'limit'=>1));
		if ($p[0]) {
			foreach($p[0] as $f=>$v) {
				$data['prodfields'][] = $f;
				if ($f=='viewed') break;
			}
		}

		$this->load->model('catalog/category');
		$data['categories'] = $this->model_catalog_category->getCategories(0);

		$this->load->model('catalog/manufacturer');
		$data['manufacturers'] = $results = $this->model_catalog_manufacturer->getManufacturers();

		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
				
		$this->response->setOutput($this->load->view('module/anylist.tpl', $data));
	}
    
    
    
    public function addRow($module=1,$data=array()) {
        $module_row = isset($this->request->get['Module']) ? $this->request->get['Module'] : $module;

		$this->load->language('module/anylist');
		$this->load->model('setting/setting');
		$this->load->model('localisation/language');
		$this->load->model('catalog/product');
		$this->load->model('catalog/category');
		$this->load->model('catalog/manufacturer');

		$prodfields = array();
		$p = $this->model_catalog_product->getProducts(array('start'=>0,'limit'=>1));
		if ($p[0]) {
			foreach($p[0] as $f=>$v) {
				$prodfields[] = $f;
				if ($f=='viewed') break;
			}
		}

		$languages = $this->model_localisation_language->getLanguages();

          
		$products_list = array();
		if ($data and isset($data['products']) and  $data['products']) {
			foreach($data['products'] as $pid) {
				$p = $this->model_catalog_product->getProduct($pid);
				if ($p)
					$products_list[] = $p; 
			}
		}

        $category_list = array();
        if ($data and $data['category']) {
            foreach($data['category'] as $cid) {
				$c = $this->model_catalog_category->getCategory($cid);
				if ($c)
					$category_list[] = $c; 
			}
        }            
				

		$entry_titlelink = $this->language->get('entry_titlelink');
		$entry_code = $this->language->get('entry_code');
		$entry_title = $this->language->get('entry_title');
		$entry_category = $this->language->get('entry_category');
		$help_category = $this->language->get('help_category');
		$entry_products = $this->language->get('entry_products');
		$entry_manufacturer = $this->language->get('entry_manufacturer');
		$entry_limit_help = $this->language->get('entry_limit_help');
		$text_enabled = $this->language->get('text_enabled');
		$text_disabled = $this->language->get('text_disabled');
		$text_period = $this->language->get('text_period');
		$button_remove = $this->language->get('button_remove');
		$entry_latest_text = $this->language->get('entry_latest_text');
		$entry_latest_products = $this->language->get('entry_latest_products');
		$entry_specials_text = $this->language->get('entry_specials_text');
		$entry_sort_order = $this->language->get('entry_sort_order');
		$entry_sort_descending = $this->language->get('entry_sort_descending');
		$entry_product = $this->language->get('entry_product');



        $html = "<tbody id=\"module-row$module_row\">
            <tr>
            <td class=\"left\" style=\"padding-top: 6px; padding-bottom: 2px; vertical-align: top\">
            <table style=\"border: none; width:96%;\">
                <tr><td>$entry_code</td><td><input class=\"form-control\" type=\"text\" name=\"anylist_module[$module_row][code]\" value=\"".(($data) ? $data['code'] : '')."\" /></td></tr>
                <tr><td>$entry_titlelink</td><td><input class=\"form-control\" type=\"text\" name=\"anylist_module[$module_row][titlelink]\" value=\"".(($data) ? $data['titlelink'] : '')."\" /></td></tr>";
                
                foreach ($languages as $language) { 
                	$html.= '<tr><td><img src="view/image/flags/' . $language['image'] . '" title="' . $language['name'] . '" /> ' . $language['name'] . ' ' . $entry_title . '</td><td><input class="form-control" type="text" name="anylist_module['.$module_row.'][title][' . $language['language_id'] . ']" value="'.(($data) ? $data['title'][$language['language_id']] : '').'" /></td></tr>';
                }
            $html.= '</table>';
            $html.= '</td>';
        
        $html.= "
            <td style=\"padding-top: 6px; padding-bottom: 2px; vertical-align: top\">
                <div class=\"col-sm-10\" style=\"padding-left: 0px;\">
                <input class=\"form-control\" type=\"text\" name=\"category_$module_row\" value=\"\" placeholder=\"$entry_category\" id=\"category_$module_row\" class=\"form-control\" />
                <div id=\"anylist-category_$module_row\" class=\"well well-sm\" style=\"height: 150px; overflow: auto;\">";
                foreach($category_list as $c) $html .= '<div id="anylist-category_' .$module_row. '_' . $c['name'] . '"><i style="cursor: pointer;" class="fa fa-minus-circle"></i> ' . $c['name'] . '<input type="hidden" name="anylist_module['.$module_row.'][category][]" value="' . $c['category_id'] . '" /></div>';
                
        $html.= "</div>
                </div>
                <br/><b>$entry_products</b>
                <input class=\"form-control\" type=\"text\" name=\"product_$module_row\" value=\"\" placeholder=\"$entry_products\" id=\"product_$module_row\" class=\"form-control\" style=\"width:80%\"/>
                <div id=\"anylist-products_$module_row\" class=\"well well-sm\" style=\"height: 150px; overflow: auto; width:80%;\">";
                foreach($products_list as $p) $html .= '<div id="anylist-products-product_' .$module_row. '_' . $p['name'] . '"><i style="cursor: pointer;" class="fa fa-minus-circle"></i> ' . $p['name'] . '<input type="hidden" name="anylist_module['.$module_row.'][products][]" value="' . $p['product_id'] . '" /></div>';
                                
         $html .= "</div>
                
                <br/><b>$entry_latest_text</b>:<br/><input class=\"form-control\" style=\"width:80%\" type=\"text\" name=\"anylist_module[$module_row][latest]\" value=\"".(($data) ? $data['latest'] : '0')."\"/>
                <br/><b>$entry_specials_text</b>:<br/><input class=\"form-control\" style=\"width:80%\" type=\"text\" name=\"anylist_module[$module_row][specials]\" value=\"".(($data) ? $data['specials'] : '0')."\"/><br/>
                <br/>
                <b>$entry_sort_order</b>
                <select class=\"form-control\" name=\"anylist_module[$module_row][sortfield]\"><option value=\"\">[no sort]</option>";
                foreach ($prodfields as $f) { 
            	         $html.= '<option '.(($data and $data['sortfield']==$f) ? 'selected="selected"' : '').' value="'. $f .'">' . $f . '</option>';
                }
            	$html.= '</select>';
            $html.= '</td>'; 	
        	
   	    $html.= "<td class=\"left\" style=\"padding-top: 6px; padding-bottom: 2px; vertical-align: top\"><input class=\"form-control\" type=\"text\" name=\"anylist_module[$module_row][width]\" value=\"".(($data) ? $data['width'] : '80')."\" size=\"3\" /> <input class=\"form-control\" type=\"text\" name=\"anylist_module[$module_row][height]\" value=\"".(($data) ? $data['height'] : '80')."\" size=\"3\" /></td>";
        
        $html.= "<td class=\"right\" style=\"padding-top: 6px; padding-bottom: 2px; vertical-align: top\"><input class=\"form-control\" type=\"text\" name=\"anylist_module[$module_row][limit]\" value=\"".(($data) ? $data['limit'] : '8')."\" size=\"3\" /></td>";
        $html.= "<td class=\"left\" style=\"padding-top: 6px; padding-bottom: 2px; vertical-align: top\">";
    
    		$categories = $this->model_catalog_category->getCategories(array('sort'=>'name'));
    		$manufacturers = $this->model_catalog_manufacturer->getManufacturers();
            
            $html.= "<div id=\"limitmanufacturer_$module_row\"><b>$entry_manufacturer</b><br /><div class=\"help\" style=\"width: 200px;\">$entry_limit_help</div><br/>";
                $html.= "<div style=\"border: 1px solid #CCCCCC; width: 200px; height: 100px; background: #FFFFFF; overflow-y: scroll;\">";
            foreach ($manufacturers as $manufacturer) { 
            	$html.= "<div><input type=\"checkbox\" name=\"anylist_module[$module_row][limitmanufacturer][]\" value=\"" . $manufacturer['manufacturer_id'] . "\" ".(($data and isset($data['limitmanufacturer']) and array_search($manufacturer['manufacturer_id'],$data['limitmanufacturer'])!==false) ? 'checked="checked"' : '')." />" . addslashes($manufacturer['name']) . "</div>";
            }
            $html.= "</div>";
            $html.= "</div>";
            	
            $html.= "<div id=\"limitcategory_$module_row\"><br/><b>$entry_category</b><br />";
                $html.= "<p style=\"width: 200px;\">$entry_limit_help</p>";
                $html.= "<div style=\"border: 1px solid #CCCCCC; width: 200px; height: 100px; background: #FFFFFF; overflow-y: scroll;\">";
                foreach ($categories as $category) {
                    $html.= "<div><input type=\"checkbox\" class=\"categories\" name=\"anylist_module[$module_row][limitcategory][]\" value=\"" . $category['category_id'] . "\" ".(($data and isset($data['limitcategory']) and array_search($category['category_id'],$data['limitcategory'])!==false) ? 'checked="checked"' : '')." />" . addslashes($category['name']) . "</div>";
                }
                $html.= "</div>";
        

   	    $html.= "</td>
        <td class=\"left\" style=\"padding-top: 6px; padding-bottom: 2px; vertical-align: top\">
                <select class=\"form-control\" name=\"anylist_module[$module_row][status]\">
                  <option ".(($data and $data['status']=='1') ? 'selected="selected"' : '')." value=\"1\" selected=\"selected\">$text_enabled</option>
                  <option ".(($data and $data['status']=='0') ? 'selected="selected"' : '')." value=\"0\">$text_disabled</option>
                </select>
        	
            	<br />$text_period<br/><input class=\"form-control datetime\" placeholder=\"Start date\" type=\"text\" size=\"12\" value=\"".(($data) ? trim($data['date_start']) : '')."\" name=\"anylist_module[$module_row][date_start]\"/> - <input class=\"form-control datetime\" placeholder=\"End date\" type=\"text\" size=\"12\" value=\"".(($data) ? trim($data['date_end']) : '')."\" name=\"anylist_module[$module_row][date_end]\"/>
        	
        </td>

        <td class=\"left\" style=\"vertical-align: top;\"><button class=\"btn btn-danger\" title=\"Remove\" data-toggle=\"tooltip\" onclick=\"$('#module-row$module_row').remove();\" type=\"button\"><i class=\"fa fa-minus-circle\"></i></button></td>              

    </tr>";
    
    $html.= "</tbody>";
           

    if (isset($this->request->get['Module'])) echo $html;
    
    return $html;


    }
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/anylist')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (isset($this->request->post['anylist_module'])) {
			foreach ($this->request->post['anylist_module'] as $key => $value) {
				if (!$value['width'] || !$value['height']) {
					$this->error['dimension'][$key] = $this->language->get('error_dimension');
				}			
			}
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>