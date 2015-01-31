// JavaScript Document

/** 
 * @version		1.0.0
 * @package		konsaexp
 * @copyright	2010
 * @license		GPLv2
 */

function show_hide_row(row_num, n)
{
	for( i=0;i<n;i++)
	{
		if (i!=row_num) {document.getElementById("inforow"+i).style.display='none';}
	}
	el=document.getElementById("inforow"+row_num);
    if(el.style.display=='table-row') 
	{
		el.style.display='none';
	} else 
	{
		el.style.display='table-row';
	}

}

function tableOrdering( order, dir, task )
{
		var form = document.adminForm;

        form.filter_order.value = order;
        form.filter_order_Dir.value = dir;
        document.adminForm.submit( task );
}