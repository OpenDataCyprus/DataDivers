<?php

namespace C5TL\Parser\DynamicItem;

/**
 * Extract translatable data from PermissionKeys.
 */
class PermissionKey extends DynamicItem
{
    /**
     * @see \C5TL\Parser\DynamicItem::getParsedItemNames()
     */
    public function getParsedItemNames()
    {
        return function_exists('t') ? t('Permission key names and descriptions') : 'Permission key names and descriptions';
    }

    /**
     * @see \C5TL\Parser\DynamicItem::getClassNameForExtractor()
     */
    protected function getClassNameForExtractor()
    {
        return '\Concrete\Core\Permission\Key\Key';
    }

    /**
     * @see \C5TL\Parser\DynamicItem::parseManual()
     */
    public function parseManual(\Gettext\Translations $translations, $concrete5version)
    {
        if (class_exists('\PermissionKeyCategory', true) && method_exists('\PermissionKeyCategory', 'getList')) {
            foreach (\PermissionKeyCategory::getList() as $pkc) {
                $pkcHandle = $pkc->getPermissionKeyCategoryHandle();
                foreach (\PermissionKey::getList($pkcHandle) as $pk) {
                    $this->addTranslation($translations, $pk->getPermissionKeyName(), 'PermissionKeyName');
                    $this->addTranslation($translations, $pk->getPermissionKeyDescription(), 'PermissionKeyDescription');
                }
            }
        }
    }
}
