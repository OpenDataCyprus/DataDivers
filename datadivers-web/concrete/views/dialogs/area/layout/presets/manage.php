<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<div class="ccm-ui">


<?php if (count($presets) > 0) { ?>
    <div class="alert alert-info"><?php echo t("Deleting a preset will not affect any layouts that have used that preset in the past.")?></div>

    <ul class="item-select-list">
    <?php foreach($presets as $preset) { ?>
        <li data-preset-row="<?php echo $preset->getAreaLayoutPresetID()?>"><span><?php echo $preset->getAreaLayoutPresetName()?>
        <a href="javascript:void(0)" class="pull-right icon-link delete-area-layout-preset" data-action="delete-area-layout-preset"><i class="fa fa-trash-o"></i></a>
        </span></li>
    <?php } ?>
    </ul>

<?php } else { ?>
    <p><?php echo t('You have no presets.')?></p>
<?php } ?>


</div>

<script type="text/javascript">
    $(function() {
        $('a[data-action=delete-area-layout-preset]').on('click', function() {
            var $row = $(this).parent().parent();
            $.concreteAjax({
                url: '<?php echo $controller->action('delete')?>',
                data: {'arLayoutPresetID': $row.attr('data-preset-row')},
                success: function(r) {
                    $row.queue(function() {
                        $(this).addClass("animated fadeOutLeft");
                        $(this).dequeue();
                    }).delay(300).queue(function() {
                        $(this).remove();
                        $(this).dequeue();
                    });

                }
            });
        });
    });
</script>