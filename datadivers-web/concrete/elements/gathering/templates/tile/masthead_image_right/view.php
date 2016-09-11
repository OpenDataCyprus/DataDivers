<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php
if (is_array($image)) {
	$image = $image[0];
}

?>
<div class="ccm-gathering-masthead-image-right ccm-gathering-masthead-image ccm-gathering-scaled-image">
	<div class="ccm-gathering-tile-title-description float-left">
		<div class="ccm-gathering-tile-headline">
			<a href="<?php echo $link?>"><?php echo $title?></a><?php echo $ownerName ?>
		</div>
		<div class="ccm-gathering-tile-description">
			<?php echo $description?>
		</div>
	</div>
	<a href="#" data-overlay="gathering-item">
		<img class="float-right" src="<?php echo $image->getSrc()?>" alt="<?php echo t('Preview Image') ?>" />
	</a>
	<div class="clearfix" style="clear: both;"></div>
</div>
