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
		<a href="<?php echo $settings; ?>" class="button" style="float: left;"><?php echo $button_settings; ?></a>
		<a href="<?php echo $orders; ?>" class="button" style="float: left;"><?php echo $button_orders; ?></a>
		<img src="view/image/setting.png" style="float: left;margin: 0 50px 0 10px;" />
		<?php if ($order['status'] < 1) { ?><a onclick="$('#form').submit();" class="button"><?php echo $button_send; ?></a><?php } ?>
		<a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a>
	  </div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div id="tabs" class="vtabs">
		<a href="#tab_data"><?php echo $tab_data; ?></a>
		<a href="#tab_product"><?php echo $tab_product; ?></a>
	  </div>
	  <div id="tab_data" class="vtabs-content">
		<table class="form">
          <tr>
            <td><?php echo $entry_status_export; ?></td>
            <td>
				<?php if ($order['status'] > 0) { ?>
					<b style="color: green;"><?php echo $text_export_success; ?></b>
				<?php } elseif ($order['status'] == 0 && !empty($order['err_text'])) { ?>
					<b style="color: red;"><?php echo $text_export_error; ?><?php echo $order['err_text']; ?></b>
				<?php } else { ?>
					<b><?php echo $text_export_null; ?></b>
				<?php } ?>
			</td>
		  </tr>
          <tr>
            <td><?php echo $entry_order_id; ?></td>
            <td><?php echo $order['order_id']; ?><input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>"/></td>
		  </tr>
          <tr>
            <td><?php echo $entry_int_number; ?></td>
            <td><input type="text" name="int_number" value="<?php echo $order['int_number']; ?>" style="width: 50%" /></td>
		  </tr>
          <tr>
            <td><?php echo $entry_service; ?></td>
            <td>
			  <?php if ($order['service'] == 1) { ?>
				<?php echo $tab_pickup; ?>
			  <?php } elseif ($order['service'] == 2) { ?>
				<?php echo $tab_courier; ?>
			  <?php } elseif ($order['service'] == 3) { ?>
				<?php echo $tab_pochta; ?>
			  <?php } ?>
			  <input type="hidden" name="service" value="<?php echo $order['service']; ?>"/>
			</td>
          <tr>
            <td><?php echo $entry_order_amount; ?></td>
            <td><input type="text" name="order_amount" value="<?php echo $order['order_amount']; ?>" style="width: 50%" /></td>
		  </tr>
          <tr>
            <td><?php echo $entry_d_price; ?></td>
            <td><input type="text" name="d_price" value="<?php echo $order['d_price']; ?>" style="width: 50%" /></td>
		  </tr>
          <tr>
            <td><?php echo $entry_fio; ?></td>
            <td><input type="text" name="fio" value="<?php echo $order['fio']; ?>" style="width: 50%" /></td>
		  </tr>
          <tr>
            <td><?php echo $entry_phone; ?></td>
            <td><input type="text" name="phone" value="<?php echo $order['phone']; ?>" style="width: 50%" /></td>
		  </tr>
          <tr>
            <td><?php echo $entry_city; ?></td>
            <td><?php echo $order['city']; ?><input type="hidden" name="city" value="<?php echo $order['city']; ?>"/></td>
		  </tr>
          <tr>
            <td><?php echo $entry_to_city; ?></td>
            <td><input type="text" name="to_city" value="<?php echo $order['to_city']; ?>" style="width: 50%" /></td>
		  </tr>
          <tr>
            <td><?php echo $entry_comment; ?></td>
            <td><input type="text" name="comment" value="<?php echo $order['comment']; ?>" style="width: 50%" /></td>
		  </tr>
          <tr>
            <td><?php echo $entry_start_pv; ?></td>
            <td>
				<select name="start_pv">
                  <option value="zt1" <?php if ($order['start_pv'] == 'zt1') { ?>selected="selected"<?php } ?>><?php echo $text_zt1; ?></option>
				  <option value="zt2" <?php if ($order['start_pv'] == 'zt2') { ?>selected="selected"<?php } ?>><?php echo $text_zt2; ?></option>
				  <option value="zt3" <?php if ($order['start_pv'] == 'zt3') { ?>selected="selected"<?php } ?>><?php echo $text_zt3; ?></option>
				  <option value="zt4" <?php if ($order['start_pv'] == 'zt4') { ?>selected="selected"<?php } ?>><?php echo $text_zt4; ?></option>
				  <option value="zt5" <?php if ($order['start_pv'] == 'zt5') { ?>selected="selected"<?php } ?>><?php echo $text_zt5; ?></option>
                </select>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_final_pv; ?></td>
            <td>
				<?php if ($order['service'] == 3) { ?>
					<input type="hidden" name="final_pv" value="<?php echo $order['final_pv']; ?>" style="width: 50%" />
				<?php } else { ?>
					<input type="text" name="final_pv" value="<?php echo $order['final_pv']; ?>" style="width: 50%" />
					</br><?php echo $order['pvz_address']; ?> <?php echo $order['pvz_phone']; ?> <?php echo $order['pvz_srok']; ?>
				<?php } ?>
			</td>
		  </tr>
          <tr>
            <td><?php echo $entry_weight; ?></td>
            <td><input type="text" name="weight" value="<?php echo $order['weight']; ?>" style="width: 50%" /></td>
		  </tr>
		  <tr>
            <td><?php echo $entry_tracker; ?></td>
            <td><?php echo $order['tracker']; ?></td>
		  </tr>
          <?php if ($order['service'] == 3) { ?>
		  <tr>
            <td><?php echo $entry_rupost; ?></td>
            <td>
				<select name="rupost">
                  <option value="1й класс" <?php if ($order['rupost'] == '1й класс') { ?>selected="selected"<?php } ?>>1й класс</option>
				  <option value="Обычная почта" <?php if ($order['rupost'] == 'Обычная почта') { ?>selected="selected"<?php } ?>>Обычная почта</option>
				  <option value="EMS" <?php if ($order['rupost'] == 'EMS') { ?>selected="selected"<?php } ?>>EMS</option>
                </select>
            </td>
          </tr>
		  <?php } else { ?>
			<input type="hidden" name="rupost" value="<?php echo $order['rupost']; ?>"/>
		  <?php } ?>
          <tr>
            <td><?php echo $entry_zip; ?></td>
            <td><input type="text" name="zip" value="<?php echo $order['zip']; ?>" style="width: 50%" /></td>
		  </tr>
          <tr>
            <td><?php echo $entry_client_obl; ?></td>
            <td><input type="text" name="client_obl" value="<?php echo $order['client_obl']; ?>" style="width: 50%" /></td>
		  </tr>
          <tr>
            <td><?php echo $entry_client_city; ?></td>
            <td><input type="text" name="client_city" value="<?php echo $order['client_city']; ?>" style="width: 50%" /></td>
		  </tr>
          <tr>
            <td><?php echo $entry_address; ?></td>
            <td><input type="text" name="address" value="<?php echo $order['address']; ?>" style="width: 50%" /></td>
		  </tr>
				<input type="hidden" name="zip_c" value="<?php echo $order['zip_c']; ?>"/>
				<input type="hidden" name="client_city_c" value="<?php echo $order['client_city_c']; ?>"/>
				<input type="hidden" name="address_c" value="<?php echo $order['address_c']; ?>"/>
				<input type="hidden" name="client_name_c" value="<?php echo $order['client_name_c']; ?>"/>
				<input type="hidden" name="org" value="<?php echo $order['org']; ?>"/>
				<input type="hidden" name="izip" value="<?php echo $order['izip']; ?>"/>
				<input type="hidden" name="icity" value="<?php echo $order['icity']; ?>"/>
				<input type="hidden" name="iaddress" value="<?php echo $order['iaddress']; ?>"/>
				<input type="hidden" name="iname" value="<?php echo $order['iname']; ?>"/>
				<input type="hidden" name="iinn" value="<?php echo $order['iinn']; ?>"/>
				<input type="hidden" name="ibank" value="<?php echo $order['ibank']; ?>"/>
				<input type="hidden" name="irs" value="<?php echo $order['irs']; ?>"/>
				<input type="hidden" name="iks" value="<?php echo $order['iks']; ?>"/>
				<input type="hidden" name="ibik" value="<?php echo $order['ibik']; ?>"/>
				<input type="hidden" name="shipping_code" value="<?php echo $order['shipping_code']; ?>"/>
          <?php if ($order['status'] < 1) { ?>
		  <tr>
            <td><?php echo $entry_type; ?></td>
            <td>
				<label><input type="radio" name="type"><?php echo $text_normal; ?></label></br>
				<?php if (isset($order['sklad']['zt1']) && count($order['sklad']['zt1']) == count($order['products'])) { ?><label><input type="radio" name="type" value="zt1"><?php echo $text_sklad; ?><?php echo $text_zt1; ?></label></br><?php } ?>
				<?php if (isset($order['sklad']['zt2']) && count($order['sklad']['zt2']) == count($order['products'])) { ?><label><input type="radio" name="type" value="zt2"><?php echo $text_sklad; ?><?php echo $text_zt2; ?></label></br><?php } ?>
				<?php if (isset($order['sklad']['zt3']) && count($order['sklad']['zt3']) == count($order['products'])) { ?><label><input type="radio" name="type" value="zt3"><?php echo $text_sklad; ?><?php echo $text_zt3; ?></label></br><?php } ?>
				<?php if (isset($order['sklad']['zt4']) && count($order['sklad']['zt4']) == count($order['products'])) { ?><label><input type="radio" name="type" value="zt4"><?php echo $text_sklad; ?><?php echo $text_zt4; ?></label></br><?php } ?>
				<?php if (isset($order['sklad']['zt5']) && count($order['sklad']['zt5']) == count($order['products'])) { ?><label><input type="radio" name="type" value="zt5"><?php echo $text_sklad; ?><?php echo $text_zt5; ?></label><?php } ?>
			</td>
		  </tr>
		  <?php } ?>
		</table>
	  </div>
	  <div id="tab_product" class="vtabs-content">
        <table class="list">
          <thead>
            <tr>
              <td class="center"><?php echo $column_image; ?></td>
              <td class="left"><?php echo $column_name; ?></td>
			  <td class="left"><?php echo $column_model; ?></td>
			  <td class="left"><?php echo $column_quantity; ?></td>
			  <td class="left"><?php echo $column_price; ?></td>
			  <td class="left"><?php echo $column_total; ?></td>
			  <td class="left"><?php echo $column_availability; ?><?php echo $text_zt1; ?></td>
			  <td class="left"><?php echo $column_availability; ?><?php echo $text_zt2; ?></td>
			  <td class="left"><?php echo $column_availability; ?><?php echo $text_zt3; ?></td>
			  <td class="left"><?php echo $column_availability; ?><?php echo $text_zt4; ?></td>
			  <td class="left"><?php echo $column_availability; ?><?php echo $text_zt5; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($order['products'] as $product) { ?>
			<input type="hidden" name="products[<?php echo $product['product_id']; ?>][art]" value="<?php echo $product['model']; ?>"/>
			<input type="hidden" name="products[<?php echo $product['product_id']; ?>][counts]" value="<?php echo $product['quantity']; ?>"/>
			<input type="hidden" name="products[<?php echo $product['product_id']; ?>][price_of_piece]" value="<?php echo $product['price']; ?>"/>
            <tr>
              <td class="center"><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" style="padding: 1px; border: 1px solid #DDDDDD;" /></td>
			  <td class="left"><a href="<?php echo $product['href']; ?>" target="_blank"><?php echo $product['name']; ?></a></td>
              <td class="left"><?php echo $product['model']; ?></td>
              <td class="left"><?php echo $product['quantity']; ?></td>
              <td class="left"><?php echo $product['price']; ?></td>
              <td class="left"><?php echo $product['total']; ?></td>
			  <?php if (isset($order['product_sklad'])) { ?>
			  <?php foreach ($order['product_sklad'] as $sklad) { ?>
				<?php if (isset($sklad['art']) && $sklad['art'] == $product['model']) { ?>
					<td class="left"><?php echo $sklad['zt1']; ?></td>
					<td class="left"><?php echo $sklad['zt2']; ?></td>
					<td class="left"><?php echo $sklad['zt3']; ?></td>
					<td class="left"><?php echo $sklad['zt4']; ?></td>
					<td class="left"><?php echo $sklad['zt5']; ?></td>
				<?php } ?>
			  <?php } ?>
			  <?php } else { ?>
				<td class="left"></td>
				<td class="left"></td>
				<td class="left"></td>
				<td class="left"></td>
				<td class="left"></td>
			  <?php } ?>
            </tr>
            <?php } ?>
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