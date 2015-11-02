<?php
class ControllerShippingAlwZaberi extends Controller {
	private $error = array();
	
	public function index() {
		$this->language->load('shipping/alw_zaberi');

		$this->document->setTitle($this->language->get('heading_title_fake'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate_modify()) {
			$this->model_setting_setting->editSetting('alw_zaberi', $this->request->post['settings']);
			$this->model_setting_setting->editSetting('alw_zaberi_courier', $this->request->post['courier']);
			$this->model_setting_setting->editSetting('alw_zaberi_pickup', $this->request->post['pickup']);
			$this->model_setting_setting->editSetting('alw_zaberi_pochta', $this->request->post['pochta']);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('shipping/alw_zaberi', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['button_settings'] = $this->language->get('button_settings');
		$this->data['button_orders'] = $this->language->get('button_orders');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->data['tab_settings'] = $this->language->get('tab_settings');
		$this->data['tab_courier'] = $this->language->get('tab_courier');
		$this->data['tab_pickup'] = $this->language->get('tab_pickup');
		$this->data['tab_pochta'] = $this->language->get('tab_pochta');
		$this->data['tab_export'] = $this->language->get('tab_export');
		$this->data['tab_status'] = $this->language->get('tab_status');
		$this->data['entry_login'] = $this->language->get('entry_login');
		$this->data['entry_key'] = $this->language->get('entry_key');
		$this->data['entry_country'] = $this->language->get('entry_country');
		$this->data['entry_weight_class'] = $this->language->get('entry_weight_class');
		$this->data['entry_paied_order'] = $this->language->get('entry_paied_order');
		$this->data['entry_default_weight'] = $this->language->get('entry_default_weight');
		$this->data['entry_added_weight'] = $this->language->get('entry_added_weight');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_cache'] = $this->language->get('entry_cache');
		$this->data['entry_debug'] = $this->language->get('entry_debug');
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_desc_courier'] = $this->language->get('entry_desc_courier');
		$this->data['entry_desc_pickup'] = $this->language->get('entry_desc_pickup');
		$this->data['entry_desc_pochta'] = $this->language->get('entry_desc_pochta');
		$this->data['entry_logo'] = $this->language->get('entry_logo');
		$this->data['entry_map'] = $this->language->get('entry_map');
		$this->data['entry_min_cost'] = $this->language->get('entry_min_cost');
		$this->data['entry_max_cost'] = $this->language->get('entry_max_cost');
		$this->data['entry_status_rus'] = $this->language->get('entry_status_rus');
		$this->data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_zone'] = $this->language->get('entry_zone');
		$this->data['entry_pochta_cost'] = $this->language->get('entry_pochta_cost');
		$this->data['entry_start_pv'] = $this->language->get('entry_start_pv');
		$this->data['entry_rupost'] = $this->language->get('entry_rupost');
		$this->data['entry_zip_c'] = $this->language->get('entry_zip_c');
		$this->data['entry_client_city_c'] = $this->language->get('entry_client_city_c');
		$this->data['entry_address_c'] = $this->language->get('entry_address_c');
		$this->data['entry_client_name_c'] = $this->language->get('entry_client_name_c');
		$this->data['entry_org'] = $this->language->get('entry_org');
		$this->data['entry_izip'] = $this->language->get('entry_izip');
		$this->data['entry_icity'] = $this->language->get('entry_icity');
		$this->data['entry_iaddress'] = $this->language->get('entry_iaddress');
		$this->data['entry_iname'] = $this->language->get('entry_iname');
		$this->data['entry_iinn'] = $this->language->get('entry_iinn');
		$this->data['entry_ibank'] = $this->language->get('entry_ibank');
		$this->data['entry_irs'] = $this->language->get('entry_irs');
		$this->data['entry_iks'] = $this->language->get('entry_iks');
		$this->data['entry_ibik'] = $this->language->get('entry_ibik');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_pochta_without'] = $this->language->get('text_pochta_without');
		$this->data['text_pochta_with'] = $this->language->get('text_pochta_with');
		$this->data['text_pochta_ur'] = $this->language->get('text_pochta_ur');
		$this->data['text_status_export'] = $this->language->get('text_status_export');
		$this->data['text_status_order'] = $this->language->get('text_status_order');
		$this->data['text_export_success_1'] = $this->language->get('text_export_success_1');
		$this->data['text_export_success_2'] = $this->language->get('text_export_success_2');
		$this->data['text_export_success_3'] = $this->language->get('text_export_success_3');
		$this->data['text_export_success_5'] = $this->language->get('text_export_success_5');
		$this->data['text_export_success_10'] = $this->language->get('text_export_success_10');
		$this->data['text_export_success_49'] = $this->language->get('text_export_success_49');
		$this->data['text_export_success_50'] = $this->language->get('text_export_success_50');
		$this->data['text_export_success_51'] = $this->language->get('text_export_success_51');
		$this->data['text_export_success_11'] = $this->language->get('text_export_success_11');
		$this->data['text_export_success_12'] = $this->language->get('text_export_success_12');
		$this->data['text_export_success_30'] = $this->language->get('text_export_success_30');
		$this->data['text_export_success_31'] = $this->language->get('text_export_success_31');
		$this->data['text_export_success_32'] = $this->language->get('text_export_success_32');
		$this->data['text_export_success_33'] = $this->language->get('text_export_success_33');
		$this->data['text_export_success_34'] = $this->language->get('text_export_success_34');
		$this->data['text_export_success_35'] = $this->language->get('text_export_success_35');
		$this->data['text_export_success_39'] = $this->language->get('text_export_success_39');
		$this->data['text_export_success_40'] = $this->language->get('text_export_success_40');
		$this->data['text_export_success_48'] = $this->language->get('text_export_success_48');
		$this->data['text_export_success_99'] = $this->language->get('text_export_success_99');

		if (isset($this->session->data['warning'])) {
			$this->data['warning'] = $this->session->data['warning'];

			unset($this->session->data['warning']);
		} else {
			$this->data['warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
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
			'href'      => $this->url->link('shipping/alw_zaberi', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['orders'] = $this->url->link('shipping/alw_zaberi/orders', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action'] = $this->url->link('shipping/alw_zaberi', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['update'] = $this->url->link('shipping/alw_zaberi/update', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['settings']['alw_zaberi_login'])) {
			$this->data['alw_zaberi_login'] = $this->request->post['settings']['alw_zaberi_login'];
		} else {
			$this->data['alw_zaberi_login'] = $this->config->get('alw_zaberi_login');
		}

		if (isset($this->request->post['settings']['alw_zaberi_key'])) {
			$this->data['alw_zaberi_key'] = $this->request->post['settings']['alw_zaberi_key'];
		} else {
			$this->data['alw_zaberi_key'] = $this->config->get('alw_zaberi_key');
		}

		if (isset($this->request->post['settings']['alw_zaberi_title'])) {
			$this->data['alw_zaberi_title'] = $this->request->post['settings']['alw_zaberi_title'];
		} else {
			$this->data['alw_zaberi_title'] = $this->config->get('alw_zaberi_title');
		}

		$this->load->model('localisation/country');

		$this->data['countries'] = $this->model_localisation_country->getCountries();

		if (isset($this->request->post['settings']['alw_zaberi_country'])) {
			$this->data['alw_zaberi_country'] = $this->request->post['settings']['alw_zaberi_country'];
		} else {
			$this->data['alw_zaberi_country'] = $this->config->get('alw_zaberi_country');
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();	

		if (isset($this->request->post['settings']['alw_zaberi_order_status_id'])) {
			$this->data['alw_zaberi_order_status_id'] = $this->request->post['settings']['alw_zaberi_order_status_id'];
		} else {
			$this->data['alw_zaberi_order_status_id'] = $this->config->get('alw_zaberi_order_status_id');		
		}

		if (isset($this->request->post['settings']['alw_zaberi_weight_class_id'])) {
			$this->data['alw_zaberi_weight_class_id'] = $this->request->post['settings']['alw_zaberi_weight_class_id'];
		} else {
			$this->data['alw_zaberi_weight_class_id'] = $this->config->get('alw_zaberi_weight_class_id');
		}

		if (isset($this->request->post['settings']['alw_zaberi_default_weight'])) {
			$this->data['alw_zaberi_default_weight'] = $this->request->post['settings']['alw_zaberi_default_weight'];
		} else {
			$this->data['alw_zaberi_default_weight'] = $this->config->get('alw_zaberi_default_weight');
		}

		if (isset($this->request->post['settings']['alw_zaberi_added_weight'])) {
			$this->data['alw_zaberi_added_weight'] = $this->request->post['settings']['alw_zaberi_added_weight'];
		} elseif ($this->config->get('alw_zaberi_added_weight')) {
			$this->data['alw_zaberi_added_weight'] = $this->config->get('alw_zaberi_added_weight');
		} else {
			$this->data['alw_zaberi_added_weight'] = 0;
		}

		if (isset($this->request->post['settings']['alw_zaberi_sort_order'])) {
			$this->data['alw_zaberi_sort_order'] = $this->request->post['settings']['alw_zaberi_sort_order'];
		} elseif ($this->config->get('alw_zaberi_sort_order')) {
			$this->data['alw_zaberi_sort_order'] = $this->config->get('alw_zaberi_sort_order');
		} else {
			$this->data['alw_zaberi_sort_order'] = 0;
		}		

		if (isset($this->request->post['settings']['alw_zaberi_status'])) {
			$this->data['alw_zaberi_status'] = $this->request->post['settings']['alw_zaberi_status'];
		} else {
			$this->data['alw_zaberi_status'] = $this->config->get('alw_zaberi_status');
		}

		if (isset($this->request->post['settings']['alw_zaberi_cache'])) {
			$this->data['alw_zaberi_cache'] = $this->request->post['settings']['alw_zaberi_cache'];
		} else {
			$this->data['alw_zaberi_cache'] = $this->config->get('alw_zaberi_cache');
		}

		if (isset($this->request->post['settings']['alw_zaberi_debug'])) {
			$this->data['alw_zaberi_debug'] = $this->request->post['settings']['alw_zaberi_debug'];
		} else {
			$this->data['alw_zaberi_debug'] = $this->config->get('alw_zaberi_debug');
		}

		$this->load->model('localisation/weight_class');
		
		$this->data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

		$this->load->model('localisation/tax_class');
		
		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		$this->load->model('localisation/geo_zone');
		
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		$this->load->model('localisation/zone');

		$this->data['zones'] = $this->model_localisation_zone->getZonesByCountryId($this->config->get('alw_zaberi_country'));

		// courier
		if (isset($this->request->post['courier']['alw_zaberi_description_courier'])) {
			$this->data['alw_zaberi_description_courier'] = $this->request->post['courier']['alw_zaberi_description_courier'];
		} else {
			$this->data['alw_zaberi_description_courier'] = $this->config->get('alw_zaberi_description_courier');
		}

		if (isset($this->request->post['courier']['alw_zaberi_sort_courier'])) {
			$this->data['alw_zaberi_sort_courier'] = $this->request->post['courier']['alw_zaberi_sort_courier'];
		} else {
			$this->data['alw_zaberi_sort_courier'] = $this->config->get('alw_zaberi_sort_courier');
		}
		
		if (isset($this->request->post['courier']['alw_zaberi_visible_courier'])) {
			$this->data['alw_zaberi_visible_courier'] = $this->request->post['courier']['alw_zaberi_visible_courier'];
		} elseif ($this->config->get('alw_zaberi_visible_courier')) {
			$this->data['alw_zaberi_visible_courier'] = $this->config->get('alw_zaberi_visible_courier');
		} else {
			$this->data['alw_zaberi_visible_courier'] = array();
		}	

		if (isset($this->request->post['courier']['alw_zaberi_min_cost_courier'])) {
			$this->data['alw_zaberi_min_cost_courier'] = $this->request->post['courier']['alw_zaberi_min_cost_courier'];
		} else {
			$this->data['alw_zaberi_min_cost_courier'] = $this->config->get('alw_zaberi_min_cost_courier');
		}

		if (isset($this->request->post['courier']['alw_zaberi_max_cost_courier'])) {
			$this->data['alw_zaberi_max_cost_courier'] = $this->request->post['courier']['alw_zaberi_max_cost_courier'];
		} else {
			$this->data['alw_zaberi_max_cost_courier'] = $this->config->get('alw_zaberi_max_cost_courier');
		}

		if (isset($this->request->post['courier']['alw_zaberi_status_rus_courier'])) {
			$this->data['alw_zaberi_status_rus_courier'] = $this->request->post['courier']['alw_zaberi_status_rus_courier'];
		} else {
			$this->data['alw_zaberi_status_rus_courier'] = $this->config->get('alw_zaberi_status_rus_courier');
		}

		if (isset($this->request->post['courier']['alw_zaberi_tax_class_id_courier'])) {
			$this->data['alw_zaberi_tax_class_id_courier'] = $this->request->post['courier']['alw_zaberi_tax_class_id_courier'];
		} else {
			$this->data['alw_zaberi_tax_class_id_courier'] = $this->config->get('alw_zaberi_tax_class_id_courier');
		}

		if (isset($this->request->post['courier']['alw_zaberi_geo_zone_id_courier'])) {
			$this->data['alw_zaberi_geo_zone_id_courier'] = $this->request->post['courier']['alw_zaberi_geo_zone_id_courier'];
		} else {
			$this->data['alw_zaberi_geo_zone_id_courier'] = $this->config->get('alw_zaberi_geo_zone_id_courier');
		}

		if (isset($this->request->post['courier']['alw_zaberi_status_courier'])) {
			$this->data['alw_zaberi_status_courier'] = $this->request->post['courier']['alw_zaberi_status_courier'];
		} else {
			$this->data['alw_zaberi_status_courier'] = $this->config->get('alw_zaberi_status_courier');
		}

		// pickup
		if (isset($this->request->post['pickup']['alw_zaberi_description_pickup'])) {
			$this->data['alw_zaberi_description_pickup'] = $this->request->post['pickup']['alw_zaberi_description_pickup'];
		} else {
			$this->data['alw_zaberi_description_pickup'] = $this->config->get('alw_zaberi_description_pickup');
		}

		if (isset($this->request->post['pickup']['alw_zaberi_map_pickup'])) {
			$this->data['alw_zaberi_map_pickup'] = $this->request->post['pickup']['alw_zaberi_map_pickup'];
		} else {
			$this->data['alw_zaberi_map_pickup'] = $this->config->get('alw_zaberi_map_pickup');
		}

		if (isset($this->request->post['pickup']['alw_zaberi_visible_pickup'])) {
			$this->data['alw_zaberi_visible_pickup'] = $this->request->post['pickup']['alw_zaberi_visible_pickup'];
		} elseif ($this->config->get('alw_zaberi_visible_pickup')) {
			$this->data['alw_zaberi_visible_pickup'] = $this->config->get('alw_zaberi_visible_pickup');
		} else {
			$this->data['alw_zaberi_visible_pickup'] = array();
		}	

		if (isset($this->request->post['pickup']['alw_zaberi_min_cost_pickup'])) {
			$this->data['alw_zaberi_min_cost_pickup'] = $this->request->post['pickup']['alw_zaberi_min_cost_pickup'];
		} else {
			$this->data['alw_zaberi_min_cost_pickup'] = $this->config->get('alw_zaberi_min_cost_pickup');
		}

		if (isset($this->request->post['pickup']['alw_zaberi_max_cost_pickup'])) {
			$this->data['alw_zaberi_max_cost_pickup'] = $this->request->post['pickup']['alw_zaberi_max_cost_pickup'];
		} else {
			$this->data['alw_zaberi_max_cost_pickup'] = $this->config->get('alw_zaberi_max_cost_pickup');
		}

		if (isset($this->request->post['pickup']['alw_zaberi_status_rus_pickup'])) {
			$this->data['alw_zaberi_status_rus_pickup'] = $this->request->post['pickup']['alw_zaberi_status_rus_pickup'];
		} else {
			$this->data['alw_zaberi_status_rus_pickup'] = $this->config->get('alw_zaberi_status_rus_pickup');
		}

		if (isset($this->request->post['pickup']['alw_zaberi_tax_class_id_pickup'])) {
			$this->data['alw_zaberi_tax_class_id_pickup'] = $this->request->post['pickup']['alw_zaberi_tax_class_id_pickup'];
		} else {
			$this->data['alw_zaberi_tax_class_id_pickup'] = $this->config->get('alw_zaberi_tax_class_id_pickup');
		}

		if (isset($this->request->post['pickup']['alw_zaberi_geo_zone_id_pickup'])) {
			$this->data['alw_zaberi_geo_zone_id_pickup'] = $this->request->post['pickup']['alw_zaberi_geo_zone_id_pickup'];
		} else {
			$this->data['alw_zaberi_geo_zone_id_pickup'] = $this->config->get('alw_zaberi_geo_zone_id_pickup');
		}

		if (isset($this->request->post['pickup']['alw_zaberi_status_pickup'])) {
			$this->data['alw_zaberi_status_pickup'] = $this->request->post['pickup']['alw_zaberi_status_pickup'];
		} else {
			$this->data['alw_zaberi_status_pickup'] = $this->config->get('alw_zaberi_status_pickup');
		}

		// pochta
		if (isset($this->request->post['pochta']['alw_zaberi_description_pochta'])) {
			$this->data['alw_zaberi_description_pochta'] = $this->request->post['pochta']['alw_zaberi_description_pochta'];
		} else {
			$this->data['alw_zaberi_description_pochta'] = $this->config->get('alw_zaberi_description_pochta');
		}

		if (isset($this->request->post['pochta']['alw_zaberi_cost_pochta'])) {
			$this->data['alw_zaberi_cost_pochta'] = $this->request->post['pochta']['alw_zaberi_cost_pochta'];
		} else {
			$this->data['alw_zaberi_cost_pochta'] = $this->config->get('alw_zaberi_cost_pochta');
		}

		if (isset($this->request->post['pochta']['alw_zaberi_min_cost_pochta'])) {
			$this->data['alw_zaberi_min_cost_pochta'] = $this->request->post['pochta']['alw_zaberi_min_cost_pochta'];
		} else {
			$this->data['alw_zaberi_min_cost_pochta'] = $this->config->get('alw_zaberi_min_cost_pochta');
		}

		if (isset($this->request->post['pochta']['alw_zaberi_max_cost_pochta'])) {
			$this->data['alw_zaberi_max_cost_pochta'] = $this->request->post['pochta']['alw_zaberi_max_cost_pochta'];
		} else {
			$this->data['alw_zaberi_max_cost_pochta'] = $this->config->get('alw_zaberi_max_cost_pochta');
		}

		if (isset($this->request->post['pochta']['alw_zaberi_status_rus_pochta'])) {
			$this->data['alw_zaberi_status_rus_pochta'] = $this->request->post['pochta']['alw_zaberi_status_rus_pochta'];
		} else {
			$this->data['alw_zaberi_status_rus_pochta'] = $this->config->get('alw_zaberi_status_rus_pochta');
		}

		if (isset($this->request->post['pochta']['alw_zaberi_tax_class_id_pochta'])) {
			$this->data['alw_zaberi_tax_class_id_pochta'] = $this->request->post['pochta']['alw_zaberi_tax_class_id_pochta'];
		} else {
			$this->data['alw_zaberi_tax_class_id_pochta'] = $this->config->get('alw_zaberi_tax_class_id_pochta');
		}

		if (isset($this->request->post['pochta']['alw_zaberi_geo_zone_id_pochta'])) {
			$this->data['alw_zaberi_geo_zone_id_pochta'] = $this->request->post['pochta']['alw_zaberi_geo_zone_id_pochta'];
		} else {
			$this->data['alw_zaberi_geo_zone_id_pochta'] = $this->config->get('alw_zaberi_geo_zone_id_pochta');
		}

		if (isset($this->request->post['pochta']['alw_zaberi_status_pochta'])) {
			$this->data['alw_zaberi_status_pochta'] = $this->request->post['pochta']['alw_zaberi_status_pochta'];
		} else {
			$this->data['alw_zaberi_status_pochta'] = $this->config->get('alw_zaberi_status_pochta');
		}

		// export
		if (isset($this->request->post['settings']['alw_zaberi_export_start_pv'])) {
			$this->data['alw_zaberi_export_start_pv'] = $this->request->post['settings']['alw_zaberi_export_start_pv'];
		} else {
			$this->data['alw_zaberi_export_start_pv'] = $this->config->get('alw_zaberi_export_start_pv');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_rupost'])) {
			$this->data['alw_zaberi_export_rupost'] = $this->request->post['settings']['alw_zaberi_export_rupost'];
		} else {
			$this->data['alw_zaberi_export_rupost'] = $this->config->get('alw_zaberi_export_rupost');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_zip_c'])) {
			$this->data['alw_zaberi_export_zip_c'] = $this->request->post['settings']['alw_zaberi_export_zip_c'];
		} else {
			$this->data['alw_zaberi_export_zip_c'] = $this->config->get('alw_zaberi_export_zip_c');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_client_city_c'])) {
			$this->data['alw_zaberi_export_client_city_c'] = $this->request->post['settings']['alw_zaberi_export_client_city_c'];
		} else {
			$this->data['alw_zaberi_export_client_city_c'] = $this->config->get('alw_zaberi_export_client_city_c');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_address_c'])) {
			$this->data['alw_zaberi_export_address_c'] = $this->request->post['settings']['alw_zaberi_export_address_c'];
		} else {
			$this->data['alw_zaberi_export_address_c'] = $this->config->get('alw_zaberi_export_address_c');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_client_name_c'])) {
			$this->data['alw_zaberi_export_client_name_c'] = $this->request->post['settings']['alw_zaberi_export_client_name_c'];
		} else {
			$this->data['alw_zaberi_export_client_name_c'] = $this->config->get('alw_zaberi_export_client_name_c');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_org'])) {
			$this->data['alw_zaberi_export_org'] = $this->request->post['settings']['alw_zaberi_export_org'];
		} else {
			$this->data['alw_zaberi_export_org'] = $this->config->get('alw_zaberi_export_org');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_izip'])) {
			$this->data['alw_zaberi_export_izip'] = $this->request->post['settings']['alw_zaberi_export_izip'];
		} else {
			$this->data['alw_zaberi_export_izip'] = $this->config->get('alw_zaberi_export_izip');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_icity'])) {
			$this->data['alw_zaberi_export_icity'] = $this->request->post['settings']['alw_zaberi_export_icity'];
		} else {
			$this->data['alw_zaberi_export_icity'] = $this->config->get('alw_zaberi_export_icity');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_iaddress'])) {
			$this->data['alw_zaberi_export_iaddress'] = $this->request->post['settings']['alw_zaberi_export_iaddress'];
		} else {
			$this->data['alw_zaberi_export_iaddress'] = $this->config->get('alw_zaberi_export_iaddress');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_iname'])) {
			$this->data['alw_zaberi_export_iname'] = $this->request->post['settings']['alw_zaberi_export_iname'];
		} else {
			$this->data['alw_zaberi_export_iname'] = $this->config->get('alw_zaberi_export_iname');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_iinn'])) {
			$this->data['alw_zaberi_export_iinn'] = $this->request->post['settings']['alw_zaberi_export_iinn'];
		} else {
			$this->data['alw_zaberi_export_iinn'] = $this->config->get('alw_zaberi_export_iinn');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_ibank'])) {
			$this->data['alw_zaberi_export_ibank'] = $this->request->post['settings']['alw_zaberi_export_ibank'];
		} else {
			$this->data['alw_zaberi_export_ibank'] = $this->config->get('alw_zaberi_export_ibank');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_irs'])) {
			$this->data['alw_zaberi_export_irs'] = $this->request->post['settings']['alw_zaberi_export_irs'];
		} else {
			$this->data['alw_zaberi_export_irs'] = $this->config->get('alw_zaberi_export_irs');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_iks'])) {
			$this->data['alw_zaberi_export_iks'] = $this->request->post['settings']['alw_zaberi_export_iks'];
		} else {
			$this->data['alw_zaberi_export_iks'] = $this->config->get('alw_zaberi_export_iks');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_ibik'])) {
			$this->data['alw_zaberi_export_ibik'] = $this->request->post['settings']['alw_zaberi_export_ibik'];
		} else {
			$this->data['alw_zaberi_export_ibik'] = $this->config->get('alw_zaberi_export_ibik');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_status_1'])) {
			$this->data['alw_zaberi_export_status_1'] = $this->request->post['settings']['alw_zaberi_export_status_1'];
		} else {
			$this->data['alw_zaberi_export_status_1'] = $this->config->get('alw_zaberi_export_status_1');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_status_2'])) {
			$this->data['alw_zaberi_export_status_2'] = $this->request->post['settings']['alw_zaberi_export_status_2'];
		} else {
			$this->data['alw_zaberi_export_status_2'] = $this->config->get('alw_zaberi_export_status_2');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_status_3'])) {
			$this->data['alw_zaberi_export_status_3'] = $this->request->post['settings']['alw_zaberi_export_status_3'];
		} else {
			$this->data['alw_zaberi_export_status_3'] = $this->config->get('alw_zaberi_export_status_3');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_status_5'])) {
			$this->data['alw_zaberi_export_status_5'] = $this->request->post['settings']['alw_zaberi_export_status_5'];
		} else {
			$this->data['alw_zaberi_export_status_5'] = $this->config->get('alw_zaberi_export_status_5');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_status_10'])) {
			$this->data['alw_zaberi_export_status_10'] = $this->request->post['settings']['alw_zaberi_export_status_10'];
		} else {
			$this->data['alw_zaberi_export_status_10'] = $this->config->get('alw_zaberi_export_status_10');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_status_11'])) {
			$this->data['alw_zaberi_export_status_11'] = $this->request->post['settings']['alw_zaberi_export_status_11'];
		} else {
			$this->data['alw_zaberi_export_status_11'] = $this->config->get('alw_zaberi_export_status_11');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_status_12'])) {
			$this->data['alw_zaberi_export_status_12'] = $this->request->post['settings']['alw_zaberi_export_status_12'];
		} else {
			$this->data['alw_zaberi_export_status_12'] = $this->config->get('alw_zaberi_export_status_12');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_status_30'])) {
			$this->data['alw_zaberi_export_status_30'] = $this->request->post['settings']['alw_zaberi_export_status_30'];
		} else {
			$this->data['alw_zaberi_export_status_30'] = $this->config->get('alw_zaberi_export_status_30');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_status_31'])) {
			$this->data['alw_zaberi_export_status_31'] = $this->request->post['settings']['alw_zaberi_export_status_31'];
		} else {
			$this->data['alw_zaberi_export_status_31'] = $this->config->get('alw_zaberi_export_status_31');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_status_32'])) {
			$this->data['alw_zaberi_export_status_32'] = $this->request->post['settings']['alw_zaberi_export_status_32'];
		} else {
			$this->data['alw_zaberi_export_status_32'] = $this->config->get('alw_zaberi_export_status_32');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_status_33'])) {
			$this->data['alw_zaberi_export_status_33'] = $this->request->post['settings']['alw_zaberi_export_status_33'];
		} else {
			$this->data['alw_zaberi_export_status_33'] = $this->config->get('alw_zaberi_export_status_33');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_status_34'])) {
			$this->data['alw_zaberi_export_status_34'] = $this->request->post['settings']['alw_zaberi_export_status_34'];
		} else {
			$this->data['alw_zaberi_export_status_34'] = $this->config->get('alw_zaberi_export_status_34');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_status_35'])) {
			$this->data['alw_zaberi_export_status_35'] = $this->request->post['settings']['alw_zaberi_export_status_35'];
		} else {
			$this->data['alw_zaberi_export_status_35'] = $this->config->get('alw_zaberi_export_status_35');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_status_39'])) {
			$this->data['alw_zaberi_export_status_39'] = $this->request->post['settings']['alw_zaberi_export_status_39'];
		} else {
			$this->data['alw_zaberi_export_status_39'] = $this->config->get('alw_zaberi_export_status_39');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_status_40'])) {
			$this->data['alw_zaberi_export_status_40'] = $this->request->post['settings']['alw_zaberi_export_status_40'];
		} else {
			$this->data['alw_zaberi_export_status_40'] = $this->config->get('alw_zaberi_export_status_40');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_status_48'])) {
			$this->data['alw_zaberi_export_status_48'] = $this->request->post['settings']['alw_zaberi_export_status_48'];
		} else {
			$this->data['alw_zaberi_export_status_48'] = $this->config->get('alw_zaberi_export_status_48');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_status_49'])) {
			$this->data['alw_zaberi_export_status_49'] = $this->request->post['settings']['alw_zaberi_export_status_49'];
		} else {
			$this->data['alw_zaberi_export_status_49'] = $this->config->get('alw_zaberi_export_status_49');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_status_50'])) {
			$this->data['alw_zaberi_export_status_50'] = $this->request->post['settings']['alw_zaberi_export_status_50'];
		} else {
			$this->data['alw_zaberi_export_status_50'] = $this->config->get('alw_zaberi_export_status_50');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_status_51'])) {
			$this->data['alw_zaberi_export_status_51'] = $this->request->post['settings']['alw_zaberi_export_status_51'];
		} else {
			$this->data['alw_zaberi_export_status_51'] = $this->config->get('alw_zaberi_export_status_51');
		}

		if (isset($this->request->post['settings']['alw_zaberi_export_status_99'])) {
			$this->data['alw_zaberi_export_status_99'] = $this->request->post['settings']['alw_zaberi_export_status_99'];
		} else {
			$this->data['alw_zaberi_export_status_99'] = $this->config->get('alw_zaberi_export_status_99');
		}

		$this->template = 'shipping/alw_zaberi.tpl';

		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function orders() {
		$this->language->load('shipping/alw_zaberi');

		$this->document->setTitle($this->language->get('heading_title_fake'));

		$this->load->model('shipping/alw_zaberi');

		$this->load->model('tool/image');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$sort = 'o.order_id';

		$order = 'DESC';

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['button_orders'] = $this->language->get('button_orders');
		$this->data['button_settings'] = $this->language->get('button_settings');
		$this->data['button_export'] = $this->language->get('button_export');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['column_order_id'] = $this->language->get('column_order_id');
		$this->data['column_customer'] = $this->language->get('column_customer');
		$this->data['column_shipping'] = $this->language->get('column_shipping');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_export_success_1'] = $this->language->get('text_export_success_1');
		$this->data['text_export_success_3'] = $this->language->get('text_export_success_3');
		$this->data['text_export_success_5'] = $this->language->get('text_export_success_5');
		$this->data['text_export_success_10'] = $this->language->get('text_export_success_10');
		$this->data['text_export_success_49'] = $this->language->get('text_export_success_49');
		$this->data['text_export_success_50'] = $this->language->get('text_export_success_50');
		$this->data['text_export_success_51'] = $this->language->get('text_export_success_51');
		$this->data['text_export_success_11'] = $this->language->get('text_export_success_11');
		$this->data['text_export_success_12'] = $this->language->get('text_export_success_12');
		$this->data['text_export_success_30'] = $this->language->get('text_export_success_30');
		$this->data['text_export_success_31'] = $this->language->get('text_export_success_31');
		$this->data['text_export_success_32'] = $this->language->get('text_export_success_32');
		$this->data['text_export_success_33'] = $this->language->get('text_export_success_33');
		$this->data['text_export_success_34'] = $this->language->get('text_export_success_34');
		$this->data['text_export_success_35'] = $this->language->get('text_export_success_35');
		$this->data['text_export_success_39'] = $this->language->get('text_export_success_39');
		$this->data['text_export_success_40'] = $this->language->get('text_export_success_40');
		$this->data['text_export_success_48'] = $this->language->get('text_export_success_48');
		$this->data['text_export_success_99'] = $this->language->get('text_export_success_99');

		if (isset($this->session->data['warning'])) {
			$this->data['warning'] = $this->session->data['warning'];

			unset($this->session->data['warning']);
		} else {
			$this->data['warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
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
			'href'      => $this->url->link('shipping/alw_zaberi', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['settings'] = $this->url->link('shipping/alw_zaberi', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['orders'] = array();

		$data = array(
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$order_total = $this->model_shipping_alw_zaberi->getTotalOrders();

		$results = $this->model_shipping_alw_zaberi->getOrders($data);

    	foreach ($results as $result) {
			if ($result['shipping_code'] == 'alw_zaberi.alw_zaberi_pickup') {
				$shipping_method = $this->language->get('tab_pickup');
			} elseif ($result['shipping_code'] == 'alw_zaberi.alw_zaberi_pochta') {
				$shipping_method = $this->language->get('tab_pochta');
			} else {
				$shipping_method = $this->language->get('tab_courier');
			}

			if ($result['status'] > 0) {
				$status = '<b style="color: green;">' . $this->language->get('text_export_success_' . $result['status']) . '</b>';
			} elseif ($result['status'] == 0 && $result['err_text'] == '') {
				$status = '<b style="color: grey;">' . $this->language->get('text_export_null') . '</b>';
			} elseif ($result['status'] == 0 && $result['err_text'] != '') {
				$status = '<b style="color: red;">' . $this->language->get('text_export_error') . $result['err_text'] . '</b>';
			}

			if ($result['customer_id'] > 0) {
				$customer = '<a href="' . $this->url->link('sale/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $result['customer_id'], 'SSL') . '" target="_blank">' . $result['customer'] . '</a>';
			} else {
				$customer = $result['customer'];
			}

			if ($result['status'] > 0) {
				$total = $this->currency->format($result['order_amount'], $result['currency_code'], $result['currency_value']);
			} else {
				$total = $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']);
			}

			$this->data['orders'][] = array(
				'order_id'     	 	 => $result['order_id'],
				'customer'      	 => $customer,
				'shipping_method'    => $shipping_method,
				'total'     	     => $total,
				'href'      	     => $this->url->link('sale/order/update', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'], 'SSL'),
				'form'      	     => $this->url->link('shipping/alw_zaberi/form', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'], 'SSL'),
				'status'		     => $status
			);
		}

		$url = '';

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('shipping/alw_zaberi/orders', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'shipping/alw_zaberi_list.tpl';

		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function form() {
		$this->language->load('shipping/alw_zaberi');

		$this->document->setTitle($this->language->get('heading_title_fake'));

		$this->load->model('shipping/alw_zaberi');

		$this->model_shipping_alw_zaberi->updateOrderStatus($this->request->get['order_id']);

		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['tab_data'] = $this->language->get('tab_data');
		$this->data['tab_product'] = $this->language->get('tab_product');
		$this->data['tab_courier'] = $this->language->get('tab_courier');
		$this->data['tab_pickup'] = $this->language->get('tab_pickup');
		$this->data['tab_pochta'] = $this->language->get('tab_pochta');
		$this->data['button_send'] = $this->language->get('button_send');
		$this->data['button_settings'] = $this->language->get('button_settings');
		$this->data['button_orders'] = $this->language->get('button_orders');
		$this->data['button_cancel_order'] = $this->language->get('button_cancel_order');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['column_image'] = $this->language->get('column_image');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_quantity'] = $this->language->get('column_quantity');
		$this->data['column_price'] = $this->language->get('column_price');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_availability'] = $this->language->get('column_availability');
		$this->data['text_export_null'] = $this->language->get('text_export_null');
		$this->data['text_export_error'] = $this->language->get('text_export_error');
		$this->data['text_status'] = $this->language->get('text_status');
		$this->data['text_normal'] = $this->language->get('text_normal');
		$this->data['text_sklad'] = $this->language->get('text_sklad');
		$this->data['text_zt1'] = $this->language->get('text_zt1');
		$this->data['text_zt2'] = $this->language->get('text_zt2');
		$this->data['text_zt3'] = $this->language->get('text_zt3');
		$this->data['text_zt4'] = $this->language->get('text_zt4');
		$this->data['text_zt5'] = $this->language->get('text_zt5');
		$this->data['entry_start_pv'] = $this->language->get('entry_start_pv');
		$this->data['entry_status_export'] = $this->language->get('entry_status_export');
		$this->data['entry_order_id'] = $this->language->get('entry_order_id');
		$this->data['entry_int_number'] = $this->language->get('entry_int_number');
		$this->data['entry_service'] = $this->language->get('entry_service');
		$this->data['entry_order_amount'] = $this->language->get('entry_order_amount');
		$this->data['entry_d_price'] = $this->language->get('entry_d_price');
		$this->data['entry_fio'] = $this->language->get('entry_fio');
		$this->data['entry_phone'] = $this->language->get('entry_phone');
		$this->data['entry_city'] = $this->language->get('entry_city');
		$this->data['entry_to_city'] = $this->language->get('entry_to_city');
		$this->data['entry_comment'] = $this->language->get('entry_comment');
		$this->data['entry_final_pv'] = $this->language->get('entry_final_pv');
		$this->data['entry_weight'] = $this->language->get('entry_weight');
		$this->data['entry_tracker'] = $this->language->get('entry_tracker');
		$this->data['entry_rupost'] = $this->language->get('entry_rupost');
		$this->data['entry_zip'] = $this->language->get('entry_zip');
		$this->data['entry_client_obl'] = $this->language->get('entry_client_obl');
		$this->data['entry_client_city'] = $this->language->get('entry_client_city');
		$this->data['entry_address'] = $this->language->get('entry_address');
		$this->data['entry_type'] = $this->language->get('entry_type');

		$this->data['action'] = $this->url->link('shipping/alw_zaberi/export', 'token=' . $this->session->data['token'] . '&order_id=' . $this->request->get['order_id'], 'SSL');
		$this->data['settings'] = $this->url->link('shipping/alw_zaberi', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['orders'] = $this->url->link('shipping/alw_zaberi/orders', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel_order'] = $this->url->link('shipping/alw_zaberi/cancel_order', 'token=' . $this->session->data['token'] . '&order_id=' . $this->request->get['order_id'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->session->data['warning'])) {
			$this->data['warning'] = $this->session->data['warning'];

			unset($this->session->data['warning']);
		} else {
			$this->data['warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$url = '';

		if (isset($this->request->get['order_id'])) {
			$url .= '&order_id=' . $this->request->get['order_id'];
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
			'href'      => $this->url->link('shipping/alw_zaberi', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['order'] = $this->model_shipping_alw_zaberi->getOrder($this->request->get['order_id']);

		if ($this->data['order']['status'] > 0) {
			$this->data['text_export_success'] = $this->language->get('text_export_success_' . $this->data['order']['status']);
		}

		$this->template = 'shipping/alw_zaberi_form.tpl';

		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

    public function cancel_order() {
		$this->language->load('shipping/alw_zaberi');

		$this->load->model('shipping/alw_zaberi');

        $result = $this->model_shipping_alw_zaberi->cancel_order($this->request->get['order_id']);

		if (isset($result)) {
			$this->session->data['success'] = $this->language->get('text_success');
		} else {
			$this->session->data['warning'] = $this->language->get('text_fail');
		}

		$this->redirect($this->url->link('shipping/alw_zaberi/form', 'token=' . $this->session->data['token'] . '&order_id=' . $this->request->get['order_id'], 'SSL'));
    }

    public function export() {
		$this->language->load('shipping/alw_zaberi');

		$this->load->model('shipping/alw_zaberi');

        $result = $this->model_shipping_alw_zaberi->export($this->request->post);

		if (isset($result)) {
			$this->session->data['success'] = $this->language->get('text_success');
		} else {
			$this->session->data['warning'] = $this->language->get('text_fail');
		}

		$this->redirect($this->url->link('shipping/alw_zaberi/form', 'token=' . $this->session->data['token'] . '&order_id=' . $this->request->get['order_id'], 'SSL'));
    }

	protected function validate_modify() {
		if (!$this->user->hasPermission('modify', 'shipping/alw_zaberi')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}

    public function install() {
        $this->load->model('shipping/alw_zaberi');

        $this->model_shipping_alw_zaberi->install();
    }

    public function uninstall() {
        $this->load->model('shipping/alw_zaberi');

        $this->model_shipping_alw_zaberi->uninstall();
    }
}
?>