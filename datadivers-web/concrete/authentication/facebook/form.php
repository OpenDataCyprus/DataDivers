<?php
if (isset($error)) {
    ?>
    <div class="alert alert-danger"><?php echo $error ?></div>
<?php
}
if (isset($message)) {
    ?>
    <div class="alert alert-success"><?php echo $message ?></div>
<?php
}

$user = new User;

if ($user->isLoggedIn()) {
    ?>
    <div class="form-group">
        <span>
            <?php echo t('Attach a %s account', t('facebook')) ?>
        </span>
        <hr>
    </div>
    <div class="form-group">
        <a href="<?php echo \URL::to('/ccm/system/authentication/oauth2/facebook/attempt_attach'); ?>" class="btn btn-primary btn-facebook btn-block">
            <i class="fa fa-facebook"></i>
            <?php echo t('Attach a %s account', t('facebook')) ?>
        </a>
    </div>
<?php
} else {
    ?>
    <div class="form-group">
        <span>
            <?php echo t('Sign in with %s', t('facebook')) ?>
        </span>
        <hr>
    </div>
    <div class="form-group">
        <a href="<?php echo \URL::to('/ccm/system/authentication/oauth2/facebook/attempt_auth'); ?>" class="btn btn-primary btn-facebook btn-block">
            <i class="fa fa-facebook"></i>
            <?php echo t('Log in with %s', 'facebook') ?>
        </a>
    </div>
<?php
}
?>
<style>
    .ccm-ui .btn-facebook {
        border-width: 0px;
        background: #3b5998;
    }
    .btn-facebook .fa-facebook {
        margin: 0 6px 0 3px;
    }
</style>
