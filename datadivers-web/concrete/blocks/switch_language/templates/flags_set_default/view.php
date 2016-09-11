<?php defined('C5_EXECUTE') or die("Access Denied.");
$ih = Core::make("multilingual/interface/flag");
?>

<div class="ccm-block-language-list-set-default-wrapper">

	<form method="post" action="<?php echo $view->action('set_current_language')?>" class="form-stacked">
        <?php if (Loader::helper('validation/numbers')->integer($_REQUEST['rcID'])) { ?>
            <input type="hidden" name="rcID" value="<?php echo Loader::helper('text')->entities($_REQUEST['rcID'])?>" />
        <?php } ?>

        <div class="form-group">
            <label class="control-label"><?php echo $label?></label>

            <?php foreach($languageSections as $ml) {  ?>
                <div class="radio">
                    <label>
                        <input type="radio" name="language" value="<?php echo $ml->getCollectionID()?>"  <?php if (is_object($defaultLocale) && $defaultLocale->getCollectionID() == $ml->getCollectionID()) { ?> checked="checked" <?php } ?> />
                        <?php echo $ih->getSectionFlagIcon($ml)?>
                        <?php echo $ml->getLanguageText($locale)?>
                    </label>
                </div>
            <?php } ?>
        </div>

        <div class="form-group">
            <div class="checkbox">
                <label>
                <?php echo $form->checkbox('remember', 1, 1)?> <?php echo t('Remember my choice on this computer.')?>
                </label>
            </div>
        </div>

        <button class="btn btn-primary" type="submit"><?php echo t("Save")?></button>
	</form>
	
</div>