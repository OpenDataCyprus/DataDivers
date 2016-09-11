<?php defined('C5_EXECUTE') or die("Access Denied.");
$ih = Core::make('multilingual/interface/flag');
?>
<div class="ccm-block-switch-language-flags">
	<div class="ccm-block-switch-language-flags-label"><?php echo $label?></div>
    <?php foreach($languageSections as $ml) { ?>
        <a href="<?php echo $view->action('switch_language', $cID, $ml->getCollectionID())?>"
           title="<?php echo $ml->getLanguageText($locale)?>"
        class="<?php if ($activeLanguage == $ml->getCollectionID()) { ?>ccm-block-switch-language-active-flag<?php } ?>"><?php
            print $ih->getSectionFlagIcon($ml);
        ?></a>
    <?php } ?>
</div>