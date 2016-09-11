<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<div class="ccm-block-rss-displayer-wrapper">

<?php if( strlen($title)>0 ){ ?>
    <div class="ccm-block-rss-displayer-header">
    	<h5><?php echo $title?></h5>
    </div>
<?php } ?>

<?php 
$rssObj=$controller;
$textHelper = Loader::helper("text");

if( strlen($errorMsg)>0 ){
	echo $errorMsg;
}else{

	foreach($posts as $itemNumber=>$item) { 
	
		if( intval($itemNumber) >= intval($rssObj->itemsToDisplay) ) break;
		?>
		
		<div class="ccm-block-rss-displayer-item">
			<div class="ccm-block-rss-displayer-item-title">
				<a href="<?php echo $item->getLink(); ?>" <?php if($rssObj->launchInNewWindow) echo 'target="_blank"' ?> >
					<?php echo $item->getTitle(); ?>
				</a>
			</div>
			<div class="ccm-block-rss-displayer-item-date"><?php echo h($this->controller->formatDateTime($item->getDateCreated())); ?></div>
			<div class="ccm-block-rss-displayer-item-summary">
				<?php
				if( $rssObj->showSummary ){
					echo $textHelper->shortText( strip_tags($item->getDescription()) );
				}
				?>
			</div>
		</div>
	
<?php  }  
}
?>
</div>