<?php
defined('C5_EXECUTE') or die("Access Denied.");
$u = new User();
$form = Loader::helper('form');

$f = File::getByID($_REQUEST['fID']);
if ($f->isError()) {
	die('Invalid File ID');
}
if (isset($_REQUEST['fvID'])) {
	$fv = $f->getVersion($_REQUEST['fvID']);
} else {
	$fv = $f->getApprovedVersion();
}

$fp = new Permissions($f);
if (!$fp->canViewFileInFileManager()) {
	die(t("Access Denied."));
}
?>
<div style="text-align: center">

<?php
$to = $fv->getTypeObject();
if ($to->getPackageHandle() != '') {
	Loader::packageElement('files/view/' . $to->getView(), $to->getPackageHandle(), array('fv' => $fv));
} else {
	Loader::element('files/view/' . $to->getView(), array('fv' => $fv));
}
?>
</div>

<div class="dialog-buttons">
<form method="post" action="<?php echo REL_DIR_FILES_TOOLS_REQUIRED?>/files/download?fID=<?php echo $f->getFileID()?>&fvID=<?php echo $f->getFileVersionID()?>" style="margin: 0px">
<?php echo $form->submit('submit', t('Download'), array('class' => 'btn btn-primary pull-right'))?>
</form>
</div>