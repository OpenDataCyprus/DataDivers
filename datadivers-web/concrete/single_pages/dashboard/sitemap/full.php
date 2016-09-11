<?php
defined('C5_EXECUTE') or die("Access Denied.");
$sh = Loader::helper('concrete/dashboard/sitemap');
?>

<?php if ($sh->canRead()) { ?>

	<div class="ccm-dashboard-content-full">
	<script type="text/javascript">
		$(function() {
			$('div#ccm-full-sitemap-container').concreteSitemap({
				includeSystemPages: $('input[name=includeSystemPages]').is(':checked')
			});

			$('input[name=includeSystemPages]').on('click', function() {
				var $tree = $('div#ccm-full-sitemap-container');
				$tree.dynatree('destroy');
				$tree.concreteSitemap({
					includeSystemPages: $('input[name=includeSystemPages]').is(':checked')
				})
			});
		});
	</script>

	<style type="text/css">
	div#ccm-full-sitemap-container {
		margin-left: 95px;
	}
	</style>

	<form action="<?php echo URL::to('/dashboard/sitemap/search')?>"  class="form-inline ccm-search-fields-none ccm-search-fields">
		<div class="form-group">
			<div class="ccm-search-main-lookup-field">
				<i class="fa fa-search"></i>
				<?php echo $form->search('cvName', array('placeholder' => t('Name')))?>
				<button type="submit" class="ccm-search-field-hidden-submit" tabindex="-1"><?php echo t('Search')?></button>
			</div>
		</div>
		<ul class="ccm-search-form-advanced list-inline">
			<li><a href="<?php echo URL::to('/dashboard/sitemap/search')?>"><?php echo t('Advanced Search')?></a>
		</ul>
	</form>


	<?php $u = new User();
	if ($u->isSuperUser()) {
		if (Queue::exists('copy_page')) {
		$q = Queue::get('copy_page');
		if ($q->count() > 0) { ?>

			<div class="alert alert-warning">
				<?php echo t('Page copy operations pending.')?>
				<button class="btn btn-xs btn-default pull-right" onclick="ConcreteSitemap.refreshCopyOperations()"><?php echo t('Resume Copy')?></button>
			</div>

		<?php }
	}

	} ?>


		<div id="ccm-full-sitemap-container"></div>


		<hr/>

		<section>
			<div class="checkbox">
			<label>
				<input type="checkbox" name="includeSystemPages" <?php if ($includeSystemPages) { ?>checked<?php } ?> value="1" />
				<?php echo t('Include System Pages in Sitemap')?>
			</label>
			</div>
		</section>


	</div>
<?php } else { ?>

	<p><?php echo t("You do not have access to the sitemap.");?></p>

<?php } ?>
