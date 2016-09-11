<?php defined('C5_EXECUTE') or die("Access Denied.");

$dh = Core::make('helper/date'); /* @var $dh \Concrete\Core\Localization\Service\Date */
?>
<div class="ccm-ui">
    <form method="post" id="ccmBlockMasterCollectionForm" data-dialog-form="master-collection-alias" action="<?php echo $controller->action('submit')?>">

        <?php if (count($cList) == 0) { ?>

            <?php echo t("There are no pages of this type added to your website. If there were, you'd be able to choose which of those pages this block appears on.")?>

        <?php } else { ?>

            <p><?php echo t("Choose which pages below this particular block should appear on. Any previously selected blocks may also be removed using the checkbox. Click the checkbox in the header to select/deselect all pages.")?></p>
            <br/>

            <table class="table-striped table table-bordered" >
                <tr>
                    <th>ID</th>
                    <th><?php echo t('Name')?></th>
                    <th ><?php echo t('Date Created')?></th>
                    <th ><?php echo t('Date Modified')?></th>
                    <th ><input type="checkbox" id="mc-cb-all" /></th>
                </tr>

                <?php

                foreach($cList as $p) { ?>
                    <tr class="active">
                        <td><?php echo $p->getCollectionID()?></td>
                        <td><a href="<?php echo URL::to($p)?>" target="_blank"><?php echo $p->getCollectionName()?></a></td>
                        <td ><?php echo $dh->formatDate($p->getCollectionDateAdded())?></td>
                        <td ><?php if ($b->isAlias($p)) { ?> <input type="hidden" name="checkedCIDs[]" value="<?php echo $p->getCollectionID()?>" /><?php } ?><?php echo $dh->formatDate($p->getCollectionDateLastModified())?></td>
                        <td ><input class="mc-cb" type="checkbox" name="cIDs[]" value="<?php echo $p->getCollectionID()?>" <?php if ($b->isAlias($p)) { ?> checked <?php } ?> /></td>
                    </tr>

                <?php } ?>

            </table>

        <?php } ?>

        <div class="dialog-buttons">
            <button class="btn btn-default pull-left" data-dialog-action="cancel"><?php echo t('Cancel')?></button>
            <a href="javascript:void(0)" onclick="$('#ccmBlockMasterCollectionForm').submit()" class="btn btn-primary pull-right"><?php echo t('Save')?></a>
        </div>

        <script type="text/javascript">
            $(function() {
                $('#mc-cb-all').click(function() {
                    if (this.checked) {
                        $('input.mc-cb').each(function() {
                            $(this).get(0).checked = true;
                        });
                    } else {
                        $('input.mc-cb').each(function() {
                            $(this).get(0).checked = false;
                        });
                    }
                });
                $('#ccmBlockMasterCollectionForm').concreteAjaxForm();

            });

        </script>
    </form>
</div>