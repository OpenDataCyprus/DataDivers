<?php defined('C5_EXECUTE') or die("Access Denied.");
$h = Loader::helper('concrete/dashboard');
$form = Loader::helper('form');
echo $h->getDashboardPaneHeaderWrapper(t('Maintenance Mode'), false, 'span6 offset3', false);?>

<form id="maintenance-mode-form" action="<?php echo $view->action('')?>" method="post" role="form">
    <?php echo $this->controller->token->output('update_maintenance')?>
    <fieldset>
        <div class="form-group">
            <div class="radio"><label><?php echo $form->radio('site_maintenance_mode', '1', $site_maintenance_mode)?> <span><?php echo t('Enabled')?></span></label></div>
            <div class="radio"><label><?php echo $form->radio('site_maintenance_mode', '0', $site_maintenance_mode)?> <span><?php echo t('Disabled')?></span></label></div>
        </div>
    </fieldset>	

    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">    
            <button class="pull-right btn btn-primary" type="submit" ><?php echo t('Save')?></button>
        </div>
    </div>
</form>
<?php echo $h->getDashboardPaneFooterWrapper(false);
