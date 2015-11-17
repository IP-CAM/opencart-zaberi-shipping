<?php
class ModelShippingAlwZaberi extends Model {
	public function getOrders($data = array()) {
		$sql = "SELECT o.order_id, o.customer_id, CONCAT(o.firstname, ' ', o.lastname) AS customer, o.total, o.currency_code, o.currency_value, o.telephone, o.shipping_code, o.shipping_country, o.shipping_zone, o.shipping_address_1, o.shipping_city, o.email, o.comment, o.payment_postcode, o.payment_method, o.shipping_method, zo.order_amount, zo.status, zo.err_text FROM `" . DB_PREFIX . "order` o LEFT JOIN `" . DB_PREFIX . "alw_zaberi_order` zo ON zo.order_id = o.order_id WHERE o.order_status_id > 0 AND o.shipping_code LIKE 'alw_zaberi.%' ORDER BY o.order_id DESC";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		$order_ids = array();

		foreach ($query->rows as $order) {
			if ($order['status'] > 0) {
				$order_ids[] = $order['order_id'];
			}
		}

		if (count($order_ids) > 0) {
			$this->updateOrderStatuses($order_ids);
		}

		return $query->rows;
	}

	public function getTotalOrders() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id > 0 AND shipping_code LIKE 'alw_zaberi.%'");

		return $query->row['total'];
	}

	public function getOrderProducts($order_id) {
		$query = $this->db->query("SELECT op.*, p.image FROM " . DB_PREFIX . "order_product op LEFT JOIN " . DB_PREFIX . "product p ON op.product_id = p.product_id WHERE op.order_id = '" . (int)$order_id . "'");

		return $query->rows;
	}

	public function getArts ($data) {
		$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
				<methodCall>
					<methodName>get_art_from_store</methodName>
					<client_name>" . $this->config->get('alw_zaberi_login') . "</client_name>
		         	<client_api_id>" . $this->config->get('alw_zaberi_key') . "</client_api_id>
					<params>
						<arts>";
							foreach ($data as $art) {
		$xml .= "				<art>" . $art . "</art>";
							}
		$xml .= "		</arts>
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

			$arts = array();
			$key = 0;

			while ($reader->read()){
				if ($reader->localName == 'art_data') {
					while ($reader->read()){
						if ($reader->nodeType == XMLReader::ELEMENT) { // element name
							$element_name = $reader->name;
						} elseif ($reader->nodeType == XMLReader::TEXT) { // element value
							$arts[$key][$element_name] = $reader->value;
						} elseif ($reader->localName == 'art_data' && $reader->nodeType == XMLReader::END_ELEMENT) { // go to next item
							$key++;
							unset($element_name);
						} elseif ($reader->localName == 'params' && $reader->nodeType == XMLReader::END_ELEMENT) {
							if (!empty($arts)) {
								return $arts;
								break;
							}
						}
					}
				}
			}

			$reader->close();
		}
    }

	public function getOrder($order_id) {
		$this->load->model('tool/image');

		$check = $this->db->query("SELECT status FROM " . DB_PREFIX . "alw_zaberi_order WHERE order_id = '" . (int)$order_id . "'");

		if (isset($check->row['status'])) {// order has been export
			$query = $this->db->query("SELECT zo.* FROM " . DB_PREFIX . "alw_zaberi_order zo WHERE zo.order_id = '" . (int)$order_id . "'");
		} else {
			$query = $this->db->query("SELECT zo.to_city, zo.final_pv, zo.status, zo.err_text, zo.tracker, zo.pvz_address, zo.pvz_phone, zo.pvz_srok, o.order_id, o.shipping_zone AS client_obl, o.shipping_city AS client_city, CONCAT(o.shipping_address_1, ' ', o.shipping_address_2) AS address, o.comment, CONCAT(o.firstname, ' ', o.lastname) AS fio, o.telephone AS phone, o.payment_postcode AS zip, o.email, o.total, o.currency_code, o.currency_value, o.shipping_code, o.order_status_id, ot.value FROM `" . DB_PREFIX . "order` o LEFT JOIN `" . DB_PREFIX . "order_total` ot ON ot.order_id = o.order_id LEFT JOIN " . DB_PREFIX . "alw_zaberi_order zo ON zo.order_id = o.order_id WHERE o.order_id = '" . (int)$order_id . "' AND o.order_status_id > 0 AND ot.code = 'shipping'");
		}

		$products = $this->db->query("SELECT op.*, p.shipping, p.weight, p.weight_class_id, p.image, op.tax FROM " . DB_PREFIX . "order_product op LEFT JOIN " . DB_PREFIX . "product p ON op.product_id = p.product_id WHERE op.order_id = '" . (int)$order_id . "'");

		$weight = 0;

		$weight_query_config = $this->db->query("SELECT * FROM " . DB_PREFIX . "weight_class WHERE weight_class_id = '" . (int)$this->config->get('alw_zaberi_weight_class_id') . "'");

		foreach ($products->rows as $product) {
			$products_data[] = array(
				'product_id'       => $product['product_id'],
				'image'			   => $this->model_tool_image->resize($product['image'], 50, 50),
				'name'             => $product['name'],
				'href'     		   => $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&product_id=' . $product['product_id'], 'SSL'),
				'model'            => $product['model'],
				'quantity'         => $product['quantity'],
				'price'    		   => $product['price'],
				'total'    		   => $product['total']
			);

			if ($product['shipping']) {
				if ($product['weight_class_id'] == $this->config->get('alw_zaberi_weight_class_id')) {
					$weight += $product['weight'];
				} else {
					$weight_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "weight_class WHERE weight_class_id = '" . (int)$product['weight_class_id'] . "'");

					$weight += $product['weight'] * ($weight_query_config->row['value'] / $weight_query->row['value']);
				}
			}

			$arts[$product['product_id']] = $product['model'];
		}

		$product_sklad = $this->getArts($arts);

		if (isset($product_sklad)) {
			foreach ($product_sklad as $key => $result) {
				if ($result['zt1'] > 0) {
					$sklad['zt1'][$key] = $result['zt1'];
				}

				if ($result['zt2'] > 0) {
					$sklad['zt2'][$key] = $result['zt2'];
				}

				if ($result['zt3'] > 0) {
					$sklad['zt3'][$key] = $result['zt3'];
				}

				if ($result['zt4'] > 0) {
					$sklad['zt4'][$key] = $result['zt4'];
				}

				if ($result['zt5'] > 0) {
					$sklad['zt5'][$key] = $result['zt5'];
				}
			}
		} else {
			$product_sklad = null;
			$sklad = null;
		}

		if ($weight == 0) {
			$weight = $this->config->get('alw_zaberi_default_weight');
		}

		if ($this->config->get('alw_zaberi_added_weight')) {
			$weight += $this->config->get('alw_zaberi_added_weight');
		}

		if (isset($check->row['status'])) {// order has been export
			$order_amount = $query->row['order_amount'];
			$int_number = $query->row['int_number'];
			$service = $query->row['service'];
			$d_price = $query->row['d_price'];
			$city = $query->row['city'];
			$start_pv = $query->row['start_pv'];
			$weight = $query->row['weight'];
			$rupost = $query->row['rupost'];
			$zip_c = $query->row['zip_c'];
			$client_city_c = $query->row['client_city_c'];
			$address_c = $query->row['address_c'];
			$client_name_c = $query->row['client_name_c'];
			$org = $query->row['org'];
			$izip = $query->row['izip'];
			$icity = $query->row['icity'];
			$iaddress = $query->row['iaddress'];
			$iname = $query->row['iname'];
			$iinn = $query->row['iinn'];
			$ibank = $query->row['ibank'];
			$irs = $query->row['irs'];
			$iks = $query->row['iks'];
			$ibik = $query->row['ibik'];
		} else {
			if ($query->row['order_status_id'] == $this->config->get('alw_zaberi_order_status_id')) {// if order is paid then reset amount
				$order_amount = 0;
			} else {
				$order_amount = $this->currency->convert($query->row['total'], $query->row['currency_code'], $this->config->get('config_currency'));
			}

			$int_number = '';

			if ($query->row['shipping_code'] == 'alw_zaberi.alw_zaberi_pickup') {
				$service = 1;
			} elseif ($query->row['shipping_code'] == 'alw_zaberi.alw_zaberi_pochta') {
				$service = 3;
			} else {
				$service = 2;
			}

			$d_price = $this->currency->convert($query->row['total'], $query->row['currency_code'], $this->config->get('config_currency'));
			$city = 78;
			$start_pv = $this->config->get('alw_zaberi_export_start_pv');
			$weight = ceil($weight);
			$rupost = $this->config->get('alw_zaberi_export_rupost');
			$zip_c = $this->config->get('alw_zaberi_export_zip_c');
			$client_city_c = $this->config->get('alw_zaberi_export_client_city_c');
			$address_c = $this->config->get('alw_zaberi_export_address_c');
			$client_name_c = $this->config->get('alw_zaberi_export_client_name_c');
			$org = $this->config->get('alw_zaberi_export_org');
			$izip = $this->config->get('alw_zaberi_export_izip');
			$icity = $this->config->get('alw_zaberi_export_icity');
			$iaddress = $this->config->get('alw_zaberi_export_iaddress');
			$iname = $this->config->get('alw_zaberi_export_iname');
			$iinn = $this->config->get('alw_zaberi_export_iinn');
			$ibank = $this->config->get('alw_zaberi_export_ibank');
			$irs = $this->config->get('alw_zaberi_export_irs');
			$iks = $this->config->get('alw_zaberi_export_iks');
			$ibik = $this->config->get('alw_zaberi_export_ibik');
		}

		$order['data'] = array(
			'order_id'     	 	 => $query->row['order_id'],
			'int_number'     	 => $int_number,
			'service'     	 	 => $service,
			'order_amount'     	 => $order_amount,
			'd_price'     	 	 => $d_price,
			'fio'     	 		 => $query->row['fio'],
			'phone'     	 	 => $query->row['phone'],
			'city'     	 		 => $city,
			'to_city'     	 	 => $query->row['to_city'],
			'comment'     	 	 => $query->row['comment'],
			'start_pv'     	 	 => $start_pv,
			'final_pv'     	 	 => $query->row['final_pv'],
			'weight'     	 	 => $weight,
			'zip'     	 		 => $query->row['zip'],
			'rupost'     	 	 => $rupost,
			'client_obl'     	 => $query->row['client_obl'],
			'client_city'     	 => $query->row['client_city'],
			'address'     	 	 => $query->row['address'],
			'zip_c'     	 	 => $zip_c,
			'client_city_c'      => $client_city_c,
			'address_c'     	 => $address_c,
			'client_name_c'      => $client_name_c,
			'org'     	 		 => $org,
			'izip'     	 		 => $izip,
			'icity'     	 	 => $icity,
			'iaddress'     	 	 => $iaddress,
			'iname'     	 	 => $iname,
			'iinn'     	 		 => $iinn,
			'ibank'     	 	 => $ibank,
			'irs'     	 		 => $irs,
			'iks'     	 		 => $iks,
			'ibik'     	 		 => $ibik,
			'tracker'     	 	 => $query->row['tracker'],
			'status'     	 	 => $query->row['status'],
			'err_text'     	 	 => $query->row['err_text'],
			'pvz_address'     	 => $query->row['pvz_address'],
			'pvz_phone'     	 => $query->row['pvz_phone'],
			'pvz_srok'     		 => $query->row['pvz_srok'],
			'products'		 	 => $products_data,
			'product_sklad'		 => $product_sklad,
			'sklad'		 		 => $sklad
		);

		return $order['data'];
	}

	public function export($data) {
		if (isset($data['type']) && $data['type'] != 'on') {
			$methodName = 'add_orders_from_store';
			$data['start_pv'] = $data['type'];
			$goods = "			<goods>";

			foreach ($data['products'] as $product) {
				$goods .= "			<arts>
										<art>" . $product['art'] . "</art>
										<counts>" . $product['counts'] . "</counts>
										<price_of_piece>" . $product['price_of_piece'] . "</price_of_piece>
									</arts>";
			}

			$goods .= "			</goods>";
		} else {
			$methodName = 'add_orders';
			$goods = '';
		}

		$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
				<methodCall>
					<methodName>" . $methodName . "</methodName>
					<client_name>" . $this->config->get('alw_zaberi_login') . "</client_name>
		         	<client_api_id>" . $this->config->get('alw_zaberi_key') . "</client_api_id>
					<params>
						<orders>
							<item>
								<order_id>" . $data['order_id'] . "</order_id>
                                <int_number>" . $data['int_number'] . "</int_number>
								<service>" . $data['service'] . "</service>
								<order_amount>" . $data['order_amount'] . "</order_amount>
								<d_price>" . $data['d_price'] . "</d_price>
								<fio>" . $data['fio'] . "</fio>
								<phone>" . $data['phone'] . "</phone>
								<city>" . $data['city'] . "</city>
								<to_city>" . $data['to_city'] . "</to_city>
								<comment>" . $data['comment'] . "</comment>
								<start_pv>" . $data['start_pv'] . "</start_pv>
								<final_pv>" . $data['final_pv'] . "</final_pv>
								<weight>" . $data['weight'] . "</weight>
								<zip>" . $data['zip'] . "</zip>
                                <rupost>" . $data['rupost'] . "</rupost>
                                <client_obl>" . $data['client_obl'] . "</client_obl>
                                <client_city>" . $data['client_city'] . "</client_city>
								<address>" . $data['address'] . "</address>
                                <zip_c>" . $data['zip_c'] . "</zip_c>
								<client_city_c>" . $data['client_city_c'] . "</client_city_c>
								<address_c>" . $data['address_c'] . "</address_c>
								<client_name_c>" . $data['client_name_c'] . "</client_name_c>
								<org>" . $data['org'] . "</org>
								<izip>" . $data['izip'] . "</izip>
								<icity>" . $data['icity'] . "</icity>
								<iaddress>" . $data['iaddress'] . "</iaddress>
								<iname>" . $data['iname'] . "</iname>
								<iinn>" . $data['iinn'] . "</iinn>
								<ibank>" . $data['ibank'] . "</ibank>
								<irs>" . $data['irs'] . "</irs>
								<iks>" . $data['iks'] . "</iks>
								<ibik>" . $data['ibik'] . "</ibik>
								" . $goods . "
							</item>
						</orders>
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
							if ($status == 'Error') {
								$this->db->query("UPDATE " . DB_PREFIX . "alw_zaberi_order SET 
									int_number = '" . $this->db->escape($data['int_number']) . "',
									service = '" . (int)$data['service'] . "',
									order_amount = '" . (float)$data['order_amount'] . "',
									d_price = '" . (float)$data['d_price'] . "',
									fio = '" . $this->db->escape($data['fio']) . "',
									phone = '" . $this->db->escape($data['phone']) . "',
									city = '" . $this->db->escape($data['city']) . "',
									to_city = '" . $this->db->escape($data['to_city']) . "',
									comment = '" . $this->db->escape($data['comment']) . "',
									start_pv = '" . $this->db->escape($data['start_pv']) . "',
									final_pv = '" . $this->db->escape($data['final_pv']) . "',
									weight = '" . $this->db->escape($data['weight']) . "',
									zip = '" . $this->db->escape($data['zip']) . "',
									rupost = '" . $this->db->escape($data['rupost']) . "',
									client_obl = '" . $this->db->escape($data['client_obl']) . "',
									client_city = '" . $this->db->escape($data['client_city']) . "',
									address = '" . $this->db->escape($data['address']) . "',
									zip_c = '" . $this->db->escape($data['zip_c']) . "',
									client_city_c = '" . $this->db->escape($data['client_city_c']) . "',
									address_c = '" . $this->db->escape($data['address_c']) . "',
									client_name_c = '" . $this->db->escape($data['client_name_c']) . "',
									org = '" . (int)$data['org'] . "',
									izip = '" . $this->db->escape($data['izip']) . "',
									icity = '" . $this->db->escape($data['icity']) . "',
									iaddress = '" . $this->db->escape($data['iaddress']) . "',
									iname = '" . $this->db->escape($data['iname']) . "',
									iinn = '" . $this->db->escape($data['iinn']) . "',
									ibank = '" . $this->db->escape($data['ibank']) . "',
									irs = '" . $this->db->escape($data['irs']) . "',
									iks = '" . $this->db->escape($data['iks']) . "',
									ibik = '" . $this->db->escape($data['ibik']) . "',
									err_text = '" . $this->db->escape($items[0]['err_text']) . "',
									status = 0 WHERE order_id = '" . (int)$data['order_id'] . "'
								");
							} elseif (!empty($items) && $status == 'Ok') {
								if (isset($items[0]['tracker'])) {
									$tracker = $items[0]['tracker'];
								} else {
									$tracker = '';
								}

								$this->db->query("UPDATE " . DB_PREFIX . "alw_zaberi_order SET 
									int_number = '" . $this->db->escape($data['int_number']) . "',
									service = '" . (int)$data['service'] . "',
									order_amount = '" . (float)$data['order_amount'] . "',
									d_price = '" . (float)$data['d_price'] . "',
									fio = '" . $this->db->escape($data['fio']) . "',
									phone = '" . $this->db->escape($data['phone']) . "',
									city = '" . $this->db->escape($data['city']) . "',
									to_city = '" . $this->db->escape($data['to_city']) . "',
									comment = '" . $this->db->escape($data['comment']) . "',
									start_pv = '" . $this->db->escape($data['start_pv']) . "',
									final_pv = '" . $this->db->escape($data['final_pv']) . "',
									weight = '" . $this->db->escape($data['weight']) . "',
									zip = '" . $this->db->escape($data['zip']) . "',
									rupost = '" . $this->db->escape($data['rupost']) . "',
									client_obl = '" . $this->db->escape($data['client_obl']) . "',
									client_city = '" . $this->db->escape($data['client_city']) . "',
									address = '" . $this->db->escape($data['address']) . "',
									zip_c = '" . $this->db->escape($data['zip_c']) . "',
									client_city_c = '" . $this->db->escape($data['client_city_c']) . "',
									address_c = '" . $this->db->escape($data['address_c']) . "',
									client_name_c = '" . $this->db->escape($data['client_name_c']) . "',
									org = '" . (int)$data['org'] . "',
									izip = '" . $this->db->escape($data['izip']) . "',
									icity = '" . $this->db->escape($data['icity']) . "',
									iaddress = '" . $this->db->escape($data['iaddress']) . "',
									iname = '" . $this->db->escape($data['iname']) . "',
									iinn = '" . $this->db->escape($data['iinn']) . "',
									ibank = '" . $this->db->escape($data['ibank']) . "',
									irs = '" . $this->db->escape($data['irs']) . "',
									iks = '" . $this->db->escape($data['iks']) . "',
									ibik = '" . $this->db->escape($data['ibik']) . "',
									uid = '" . $this->db->escape($items[0]['result']) . "',
									tracker = '" . $this->db->escape($tracker) . "',
									barcode = '" . $this->db->escape($items[0]['barcode']) . "',
									status = 1 WHERE order_id = '" . (int)$data['order_id'] . "'
								");

								return $items;
							}
						}
					}
				}
			}

			$reader->close();
		}
	}

	public function cancel_order($order_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "alw_zaberi_order SET status = 5 WHERE order_id = '" . (int)$order_id . "'");
	}

	function updateOrderStatus($order_id) {
		$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
				<methodCall>
					<methodName>get_orders_by_order_id</methodName>
					<client_name>" . $this->config->get('alw_zaberi_login') . "</client_name>
		         	<client_api_id>" . $this->config->get('alw_zaberi_key') . "</client_api_id>
					<params>
						<orders>
							<order_id>" . $order_id . "</order_id>
						</orders>
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
						} elseif ($reader->localName == 'params' && $reader->nodeType == XMLReader::END_ELEMENT) {
							if (!empty($items) && $status == 'Ok') {
								$alw_zaberi_export_status = 'alw_zaberi_export_status_' . $items[0]['status'];

								if ($this->config->get($alw_zaberi_export_status)) {
									$this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . $this->db->escape($this->config->get($alw_zaberi_export_status)) . "' WHERE order_id = '" . (int)$order_id . "'");
								}

								if (isset($items[0]['tracker'])) {
									$tracker = $items[0]['tracker'];
								} else {
									$tracker = '';
								}

								$this->db->query("UPDATE " . DB_PREFIX . "alw_zaberi_order SET 
									tracker = '" . $this->db->escape($items[0]['tracker']) . "', 
									barcode = '" . $this->db->escape($items[0]['barcode']) . "', 
									status = '" . (int)$items[0]['status'] . "', 
									splus = '" . (float)$items[0]['splus'] . "', 
									sminus = '" . (float)$items[0]['sminus'] . "' 
									WHERE order_id = '" . (int)$order_id . "'");
								break;
							}
						}
					}
				}
			}

			$reader->close();
		}
	}

	function updateOrderStatuses($order_ids) {
		$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
				<methodCall>
					<methodName>get_orders_by_order_id</methodName>
					<client_name>" . $this->config->get('alw_zaberi_login') . "</client_name>
		         	<client_api_id>" . $this->config->get('alw_zaberi_key') . "</client_api_id>
					<params>
						<orders>";

		foreach ($order_ids as $order_id) {
			$xml .= 	"			<order_id>" . $order_id . "</order_id>";
		}

		$xml .= "		</orders>
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
						} elseif ($reader->localName == 'params' && $reader->nodeType == XMLReader::END_ELEMENT) {
							if (!empty($items) && $status == 'Ok') {
								foreach ($items as $item) {
									if (isset($item['status'])) {
										$alw_zaberi_export_status = 'alw_zaberi_export_status_' . $item['status'];

										if ($this->config->get($alw_zaberi_export_status)) {
											$this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . $this->db->escape($this->config->get($alw_zaberi_export_status)) . "' WHERE order_id = '" . (int)$item['order_id'] . "'");
										}

										$this->db->query("UPDATE " . DB_PREFIX . "alw_zaberi_order SET status = '" . (int)$item['status'] . "' WHERE order_id = '" . (int)$item['order_id'] . "'");
									}
								}

								break;
							}
						}
					}
				}
			}

			$reader->close();
		}
	}

	public function updateOrderPickup($order_id, $pickup_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "alw_zaberi_order SET final_pv = '" . $this->db->escape($pickup_id) . "' WHERE order_id = '" . (int)$order_id . "'");
	}

	public function install() {
		$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "alw_zaberi_order (
			order_id int(11) NOT NULL,
			int_number varchar(255) DEFAULT NULL,
			service tinyint(1) DEFAULT NULL,
			order_amount decimal(15,4) DEFAULT NULL,
			d_price decimal(15,4) DEFAULT NULL,
			fio varchar(255) DEFAULT NULL,
			phone varchar(255) DEFAULT NULL,
			city int(11) DEFAULT NULL,
			to_city int(11) DEFAULT NULL,
			comment varchar(255) DEFAULT NULL,
			start_pv varchar(255) DEFAULT NULL,
			final_pv varchar(255) DEFAULT NULL,
			weight float(15,2) DEFAULT NULL,
			zip varchar(255) DEFAULT NULL,
			rupost varchar(255) DEFAULT NULL,
			client_obl varchar(255) DEFAULT NULL,
			client_city varchar(255) DEFAULT NULL,
			address varchar(255) DEFAULT NULL,
			zip_c varchar(255) DEFAULT NULL,
			client_city_c varchar(255) DEFAULT NULL,
			address_c varchar(255) DEFAULT NULL,
			client_name_c varchar(255) DEFAULT NULL,
			org tinyint(1) DEFAULT NULL,
			izip varchar(255) DEFAULT NULL,
			icity varchar(255) DEFAULT NULL,
			iaddress varchar(255) DEFAULT NULL,
			iname varchar(255) DEFAULT NULL,
			iinn varchar(255) DEFAULT NULL,
			ibank varchar(255) DEFAULT NULL,
			irs varchar(255) DEFAULT NULL,
			iks varchar(255) DEFAULT NULL,
			ibik varchar(255) DEFAULT NULL,
			uid int(11) DEFAULT NULL,
			err_text varchar(255) DEFAULT NULL,
			tracker varchar(255) DEFAULT NULL,
			barcode varchar(255) DEFAULT NULL,
			splus decimal(15,4) DEFAULT NULL,
			sminus decimal(15,4) DEFAULT NULL,
			sms_status tinyint(1) DEFAULT NULL,
			status tinyint(2) DEFAULT NULL,
			pvz_address varchar(255) DEFAULT NULL,
			pvz_phone varchar(255) DEFAULT NULL,
			pvz_srok varchar(255) DEFAULT NULL,
			PRIMARY KEY (order_id) 
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci"
		);
	}

	public function uninstall() {
		$this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "alw_zaberi_order");
	}
}
?>