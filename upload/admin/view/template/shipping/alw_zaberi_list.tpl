<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/shipping.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
		<a href="<?php echo $settings; ?>" class="button" style="float: left;"><?php echo $button_settings; ?></a>
		<a class="button" style="background: #ccc; cursor: default; float: left;"><?php echo $button_orders; ?></a>
		<img src="view/image/setting.png" style="float: left;margin: 0 50px 0 10px;" />
		<a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a>
	  </div>
    </div>
    <div class="content">
      <form action="" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td class="center"><?php echo $column_order_id; ?></td>
              <td class="left"><?php echo $column_customer; ?></td>
			  <td class="left"><?php echo $column_total; ?></td>
			  <td class="left"><?php echo $column_shipping; ?></td>
              <td class="center"><?php echo $column_status; ?></td>
              <td class="center"></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($orders) { ?>
            <?php foreach ($orders as $order) { ?>
            <tr>
              <td class="center"><a href="<?php echo $order['href']; ?>" target="_blank"><?php echo $order['order_id']; ?></a></td>
              <td class="left"><?php echo $order['customer']; ?></td>
              <td class="left"><?php echo $order['total']; ?></td>
			  <td class="left"><?php echo $order['shipping_method']; ?></td>
              <td class="center"><?php echo $order['status']; ?></td>
              <td class="center"><a href="<?php echo $order['form']; ?>" class="button"><?php echo $button_export; ?></a></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<?php echo $footer; ?>