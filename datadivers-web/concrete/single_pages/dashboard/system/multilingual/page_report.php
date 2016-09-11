<?php defined('C5_EXECUTE') or die("Access Denied.");
$nav = Loader::helper('navigation');
?>

<?php if (count($sections) > 0) { ?>

<div class="ccm-dashboard-content-full">

    <form role="form" action="<?php echo $controller->action('view')?>" data-form="search-multilingual-pages" class="form-inline ccm-search-fields">
        <input type="hidden" name="sectionID" value="<?php echo $sectionID?>" />
        <div class="ccm-search-fields-row">
            <div class="form-group">
                <?php echo $form->label('keywords', t('Search'))?>
                <div class="ccm-search-field-content">
                    <div class="ccm-search-main-lookup-field">
                        <i class="fa fa-search"></i>
                        <?php echo $form->search('keywords', array('placeholder' => t('Keywords')))?>
                        <button type="submit" class="ccm-search-field-hidden-submit" tabindex="-1"><?php echo t('Search')?></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="ccm-search-fields-row">
            <div class="form-group">
                <label class="control-label" for="sectionIDSelect"><?php echo t('Choose Source')?></label>
                <div class="ccm-search-field-content">
                    <?php echo $form->select('sectionIDSelect', $sections, $sectionID)?>
                </div>
            </div>
        </div>

        <div class="ccm-search-fields-row" data-list="multilingual-targets">
            <div class="form-group">
                <label class="control-label"><?php echo t('Choose Targets')?></label>
                <div class="ccm-search-field-content">
                <?php foreach($sectionList as $sc) { ?>
                    <?php $args = array('style' => 'vertical-align: middle');
                    if ($sectionID == $sc->getCollectionID()) {
                        $args['disabled'] = 'disabled';
                    }
                    ?>
                    <div>
                        <label class="checkbox-inline">
                            <?php echo $form->checkbox('targets[' . $sc->getCollectionID() . ']', $sc->getCollectionID(), in_array($sc->getCollectionID(), $targets), $args)?>
                            <?php echo $fh->getSectionFlagIcon($sc)?>
                            <?php echo $sc->getLanguageText(). " (".$sc->getLocale().")"; ?>
                        </label>
                    </div>
                <?php } ?>
                </div>
            </div>
        </div>

        <div class="ccm-search-fields-row">
            <div class="form-group">
                <label class="control-label"><?php echo t('Display')?></label>
                <div class="ccm-search-field-content">
                    <label class="radio-inline">
                        <?php echo $form->radio('showAllPages', 0, 0)?>
                        <?php echo t('Only Missing Pages')?>
                    </label>
                    <label class="radio-inline">
                        <?php echo $form->radio('showAllPages', 1, false)?>
                        <?php echo t('All Pages') ?>
                    </label>
                </div>
            </div>
        </div>

        <div class="ccm-search-fields-submit">
            <button type="submit" class="btn btn-primary pull-right"><?php echo t('Search')?></button>
        </div>

    </form>

    <?php if (count($sections) > 0) {
        $width = 100 / count($sections);
    } else {
        $width = '100';
    }?>

    <div class="table-responsive">
        <table class="ccm-search-results-table">
            <thead>
            <tr>
                <th style="width: <?php echo $width?>%"><span><?php
                    $sourceMS = \Concrete\Core\Multilingual\Page\Section\Section::getByID($sectionID);
                    print t('%s (%s)', $sourceMS->getLanguageText(), $sourceMS->getLocale());
                    ?>
                </span></th>
                <?php foreach($targetList as $sc) { ?>
                    <?php if ($section->getCollectionID() != $sc->getCollectionID()) { ?>
                        <th style="width:<?php echo $width?>%"><span><?php
                            print $fh->getSectionFlagIcon($sc);
                            print '&nbsp;';
                            print t('%s (%s)', $sc->getLanguageText(), $sc->getLocale());
                            ?>
                        </span></th>
                    <?php } ?>
                <?php } ?>
            </tr>
            </thead>
            <tbody>
            <?php if (count($pages) > 0) { ?>
                <?php foreach($pages as $pc) { ?>
                    <tr>
                    <td>
                        <a href="<?php echo $pc->getCollectionLink()?>"><?php echo $pc->getCollectionName()?></a>
                        <div><small><?php echo $pc->getCollectionPath()?></small></div>
                    </td>
                    <?php foreach($targetList as $sc) {

                        $multilingualController = Core::make('\Concrete\Controller\Backend\Page\Multilingual');
                        $multilingualController->setPageObject($pc);
                        ?>
                        <?php if ($section->getCollectionID() != $sc->getCollectionID()) { ?>
                            <td><div data-multilingual-page-section="<?php echo $sc->getCollectionID()?>" data-multilingual-page-source="<?php echo $pc->getCollectionID()?>">

                                    <div data-wrapper="page">
                                    <?php 						$cID = $sc->getTranslatedPageID($pc);
                                if ($cID) {
                                    $p = \Page::getByID($cID);
                                    print '<a href="' . $nav->getLinkToCollection($p) . '">' . $p->getCollectionName() . '</a>';
                                } else if ($cID === '0') {
                                    print t('Ignored');

                                } ?>
                                    </div>
                                    <div data-wrapper="buttons">
                                    <?php

                                    $cParentID = $pc->getCollectionParentID();
                                    $cParent = Page::getByID($cParentID);
                                    $cParentRelatedID = $sc->getTranslatedPageID($cParent);
                                    if ($cParentRelatedID) {

                                        $assignLang = t('Re-Map');
                                        if (!$cID) {
                                            $assignLang = t('Map');
                                        }
                                        ?>
                                        <?php if (!$cID) { ?>
                                            <button class="btn btn-success btn-xs" type="button"
                                                    data-btn-action="create"
                                                    data-btn-url="<?php echo $multilingualController->action('create_new')?>"
                                                    data-btn-multilingual-page-source="<?php echo $pc->getCollectionID()?>"
                                                    data-btn-multilingual-section="<?php echo $sc->getCollectionID()?>"
                                            ><?php echo t('Create Page')?></button>
                                        <?php } ?>
                                        <button class="btn btn-info btn-xs" type="button"
                                                data-btn-action="map"
                                                data-btn-url="<?php echo $multilingualController->action('assign')?>"
                                                data-btn-multilingual-page-source="<?php echo $pc->getCollectionID()?>"
                                                data-btn-multilingual-section="<?php echo $sc->getCollectionID()?>"
                                            ><?php echo $assignLang?></button>
                                        <?php if ($cID !== '0' && !$cID) { ?>
                                           <button class="btn btn-warning btn-xs" type="button"
                                               data-btn-action="ignore"
                                               data-btn-url="<?php echo $multilingualController->action('ignore')?>"
                                               data-btn-multilingual-page-source="<?php echo $pc->getCollectionID()?>"
                                               data-btn-multilingual-section="<?php echo $sc->getCollectionID()?>"
                                           ><?php echo t('Ignore')?></button>
                                        <?php } ?>
                                        <?php if ($cID) { ?>
                                            <button class="btn btn-danger btn-xs" type="button"
                                                    data-btn-action="unmap"
                                                    data-btn-url="<?php echo $multilingualController->action('unmap')?>"
                                                    data-btn-multilingual-page-source="<?php echo $pc->getCollectionID()?>"
                                                ><?php echo t('Un-Map')?></button>
                                        <?php } ?>

                                    <?php } else { ?>
                                        <div class="ccm-note"><?php echo t("Create the parent page first.")?></div>
                                    <?php } ?>
                                    </div>
                                </div>
                            </td>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            <?php } else {?>
                <tr>
                    <td colspan="4"><?php echo t('No pages found.')?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

    <script type="text/javascript">

        replaceLinkWithPage = function(cID, sectionID, link, icon, name) {
            var $wrapper = $('div[data-multilingual-page-section=' + sectionID + '][data-multilingual-page-source=' + cID + ']');
            var newLink = '<a href="' + link + '">' + name + '<\/a>';
            $wrapper.find('div[data-wrapper=page]').html(newLink);
            $wrapper.find('div[data-wrapper=buttons]').hide();
        }

        $(function() {

            $("select[name=sectionIDSelect]").change(function() {
                $("div[data-list=multilingual-targets] input").attr('disabled', false);
                $("div[data-list=multilingual-targets] input[value=" + $(this).val() + "]").attr('disabled', true).attr('checked', false);
                $("input[name=sectionID]").val($(this).val());
                $("form[data-form=multilingual-search-pages]").submit();
            });

            $('button[data-btn-action=create]').on('click', function(e) {
                var sectionID = $(this).attr('data-btn-multilingual-section'),
                    cID = $(this).attr('data-btn-multilingual-page-source');
                e.preventDefault();

                $.concreteAjax({
                    url: $(this).attr('data-btn-url'),
                    method: 'post',
                    data: {
                        'section': sectionID,
                        'cID': cID
                    },
                    success: function(r) {
                        ConcreteAlert.notify({
                            'message': r.message,
                            'title': r.title
                        });
                        if (r.pages[0]) {
                            replaceLinkWithPage(cID, sectionID, r.link, r.icon, r.name);
                        }

                    }
                });
            });

            $('button[data-btn-action=map]').on('click', function(e) {
                var sectionID = $(this).attr('data-btn-multilingual-section'),
                    cID = $(this).attr('data-btn-multilingual-page-source'),
                    url = $(this).attr('data-btn-url');

                e.preventDefault();
                ConcretePageAjaxSearch.launchDialog(function(data) {
                    $.concreteAjax({
                        url: url,
                        method: 'post',
                        data: {
                            'destID': data.cID,
                            'cID': cID
                        },
                        success: function(r) {
                            replaceLinkWithPage(cID, sectionID, r.link, r.icon, r.name);
                        }
                    });

                });
            });

            $('button[data-btn-action=ignore]').on('click', function(e) {
                var sectionID = $(this).attr('data-btn-multilingual-section'),
                    cID = $(this).attr('data-btn-multilingual-page-source');
                e.preventDefault();
                $.concreteAjax({
                    url: $(this).attr('data-btn-url'),
                    method: 'post',
                    data: {
                        'section': sectionID,
                        'cID': cID
                    },
                    success: function(r) {
                        var $wrapper = $('div[data-multilingual-page-section=' + sectionID + '][data-multilingual-page-source=' + cID + ']');
                        $wrapper.find('div[data-wrapper=page]').html('<?php echo t('Ignored')?>');
                        $wrapper.find('div[data-wrapper=buttons]').hide();
                    }
                });
            });

            $('button[data-btn-action=unmap]').on('click', function(e) {
                var cID = $(this).attr('data-btn-multilingual-page-source');
                e.preventDefault();
                $.concreteAjax({
                    url: $(this).attr('data-btn-url'),
                    method: 'post',
                    data: {
                        'cID': cID
                    },
                    success: function(r) {
                        var $wrapper = $('div[data-multilingual-page-source=' + cID + ']');
                        $wrapper.find('div[data-wrapper=page]').html('<?php echo t('Unmapped')?>');
                        $wrapper.find('div[data-wrapper=buttons]').hide();
                    }
                });
            });

        });

    </script>

    <div class="ccm-search-results-pagination">
        <?php if ($pagination->haveToPaginate()) { ?>
            <?php echo $pagination->renderView('dashboard');?>
        <?php } ?>
    </div>
</div>


<?php } else { ?>
	<p><?php echo t('You have not defined any multilingual sections for your site yet.')?></p>
<?php } ?>