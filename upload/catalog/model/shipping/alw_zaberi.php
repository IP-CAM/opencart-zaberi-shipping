<?php
class ModelShippingAlwZaberi extends Model {
	function getQuote($address) {
		$this->language->load('shipping/alw_zaberi');

		$quote_data_courier = array();
		$quote_data_pickup = array();
		$quote_data_pochta = array();
		$method_data = array();

		if ($this->config->get('alw_zaberi_status_courier') == 1) {
		  if (($this->config->get('alw_zaberi_status_rus_courier') == 1 && $address['country_id'] == $this->config->get('alw_zaberi_country')) || ($this->config->get('alw_zaberi_status_rus_courier') == 0)) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('alw_zaberi_geo_zone_id_courier') . "' AND country_id = '" . $this->config->get('alw_zaberi_country') . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
	
			if (!$this->config->get('alw_zaberi_geo_zone_id_courier')) {
				$status = true;
			} elseif ($query->num_rows) {
				$status = true;
			} else {
				$status = false;
			}

			if ($this->config->get('config_currency') == 'RUB') {
				$sub_total = $this->currency->convert($this->cart->getSubTotal(), $this->config->get('config_currency'), $this->currency->getCode());
			} else {
				$sub_total = $this->currency->convert($this->cart->getSubTotal(), 'RUB', $this->config->get('config_currency'));
			}

			if ($this->config->get('alw_zaberi_min_cost_courier') > 0 && $this->config->get('alw_zaberi_min_cost_courier') > $sub_total) {
				$status = false;
			}

			if ($this->config->get('alw_zaberi_max_cost_courier') > 0 && $this->config->get('alw_zaberi_max_cost_courier') > $sub_total) {
				$status = false;
			}

			if ($status) {
				$address_city = trim(mb_strtolower($address['city'], 'UTF-8'));

				if (isset($address_city)) {
					$weight = 0;
					$cost = 0;
					$alw_zaberi = '';

					foreach ($this->cart->getProducts() as $product) {
						if ($product['shipping']) {
							$weight += $this->weight->convert($product['weight'], $product['weight_class_id'], $this->config->get('alw_zaberi_weight_class_id'));
						}
					}

					if ($weight == 0) {
						$weight = $this->config->get('alw_zaberi_default_weight');
					}

					if ($this->config->get('alw_zaberi_added_weight')) {
						$weight += $this->config->get('alw_zaberi_added_weight');
					}

					if ($this->config->get('alw_zaberi_cache') == 1) {
						$alw_zaberi = $this->cache->get('alw_zaberi.' . $this->translit($address_city) . '.' . $sub_total . '.' . ceil($weight));
					}

					if (!$alw_zaberi) {
						$alw_zaberi = array();

						$alw_zaberi['alw_zaberi_city'] = $this->getCity($address_city);

						if (isset($alw_zaberi['alw_zaberi_city'])) {
							$alw_zaberi['alw_zaberi_cost'] = $this->getCost(2, $sub_total, $sub_total, 78, $alw_zaberi['alw_zaberi_city'], ceil($weight));

							$this->session->data['alw_zaberi_city'] = $alw_zaberi['alw_zaberi_city'];
						}

						if ($this->config->get('alw_zaberi_cache') == 1) {
							$this->cache->set('alw_zaberi.' . $this->translit($address_city) . '.' . $sub_total . '.' . ceil($weight), $alw_zaberi);
						}
					}

					if (!empty($alw_zaberi['alw_zaberi_cost'])) {
						unset($title);

						foreach ($alw_zaberi['alw_zaberi_cost'] as $key => $courier) {
							if ($courier['type'] == 2) {
								$cost = $courier['tarif_price'];

								$courier_srok_dostavki = $courier['srok_dostavki'];
							} else {
								unset($alw_zaberi['alw_zaberi_cost'][$key]);
							}
						}

						$input = array(
							'{days}'
						);

						$output = array(
							'days' => $courier_srok_dostavki
						);

						$title = html_entity_decode(str_replace($input, $output, $this->config->get('alw_zaberi_description_courier')));

						if ($this->config->get('config_currency') == 'RUB') {
							$text = $this->currency->format($this->tax->calculate($cost, $this->config->get('alw_zaberi_tax_class_id_courier'), $this->config->get('config_tax')));
						} else {
							$text = $this->currency->format($this->currency->convert($this->tax->calculate($cost, $this->config->get('alw_zaberi_tax_class_id_courier'), $this->config->get('config_tax')), 'RUB', $this->config->get('config_currency')));
						}

						if (isset($title)) {
							$quote_data_courier['alw_zaberi_courier'] = array(
								'code'          => 'alw_zaberi.alw_zaberi_courier',
								'title'         => $title,
								'cost'          => $cost,
								'tax_class_id'  => $this->config->get('alw_zaberi_tax_class_id_courier'),
								'text'          => $text,
								'delivery_type' => 'courier'
							);
						}
					}
				}
			}
		  }
		}

		if ($this->config->get('alw_zaberi_status_pickup') == 1) {
		  if (($this->config->get('alw_zaberi_status_rus_pickup') == 1 && $address['country_id'] == $this->config->get('alw_zaberi_country')) || ($this->config->get('alw_zaberi_status_rus_pickup') == 0)) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('alw_zaberi_geo_zone_id_pickup') . "' AND country_id = '" . $this->config->get('alw_zaberi_country') . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
	
			if (!$this->config->get('alw_zaberi_geo_zone_id_pickup')) {
				$status = true;
			} elseif ($query->num_rows) {
				$status = true;
			} else {
				$status = false;
			}

			if ($this->config->get('config_currency') == 'RUB') {
				$sub_total = $this->currency->convert($this->cart->getSubTotal(), $this->config->get('config_currency'), $this->currency->getCode());
			} else {
				$sub_total = $this->currency->convert($this->cart->getSubTotal(), 'RUB', $this->config->get('config_currency'));
			}

			if ($this->config->get('alw_zaberi_min_cost_pickup') > 0 && $this->config->get('alw_zaberi_min_cost_pickup') > $sub_total) {
				$status = false;
			}

			if ($this->config->get('alw_zaberi_max_cost_pickup') > 0 && $this->config->get('alw_zaberi_max_cost_pickup') > $sub_total) {
				$status = false;
			}

			if ($status) {
				$address_city = trim(mb_strtolower($address['city'], 'UTF-8'));

				if (isset($address_city)) {
					$weight = 0;
					$cost = 0;
					$alw_zaberi = '';

					foreach ($this->cart->getProducts() as $product) {
						if ($product['shipping']) {
							$weight += $this->weight->convert($product['weight'], $product['weight_class_id'], $this->config->get('alw_zaberi_weight_class_id'));
						}
					}

					if ($weight == 0) {
						$weight = $this->config->get('alw_zaberi_default_weight');
					}

					if ($this->config->get('alw_zaberi_added_weight')) {
						$weight += $this->config->get('alw_zaberi_added_weight');
					}

					if ($this->config->get('alw_zaberi_cache') == 1) {
						$alw_zaberi = $this->cache->get('alw_zaberi.' . $this->translit($address_city) . '.' . $sub_total . '.' . ceil($weight));
					}

					if (!$alw_zaberi) {
						$alw_zaberi = array();

						$alw_zaberi['alw_zaberi_city'] = $this->getCity($address_city);

						if (isset($alw_zaberi['alw_zaberi_city'])) {
							$alw_zaberi['alw_zaberi_cost'] = $this->getCost(1, $sub_total, $sub_total, 78, $alw_zaberi['alw_zaberi_city'], ceil($weight));

							$this->session->data['alw_zaberi_city'] = $alw_zaberi['alw_zaberi_city'];
						}

						if ($this->config->get('alw_zaberi_cache') == 1) {
							$this->cache->set('alw_zaberi.' . $this->translit($address_city) . '.' . $sub_total . '.' . ceil($weight), $alw_zaberi);
						}
					}

					if (!empty($alw_zaberi['alw_zaberi_cost'])) {
						unset($title);
						$map = '';

						foreach ($alw_zaberi['alw_zaberi_cost'] as $key => $pickup) {
							if ($pickup['type'] == 2) {
								unset($alw_zaberi['alw_zaberi_cost'][$key]);
							}
						}

						$pickups = '</br><select class="alw_zaberi_select" onchange="update_zaberi(this.value);" style="max-width: 300px;">';

						foreach ($alw_zaberi['alw_zaberi_cost'] as $pickup) {
							$pickups .= '<option value="' . $pickup['cod'] . '"';

							if (isset($this->session->data['alw_zaberi_pickup_id']) && $this->session->data['alw_zaberi_pickup_id'] == $pickup['cod']) {
								$pickups .= 'selected="selected"';

								$cost = $pickup['tarif_price'];

								if (isset($pickup['proezd_info'])) {
									$pickup_proezd_info = $pickup['proezd_info'];
								} else {
									$pickup_proezd_info = '';
								}

								if (isset($pickup['phone'])) {
									$pickup_phone = $pickup['phone'];
								} else {
									$pickup_phone = '';
								}

								if (isset($pickup['srok_dostavki'])) {
									$pickup_srok_dostavki = $pickup['srok_dostavki'];
								} else {
									$pickup_srok_dostavki = '';
								}

								if (isset($pickup['adress'])) {
									$pickup_adress = $pickup['adress'];
								} else {
									$pickup_adress = '';
								}

								if (isset($pickup['worktime'])) {
									$pickup_worktime = $pickup['worktime'];
								} else {
									$pickup_worktime = '';
								}

								if (isset($pickup['latitude'])) {
									$pickup_latitude = $pickup['latitude'];
								} else {
									$pickup_latitude = '';
								}

								if (isset($pickup['longitude'])) {
									$pickup_longitude = $pickup['longitude'];
								} else {
									$pickup_longitude = '';
								}
							}

							$pickups .= '>' . $pickup['adress'] . '</option>';
						}

						$pickups .= '</select>';

						$pickup_temp = array_keys($alw_zaberi['alw_zaberi_cost']);

						$pickup_key = reset($pickup_temp);

						if (isset($alw_zaberi['alw_zaberi_cost'][$pickup_key])) {
							if (!isset($this->session->data['alw_zaberi_pickup_id']) || empty($pickup_adress)) {
								$cost = $alw_zaberi['alw_zaberi_cost'][$pickup_key]['tarif_price'];

								if (isset($alw_zaberi['alw_zaberi_cost'][$pickup_key]['proezd_info'])) {
									$pickup_proezd_info = $alw_zaberi['alw_zaberi_cost'][$pickup_key]['proezd_info'];
								} else {
									$pickup_proezd_info = '';
								}

								if (isset($alw_zaberi['alw_zaberi_cost'][$pickup_key]['phone'])) {
									$pickup_phone = $alw_zaberi['alw_zaberi_cost'][$pickup_key]['phone'];
								} else {
									$pickup_phone = '';
								}

								if (isset($alw_zaberi['alw_zaberi_cost'][$pickup_key]['srok_dostavki'])) {
									$pickup_srok_dostavki = $alw_zaberi['alw_zaberi_cost'][$pickup_key]['srok_dostavki'];
								} else {
									$pickup_srok_dostavki = '';
								}

								if (isset($alw_zaberi['alw_zaberi_cost'][$pickup_key]['adress'])) {
									$pickup_adress = $alw_zaberi['alw_zaberi_cost'][$pickup_key]['adress'];
								} else {
									$pickup_adress = '';
								}

								if (isset($alw_zaberi['alw_zaberi_cost'][$pickup_key]['worktime'])) {
									$pickup_worktime = $alw_zaberi['alw_zaberi_cost'][$pickup_key]['worktime'];
								} else {
									$pickup_worktime = '';
								}

								if (isset($alw_zaberi['alw_zaberi_cost'][$pickup_key]['latitude'])) {
									$pickup_latitude = $alw_zaberi['alw_zaberi_cost'][$pickup_key]['latitude'];
								} else {
									$pickup_latitude = '';
								}

								if (isset($alw_zaberi['alw_zaberi_cost'][$pickup_key]['longitude'])) {
									$pickup_longitude = $alw_zaberi['alw_zaberi_cost'][$pickup_key]['longitude'];
								} else {
									$pickup_longitude = '';
								}
							}

							$this->session->data['alw_zaberi_pickup_id'] = $alw_zaberi['alw_zaberi_cost'][$pickup_key]['cod'];

							$input = array(
								'{adress}',
								'{worktime}',
								'{info}',
								'{phone}',
								'{days}'
							);

							$output = array(
								'adress'    => $pickup_adress,
								'worktime'  => $pickup_worktime,
								'info' 		=> $pickup_proezd_info,
								'phone'     => $pickup_phone,
								'days' 		=> $pickup_srok_dostavki
							);

							$title = html_entity_decode(str_replace($input, $output, $this->config->get('alw_zaberi_description_pickup')));

							if ($this->config->get('alw_zaberi_map_pickup') == 1) {
								$map = ' <a class="alw_zaberi_colorbox" onclick="get_zaberi_map(' . $pickup_latitude . ',' . $pickup_longitude . ',\'' . $pickup_adress . '\');">' . $this->language->get('text_map') . '</a>';
							}
						
							if ($this->config->get('config_currency') == 'RUB') {
								$text = $this->currency->format($this->tax->calculate($cost, $this->config->get('alw_zaberi_tax_class_id_pickup'), $this->config->get('config_tax')));
							} else {
								$text = $this->currency->format($this->currency->convert($this->tax->calculate($cost, $this->config->get('alw_zaberi_tax_class_id_pickup'), $this->config->get('config_tax')), 'RUB', $this->config->get('config_currency')));
							}

							if (isset($title)) {
								$quote_data_pickup['alw_zaberi_pickup'] = array(
									'code'          	=> 'alw_zaberi.alw_zaberi_pickup',
									'title'         	=> $title,
									'zaberi_map'    	=> $map,
									'cost'          	=> $cost,
									'tax_class_id' 	 	=> $this->config->get('alw_zaberi_tax_class_id_pickup'),
									'text'          	=> $text,
									'delivery_type'	 	=> 'pickup',
									'description'		=> $pickups
								);
							}
						}
					}
				}
			}
		  }
		}

		if ($this->config->get('alw_zaberi_status_pochta') == 1) {
		  if (($this->config->get('alw_zaberi_status_rus_pochta') == 1 && $address['country_id'] == $this->config->get('alw_zaberi_country')) || ($this->config->get('alw_zaberi_status_rus_pochta') == 0)) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('alw_zaberi_geo_zone_id_pochta') . "' AND country_id = '" . $this->config->get('alw_zaberi_country') . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
	
			if (!$this->config->get('alw_zaberi_geo_zone_id_pochta')) {
				$status = true;
			} elseif ($query->num_rows) {
				$status = true;
			} else {
				$status = false;
			}

			if ($this->config->get('config_currency') == 'RUB') {
				$sub_total = $this->currency->convert($this->cart->getSubTotal(), $this->config->get('config_currency'), $this->currency->getCode());
			} else {
				$sub_total = $this->currency->convert($this->cart->getSubTotal(), 'RUB', $this->config->get('config_currency'));
			}

			if ($this->config->get('alw_zaberi_min_cost_pochta') > 0 && $this->config->get('alw_zaberi_min_cost_pochta') > $sub_total) {
				$status = false;
			}

			if ($this->config->get('alw_zaberi_max_cost_pochta') > 0 && $this->config->get('alw_zaberi_max_cost_pochta') > $sub_total) {
				$status = false;
			}

			if ($status) {
				$cost = 0;
				$cost = $this->config->get('alw_zaberi_cost_pochta');

				$title = $this->config->get('alw_zaberi_description_pochta');

				if ($this->config->get('config_currency') == 'RUB') {
					$text = $this->currency->format($this->tax->calculate($cost, $this->config->get('alw_zaberi_tax_class_id_pochta'), $this->config->get('config_tax')));
				} else {
					$text = $this->currency->format($this->currency->convert($this->tax->calculate($cost, $this->config->get('alw_zaberi_tax_class_id_pochta'), $this->config->get('config_tax')), 'RUB', $this->config->get('config_currency')));
				}

				if (isset($title)) {
					$quote_data_pochta['alw_zaberi_pochta'] = array(
						'code'          => 'alw_zaberi.alw_zaberi_pochta',
						'title'         => $title,
						'cost'          => $cost,
						'tax_class_id'  => $this->config->get('alw_zaberi_tax_class_id_pochta'),
						'text'          => $text,
						'delivery_type' => 'pochta'
					);
				}
			}
		  }
		}

		if (!empty($quote_data_courier) || !empty($quote_data_pickup) || !empty($quote_data_pochta)) {
			$quote_data = array_merge($quote_data_courier, $quote_data_pickup, $quote_data_pochta);

			$method_data = array(
				'code'       => 'alw_zaberi',
				'title'      => $this->config->get('alw_zaberi_title'),
				'quote'      => $quote_data,
				'sort_order' => $this->config->get('alw_zaberi_sort_order'),
				'error'      => false
			);

			return $method_data;
		}
	}

    protected function getCity ($address_city) {
		$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
				<methodCall>
					<methodName>get_cities</methodName>
					<client_name>" . $this->config->get('alw_zaberi_login') . "</client_name>
		         	<client_api_id>" . $this->config->get('alw_zaberi_key') . "</client_api_id>
					<params>
						<get_cities>" . $address_city . "</get_cities>
 		            </params>
				</methodCall>";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://lc.zaberi-tovar.ru/api/');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'xml=' . $xml);
		$result = curl_exec($ch);
		curl_close($ch);

		if (!empty($result)) {
			$reader = new XMLReader();
			$reader->xml($result);

			$cities = array();
			$status = '';
			$error = '';
			$key = 0;

			while ($reader->read()){
				if ($reader->localName == 'status' && $reader->nodeType == XMLReader::ELEMENT) {
					$reader->read();
					$status = $reader->value;
				} elseif ($reader->localName == 'global_err_text' && $reader->nodeType == XMLReader::ELEMENT) {
					$reader->read();
					$error = $reader->value;
				} elseif ($reader->localName == 'city') {
					while ($reader->read()){
						if ($reader->nodeType == XMLReader::ELEMENT) { // element name
							$element_name = $reader->name;
						} elseif ($reader->nodeType == XMLReader::TEXT) { // element value
							$cities[$key][$element_name] = $reader->value;
						} elseif ($reader->localName == 'city' && $reader->nodeType == XMLReader::END_ELEMENT) { // go to next item
							$key++;
							unset($element_name);
						} elseif ($reader->localName == 'params' && $reader->nodeType == XMLReader::END_ELEMENT) { // after all, return or log
							if ($status == 'Error' && $this->config->get('alw_zaberi_debug') == 1) {
								$this->log->write($this->language->get('error_log_city') . $error);
							} elseif (!empty($cities) && $status == 'Ok') {
								foreach ($cities as $city) {
									if ($address_city == trim(mb_strtolower(preg_replace('/\,.*/', '', $city['city_name']), 'UTF-8'))) {
										return $city['city_code'];
										break;
									}
								}
							} elseif ($this->config->get('alw_zaberi_debug') == 1) {
								$this->log->write($this->language->get('error_log_city') . $this->language->get('error_inner'));
							}
						}
					}
				}
			}

			$reader->close();
		} else {
			$this->log->write($this->language->get('error_log_api'));
		}
    }

    protected function getCost($service, $order_amount, $d_price, $city, $to_city, $weight) {
		$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
				<methodCall>
					<methodName>show_pv_text</methodName>
					<client_name>" . $this->config->get('alw_zaberi_login') . "</client_name>
		         	<client_api_id>" . $this->config->get('alw_zaberi_key') . "</client_api_id>
					<params>
						<show_pv>
							<service>" . $service . "</service>
							<order_amount>" . $order_amount . "</order_amount>
 		                    <d_price>" . $d_price . "</d_price>
							<city>" . $city . "</city>
							<to_city>" . $to_city . "</to_city>
 		                    <weight>" . $weight . "</weight>
						</show_pv>
 		            </params>
				</methodCall>";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://lc.zaberi-tovar.ru/api/');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'xml=' . $xml);
		$result = curl_exec($ch);
		curl_close($ch);

		if (!empty($result)) {
			$reader = new XMLReader();
			$reader->xml($result);

			$items = array();
			$status = '';
			$error = '';
			$key = 0;

			while ($reader->read()){
				if ($reader->localName == 'status' && $reader->nodeType == XMLReader::ELEMENT) {
					$reader->read();
					$status = $reader->value;
				} elseif ($reader->localName == 'global_err_text' && $reader->nodeType == XMLReader::ELEMENT) {
					$reader->read();
					$error = $reader->value;
				} elseif ($reader->localName == 'item') {
					while ($reader->read()){
						if ($reader->nodeType == XMLReader::ELEMENT) { // element name
							$element_name = $reader->name;
						} elseif ($reader->nodeType == XMLReader::TEXT) { // element value
							$items[$key][$element_name] = $reader->value;
						} elseif ($reader->localName == 'item' && $reader->nodeType == XMLReader::END_ELEMENT) { // go to next item
							$key++;
							unset($element_name);
						} elseif ($reader->localName == 'params' && $reader->nodeType == XMLReader::END_ELEMENT) { // after all, return or log
							if ($status == 'Error' && $this->config->get('alw_zaberi_debug') == 1) {
								$this->log->write($this->language->get('error_log_ship') . $error);
							} elseif (!empty($items) && $status == 'Ok') {
								return $items;
							} elseif ($this->config->get('alw_zaberi_debug') == 1) {
								$this->log->write($this->language->get('error_log_ship') . $this->language->get('error_inner'));
							}
						}
					}
				}
			}

			$reader->close();
		} else {
			$this->log->write($this->language->get('error_log_api'));
		}
    }

	function addOrderPickup($order_id, $pickup_id, $city_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "alw_zaberi_order WHERE order_id = '" . (int)$order_id . "'");

		$this->db->query("INSERT INTO " . DB_PREFIX . "alw_zaberi_order SET order_id = '" . (int)$order_id . "', final_pv = '" . $this->db->escape($pickup_id) . "', to_city = '" . $this->db->escape($city_id) . "'");
	}

	function addOrderOther($order_id, $city_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "alw_zaberi_order WHERE order_id = '" . (int)$order_id . "'");

		$this->db->query("INSERT INTO " . DB_PREFIX . "alw_zaberi_order SET order_id = '" . (int)$order_id . "', to_city = '" . $this->db->escape($city_id) . "'");
	}

	protected function translit($str) {
		$replace = array(
			"А"=>"a",			"а"=>"a",			" "=>"_",			"$"=>"_",
			"Б"=>"b",			"б"=>"b",			"."=>"_",			"&amp;"=>"_",
			"В"=>"v",			"в"=>"v",			"/"=>"_",
			"Г"=>"g",			"г"=>"g",			","=>"_",
			"Д"=>"d",			"д"=>"d",			"-"=>"-",
			"Е"=>"e",			"е"=>"e",			"("=>"_",
			"Ё"=>"e",			"ё"=>"e",			")"=>"_",
			"Ж"=>"j",			"ж"=>"j",			"["=>"_",
			"З"=>"z",			"з"=>"z",			"]"=>"_",
			"И"=>"i",			"и"=>"i",			"="=>"_",
			"Й"=>"y",			"й"=>"y",			"+"=>"_",
			"К"=>"k",			"к"=>"k",			"*"=>"_",
			"Л"=>"l",			"л"=>"l",			"?"=>"_",
			"М"=>"m",			"м"=>"m",			"\""=>"_",
			"Н"=>"n",			"н"=>"n",			"'"=>"_",
			"О"=>"o",			"о"=>"o",			"&"=>"_",
			"П"=>"p",			"п"=>"p",			"%"=>"_",
			"Р"=>"r",			"р"=>"r",			"#"=>"_",
			"С"=>"s",			"с"=>"s",			"@"=>"_",
			"Т"=>"t",			"т"=>"t",			"!"=>"_",
			"У"=>"u",			"у"=>"u",			";"=>"_",
			"Ф"=>"f",			"ф"=>"f",			"№"=>"_",
			"Х"=>"h",			"х"=>"h",			"^"=>"_",
			"Ц"=>"ts",			"ц"=>"ts",			":"=>"_",
			"Ч"=>"ch",			"ч"=>"ch",			"~"=>"_",
			"Ш"=>"sh",			"ш"=>"sh",			"\\"=>"_",
			"Щ"=>"sch",			"щ"=>"sch",			"Ґ"=>"G",
			"Ъ"=>"",			"ъ"=>"y",			"є"=>"e",
			"Ы"=>"i",			"ы"=>"i",			"Є"=>"E",
			"Ь"=>"j",			"ь"=>"j",			"і"=>"i",
			"Э"=>"e",			"э"=>"e",			"І"=>"I",
			"Ю"=>"yu",			"ю"=>"yu",			"ї"=>"i",
			"Я"=>"ya",			"я"=>"ya",			"Ї"=>"I"
		);

		return strtr($str, $replace);
	}
}
?>