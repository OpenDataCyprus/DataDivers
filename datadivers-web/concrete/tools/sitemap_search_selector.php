<?php
defined('C5_EXECUTE') or die("Access Denied.");
$sh = Loader::helper('concrete/dashboard/sitemap');
if (!$sh->canRead()) {
	die(t('Access Denied.') . ' ' . t('You do not have access to the sitemap.'));
}

$v = View::getInstance();
$v->requireAsset('core/sitemap');

/*

$select_mode = Loader::helper('text')->entities($_REQUEST['sitemap_select_mode']);
$callback = Loader::helper('text')->entities($_REQUEST['callback']);

if (Loader::helper('validation/numbers')->integer($_REQUEST['cID']) && $select_mode == 'move_copy_delete') {
	$cID = '&cID=' . $_REQUEST['cID'];
} else {
	$cID = '';
}

if ($callback) {
	$callback = '&callback=' . addslashes($callback);
}
*/

if (isset($_REQUEST['requestID']) && Loader::helper('validation/numbers')->integer($_REQUEST['requestID'])) {
	$requestID = $_REQUEST['requestID'];
}

?>
<div class="ccm-ui" id="ccm-sitemap-search-selector">

<?php echo Loader::helper('concrete/ui')->tabs(array(
	array('sitemap', t('Full Sitemap')),
	array('explore', t('Flat View')),
	array('search', t('Search'))
));
?>

<div id="ccm-tab-content-sitemap"></div>

<div id="ccm-tab-content-explore"></div>

<div id="ccm-tab-content-search"></div>

</div>

<script type="text/javascript">
ccm_sitemapSearchSelectorHideBottom = function() {
	$('#ccm-sitemap-search-selector').parent().parent().find('.ui-dialog-buttonpane').hide();
}

ccm_sitemapSearchSelectorShowBottom = function() {
	$('#ccm-sitemap-search-selector').parent().parent().find('.ui-dialog-buttonpane').show();
}


$(function() {
	var sst = jQuery.cookie('ccm-sitemap-selector-tab');
	if (sst != 'explore' && sst != 'search') {
		sst = 'sitemap';
	}
	$('a[data-tab=' + sst + ']').parent().addClass('active');
	ccm_sitemapSearchSelectorHideBottom();
	$('a[data-tab=sitemap]').click(function() {
		jQuery.cookie('ccm-sitemap-selector-tab', 'sitemap', {path: '<?php echo DIR_REL?>/'});
		ccm_sitemapSearchSelectorHideBottom();
		if ($('#ccm-tab-content-sitemap').html() == '') { 
			jQuery.fn.dialog.showLoader();
			$('#ccm-tab-content-sitemap').load('<?php echo REL_DIR_FILES_TOOLS_REQUIRED?>/sitemap_overlay?requestID=<?php echo $requestID?>', function() {
				jQuery.fn.dialog.hideLoader();
			});
		}
	});
	$('a[data-tab=explore]').click(function() {
		jQuery.cookie('ccm-sitemap-selector-tab', 'explore', {path: '<?php echo DIR_REL?>/'});
		ccm_sitemapSearchSelectorHideBottom();
		if ($('#ccm-tab-content-explore').html() == '') { 
			jQuery.fn.dialog.showLoader();
			$('#ccm-tab-content-explore').load('<?php echo REL_DIR_FILES_TOOLS_REQUIRED?>/sitemap_overlay?display=flat&requestID=<?php echo $requestID?>', function() {
				jQuery.fn.dialog.hideLoader();
			});
		}
	});
	$('a[data-tab=search]').click(function() {
		jQuery.cookie('ccm-sitemap-selector-tab', 'search', {path: '<?php echo DIR_REL?>/'});
		ccm_sitemapSearchSelectorShowBottom();
		if ($('#ccm-tab-content-search').html() == '') { 
			jQuery.fn.dialog.showLoader();
			$('#ccm-tab-content-search').load('<?php echo URL::to('/ccm/system/dialogs/page/search')?>', function() {
				jQuery.fn.dialog.hideLoader();
			});
		}
	});

	$('#ccm-sitemap-search-selector ul li.active a').click();
});
</script>