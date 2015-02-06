// JavaScript Document

/**
 * @version		2.5.15
 * @package		konsa_expeditions
 * @copyright	2015 SP
 * @license		GPLv2
 */

var new_sessions = 0;
var aInt = 0;
function new_artist_session(){
	
	new_sessions ++;
	/*var container = document.getElementById("new_tracks");
	
	var inner = '<div><input class="text_area" type="text" name="0_disc_num_' + new_tracks + '" id="0_disc_num_' + new_tracks + '" size="3" maxlength="3" /> <input class="text_area" type="text" name="0_num_' + new_tracks + '" id="0_num_' + new_tracks + '" size="3" maxlength="3" /> <input class="text_area" type="text" name="0_track_' + new_tracks + '" id="0_track_' + new_tracks + '" size="100" maxlength="250" /></div>';
	
	container.innerHTML += inner;
	*/
	var tbl = document.getElementById("sessions_table");
			//alert (tbl.rows.length);
	var tblLength = tbl.rows.length;
	if (tblLength == 1){
		aInt = 1;
	} else {
		if (aInt==0){
			var sInt = tbl.rows[tblLength-1].getElementsByTagName("td").item(2).innerHTML;
			aInt = parseInt(sInt)+1;
		} else {
			aInt += 1;
		}
	}
	
	var newRow = tbl.insertRow();
	var newCell = newRow.insertCell(0);
	
	newCell = newRow.insertCell(1);
	
	newCell.innerHTML = '<select name="0_session_' + new_sessions+'" id="0_session_' + new_sessions+'" ">'+document.getElementById("select1").value+'</select> <input type="hidden" name="0_sessiontheme_' + new_sessions+'" id="0_sessiontheme_' + new_sessions+'" value="" />';
	newCell = newRow.insertCell(2);

}


function delete_selected_sessions(){
	Alert('DELETE');
	document.adminForm.controller.value = "artist";
	document.adminForm.task.value = "cancel";
	//Alert(document.adminForm.controller.value+" : "+document.adminForm.task.value);
	document.adminForm.submit();
}

var new_phonograms = 0;
function new_phonogram(){
	new_phonograms ++;
	/*var container = document.getElementById("new_tracks");
	
	var inner = '<div><input class="text_area" type="text" name="0_disc_num_' + new_tracks + '" id="0_disc_num_' + new_tracks + '" size="3" maxlength="3" /> <input class="text_area" type="text" name="0_num_' + new_tracks + '" id="0_num_' + new_tracks + '" size="3" maxlength="3" /> <input class="text_area" type="text" name="0_track_' + new_tracks + '" id="0_track_' + new_tracks + '" size="100" maxlength="250" /></div>';
	
	container.innerHTML += inner;
	*/

	var tbl = document.getElementById("phonograms_table");
	/* var newRow = tbl.insertRow(tbl.rows.length); */
var newRow = tbl.insertRow(1);
	var newCell = newRow.insertCell(0);
	
	newCell = newRow.insertCell(1);
	
	newCell = newRow.insertCell(2);
	newCell.innerHTML = '<input class="text_area" type="text" name="0_phonogram_title_' + new_phonograms + '" id="0_phonogram_title_' + new_phonograms + '" size="130" maxlength="300" />';
	
	newCell = newRow.insertCell(3);
//	newCell.innerHTML = '<select name="0_phonogram_place_' + new_phonograms+'" id="0_phonogram_place_' + new_phonograms+'">'+select_town+'</select>';
	
	newCell = newRow.insertCell(4);
	newCell = newRow.insertCell(5);
	newCell = newRow.insertCell(6);

}

function delete_selected_phonograms(){
	
	document.adminForm.controller.value = "phonogram";
	document.adminForm.task.value = "remove";
	document.adminForm.submit();
}

var new_docs = 0;
function new_doc(){
	new_docs ++;

	var tbl = document.getElementById("docs_table");
	/* var newRow = tbl.insertRow(tbl.rows.length); */
var newRow = tbl.insertRow(1);
	var newCell = newRow.insertCell(0);
	
	newCell = newRow.insertCell(1);
	
	newCell = newRow.insertCell(2);
	newCell.innerHTML = '<input class="text_area" type="text" name="0_doc_title_' + new_docs + '" id="0_doc_title_' + new_docs + '" size="130" maxlength="300" />';
	
	newCell = newRow.insertCell(3);
	newCell = newRow.insertCell(4);

}

function delete_selected_docs(){
	
	document.adminForm.controller.value = "doc";
	document.adminForm.task.value = "remove";
	document.adminForm.submit();
}
