<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.calendar'); ?>

<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">

<?php // Закладка основных данных
//print_r($this); die; 

jimport('joomla.html.pane');
$pane =& JPane::getInstance('tabs', array('startOffset' => $this->tab ));
echo $pane->startPane( 'pane' );
echo $pane->startPanel( JText::_('COM_KONSAEXP_SESSION_DETAILS'), 'panel1' );
echo $this->loadTemplate('panel1'); 
echo $pane->endPanel();

?>

<div class="clr"></div>

<input type="hidden" name="option" value="com_konsaexp" />
<input type="hidden" name="id" value="<?php echo $this->data->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="session" />
</form>
