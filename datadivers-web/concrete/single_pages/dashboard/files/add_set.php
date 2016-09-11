<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php $ih = Loader::helper('concrete/ui'); ?>

    <form method="post" class="form-horizontal" id="file-sets-add" action="<?php echo $view->url('/dashboard/files/add_set', 'do_add')?>">
	<div class="ccm-pane-body">
    	
		<?php echo $validation_token->output('file_sets_add');?>

		<div class="control-group">
			<?php echo Loader::helper("form")->label('file_set_name', t('Name'))?>
			<div class="controls">
				<?php echo $form->text('file_set_name','', array('class' => 'span4'))?>
			</div>
		</div>
	</div>

	<div class="ccm-dashboard-form-actions-wrapper">
	<div class="ccm-dashboard-form-actions">
		<a href="<?php echo View::url('/dashboard/files/sets')?>" class="btn btn-default pull-left"><?php echo t('Cancel')?></a>
		<?php echo Loader::helper("form")->submit('add', t('Add'), array('class' => 'btn btn-primary pull-right'))?>
	</div>
	</div>
    </form>
