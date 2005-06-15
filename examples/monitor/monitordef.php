<?php
/**
 * Default Progress2 Monitor. Used default QF renderer.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 */
require_once 'HTML/Progress2/Monitor.php';

$pm = new HTML_Progress2_Monitor();

$pb =& $pm->getProgressElement();
$pb->setAnimSpeed(200);
$pb->setIncrement(10);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Default Progress2 Monitor </title>
<style type="text/css">
<!--
<?php echo $pm->getStyle(); ?>
// -->
</style>
<script type="text/javascript">
<!--
<?php echo $pm->getScript(); ?>
//-->
</script>
</head>
<body>

<?php
echo $pm->toHtml();
$pm->run();
?>

</body>
</html>