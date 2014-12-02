// * @file s5_mp3_player.js
// * @license GNU/GPL, see LICENSE.php, swf and js files are commercial and non-gpl licensed.
// * Site: www.shape5.com
// * Email: contact@shape5.com
// * @copyright (C) 2009 Shape 5


var arMP3Players = new Array();
var bMP3PlayerStarted = false;

function registerMP3Player(playerID,autostart){
	arMP3Players.push(playerID);
	if(autostart == "1" && !bMP3PlayerStarted){
		bMP3PlayerStarted = true;
		setTimeout("document.getElementById('"+playerID+"').autostart()",100);
	}
}

function stopMP3Players(playerID){
	for(i=0;i<arMP3Players.length;i++){
		if(playerID != arMP3Players[i]){
			document.getElementById(arMP3Players[i]).stopPlayer();
		}
	}
}


