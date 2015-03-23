<?php
function gbcart_dashboard_page() {
	echo '
	<div class="wrap">
		<div id="icon-options-general" class="icon32"></div>
		<h2>GBCart Settings</h2>

		<div id="poststuff" class="ui-sortable meta-box-sortables">
			<div class="postbox">
				<h3>Dashboard</h3>
				<div class="inside">';
					?>
					<h3>Item Catalogue</h3>
					<script>
						var url;
						function newUser(){
							jQuery('#dlg').dialog('open').dialog('setTitle','New Item');
							jQuery('#fm').form('clear');
							url = '<?php echo GBC_PLUGIN_URL; ?>/save_user.php';
						}
						function editUser(){
							var row = jQuery('#dg').datagrid('getSelected');
							if (row){
								jQuery('#dlg').dialog('open').dialog('setTitle','Edit Item');
								jQuery('#fm').form('load',row);
								url = '<?php echo GBC_PLUGIN_URL; ?>/update_user.php?id='+row.itemId;
							}
						}
						function saveUser(){
							jQuery('#fm').form('submit',{
								url: url,
								onSubmit: function(){
									return jQuery(this).form('validate');
								},
								success: function(result){
									var result = eval('('+result+')');
									if(result.success){
										jQuery('#dlg').dialog('close'); // close the dialog
										jQuery('#dg').datagrid('reload'); // reload the user data
									}
								}
							});
						}
						function removeUser(){
							var row = jQuery('#dg').datagrid('getSelected');
							if(row) {
                                jQuery.post('<?php echo GBC_PLUGIN_URL; ?>/remove_user.php',{id:row.itemId}, function(result){
                                    if(result.success){
                                        jQuery('#dg').datagrid('reload'); // reload the user data
                                    }
                                }, 'json');
							}
						}
					</script>

					<table id="dg" title="Items" class="easyui-datagrid" style="width:800px;height:350px;" url="<?php echo GBC_PLUGIN_URL; ?>/get_users.php" toolbar="#toolbar" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true">
						<thead>
							<tr>
								<th field="itemId" width="20">ID</th>
								<th field="itemName" width="90">Name</th>
								<th field="itemDesc" width="110">Description</th>
								<th field="itemPrice" width="40">Price</th>
								<th field="itemDiscount" width="20">Discount</th>
								<th field="itemCategory" width="20">Category</th>
							</tr>
						</thead>
					</table>
					<div id="toolbar">
						<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()"><i class="fa fa-plus-square"></i> New Item</a>
						<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()"><i class="fa fa-pencil-square"></i> Edit Item</a>
						<a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="removeUser()"><i class="fa fa-minus-square"></i> Remove Item</a>
					</div>
	
					<div id="dlg" class="easyui-dialog" style="width:400px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
						<div class="ftitle">User Information</div>
						<form id="fm" method="post" novalidate>
							<input name="itemID" type="hidden">
							<div class="fitem"><label>Name:</label><input name="itemName" type="text" required></div>
							<div class="fitem"><label>Description:</label><input name="itemDesc" type="text" required></div>
							<div class="fitem"><label>Price:</label><input name="itemPrice" type="text"></div>
							<div class="fitem"><label>Discount:</label><input name="itemDiscount" type="text"></div>
							<div class="fitem"><label>Category:</label><input name="itemCategory" type="text"></div>
						</form>
					</div>
					<div id="dlg-buttons">
						<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveUser()">Save</a>
						<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="jQuery('#dlg').dialog('close')">Cancel</a>
					</div>

					<h3>Help and support</h3>
					<p><code>[gbcart]</code> - displays the products in a zebra table</p>
					<p><code>[gbcart category="School Books"]</code> - displays the selected category products in a zebra table</p>
					<p><code>[gbsearch]</code> - displays a search input form</p>
					<p><code>[gbcheckout]</code> - displays the shopping cart and the checkout form</p>
					<p>Check the <a href="http://getbutterfly.com/wordpress-plugins/gbcart/" rel="external">official web site</a> for news, updates and general help.</p>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
