<?php defined('C5_EXECUTE') or die("Access Denied.");

$footerSiteTitle = new GlobalArea('Footer Site Title');
$footerSocial = new GlobalArea('Footer Social');
$footerSiteTitleBlocks = $footerSiteTitle->getTotalBlocksInArea();
$footerSocialBlocks = $footerSocial->getTotalBlocksInArea();
$displayFirstSection = $footerSiteTitleBlocks > 0 || $footerSocialBlocks > 0 || $c->isEditMode();

?>

<footer id="footer-theme">
    <?php if ($displayFirstSection) { ?>
    <section>
    <div class="container">
        <div class="row">
            <div class="col-sm-9">
                <?php
                $a = new GlobalArea('Footer Site Title');
                $a->display();
                ?>
            </div>
            <div class="col-sm-3">
                <?php
                $a = new GlobalArea('Footer Social');
                $a->display();
                ?>
            </div>
        </div>
    </div>
    </section>
    <?php } ?>
    <section>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
            <?php
            $a = new GlobalArea('Footer Legal');
            $a->display();
            ?>
            </div>
            <div class="col-sm-3">
                <?php
                $a = new GlobalArea('Footer Navigation');
                $a->display();
                ?>
            </div>
            <div class="col-sm-3">
                <?php
                $a = new GlobalArea('Footer Contact');
                $a->display();
                ?>
            </div>
        </div>
    </div>
    </section>
</footer>




<?php $this->inc('elements/footer_bottom.php');?>
