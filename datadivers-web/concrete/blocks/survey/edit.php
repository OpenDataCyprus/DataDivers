<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<style type="text/css">
    div.survey-block-option {
        position: relative;
        border-bottom: 1px solid #ddd;
        margin-bottom: 3px;
    }

    div.survey-block-option img {
        position: absolute;
        top: 3px;
        right: 0px;
    }

</style>
<div class="ccm-ui survey-block-edit">
    <div class="form-group">
        <label for="questionEntry"><?php echo t('Question') ?></label>
        <input type="text" style="width: 320px" name="question" value="<?php echo $controller->getQuestion() ?>"
               class="form-control"/>
    </div>
    <label for="requiresRegistration"><?php echo t('Target Audience') ?></label>

    <div class="radio">
        <label>
            <input id="requiresRegistration" type="radio" value="0" name="requiresRegistration"
                   style="vertical-align: middle" <?php if (!$controller->requiresRegistration()) { ?> checked <?php } ?> />&nbsp;<?php echo t(
                'Public') ?>
        </label>
    </div>
    <div class="radio">
        <label>
            <input type="radio" value="1" name="requiresRegistration"
                   style="vertical-align: middle" <?php if ($controller->requiresRegistration()) { ?> checked <?php } ?> />&nbsp;<?php echo t(
                'Only Registered Users') ?>
        </label>
    </div>
    <hr/>
    <label><?php echo t('Answer Options') ?></label>

    <div class="form-group">
        <div class="poll-options">
            <?php
            $options = $controller->getPollOptions();
            if (count($options) == 0) {
                ?>
                <div class="empty">
                    <?php echo t('None') ?>
                </div>
                <?php
            } else {
                foreach ($options as $opt) {
                    ?>
                    <div class="survey-block-option">
                        <a href="#" class="pull-right delete">
                            <i class="fa fa-trash-o"></i>
                        </a>
                        <?php echo h($opt->getOptionName()) ?>
                        <input type="hidden" name="survivingOptionNames[]"
                               value="<?php echo h($opt->getOptionName()) ?>"/>
                    </div>
                <?php
                }
            } ?>
        </div>
    </div>
    <label for="optionEntry"><?php echo t('Add Option') ?></label>

    <div class="form-group">
        <div class="input-group">
            <input type="text" name="optionValue" class="option-value form-control"/>
            <span class="input-group-btn">
                <button class="add-option btn btn-default" type="button">
                    <?php echo t('Add'); ?>
                </button>
            </span>
        </div>
    </div>
    <script type="text/template" role="option">
        <div class="survey-block-option">
            <a href="#" class="delete pull-right">
                <i class="fa fa-trash-o"></i>
            </a>
            <%- value %>
            <input type="hidden" name="pollOption[]"
                   value="<%- value %>"/>
        </div>
    </script>
</div>
<script type="text/javascript">
    Concrete.event.fire('survey-edit-open');
</script>
