<?php 

namespace Concrete\Package\ThemeMyelemental;
 
use Concrete\Core\Package\Package;
use Concrete\Core\Page\Theme\Theme;
 
defined('C5_EXECUTE') or die(_("Access Denied."));
 
class Controller extends Package
{

	protected $pkgHandle = 'theme_myelemental';
	protected $appVersionRequired = '5.7.1';
	protected $pkgVersion = '1.0';
 
	public function getPackageDescription()
	{
    return t("Adds MyElemental Theme.");
	}
 
	public function getPackageName()
	{
    return t("MyElemental");
	}
	public function install()
	{
    $pkg = parent::install();
    Theme::add('myelemental', $pkg);

    $small = \Concrete\Core\File\Image\Thumbnail\Type\Type::getByHandle('small');
	if (!is_object($small)) {
    	$type = new \Concrete\Core\File\Image\Thumbnail\Type\Type();
    	$type->setName('Small');
    	$type->setHandle('small');
    	$type->setWidth(740);
    	$type->save();
	}

    $medium = \Concrete\Core\File\Image\Thumbnail\Type\Type::getByHandle('medium');
	if (!is_object($medium)) {
    	$type = new \Concrete\Core\File\Image\Thumbnail\Type\Type();
    	$type->setName('Medium');
    	$type->setHandle('medium');
    	$type->setWidth(940);
    	$type->save();
	}

	}

 

}

?>