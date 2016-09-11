<?php
defined('C5_EXECUTE') or die("Access Denied.");
$form = Loader::helper('form');
$parent = \Concrete\Core\Tree\Node\Node::getByID(Loader::helper('security')->sanitizeInt($_REQUEST['treeNodeParentID']));
$np = new Permissions($parent);
$tree = $parent->getTreeObject();
if ($tree->getTreeTypeHandle() != 'topic') {
	die;
}

$url = View::url('/dashboard/system/attributes/topics', 'add_topic_node', $parent->getTreeNodeID());
if (is_object($parent) && $np->canAddTopicTreeNode()) { ?>

	<div class="ccm-ui">
		<form method="post" data-topic-form="add-topic-node" class="form-horizontal" action="<?php echo $url?>">
			<?php echo Loader::helper('validation/token')->output('add_topic_node')?>
			<div class="form-group">
				<?php echo $form->label('treeNodeTopicName', t('Topic'))?>
				<?php echo $form->text('treeNodeTopicName', '', array('class' => 'span4'))?>
			</div>

			<div class="dialog-buttons">
				<button class="btn btn-default" onclick="jQuery.fn.dialog.closeTop()"><?php echo t('Cancel')?></button>
				<button class="btn btn-primary pull-right" type="submit"><?php echo t('Add')?></button>
			</div>
		</form>
	</div>


<?php
}

