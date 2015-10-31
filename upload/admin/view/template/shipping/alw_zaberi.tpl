<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <?php if ($warning) { ?>
  <div class="warning"><?php echo $warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/shipping.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
		<a style="background: #ccc; cursor: default; float: left;" class="button"><?php echo $button_settings; ?></a>
		<a href="<?php echo $orders; ?>" class="button" style="float: left;"><?php echo $button_orders; ?></a>
		<img src="view/image/setting.png" style="float: left;margin: 0 50px 0 10px;" />
		<a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a>
		<a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a>
	  </div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div id="tabs" class="vtabs">
		<a href="#tab_settings"><?php echo $tab_settings; ?></a>
		<a href="#tab_courier"><?php echo $tab_courier; ?></a>
		<a href="#tab_pickup"><?php echo $tab_pickup; ?></a>
		<a href="#tab_pochta"><?php echo $tab_pochta; ?></a>
		<a href="#tab_export"><?php echo $tab_export; ?></a>
		<a href="#tab_status"><?php echo $tab_status; ?></a>
	  </div>

      <div id="tab_settings" class="vtabs-content">
		<table class="form">
          <tr>
            <td><?php echo $entry_login; ?></td>
            <td><input type="text" name="settings[alw_zaberi_login]" value="<?php echo $alw_zaberi_login; ?>" style="width: 50%" /></td>
		  </tr>
          <tr>
            <td><?php echo $entry_key; ?></td>
            <td><input type="text" name="settings[alw_zaberi_key]" value="<?php echo $alw_zaberi_key; ?>" style="width: 50%" /></td>
		  </tr>
          <tr>
            <td><?php echo $entry_title; ?></td>
			<td><input type="text" name="settings[alw_zaberi_title]" value="<?php echo $alw_zaberi_title; ?>" style="width: 50%" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_country; ?></td>
            <td>
				<select name="settings[alw_zaberi_country]">
                  <option value="0"><?php echo $text_none; ?></option>
				  <?php foreach ($countries as $country) { ?>
                  <?php if ($country['country_id'] == $alw_zaberi_country) { ?>
                  <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
			</td>
          </tr>
          <tr>
            <td><?php echo $entry_weight_class; ?></td>
            <td>
				<select name="settings[alw_zaberi_weight_class_id]">
                  <?php foreach ($weight_classes as $weight_class) { ?>
                  <?php if ($weight_class['weight_class_id'] == $alw_zaberi_weight_class_id) { ?>
                  <option value="<?php echo $weight_class['weight_class_id']; ?>" selected="selected"><?php echo $weight_class['title']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $weight_class['weight_class_id']; ?>"><?php echo $weight_class['title']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
			</td>
          </tr>
          <tr>
            <td><?php echo $entry_paied_order; ?></td>
            <td>
				<select name="settings[alw_zaberi_order_status_id]">
                  <?php foreach ($order_statuses as $order_status) { ?>
                  <?php if ($order_status['order_status_id'] == $alw_zaberi_order_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
			</td>
          </tr>
          <tr>
            <td><?php echo $entry_default_weight; ?></td>
            <td><input type="text" name="settings[alw_zaberi_default_weight]" value="<?php echo $alw_zaberi_default_weight; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_added_weight; ?></td>
            <td><input type="text" name="settings[alw_zaberi_added_weight]" value="<?php echo $alw_zaberi_added_weight; ?>" /></td>
          </tr> 
          <tr>
            <td><?php echo $entry_sort_order; ?></td>
            <td><input type="text" name="settings[alw_zaberi_sort_order]" value="<?php echo $alw_zaberi_sort_order; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td>
				<select name="settings[alw_zaberi_status]">
                <?php if ($alw_zaberi_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
			</td>
          </tr>
          <tr>
            <td><?php echo $entry_cache; ?></td>
            <td>
				<select name="settings[alw_zaberi_cache]">
                <?php if ($alw_zaberi_cache) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
			</td>
          </tr>
          <tr>
            <td><?php echo $entry_debug; ?></td>
            <td>
				<select name="settings[alw_zaberi_debug]">
                <?php if ($alw_zaberi_debug) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
			</td>
          </tr>
        </table>
	  </div>

	  <div id="tab_courier" class="vtabs-content">
		<table class="form">
          <tr>
            <td><?php echo $entry_desc_courier; ?></td>
			<td><input type="text" name="courier[alw_zaberi_description_courier]" value="<?php echo $alw_zaberi_description_courier; ?>" style="width: 50%" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_min_cost; ?></td>
            <td><input type="text" name="courier[alw_zaberi_min_cost_courier]" value="<?php echo $alw_zaberi_min_cost_courier; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_max_cost; ?></td>
            <td><input type="text" name="courier[alw_zaberi_max_cost_courier]" value="<?php echo $alw_zaberi_max_cost_courier; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_status_rus; ?></td>
            <td><select name="courier[alw_zaberi_status_rus_courier]">
                <?php if ($alw_zaberi_status_rus_courier) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_tax_class; ?></td>
            <td><select name="courier[alw_zaberi_tax_class_id_courier]">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php foreach ($tax_classes as $tax_class) { ?>
                  <?php if ($tax_class['tax_class_id'] == $alw_zaberi_tax_class_id_courier) { ?>
                  <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_geo_zone; ?></td>
            <td><select name="courier[alw_zaberi_geo_zone_id_courier]">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $alw_zaberi_geo_zone_id_courier) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="courier[alw_zaberi_status_courier]">
                <?php if ($alw_zaberi_status_courier) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
        </table>
	  </div>

	  <div id="tab_pickup" class="vtabs-content">
		<table class="form">
          <tr>
            <td><?php echo $entry_desc_pickup; ?></td>
			<td><input type="text" name="pickup[alw_zaberi_description_pickup]" value="<?php echo $alw_zaberi_description_pickup; ?>" style="width: 50%" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_map; ?></td>
            <td><select name="pickup[alw_zaberi_map_pickup]">
                <?php if ($alw_zaberi_map_pickup) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_min_cost; ?></td>
            <td><input type="text" name="pickup[alw_zaberi_min_cost_pickup]" value="<?php echo $alw_zaberi_min_cost_pickup; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_max_cost; ?></td>
            <td><input type="text" name="pickup[alw_zaberi_max_cost_pickup]" value="<?php echo $alw_zaberi_max_cost_pickup; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_status_rus; ?></td>
            <td><select name="pickup[alw_zaberi_status_rus_pickup]">
                <?php if ($alw_zaberi_status_rus_pickup) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_tax_class; ?></td>
            <td><select name="pickup[alw_zaberi_tax_class_id_pickup]">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php foreach ($tax_classes as $tax_class) { ?>
                  <?php if ($tax_class['tax_class_id'] == $alw_zaberi_tax_class_id_pickup) { ?>
                  <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_geo_zone; ?></td>
            <td><select name="pickup[alw_zaberi_geo_zone_id_pickup]">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $alw_zaberi_geo_zone_id_pickup) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="pickup[alw_zaberi_status_pickup]">
                <?php if ($alw_zaberi_status_pickup) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
        </table>
	  </div>

	  <div id="tab_pochta" class="vtabs-content">
		<table class="form">
          <tr>
            <td><?php echo $entry_desc_pochta; ?></td>
			<td><input type="text" name="pochta[alw_zaberi_description_pochta]" value="<?php echo $alw_zaberi_description_pochta; ?>" style="width: 50%" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_pochta_cost; ?></td>
            <td><input type="text" name="pochta[alw_zaberi_cost_pochta]" value="<?php echo $alw_zaberi_cost_pochta; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_min_cost; ?></td>
            <td><input type="text" name="pochta[alw_zaberi_min_cost_pochta]" value="<?php echo $alw_zaberi_min_cost_pochta; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_max_cost; ?></td>
            <td><input type="text" name="pochta[alw_zaberi_max_cost_pochta]" value="<?php echo $alw_zaberi_max_cost_pochta; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_status_rus; ?></td>
            <td><select name="pochta[alw_zaberi_status_rus_pochta]">
                <?php if ($alw_zaberi_status_rus_pochta) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_tax_class; ?></td>
            <td><select name="pochta[alw_zaberi_tax_class_id_pochta]">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php foreach ($tax_classes as $tax_class) { ?>
                  <?php if ($tax_class['tax_class_id'] == $alw_zaberi_tax_class_id_pochta) { ?>
                  <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_geo_zone; ?></td>
            <td><select name="pochta[alw_zaberi_geo_zone_id_pochta]">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $alw_zaberi_geo_zone_id_pochta) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="pochta[alw_zaberi_status_pochta]">
                <?php if ($alw_zaberi_status_pochta) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
        </table>
	  </div>

	  <div id="tab_export" class="vtabs-content">
		<table class="form">
          <tr>
            <td><?php echo $entry_start_pv; ?></td>
            <td>
				<select name="settings[alw_zaberi_export_start_pv]">
                  <option value="zt1" <?php if ($alw_zaberi_export_start_pv == 'zt1') { ?>selected="selected"<?php } ?>>Озерки (zt1)</option>
				  <option value="zt2" <?php if ($alw_zaberi_export_start_pv == 'zt2') { ?>selected="selected"<?php } ?>>Ленинский (zt2)</option>
				  <option value="zt3" <?php if ($alw_zaberi_export_start_pv == 'zt3') { ?>selected="selected"<?php } ?>>Дыбенко (zt3)</option>
				  <option value="zt4" <?php if ($alw_zaberi_export_start_pv == 'zt4') { ?>selected="selected"<?php } ?>>Международная (zt4)</option>
				  <option value="zt5" <?php if ($alw_zaberi_export_start_pv == 'zt5') { ?>selected="selected"<?php } ?>>Пискаревский (zt5)</option>
                </select>
            </td>
          </tr>
		</table>
		<table class="form">
		  <h2><?php echo $text_pochta_without; ?></h2>
          <tr>
            <td><?php echo $entry_rupost; ?></td>
            <td>
				<select name="settings[alw_zaberi_export_rupost]">
                  <option value="1й класс" <?php if ($alw_zaberi_export_rupost == '1й класс') { ?>selected="selected"<?php } ?>>1й класс</option>
				  <option value="Обычная почта" <?php if ($alw_zaberi_export_rupost == 'Обычная почта') { ?>selected="selected"<?php } ?>>Обычная почта</option>
				  <option value="EMS" <?php if ($alw_zaberi_export_rupost == 'EMS') { ?>selected="selected"<?php } ?>>EMS</option>
                </select>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_zip_c; ?></td>
			<td><input type="text" name="settings[alw_zaberi_export_zip_c]" value="<?php echo $alw_zaberi_export_zip_c; ?>" style="width: 50%" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_client_city_c; ?></td>
			<td><input type="text" name="settings[alw_zaberi_export_client_city_c]" value="<?php echo $alw_zaberi_export_client_city_c; ?>" style="width: 50%" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_address_c; ?></td>
			<td><input type="text" name="settings[alw_zaberi_export_address_c]" value="<?php echo $alw_zaberi_export_address_c; ?>" style="width: 50%" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_client_name_c; ?></td>
			<td><input type="text" name="settings[alw_zaberi_export_client_name_c]" value="<?php echo $alw_zaberi_export_client_name_c; ?>" style="width: 50%" /></td>
          </tr>
		</table>
		<table class="form">
          <h2><?php echo $text_pochta_with; ?></h2>
		  <tr>
            <td><?php echo $entry_org; ?></td>
            <td>
				<select name="settings[alw_zaberi_export_org]">
                  <option value="1" <?php if ($alw_zaberi_export_org == 1) { ?>selected="selected"<?php } ?>>Юр. лицо</option>
				  <option value="2" <?php if ($alw_zaberi_export_org == 2) { ?>selected="selected"<?php } ?>>Физ. лицо</option>
                </select>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_izip; ?></td>
			<td><input type="text" name="settings[alw_zaberi_export_izip]" value="<?php echo $alw_zaberi_export_izip; ?>" style="width: 50%" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_icity; ?></td>
			<td><input type="text" name="settings[alw_zaberi_export_icity]" value="<?php echo $alw_zaberi_export_icity; ?>" style="width: 50%" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_iaddress; ?></td>
			<td><input type="text" name="settings[alw_zaberi_export_iaddress]" value="<?php echo $alw_zaberi_export_iaddress; ?>" style="width: 50%" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_iname; ?></td>
			<td><input type="text" name="settings[alw_zaberi_export_iname]" value="<?php echo $alw_zaberi_export_iname; ?>" style="width: 50%" /></td>
          </tr>
		</table>
		<table class="form"> 
          <h2><?php echo $text_pochta_ur; ?></h2>
		  <tr>
            <td><?php echo $entry_iinn; ?></td>
			<td><input type="text" name="settings[alw_zaberi_export_iinn]" value="<?php echo $alw_zaberi_export_iinn; ?>" style="width: 50%" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_ibank; ?></td>
			<td><input type="text" name="settings[alw_zaberi_export_ibank]" value="<?php echo $alw_zaberi_export_ibank; ?>" style="width: 50%" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_irs; ?></td>
			<td><input type="text" name="settings[alw_zaberi_export_irs]" value="<?php echo $alw_zaberi_export_irs; ?>" style="width: 50%" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_iks; ?></td>
			<td><input type="text" name="settings[alw_zaberi_export_iks]" value="<?php echo $alw_zaberi_export_iks; ?>" style="width: 50%" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_ibik; ?></td>
			<td><input type="text" name="settings[alw_zaberi_export_ibik]" value="<?php echo $alw_zaberi_export_ibik; ?>" style="width: 50%" /></td>
          </tr>
        </table>
	  </div>

	  <div id="tab_status" class="vtabs-content">
        <table class="list">
          <thead>
            <tr>
              <td class="right"><?php echo $text_status_export; ?></td>
              <td class="left"><?php echo $text_status_order; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="right"><?php echo $text_export_success_1; ?></td>
              <td class="left">
				<select name="settings[alw_zaberi_export_status_1]">
                  <option value="0"><?php echo $text_none; ?></option>
				  <?php foreach ($order_statuses as $order_status) { ?>
                  <?php if ($order_status['order_status_id'] == $alw_zaberi_export_status_1) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
			  </td>
            </tr>
            <tr>
              <td class="right"><?php echo $text_export_success_2; ?></td>
              <td class="left">
				<select name="settings[alw_zaberi_export_status_2]">
                  <option value="0"><?php echo $text_none; ?></option>
				  <?php foreach ($order_statuses as $order_status) { ?>
                  <?php if ($order_status['order_status_id'] == $alw_zaberi_export_status_2) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
			  </td>
            </tr>
            <tr>
              <td class="right"><?php echo $text_export_success_3; ?></td>
              <td class="left">
				<select name="settings[alw_zaberi_export_status_3]">
                  <option value="0"><?php echo $text_none; ?></option>
				  <?php foreach ($order_statuses as $order_status) { ?>
                  <?php if ($order_status['order_status_id'] == $alw_zaberi_export_status_3) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
			  </td>
            </tr>
            <tr>
              <td class="right"><?php echo $text_export_success_5; ?></td>
              <td class="left">
				<select name="settings[alw_zaberi_export_status_5]">
                  <option value="0"><?php echo $text_none; ?></option>
				  <?php foreach ($order_statuses as $order_status) { ?>
                  <?php if ($order_status['order_status_id'] == $alw_zaberi_export_status_5) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
			  </td>
            </tr>
            <tr>
              <td class="right"><?php echo $text_export_success_10; ?></td>
              <td class="left">
				<select name="settings[alw_zaberi_export_status_10]">
                  <option value="0"><?php echo $text_none; ?></option>
				  <?php foreach ($order_statuses as $order_status) { ?>
                  <?php if ($order_status['order_status_id'] == $alw_zaberi_export_status_10) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
			  </td>
            </tr>
            <tr>
              <td class="right"><?php echo $text_export_success_49; ?></td>
              <td class="left">
				<select name="settings[alw_zaberi_export_status_49]">
                  <option value="0"><?php echo $text_none; ?></option>
				  <?php foreach ($order_statuses as $order_status) { ?>
                  <?php if ($order_status['order_status_id'] == $alw_zaberi_export_status_49) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
			  </td>
            </tr>
            <tr>
              <td class="right"><?php echo $text_export_success_50; ?></td>
              <td class="left">
				<select name="settings[alw_zaberi_export_status_50]">
                  <option value="0"><?php echo $text_none; ?></option>
				  <?php foreach ($order_statuses as $order_status) { ?>
                  <?php if ($order_status['order_status_id'] == $alw_zaberi_export_status_50) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
			  </td>
            </tr>
            <tr>
              <td class="right"><?php echo $text_export_success_51; ?></td>
              <td class="left">
				<select name="settings[alw_zaberi_export_status_51]">
                  <option value="0"><?php echo $text_none; ?></option>
				  <?php foreach ($order_statuses as $order_status) { ?>
                  <?php if ($order_status['order_status_id'] == $alw_zaberi_export_status_51) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
			  </td>
            </tr>
          </tbody>
        </table>
	  </div>

      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script>
<?php echo $footer; ?>