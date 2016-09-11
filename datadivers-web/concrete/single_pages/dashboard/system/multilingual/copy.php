<?php defined('C5_EXECUTE') or die("Access Denied.");?>
<?php
use Concrete\Core\Multilingual\Page\Section\Section as MultilingualSection;
?>

<?php if (count($pages)) { ?>

    <fieldset>
        <legend><?php echo t('Copy Locale Tree')?></legend>
    <?php
    $u = new User();
    $copyLocales = array();
    $includesHome = false;
    foreach($pages as $pc) {
        $pcl = MultilingualSection::getByID($pc->getCollectionID());
        if ($pc->getCollectionID() == HOME_CID) {
            $includesHome = true;
        }
        $copyLocales[$pc->getCollectionID()] = tc(/*i18n: %1$s is a page name, %2$s is a language name, %3$s is a locale identifier (eg en_US)*/'PageWithLocale', '%1$s (%2$s, %3$s)', $pc->getCollectionName(), $pcl->getLanguageText(), $pcl->getLocale());
    }

    if ($u->isSuperUser() && !$includesHome) { ?>
    <form method="post" id="ccm-internationalization-copy-tree" action="#">
        <?php if (count($pages) > 1) {
            $copyLocaleSelect1 = $form->select('copyTreeFrom', $copyLocales);
            $copyLocaleSelect2 = $form->select('copyTreeTo', $copyLocales);
            ?>
            <p><?php echo t('Copy all pages from a locale to another section. This will only copy pages that have not been associated. It will not replace or remove any pages from the destination section.')?></p>
            <div class="form-group">
                <label class="control-label"><?php echo t('Copy From')?></label>
                <?php echo $copyLocaleSelect1?>
            </div>

            <div class="form-group">
                <label class="control-label"><?php echo tc('Destination', 'To')?></label>
                <?php echo $copyLocaleSelect2?>
            </div>

            <?php echo Loader::helper('validation/token')->output('copy_tree')?>
            <button class="btn btn-default pull-left" type="submit" name="copy"><?php echo t('Copy Tree')?></button>

        <?php } else if (count($pages) == 1) { ?>
            <p><?php echo t("You must have more than one multilingual section to use this tool.")?></p>
        <?php } else { ?>
            <p><?php echo t('You have not created any multilingual content sections yet.')?></p>
        <?php } ?>

        <script type="text/javascript">
        $(function() {
            $("#ccm-internationalization-copy-tree").on('submit', function() {
                var ctf = $('select[name=copyTreeFrom]').val();
                var ctt = $('select[name=copyTreeTo]').val();
                if (ctt > 0 && ctf > 0 && ctt != ctf) {
                    ccm_triggerProgressiveOperation(
                        CCM_TOOLS_PATH + '/dashboard/sitemap_copy_all',
                        [
                            {'name': 'origCID', 'value': ctf},
                            {'name': 'destCID', 'value': ctt},
                            {'name': 'copyChildrenOnly', 'value': true},
                            {'name': 'multilingual', 'value': true}
                        ],
                        "<?php echo t('Copy Locale Tree')?>", function() {
                            window.location.href= "<?php echo $this->action('tree_copied')?>";
                        }
                    );
                } else {
                    alert("<?php echo t('You must choose two separate multilingual sections to copy from/to')?>");
                }
                return false;
            });
        });
        </script>

    </form>
    <?php } else if (!$u->isSuperUser()) { ?>
        <p><?php echo t('Only the super user may copy locale trees.')?></p>
    <?php } else if ($includesHome) { ?>
        <p><?php echo t('Since one of your multilingual sections is the home page, you may not duplicate your site tree using this tool. You must manually assign pages using the page report.')?></p>
    <?php } ?>
    </fieldset>

    <hr/>

    <fieldset>
        <legend><?php echo t('Rescan Multilingual Tree')?></legend>
        <?php
        if ($u->isSuperUser() && !$includesHome) { ?>
            <form method="post" id="ccm-internationalization-rescan-tree" action="#">
                <?php if (count($pages) > 1) {
                    ?>
                    <p><?php echo t('Scans all blocks within the selected section. Any links to pages within another multilingual section will be updated to link to the pages within the selected tree. Any blocks within the scanned section that reference pages in another multilingual section will be updated to point to the page within the selected tree.')?></p>
                    <div class="form-group">
                        <label class="control-label"><?php echo t('Rescan Locale')?></label>
                        <?php echo $form->select('rescanLocale', $copyLocales);?>
                    </div>

                    <?php echo Loader::helper('validation/token')->output('rescan_locale')?>
                    <button class="btn btn-default pull-left" type="submit" name="rescan_locale"><?php echo t('Rescan Locale')?></button>

                <?php } else if (count($pages) == 1) { ?>
                    <p><?php echo t("You must have more than one multilingual section to use this tool.")?></p>
                <?php } else { ?>
                    <p><?php echo t('You have not created any multilingual content sections yet.')?></p>
                <?php } ?>

                <script type="text/javascript">
                    $(function() {
                        $("#ccm-internationalization-rescan-tree").on('submit', function() {
                            var ctf = $('select[name=rescanLocale]').val();
                            if (ctf > 0) {
                                ccm_triggerProgressiveOperation(
                                    '<?php echo $view->action('rescan_locale')?>',
                                    [
                                        {'name': 'locale', 'value': ctf},
                                        {'name': 'ccm_token', 'value': '<?php echo Core::make('token')->generate('rescan_locale')?>'}
                                    ],
                                    "<?php echo t('Rescan Links')?>",
                                    function() {
                                        window.location.href= "<?php echo $this->action('links_rescanned')?>";
                                    }
                                );
                            }
                            return false;
                        });
                    });
                </script>

            </form>
        <?php } else if (!$u->isSuperUser()) { ?>
            <p><?php echo t('Only the super user may rescan the links inside a multilingual tree.')?></p>
        <?php } else if ($includesHome) { ?>
            <p><?php echo t('Since one of your multilingual sections is the home page, you may not rescan the links in your site tree using this tool.')?></p>
        <?php } ?>
    </fieldset>

<?php } else { ?>
    <p><?php echo t('You have not created any multilingual content sections yet.'); ?></p>
<?php } ?>