<?php
class ControllerModuleMinewhat extends Controller {

	private $error = array();

	public function index() {

		$this->load->language('module/minewhat');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$this->model_setting_setting->editSetting('minewhat', $this->request->post);

			if($this->request->post['minewhat_enable'] == '1') {
				if(strlen($this->request->post['minewhat_domain_id']) > 0) {
					$this->session->data['success'] = $this->language->get('message_enabled');
					$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
				} else {
					$this->error['warning'] = $this->language->get('message_warning');
				}
			} else {
				$this->error['warning'] = $this->language->get('message_disabled');
			}

		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_domain_id'] = $this->language->get('text_domain_id');

		$this->data['text_enable'] = $this->language->get('text_enable');

		$this->data['option_enable'] = $this->language->get('option_enable');
		$this->data['option_disable'] = $this->language->get('option_disable');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

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
     		'text'      => $this->language->get('text_module'),
		'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
    		'separator' => ' :: '
 		);

 		$this->data['breadcrumbs'][] = array(
     		'text'      => $this->language->get('heading_title'),
		'href'      => $this->url->link('module/minewhat', 'token=' . $this->session->data['token'], 'SSL'),
    		'separator' => ' :: '
 		);

		$this->data['action'] = $this->url->link('module/minewhat', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');


		if (isset($this->request->post['minewhat_domain_id'])) {
			$this->data['minewhat_domain_id'] = $this->request->post['minewhat_domain_id'];
		} else {
			$this->data['minewhat_domain_id'] = $this->config->get('minewhat_domain_id');
		}

		if (isset($this->request->post['minewhat_enable'])) {
			$this->data['minewhat_enable'] = $this->request->post['minewhat_enable'];
		} else {
			$this->data['minewhat_enable'] = $this->config->get('minewhat_enable');
		}

		$this->load->model('design/layout');

		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->template = 'module/minewhat.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());

	}

}
?>
