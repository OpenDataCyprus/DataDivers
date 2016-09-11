<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<div class="ccm-ui">

    <form class="form-stacked" data-dialog-form="add-external-link" method="post" action="<?php echo $controller->action('submit')?>">

        <div class="form-group">
            <label class="control-label"><?php echo t('Name')?></label>
            <input type="text" name="name" value="<?php echo h($name)?>" class="form-control" />
        </div>

        <div class="form-group">
            <label class="control-label"><?php echo t('URL')?></label>
            <input type="text" name="link" value="<?php echo h($link)?>" class="form-control" />
        </div>

        <div class="form-group">
            <div class="checkbox">
                <label><input type="checkbox" <?php if ($openInNewWindow) { ?>checked<?php } ?> name="openInNewWindow" value="1"  />
                    <?php echo t('Open Link in New Window')?></label>
        </div>

        <div class="dialog-buttons">
            <button class="btn btn-default pull-left" data-dialog-action="cancel"><?php echo t('Cancel')?></button>
            <button type="button" data-dialog-action="submit" class="btn btn-primary pull-right"><?php echo t('Add')?></button>
        </div>
    </form>
</div>
