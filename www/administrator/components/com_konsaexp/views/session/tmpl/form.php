<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.calendar'); ?>

<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">

<?php // Закладка основных данных
//print_r($this); die; 

jimport('joomla.html.pane');
$pane =& JPane::getInstance('tabs', array('startOffset' => $this->tab ));
echo $pane->startPane( 'pane' );
// Главная вкладка
echo $pane->startPanel( JText::_('COM_KONSAEXP_SESSION_DETAILS'), 'panel_main' );
echo $this->loadTemplate('panel_main'); 
echo $pane->endPanel();

// Вкладка участники
//echo $pane->startPanel( JText::_('COM_KONSAEXP_SESSION_PEOPLES'), 'panel_people' );
//echo $this->loadTemplate('panel_people');
//echo $pane->endPanel();


//Вкладка фонограммы
echo $pane->startPanel( JText::_('COM_KONSAEXP_SESSION_PHONOGRAMS'), 'panel_phonograms' );
echo $this->loadTemplate('panel_phonograms');
echo $pane->endPanel();


echo $pane->endPane( 'pane' );

?>

<div class="clr"></div>





<input type="hidden" name="option" value="com_konsaexp" />
<input type="hidden" name="id" value="<?php echo $this->data->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="session" />
</form>
