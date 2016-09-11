<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo APP_CHARSET?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo DIR_REL?>/concrete/themes/concrete/main.css" />
    <?php
    $view->requireAsset('core/app');
    $view->requireAsset('css', 'bootstrap');
    $view->requireAsset('css', 'font-awesome');
    $view->requireAsset('javascript', 'jquery');
    $view->requireAsset('javascript', 'bootstrap/alert');
    $view->requireAsset('javascript', 'bootstrap/transition');
    $view->markHeaderAssetPosition();
    ?>
</head>
<body class="ccm-ui">

<div id="ccm-toolbar">
    <ul>
        <li class="ccm-logo"><span><?php echo Loader::helper('concrete/ui')->getToolbarLogoSRC()?></span></li>
    </ul>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <br/><br/><br/>
            <?php
                Loader::element('error_fatal', array('innerContent' => $innerContent, 'titleContent' => $titleContent));
            ?>
            <p><a href="<?php echo Core::getApplicationURL()?>" class="btn btn-default"><?php echo t('&lt; Back to Home')?></a></p>
        </div>
    </div>
</div>

<?php Loader::element('footer_required'); ?>

</body>
</html>
