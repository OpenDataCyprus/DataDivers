<?php
defined('C5_EXECUTE') or die("Access Denied.");
use Concrete\Core\Http\ResponseAssetGroup;
use Concrete\Core\ImageEditor\ImageEditor;
use Whoops\Exception\ErrorException;

$editorid = substr(sha1(time()), 0, 5); // Just enough entropy.

$u = new User();
$form = Loader::helper('form');
/** @var FileVersion $fv */
$f = $fv->getFile();
$fp = new Permissions($f);
if (!$fp->canEditFileContents()) {
    die(t("Access Denied."));
}

$req = ResponseAssetGroup::get();
$req->requireAsset('core/imageeditor');

/** @var ImageEditor $editor */
if (!$editor) {
    $editor = \Core::make('editor/image/core');
}

$filters = $editor->getFilterList();
$controls = $editor->getControlList()

?>
    <div class='table ccm-ui'>
        <div class='editorcontainer'>
            <div id='<?php echo $editorid ?>' class='Editor'></div>
            <div class='bottomBar'></div>
        </div>
        <div class='controls'>
            <div class='controlscontainer'>
                <div class='editorcontrols'>
                    <div class='control-sets'>
                        <?php
                        if (!$controls) {
                            echo "&nbsp;";
                        }
                        /** @var \Concrete\Core\ImageEditor\EditorExtensionInterface $control */
                        foreach ((array) $controls as $control) {
                            $control_handle = $control->getHandle();
                            $assets = $control->getAssets();
                            $javascript_asset = $control->getExtensionAsset();

                            foreach ($assets as $asset) {
                                $req->addOutputAsset($asset);
                            }
                            ?>
                            <div class="controlset controlset-<?php echo $control_handle ?> control control-<?php echo $control_handle ?>"
                                 data-namespace="<?php echo $control_handle ?>"
                                 data-src="<?php echo $javascript_asset->getAssetUrl() ?>">
                                <h4><?php echo $control->getName() ?></h4>

                                <div class="control">
                                    <div class="contents">
                                        <?php
                                        try {
                                            $view = $control->getView();
                                            $view->addScopeItems(array('editor' => $editor, 'fv' => $fv));
                                            echo $view->render();
                                        } catch (ErrorException $e) {
                                            echo t("Invalid View: '{$e->getMessage()}''");
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class='border'></div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class='save'>
                    <button class='cancel btn'><?php echo t('Cancel')?></button>
                    <button class='save btn pull-right btn-primary'><?php echo t('Save')?></button>
                </div>
            </div>
        </div>
    </div>

<?php
if (!$settings) {
    $settings = array();
}
$fnames = array();

foreach ($filters as $filter) {
    $assets = $filter->getAssets();
    $extension_asset = $filter->getExtensionAsset();
    $filter_handle = $filter->getHandle();

    foreach ($assets as $handle => $asset) {
        $req->addOutputAsset($asset);
    }


    $fnames[$filter_handle] = array(
        'src' => $extension_asset->getAssetURL(),
        'name' => h($filter->getName()),
        "selector" => ".filter.filter-{$filter_handle}"
    );
}
?>
    <script>
        $(function () {
            _.defer(function () {
                var defaults = {
                        saveUrl: CCM_DISPATCHER_FILENAME + '/tools/required/files/importers/imageeditor',
                        src: '<?php echo $fv->getURL()?>',
                        fID: <?php echo $fv->getFileID() ?>,
                        controlsets: {},
                        filters: {},
                        debug: false,
                        jpegCompression: <?php echo Config::get('concrete.misc.default_jpeg_image_compression') / 100 ?>,
                        mime: '<?php echo $fv->getMimeType() ?>'
                    },
                    settings = _.extend(defaults, <?php echo json_encode($settings) ?>);
                $('div.controlset', 'div.controls').each(function () {
                    settings.controlsets[$(this).attr('data-namespace')] = {
                        src: $(this).attr('data-src'),
                        element: $(this).children('div.control').children('div.contents')
                    }
                });
                $('div.component', 'div.controls').each(function () {
                    settings.components[$(this).attr('data-namespace')] = {
                        src: $(this).attr('>getdata-src'),
                        element: $(this).children('div.control').children('div.contents')
                    }
                });
                settings.filters = <?php echo json_encode($fnames); ?>;
                var editor = $('div#<?php echo $editorid?>.Editor');
                window.im = editor.closest('.ui-dialog-content').css('padding', 0).end().ImageEditor(settings);
            });

            Concrete.event.unbind('ImageEditorDidSave.core');
            <?php
            if (!isset($no_bind) || !$no_bind) {
                ?>
                Concrete.event.bind('ImageEditorDidSave.core', function(e) {
                    Concrete.event.unbind(e);
                    window.location = window.location;
                    window.location.reload();
                });
                <?php
            }
            ?>
        });
    </script>
