<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php

$sets = FileSet::getMySets();
?>

<div class="form-group" id="ccm-file-set-search">
	<form class="form-inline">
		<input type="search" class="form-control input-sm" data-field="file-set-search" autocomplete="off" placeholder="<?php echo t('Filter Sets')?>" />
	</form>
</div>


<div class="form-group" id="ccm-file-set-list">
	<?php if (count($sets)) { ?>
		<?php foreach($sets as $fs) {
			if ($displayFileSet($fs)) {	?>
			<div class="checkbox li">
				<label>
				<?php print $getCheckbox($fs);?>
				<span data-label="file-set-name"><?php echo $fs->getFileSetName()?></span>
				</label>
			</div>
			<?php } ?>
		<?php } ?>
	<?php } ?>
</div>

<button type="button" class="btn-sm btn btn-default" data-action="add-file-set"><?php echo t('Add Set')?> <i class="fa fa-plus-circle"></i></button>

<script type="text/template" class="ccm-template-file-set-checkbox">
	<div class="form-group form-group-file-set-checkbox">
		<div class="form-inline">
			<a href="#" class="icon-link"><i class="fa fa-minus-circle"></i></a>
			<input type="text" class="form-control" name="fsNew[]">
			<label class="checkbox-inline" ><input type="checkbox" name="fsNewShare[]" value="1" checked /> <span class="small"><?php echo t('Public Set.')?></span></label>
		</div>
	</div>
</script>

<script type="text/javascript">
	$(function() {
		var _checkbox = _.template($('script.ccm-template-file-set-checkbox').html());
		$('button[data-action=add-file-set]').on('click', function() {
			$('#ccm-file-set-list').append(_checkbox)
		});
		$('#ccm-file-set-list').on('click', 'a', function(e) {
			e.preventDefault();
			var $row = $(this).parent();
			$row.remove();
		});
		$('input[data-field=file-set-search]').liveUpdate('ccm-file-set-list', 'fileset').closest('form').unbind('submit.liveupdate');
	});
</script>

<style type="text/css">
	div.form-group-file-set-checkbox {
		position: relative;
		margin-left: 20px;
	}

	div.form-group-file-set-checkbox a {
		position: absolute;
		left: -20px;
		top: 7px;
	}
</style>
