<?php
/**
 * @var \Concrete\Core\Attribute\Key\Key $ak
 * @var $objects
 * @var $object
 * @var callback $permissionsCallback
 * @var array $permissionsArguments
 * @var string $clearAction
 * @var string $saveAction
 * @var string $display
 */


if (isset($objects)) {
    foreach ($objects as $object) {
        $value = $object->getAttributeValueObject($ak);
        if (!is_object($value)) {
            $display = '';
        } else {
            $display = $value->getValue('displaySanitized', 'display');
        }
        if (isset($lastDisplay) && $display != $lastDisplay) {
            $display = t('Multiple Values');
        }
        $lastDisplay = $display;
    }
} else {
    $value = $object->getAttributeValueObject($ak);
    if (is_object($value)) {
        $display = $value->getValue('displaySanitized', 'display');
    } else {
        $display = '';
    }
}

$canEdit = $permissionsCallback($ak, $permissionsArguments); ?>

    <div class="row">
        <div class="col-md-2"><p><?php echo $ak->getAttributeKeyDisplayName() ?></p></div>
        <div class="col-md-10" <?php if ($canEdit) { ?>data-editable-field-inline-commands="true"<?php } ?>>
            <?php if ($canEdit) { ?>
                <ul class="ccm-edit-mode-inline-commands">
                    <li><a href="#" data-key-id="<?php echo $ak->getAttributeKeyID() ?>"
                           data-url="<?php echo $clearAction ?>"
                           data-editable-field-command="clear_attribute">
                            <i class="fa fa-trash-o"></i>
                        </a></li>
                </ul>
            <?php } ?>
            <span
                    <?php if ($canEdit) { ?>
                        data-title="<?php echo $ak->getAttributeKeyDisplayName() ?>"
                        data-key-id="<?php echo $ak->getAttributeKeyID() ?>"
                        data-name="<?php echo $ak->getAttributeKeyID() ?>"
                        data-editable-field-type="xeditableAttribute"
                        data-url="<?php echo $saveAction ?>"
                        data-type="concreteattribute"<?php
                        echo $ak->atHandle==='textarea' ? "data-editableMode='inline'" : '';
                    } ?> >
                <?php echo $display ?>
            </span>
        </div>
    </div>

<?php if ($canEdit) { ?>

    <div style="display: none">
        <div data-editable-attribute-key-id="<?php echo $ak->getAttributeKeyID() ?>">
            <?php
            $value = $object->getAttributeValueObject($ak);
            $ak->render('form', $value);
            ?>
        </div>
    </div>

<?php }