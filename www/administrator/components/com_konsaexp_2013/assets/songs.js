// JavaScript Document

/**
 * @version		1.0.1
 * @package		muscol
 * @copyright	2009 JoomlaMusicSolutions.com
 * @license		GPLv2
 */

var new_songs = 0;
function new_song(){
	new_songs ++;
	/*var container = document.getElementById("new_songs");
	
	var inner = '<div><input class="text_area" type="text" name="0_disc_num_' + new_songs + '" id="0_disc_num_' + new_songs + '" size="3" maxlength="3" /> <input class="text_area" type="text" name="0_num_' + new_songs + '" id="0_num_' + new_songs + '" size="3" maxlength="3" /> <input class="text_area" type="text" name="0_song_' + new_songs + '" id="0_song_' + new_songs + '" size="100" maxlength="250" /></div>';
	
	container.innerHTML += inner;
	*/
	var tbl = document.getElementById("songs_table");
	var newRow = tbl.insertRow(tbl.rows.length);
	var newCell = newRow.insertCell(0);
	
	newCell = newRow.insertCell(1);
	
	newCell = newRow.insertCell(2);
	newCell.innerHTML = '<input class="text_area" type="text" name="0_disc_num_' + new_songs + '" id="0_disc_num_' + new_songs + '" size="3" maxlength="3" />';
	
	newCell = newRow.insertCell(3);
	newCell.innerHTML = '<input class="text_area" type="text" name="0_num_' + new_songs + '" id="0_num_' + new_songs + '" size="3" maxlength="3" />';
	
	newCell = newRow.insertCell(4);
	newCell.innerHTML = '<input class="text_area" type="text" name="0_song_' + new_songs + '" id="0_song_' + new_songs + '" size="100" maxlength="250" />';
	
	newCell = newRow.insertCell(5);
	newCell.innerHTML = '<input class="text_area" type="text" name="0_hours_' + new_songs + '" id="0_hours_' + new_songs + '" size="2" maxlength="2" /> : <input class="text_area" type="text" name="0_minuts_' + new_songs + '" id="0_minuts_' + new_songs + '" size="2" maxlength="2" /> : <input class="text_area" type="text" name="0_seconds_' + new_songs + '" id="0_seconds_' + new_songs + '" size="2" maxlength="2" />';
	
	newCell = newRow.insertCell(6);
	newCell = newRow.insertCell(7);
	newCell = newRow.insertCell(8);

}

function delete_selected_songs(){
	
	document.adminForm.controller.value = "song";
	document.adminForm.task.value = "remove";
	document.adminForm.submit();
}
