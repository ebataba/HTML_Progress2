<?php
/**
 * Custom example of AJAX file upload with HTML_Progress2, PHP 5.2+ and APC
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 * @example    examples/ajax/upload/apc5_upload3.php
 *             AP5 basic upload source code
 * @link       http://www.laurent-laville.org/img/progress/screenshot/apc5_upload4.png
 *             screenshot (Image PNG, 443x170 pixels) 4,98 Kb
 */

// final destination of uploaded files
$path = 'web_files/' ;

// basic PHP function file upload handler
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (is_uploaded_file($_FILES['userfile1']['tmp_name'])) {
        if (move_uploaded_file($_FILES['userfile1']['tmp_name'], $path . $_FILES['userfile1']['name'])) {
            $html_output = 'Upload finished';
            echo '<pre>'; var_dump($_FILES); echo '</pre>';
        } else {
            $html_output = 'Upload failed';
        }
    }
    if (is_uploaded_file($_FILES['userfile2']['tmp_name'])) {
        if (move_uploaded_file($_FILES['userfile2']['tmp_name'], $path . $_FILES['userfile2']['name'])) {
            $html_output = 'Upload finished';
            echo '<pre>'; var_dump($_FILES); echo '</pre>';
        } else {
            $html_output = 'Upload failed';
        }
    }
    die($html_output);
}

require_once 'PEAR.php';
require_once 'HTML/Progress2.php';

PEAR::setErrorHandling(PEAR_ERROR_DIE);

// build a progress bar without default percentage label
$pb = new HTML_Progress2(null, HTML_PROGRESS2_BAR_HORIZONTAL, 0, 100);
$pb->setIdent('PB1');

// will replace the default uplStatus label with formatted option (see auto_server.php)
$pb->addLabel(HTML_PROGRESS2_LABEL_TEXT, 'sizeStatus');
// will show the current filename during upload
$pb->addLabel(HTML_PROGRESS2_LABEL_TEXT, 'fileName');

$pb->setCellCount(20);

$pb->setLabelAttributes('pct1', array(
    'width' => 400,
    'height' => 20,
    'valign' => 'center',
    'align' => 'center',
    'color' => 'yellow'
));
$pb->setBorderPainted(true);
$pb->setCellAttributes(array(
    'active-color' => 'blue',
    'inactive-color' => 'lightgrey',
    'width' => 20,
    'spacing' => 0
));
$pb->setBorderAttributes(array(
    'width' => 1,
    'style' => 'solid',
    'color' => 'black'
));
$pb->setLabelAttributes('fileName', 'valign=bottom align=left');

$pb->registerAJAX('auto_server.php', array('Request1APC5Status'));

// upload progress identifier : must be unique to avoid collision
$progress_key = md5(uniqid(rand(), true));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>APC PHP5 AJAX Upload Progress Meter custom example </title>
<script type="text/javascript" src="HTML_Progress2.js"></script>
<?php echo $pb->setupAJAX(); ?>
<script type="text/javascript">
//<![CDATA[
HTML_Progress2.serverClassName  = 'Request1APC5Status';
HTML_Progress2.serverMethodName = 'getStatus';
HTML_Progress2.onComplete       = 'doNothing';

function beginUpload()
{
    HTML_Progress2.requestArgs = 'uploadID=<?php echo $progress_key; ?>';
    HTML_Progress2.start('<?php echo $pb->getIdent(); ?>', 1000);

}
function doNothing()
{
}
//]]>
</script>
<style type="text/css">
<!--
<?php echo $pb->getStyle(); ?>

body {background-color: #EEEEEE; }
 -->
</style>
</head>
<body>

<form enctype="multipart/form-data" target="tfrm" action="apc5_upload4.php" method="post" onsubmit="beginUpload();">
  <input type="hidden" name="APC_UPLOAD_PROGRESS" id="progress_key" value="<?php echo $progress_key; ?>" />
  <input type="file" id="userfile1"  name="userfile1" /><br />
  <input type="file" id="userfile2"  name="userfile2" /><br />
  <input type="submit" value="Upload!" />
</form>
<iframe id="tfrm" name="tfrm" style="width:1px;height:1px;border:0"></iframe>

<?php $pb->display(); ?>

</body>
</html>