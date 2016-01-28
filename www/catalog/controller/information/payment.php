<?php 
require 'system/class/phpmailer/PHPMailerAutoload.php';
class ControllerInformationPayment extends Controller {
	/**create by templateopencart.net**/
	private $error = array(); 
	    
  	public function index() {
	
        $this->language->load('information/payment');

    	$this->document->setTitle($this->language->get('heading_title'));  
	 
		$data['error_warning'] = "";
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
		
			if (isset($_FILES["file"]["name"]))
			{
				$imageFileType = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
				$target_dir = getcwd()."/image/payment/";
				$target_file = $target_dir . "slip".date("YmdHis").".".$imageFileType;
				$uploadOk = 1;
				
				$check = getimagesize($_FILES["file"]["tmp_name"]);
				
				if($check !== false) {
					//echo "File is an image - " . $check["mime"] . ".";
					$uploadOk = 1;
				} else {
					$data['error_warning'] .=  "File is not an image.";
					$uploadOk = 0;
				}
				
				// Check file size
				if ($_FILES["file"]["size"] > 5000000) {
					$data['error_warning'] .=  "Sorry, your file is too large.";
					$uploadOk = 0;
				}
				// Allow certain file formats
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" ) {
					$data['error_warning'] .=  "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
					$uploadOk = 0;
				}
				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 0) {
					$data['error_warning'] .=  "Sorry, your file was not uploaded.";
				// if everything is ok, try to upload file
				} else {
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
						//echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
					} else {
						$data['error_warning'] .= "Sorry, there was an error uploading your file.";
					}
				}
			}

			$str1 = '<span style="color:#000; padding-right:20px;" >' . $this->language->get('entry_enquiry') . '</span>' . $this->request->post['enquiry'];
			$str2 = '<span style="color:#000; padding-right:20px;" >' . $this->language->get('text_bank_account') . '</span>'.  $this->request->post['bank'];
			$str3=  '<span style="color:#000; padding-right:20px;" >' .$this->language->get('text_transfer_date') . '</span>'.  $this->request->post['transfer_date'];
			$str3.=  ' <span style="color:#000; padding-right:20px;" >' .$this->language->get('text_transfer_time') . '</span>'.  $this->request->post['transfer_time'];
			$str4=  '<span style="color:#000; padding-right:20px;" >' .$this->language->get('text_amount_paid')   . '</span>'.  $this->request->post['amount_paid'] .$this->language->get('text_curr_unit') ;
			$str5=  '<span style="color:#000; padding-right:20px;" >' .$this->language->get('text_orderno')       . '</span>'.  $this->request->post['orderno'] ;
			$str6=  '<span style="color:#000; padding-right:20px;" >' . $this->language->get('entry_name')         .'</span>'.  $this->request->post['name'];
			$str0 =  '<span style="color:#000; padding-right:20px;" >' . $this->language->get('entry_email') . '</span>' . $this->request->post['email'];
	        $str_subject= $this->language->get('email_subject') . '   '.  $this->request->post['orderno'];
			 

		    $str_massage =  '<div style="font-size:15px;
			               color:#FF6363; 
						   margin:0 auto; 
						   width:100%;
						   line-height:30px;
						   padding:80px 0 0 80px;
					    " >'. $str6 .'<br/> '.    
				$str5 . '<br/> '.   
				$str2 . '<br/> '.
				$str3 . '<br/> '. 
				$str4 . '<br/> '. 
				$str0 . '<br/> '. 
				$str1 . '</div>' ;
		 
			$mail = new PHPMailer;
			$mail->isSMTP();
			$mail->SMTPDebug = 0;
			$mail->SMTPSecure = "tls";
			$mail->Debugoutput = 'html';
			$mail->CharSet = 'UTF-8';
			$mail->Host = MAIL_HOST;
			$mail->Port = 587;
			$mail->SMTPAuth = true;
			$mail->Username = MAIL_USERNAME;
			$mail->Password = MAIL_PASSWORD;
			$mail->setFrom('customer@keentobuy.com', 'customer@keentobuy.com');
			$mail->addAddress('veeqed@gmail.com', 'veeqed@gmail.com');
			$mail->Subject = $str_subject;
			$mail->msgHTML($str_massage);

			$mail->AltBody = $str_massage;
			$mail->addAttachment($target_file);
			
			if (!$mail->send()) {
				echo "Mailer Error: " . $mail->ErrorInfo;
			} else {
				$this->response->redirect($this->url->link('information/payment/success'));
			}
    	}

      	$data['breadcrumbs'] = array();

      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),        	
        	'separator' => false
      	);

      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('information/payment'),
        	'separator' => $this->language->get('text_separator')
      	);	
			
    	$data['heading_title'] = $this->language->get('heading_title');
		$data['subhead'] = $this->language->get('subhead');

		$data['text_bank_account'] = $this->language->get('text_bank_account');
        $data['text_transfer_date'] = $this->language->get('text_transfer_date');
		$data['text_transfer_time'] = $this->language->get('text_transfer_time');
        $data['text_amount_paid'] = $this->language->get('text_amount_paid');
		$data['text_orderno'] = $this->language->get('text_orderno');
		$data['text_curr_unit'] = $this->language->get('text_curr_unit');
		$data['text_file'] = $this->language->get('text_file');
        $data['text_listbank_account'] = $this->language->get('text_listbank_account');
 


    	$data['entry_name'] = $this->language->get('entry_name');
    	$data['entry_email'] = $this->language->get('entry_email');
    	$data['entry_enquiry'] = $this->language->get('entry_enquiry');
		$data['entry_captcha'] = $this->language->get('entry_captcha');

		if (isset($this->error['name'])) {
    		$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

    	$data['button_continue'] = $this->language->get('button_continue');
    
		$data['action'] = $this->url->link('information/payment');
		$data['store'] = $this->config->get('config_name');
    	$data['address'] = nl2br($this->config->get('config_address'));
    	$data['telephone'] = $this->config->get('config_telephone');
    	$data['fax'] = $this->config->get('config_fax');
    	
		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} else {
			$data['name'] = $this->customer->getFirstName();
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} else {
			$data['email'] = $this->customer->getEmail();
		}


   /************************************/
		
		if (isset($this->request->post['transfer_date'])) {
			$data['transfer_date'] = $this->request->post['transfer_date'];
		} else {
			$data['transfer_date'] = '';
		}
		
		if (isset($this->request->post['transfer_time'])) {
			$data['transfer_time'] = $this->request->post['transfer_time'];
		} else {
			$data['transfer_time'] = '';
		}
 
        if (isset($this->error['transfer_date'])) {
    		$data['error_transfer_date'] = $this->error['transfer_date'];
		} else {
			$data['error_transfer_date'] = '';
		}

		if (isset($this->error['transfer_time'])) {
    		$data['error_transfer_time'] = $this->error['transfer_time'];
		} else {
			$data['error_transfer_time'] = '';
		}

		
		if (isset($this->request->post['orderno'])) {
			$data['orderno'] = $this->request->post['orderno'];
		} else {
			$data['orderno'] = '';
		}
		
          if (isset($this->error['orderno'])) {
    		$data['error_orderno'] = $this->error['orderno'];
		} else {
			$data['error_orderno'] = '';
		}


	   if (isset($this->request->post['amount_paid'])) {
			$data['amount_paid'] = $this->request->post['amount_paid'];
		} else {
			$data['amount_paid'] = '';
		}


        if (isset($this->error['amount_paid'])) {
    		$data['error_amount_paid'] = $this->error['amount_paid'];
		} else {
			$data['error_amount_paid'] = '';
		}

     	if (isset($this->request->post['bank'])) {
			$data['bank'] = $this->request->post['bank'];
		} else {
			$data['bank'] = '';
			
		}
		
        if (isset($this->error['bank'])) {
    		$data['error_bank'] = $this->error['bank'];
		} else {
			$data['error_bank'] = '';
		}
		
		if (isset($this->error['email'])) {
    		$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

    /************************************/


 


		if (isset($this->request->post['enquiry'])) {
			$data['enquiry'] = $this->request->post['enquiry'] ;
		} else {
			$data['enquiry'] = '';
		}


		
		if (isset($this->request->post['captcha'])) {
			$data['captcha'] = $this->request->post['captcha'];
		} else {
			$data['captcha'] = '';
		}		

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/payment.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/payment.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/information/payment.tpl', $data));
		}
  	}

  	public function success() {
		$this->language->load('information/payment');

		$this->document->setTitle($this->language->get('heading_title')); 

      	$data['breadcrumbs'] = array();

      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
        	'separator' => false
      	);

      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('information/payment'),
        	'separator' => $this->language->get('text_separator')
      	);	
		
    	$data['heading_title'] = $this->language->get('heading_title');

    	$data['text_message'] = $this->language->get('text_message');

    	$data['button_continue'] = $this->language->get('button_continue');

    	$data['continue'] = $this->url->link('common/home');
		
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/success.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/common/success.tpl', $data));
		}
	}
	
  	protected function validate() {

    	if (utf8_strlen($this->request->post['name']) == 0) {
      		$this->error['name'] = $this->language->get('error_massage');
    	}
      
        if (utf8_strlen($this->request->post['orderno']) == 0) {
      		$this->error['orderno'] = $this->language->get('error_massage');
    	}

       if (!isset($this->request->post['bank']))  {
      		$this->error['bank'] =  $this->language->get('error_bank_acc');
    	}
        if (!is_numeric($this->request->post['amount_paid'])  or  utf8_strlen($this->request->post['amount_paid']) == 0 )   {
      		$this->error['amount_paid'] =  $this->language->get('error_massage');
    	}

        if (utf8_strlen($this->request->post['transfer_date']) == 0)  {
      		$this->error['transfer_date']  =  $this->language->get('error_massage');
    	}
		
		$date_regex = '/^(19|20)\d\d[\-\/.](0[1-9]|1[012])[\-\/.](0[1-9]|[12][0-9]|3[01])$/';
		
		if (!preg_match($date_regex, $this->request->post['transfer_date'])) {
			$this->error['transfer_date']  =  $this->language->get('error_date');
		}
		
		$time_regex = "/(\d{2}):(\d{2})$/";
		
		if (!preg_match($time_regex, $this->request->post['transfer_time'])) {
			$this->error['transfer_time']  =  $this->language->get('error_time');
		}

		if (!filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['email']  =  $this->language->get('error_email');
		}

		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}  	  
  	}

	public function captcha() {
		$this->load->library('captcha');
		
		$captcha = new Captcha();
		
		$this->session->data['captcha'] = $captcha->getCode();
		
		$captcha->showImage();
	}	
}
?>
