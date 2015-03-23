<?php
function gbcart_orders_page() {
	?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"></div>
		<h2>GBCart Orders</h2>

		<div id="poststuff" class="ui-sortable meta-box-sortables">
			<div class="postbox">
				<h3>Orders</h3>
				<div class="inside">
					<table id="dg" title="Items" class="easyui-datagrid" style="width:900px;height:250px;" url="<?php echo GBC_PLUGIN_URL; ?>/get_orders.php" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true">
						<thead>
							<tr>
								<th field="orderID">ID</th>
								<th field="orderName">Name</th>
								<th field="orderLastName">Last Name</th>
								<th field="orderCompany">Company</th>
								<th field="orderLocation">Location</th>
								<th field="orderEmail">Email</th>
								<th field="orderPhone">Phone</th>
								<th field="orderAddress1">Address 1</th>
								<th field="orderAddress2">Address 2</th>
								<th field="orderComments">Comments</th>
								<th field="orderCart">Cart</th>
								<th field="orderDate">Date</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>

			<h2>GBCart Description</h2>
			<p>Place one of the existing shortcodes in your post or page. Check the Dashboard page for all possible shortcode combinations.</p>
			<p><em>You are using <b>GBCart</b> version <b><?php echo GBC_PLUGIN_VERSION; ?></b>.</em></p>

			<p>For more information and updates, visit the <a href="http://getbutterfly.com/wordpress-plugins/gbcart/" rel="external">official web site</a></p>
		</div>
	</div>	
<?php } ?>
