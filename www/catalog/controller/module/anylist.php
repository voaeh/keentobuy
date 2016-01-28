<?php
// Limit length of description returned with list of all products
define('DESCRIPTION_LIMIT_CHARS',300);
  

class ControllerModuleAnylist extends Controller {
	public function index($setting) {
		$enabled = true;

		$enabled = ($enabled and (!isset($setting['date_start']) or trim($setting['date_start'])=='' or strtotime($setting['date_start'])<time()) );
		$enabled = ($enabled and (!isset($setting['date_end']) or trim($setting['date_end'])=='' or strtotime($setting['date_end'])>time()) );

		if ($enabled) {
			$languageId = $this->config->get('config_language_id');
	        $data = array();
	   		//$data['heading_title'] = $setting['title'][2];
			$data['heading_title'] = "";
			$data['button_cart'] = $this->language->get('button_cart');
	
			//$data['titlelink']  = (empty($setting['titlelink']) and !empty($setting['code'])) ? $this->url->link('module/anylist/listall', 'list_id=' . $setting['code']) : $setting['titlelink'];
			$data['titlelink']  = "";
			$data['latest']     = (isset($setting['latest'])) ? (int) $setting['latest'] : 0;
			$data['specials']   = (isset($setting['specials'])) ? (int) $setting['specials'] : 0;
			$data['grid']       = (isset($setting['view'])) ? ((int) $setting['view'] > 0): false;

		
	        $data['products']   = $this->GetProducts($setting,false);
	            
			$data['button_cart'] = $this->language->get('button_cart');
			$data['button_wishlist'] = $this->language->get('button_wishlist');
			$data['button_compare'] = $this->language->get('button_compare');
			$data['text_tax']       = $this->language->get('text_tax');
			$data['button_grid'] = $this->language->get('button_grid');
			$data['button_list'] = $this->language->get('button_list');
	        
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/anylist.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/anylist.tpl';
			} else {
				$this->template = 'default/template/module/anylist.tpl';
			}
	
			return $this->load->view($this->template, $data);
		}
	}
    
    
	public function listall() {
		$languageId = $this->config->get('config_language_id');
		$this->language->load('product/category');

        $data = array();
		$data['text_refine'] = $this->language->get('text_refine');
		$data['text_empty'] = $this->language->get('text_empty');			
		$data['text_quantity'] = $this->language->get('text_quantity');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_model'] = $this->language->get('text_model');
		$data['text_tax'] = $this->language->get('text_tax');
		$data['text_price'] = $this->language->get('text_price');
		$data['text_tax'] = $this->language->get('text_tax');
		$data['text_points'] = $this->language->get('text_points');
		$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
		$data['text_display'] = $this->language->get('text_display');
		$data['text_list'] = $this->language->get('text_list');
		$data['text_grid'] = $this->language->get('text_grid');
		$data['text_sort'] = $this->language->get('text_sort');
		$data['text_limit'] = $this->language->get('text_limit');
				
		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_grid'] = $this->language->get('button_grid');
		$data['button_list'] = $this->language->get('button_list');

		$data['compare'] = $this->url->link('product/compare');

		if (  isset($this->request->get['list_id']) ) {
	        $conf = $this->config->get('anylist_module');   
            foreach($conf as $box_config) {
                if ($box_config['code']==$this->request->get['list_id']) {
                    $setting = $box_config;
                    break 1;
                }
            }
			$data['products'] = $this->GetProducts($setting,true);
			$data['heading_title'] =  $setting['title'][$languageId];
			$product_total = count($data['products']);
        } else {
            $data['products'] = array();
		    $data['heading_title'] = $this->language->get('text_empty');
		    $product_total = 0;
		}
			


		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else { 
			$page = 1;
		}	
							
		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_catalog_limit');
		}
							
		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
       		'separator' => false
   		);	
			
   		$data['breadcrumbs'][] = array(
       		'text'      => $data['heading_title'],
			'href'      => $this->url->link('module/anylist/listall','&list_id='.$this->request->get['list_id']),
       		'separator' => $this->language->get('text_separator')
   		);	
			

		$url = '';
		if (isset($this->request->get['limit'])) {
		$url .= '&limit=' . $this->request->get['limit'];
		}
				

		$data['sorts'] = array();
		$data['limits'] = array();
		$data['thumb'] = false;
		$data['description'] = false;
		$data['categories'] = array();

		$limits = array_unique(array($this->config->get('config_catalog_limit'), 25, 50, 75, 100));
    	sort($limits);

		foreach($limits as $limits){
			$data['limits'][] = array(
				'text'  => $limits,
				'value' => $limits,
				'href'  => $this->url->link('module/anylist/listall/', 'list_id=' . $this->request->get['list_id'] . '&limit=' . $limits)
			);
		}
		
		$data['sorts'][] = array(
			'text'  => $this->language->get('text_default'),
			'value' => '',
			'href'  => $this->url->link('module/anylist/listall', 'list_id=' . $this->request->get['list_id'] . $url)
		);
		
		

        
	
		$data['sort'] = '';
		$data['order'] = '';
		$data['limit'] = $limit;
	
		$data['continue'] = $this->url->link('common/home');

        if ($product_total<$limit or $limit==0) {
            $data['results'] = sprintf($this->language->get('text_pagination'), 1, $product_total, $product_total, 1);
    		$data['pagination'] = '';
        } else {
    		$pagination = new Pagination();
    		$pagination->total = $product_total;
    		$pagination->page = $page;
    		$pagination->limit = $limit;
    		$pagination->text = $this->language->get('text_pagination');
    		$pagination->url = $this->url->link('module/anylist/listall', 'list_id=' . $this->request->get['list_id'] . $url . '&page={page}');
    	
    		$data['pagination'] = $pagination->render();

            $data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));
        }


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/category.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/product/category.tpl';
		} else {
			$this->template = 'default/template/product/category.tpl';
		}
		

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
			

				
		$this->response->setOutput( $this->load->view($this->template, $data) );
			
	}
    
    
    protected function GetProducts($setting,$returnAllProducts=false) {
		$this->load->model('module/anylist');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
        
        $resultingProducts = array();
		
        $limitcat = (isset($setting['limitcategory'])) ? $setting['limitcategory'] : array();		
        $limitman = (isset($setting['limitmanufacturer'])) ? $setting['limitmanufacturer'] : array();	
        
	    $filter = false;

		if (!isset($this->request->get['route']))
		{
			$this->request->get['route'] = 'common/home';
		}
		
        if (stripos($this->request->get['route'],'product/category')!==false and stripos($this->request->get['route'],'product/category')!==false)
            $filter = 'category'; 
        elseif (stripos($this->request->get['route'],'product/manufacturer')!==false and stripos($this->request->get['route'],'product/manufacturer')!==false)
            $filter = 'manufacturer'; 
        elseif (stripos($this->request->get['route'],'product/product')!==false and stripos($this->request->get['route'],'product/product')!==false)
            $filter = 'product'; 
        else
            $filter = false;
            
        $ok = true;

		if ($filter=='category' and is_array($limitcat) and count($limitcat)>0 and isset($this->request->get['path'])) {
			$path = explode("_",$this->request->get['path']);
			$curr_cat = $path[count($path)-1];
			$ok = ($ok and array_search($curr_cat,$limitcat)!==false);
		}		
		 
		if ($filter=='manufacturer' and is_array($limitman) and count($limitman)>0) {
			$curr_man = (isset($this->request->get['manufacturer_id'])) ? (int) $this->request->get['manufacturer_id'] : 0;
			$ok = ($ok and array_search($curr_man,$limitman)!==false);
           
		}		
		 
		if ($filter=='product' and ((is_array($limitman) and count($limitman)>0) or (is_array($limitcat) and count($limitcat)>0)) and isset($this->request->get['product_id'])) {
			$curr_pro = (int) $this->request->get['product_id'];
			$myProduct = $this->model_catalog_product->getProduct($curr_pro);
			if ($ok and is_array($limitman) and count($limitman)>0)
				$ok = ($ok and array_search($myProduct['manufacturer_id'],$limitman)!==false);
				
			if ($ok and is_array($limitcat) and count($limitcat)>0) {
				$rc = $this->model_catalog_product->getCategories($curr_pro);

                $ok2 = false;

				// If ANY of product's category exists in filter  
                foreach($rc as $c) {
                    $ok2 = ($ok2 OR array_search($c['category_id'],$limitcat)!==false);
                }

				// If EXACT of product's categories exists in filter  
				//foreach($rc as $c) {
				//	$ok2 = ($ok2 AND array_search($c['category_id'],$limitcat)!==false);
				//} 
                $ok = ($ok AND $ok2);
			}
		}
		

		if (!$filter or $ok) {
			$category = (isset($setting['category'])) ? $setting['category'] : array(); 
			// SORTING OF LIST:
			//	 'sort' is field of product table (only product table - no names, no descriptions)
			//   'order' is ASC / DESC order
			$products = $this->model_module_anylist->getProductsID( array(
																			'category'=>$category, 
																			'products'=>(isset($setting['products'])) ? $setting['products'] : array(), 
																			'latest'=>(isset($setting['latest'])) ? (int) $setting['latest'] : 0,
																			'specials'=>(isset($setting['specials'])) ? (int) $setting['specials'] : 0,
																			'date_start'=>(isset($setting['date_start']) ? $setting['date_start'] : ''),
																			'date_end'=>(isset($setting['date_end']) ? $setting['date_end'] : ''),
																			'sort'=>(isset($setting['sortfield']) ? $setting['sortfield'] : ''),
																			'order'=>(isset($setting['sortorder']) ? $setting['sortorder'] : '') 
																			) 
																	);
                                                                    
			//$limit = ($setting['limit']>count($products) or $returnAllProducts) ? count($products) : intval($setting['limit']); 
				
			$limit = 50;
	        if (count($products)<$limit or $limit==0 or count($products)==1) {
	            $results = array_keys($products);
	        } else  {
	    		$results = ($limit>2) ? array_rand($products,$limit) : array( rand(0,count($products)-1) );
	        }
            
            
			foreach ($results as $pid) {

				$result = (isset($products[$pid]) and $products[$pid]>0) ? $this->model_catalog_product->getProduct($products[$pid]) : false;
				if ($result) {
    				if ($result['image']) {
    					$image = $this->model_tool_image->resize($result['image'], 200, 200);
					} else {
						$image = false;
					}
								
					if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$price = false;
					}
							
					if ((float)$result['special']) {
						$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$special = false;
					}
					
    				if ($this->config->get('config_tax')) {
    					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
    				} else {
    					$tax = false;
    				}				
    				
					if ($this->config->get('config_review_status')) {
						$rating = $result['rating'];
					} else {
						$rating = false;
					}
					
                  if ($returnAllProducts) {
				    $description = utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '...';
                  } else {
                    $description = html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8');
                  }
                    
                  $resultingProducts[] = array(
						'product_id' => $result['product_id'],
						'thumb'   	 => $image,
						'name'    	 => $result['name'],
						'description'=> utf8_substr(strip_tags(html_entity_decode($description, ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
						'price'   	 => $price,
						'special' 	 => $special,
                        'tax'        => $tax,
						'rating'     => $rating,
						'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
						'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
					);
				}
			}
		} else {
			$resultingProducts = array();
		}  
        
        return $resultingProducts;
        
    }
 
}
?>