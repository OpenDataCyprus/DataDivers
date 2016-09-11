<?php
defined('C5_EXECUTE') or die("Access Denied.");
$templates = array();
$pagetype = $set->getPagetypeObject();
foreach($pagetype->getPageTypePageTemplateObjects() as $template) {
	$templates[$template->getPageTemplateID()] = $template->getPageTemplateDisplayName();
}
$ptComposerPageTemplateID = $control->getPageTypeComposerControlDraftValue();
if (!$ptComposerPageTemplateID) {
	$ptComposerPageTemplateID = $pagetype->getPageTypeDefaultPageTemplateID();
}
?>

<div class="form-group">
	<label class="control-label"><?php echo $label?></label>
	<?php if($description): ?>
	<i class="fa fa-question-circle launch-tooltip" title="" data-original-title="<?php echo $description?>"></i>
	<?php endif; ?>
	<div data-composer-field="page_template">
		<?php echo $form->select('ptComposerPageTemplateID', $templates, $ptComposerPageTemplateID)?>
	</div>
</div>