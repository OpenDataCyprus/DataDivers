<?php defined('C5_EXECUTE') or die("Access Denied."); ?> 
<?php
$tp = new TaskPermission();
if (!$tp->canAccessGroupSearch()) {
	?>
	<p><?php echo t('You do not have access to the group search.')?></p>
	<?php
} else {

$form = Loader::helper('form');
$searchRequest = $_REQUEST;
$result = Loader::helper('json')->encode($controller->getSearchResultObject()->getJSONObject());
$tree = GroupTree::get();
$guestGroupNode = GroupTreeNode::getTreeNodeByGroupID(GUEST_GROUP_ID);
$registeredGroupNode = GroupTreeNode::getTreeNodeByGroupID(REGISTERED_GROUP_ID);
?>

<style type="text/css">
	div[data-search=groups] form.ccm-search-fields {
		margin-left: 0px !important;
	}
</style>

<div data-search="groups">
<script type="text/template" data-template="search-form">
<form role="form" data-search-form="groups" action="<?php echo URL::to('/ccm/system/search/groups/submit')?>" class="form-inline ccm-search-fields ccm-search-fields-none">
	<input type="hidden" name="filter" value="<?php echo h($searchRequest['filter'])?>" />

	<div class="ccm-search-fields-row">
	<div class="form-group">
		<div class="ccm-search-main-lookup-field">
			<i class="fa fa-search"></i>
			<?php echo $form->search('keywords', $searchRequest['keywords'], array('placeholder' => t('Name')))?>
			<button type="submit" class="ccm-search-field-hidden-submit" tabindex="-1"><?php echo t('Search')?></button>
		</div>
	</div>
	</div>
</form>
</script>

<script type="text/template" data-template="search-results-table-body">
<% _.each(items, function(group) {%>
<tr>
	<% for(i = 0; i < group.columns.length; i++) {
		var column = group.columns[i]; 
		%>
		<td><%=column.value%></td>
	<% } %>
</tr>
<% }); %>
</script>


<div data-search-element="wrapper"></div>

<div class="group-tree" data-group-tree="<?php echo $tree->getTreeID()?>"></div>

<div data-search-element="results">

<table border="0" cellspacing="0" cellpadding="0" class="ccm-search-results-table">
<thead>
</thead>
<tbody>
</tbody>
</table>

<div class="ccm-search-results-pagination"></div>

</div>


<script type="text/template" data-template="search-results-pagination">
<%=paginationTemplate%>
</script>

<script type="text/template" data-template="search-results-table-head">
<tr>
	<% 
	for (i = 0; i < columns.length; i++) {
		var column = columns[i];
		if (column.isColumnSortable) { %>
			<th class="<%=column.className%>"><a href="<%=column.sortURL%>"><%=column.title%></a></th>
		<% } else { %>
			<th><span><%=column.title%></span></th>
		<% } %>
	<% } %>
</tr>
</script>

<script type="text/javascript">
$(function() {
	$('[data-group-tree]').concreteGroupsTree({
		'treeID': '<?php echo $tree->getTreeID()?>',
		<?php if ($searchRequest['filter'] == 'assign') { ?>
	      'removeNodesByID': ['<?php echo $guestGroupNode->getTreeNodeID()?>','<?php echo $registeredGroupNode->getTreeNodeID()?>'],
	      <?php } ?>
		<?php if ($selectMode) { ?>
			onClick: function(node) {
				ConcreteEvent.publish('SelectGroup', {'gID': node.data.gID, 'gName': node.data.title});
			},
		'enableDragAndDrop': false
		<?php } ?>
	});
	$('div[data-search=groups]').concreteAjaxSearch({
		result: <?php echo $result?>,
		onLoad: function(concreteSearch) {
			var handleSubmit = function() {
				var $input = concreteSearch.$element.find('input[name=keywords]');
				if ($input.val() != '') {
					concreteSearch.$element.find('[data-group-tree]').hide();
					concreteSearch.$results.show();
				} else {
					concreteSearch.$element.find('[data-group-tree]').show();
					concreteSearch.$results.hide();
				}
			}
			concreteSearch.$element.on('submit', 'form[data-search-form=groups]', handleSubmit);
			handleSubmit();
			concreteSearch.$element.on('keyup', 'input[name=keywords]', function(e) {
				if ($(this).val() == '') {
					handleSubmit();
				}
			});
			<?php if ($selectMode) { ?>
			concreteSearch.$element.on('click', 'a[data-group-id]', function() {
				ConcreteEvent.publish('SelectGroup', {
					gID: $(this).attr('data-group-id'),
					gName: $(this).attr('data-group-name')
				});
				return false;
			});
			<?php } ?>
		}
	});

});
</script>

</div>


<?php
}

