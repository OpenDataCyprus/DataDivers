<?php
defined('C5_EXECUTE') or die("Access Denied.");
$form = Loader::helper('form');

$searchFields = $controller->getSearchFields();

if (Config::get('concrete.permissions.model') != 'simple') {
    $searchFields['permissions_inheritance'] = t('Permissions Inheritance');
}

$flr = new \Concrete\Core\Search\StickyRequest('pages');
$req = $flr->getSearchRequest();

?>

<script type="text/template" data-template="search-form">
<form role="form" data-search-form="pages" action="<?php echo URL::to('/ccm/system/search/pages/submit')?>" class="ccm-search-fields">
	<div class="ccm-search-fields-row form-inline">
	<div class="form-group">
		<select data-bulk-action="pages" disabled class="ccm-search-bulk-action form-control">
			<option value=""><?php echo t('Items Selected')?></option>
			<option data-bulk-action-type="dialog" data-bulk-action-title="<?php echo t('Page Properties')?>" data-bulk-action-url="<?php echo URL::to('/ccm/system/dialogs/page/bulk/properties')?>" data-bulk-action-dialog-width="630" data-bulk-action-dialog-height="450"><?php echo t('Edit Properties')?></option>
			<option data-bulk-action-type="dialog" data-bulk-action-title="<?php echo t('Move/Copy')?>" data-bulk-action-url="<?php echo REL_DIR_FILES_TOOLS_REQUIRED?>/sitemap_search_selector" data-bulk-action-dialog-width="90%" data-bulk-action-dialog-height="70%"><?php echo t('Move/Copy')?></option>
<?php /*	    <option data-bulk-action-type="dialog" data-bulk-action-title="<?=t('Speed Settings')?>" data-bulk-action-url="<?=REL_DIR_FILES_TOOLS_REQUIRED?>/pages/speed_settings" data-bulk-action-dialog-width="610" data-bulk-action-dialog-height="340"><?=t('Speed Settings')?></option>
			<?php if (Config::get('concrete.permissions.model') == 'advanced') { ?>
				<option data-bulk-action-type="dialog" data-bulk-action-title="<?=t('Change Permissions')?>" data-bulk-action-url="<?=REL_DIR_FILES_TOOLS_REQUIRED?>/pages/permissions" data-bulk-action-dialog-width="430" data-bulk-action-dialog-height="630"><?=t('Change Permissions')?></option>
				<option data-bulk-action-type="dialog" data-bulk-action-title="<?=t('Change Permissions - Add Access')?>" data-bulk-action-url="<?=REL_DIR_FILES_TOOLS_REQUIRED?>/pages/permissions_access?task=add" data-bulk-action-dialog-width="440" data-bulk-action-dialog-height="200"><?=t('Change Permissions - Add Access')?></option>
				<option data-bulk-action-type="dialog" data-bulk-action-title="<?=t('Change Permissions - Remove Access')?>" data-bulk-action-url="<?=REL_DIR_FILES_TOOLS_REQUIRED?>/pages/permissions_access?task=remove" data-bulk-action-dialog-width="440" data-bulk-action-dialog-height="300"><?=t('Change Permissions - Remove Access')?></option>
			<?php } ?>
			<option data-bulk-action-type="dialog" data-bulk-action-title="<?=t('Design')?>" data-bulk-action-url="<?=REL_DIR_FILES_TOOLS_REQUIRED?>/pages/design" data-bulk-action-dialog-width="610" data-bulk-action-dialog-height="405"><?=t('Design')?></option>
 */ ?>
			<option data-bulk-action-type="dialog" data-bulk-action-title="<?php echo t('Delete')?>" data-bulk-action-url="<?php echo REL_DIR_FILES_TOOLS_REQUIRED?>/pages/delete" data-bulk-action-dialog-width="500" data-bulk-action-dialog-height="400"><?php echo t('Delete')?></option>
		</select>
	</div>
	<div class="form-group">
		<div class="ccm-search-main-lookup-field">
			<i class="fa fa-search"></i>
			<?php echo $form->search('cvName', $req['cvName'], array('placeholder' => t('Page Name')))?>
			<button type="submit" class="ccm-search-field-hidden-submit" tabindex="-1"><?php echo t('Search')?></button>
		</div>
	</div>
	<ul class="ccm-search-form-advanced list-inline">
		<li><a href="#" data-search-toggle="advanced"><?php echo t('Advanced Search')?></a>
		<li><a href="#" data-search-toggle="customize" data-search-column-customize-url="<?php echo URL::to('/ccm/system/dialogs/page/search/customize')?>"><?php echo t('Customize Results')?></a>
	</ul>
	</div>
	<div class="ccm-search-fields-advanced"></div>
	<div class="ccm-search-fields-row ccm-search-fields-submit">
		<div class="form-group form-group-full">
			<label class="control-label"><?php echo t('Per Page')?></label>
			<div class="ccm-search-field-content ccm-search-field-content-select2">
				<?php echo $form->select('numResults', array(10 => t('10'), 20 => t('20'), 50 => t('50'), 100 => t('100'), 250 => t('250'), 500 => t('500'), 1000 => t('1000'))); ?>
			</div>
		</div>
		<button type="submit" class="btn btn-primary pull-right"><?php echo t('Search')?></button>
	</div>

</form>
</script>

<script type="text/template" data-template="search-field-row">
<div class="ccm-search-fields-row">
	<select name="field[]" class="ccm-search-choose-field" data-search-field="pages">
		<option value=""><?php echo t('Choose Field')?></option>
		<?php foreach ($searchFields as $key => $value) { ?>
			<option value="<?php echo $key?>" <% if (typeof(field) != 'undefined' && field.field == '<?php echo $key?>') { %>selected<% } %> data-search-field-url="<?php echo URL::to('/ccm/system/search/pages/field', $key)?>"><?php echo $value?></option>
		<?php } ?>
	</select>
	<div class="ccm-search-field-content"><% if (typeof(field) != 'undefined') { %><%=field.html%><% } %></div>
	<a data-search-remove="search-field" class="ccm-search-remove-field" href="#"><i class="fa fa-minus-circle"></i></a>
</div>
</script>

<script type="text/template" data-template="search-results-table-body">
<% _.each(items, function (page) {%>
<tr data-launch-search-menu="<%=page.cID%>" data-page-id="<%=page.cID%>" data-page-name="<%=page.cvName%>">
	<td><span class="ccm-search-results-checkbox"><input type="checkbox" class="ccm-flat-checkbox" data-search-checkbox="individual" value="<%=page.cID%>" /></span></td>
	<% for (i = 0; i < page.columns.length; i++) {
		var column = page.columns[i];
		if (column.key == 'cvName') { %>
			<td class="ccm-search-results-name"><%=column.value%></td>
		<% } else { %>
			<td><%=column.value%></td>
		<% } %>
	<% } %>
</tr>
<% }); %>
</script>

<?php Loader::element('search/template')?>
