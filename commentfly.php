<?php
//  ------------------------------------------------------------------------ //
//                        QUEST - MODULE FOR XOOPS 2                         //
//                  Copyright (c) 2005-2006 Instant Zero                     //
//                     <http://www.instant-zero.com/>                        //
// ------------------------------------------------------------------------- //
//  This program is NOT free software; you can NOT redistribute it and/or    //
//  modify without my assent.   										     //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed WITHOUT ANY WARRANTY; without even the       //
//  implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. //
//  ------------------------------------------------------------------------ //


/**
 * Enregistrement d'un commentaire � la vol�e pour une cat�gorie dans un questionnaire et pour une personne
 */
include_once '../../mainfile.php';
include_once XOOPS_ROOT_PATH.'/modules/quest/include/functions.php';

$uid = 0;
if(is_object($xoopsUser)) {
	$uid = $xoopsUser->getVar('uid');
} else {	// Acc�s r�serv� aux utilisateurs enregistr�s
    redirect_header(XOOPS_URL.'/index.php',2,_ERRORS);
    exit();
}

// Param�tres recus
$IdQuestionnaire = intval($_POST['IdQuestionnaire']);
$IdCategorie = intval($_POST['IdCategorie']);
$area = intval($_POST['area']);		// De 1 � 3
$areavalue = $_POST['areavalue'];

$IP = Quest_IP();

// Initialisation des handlers
$categories_handler = & xoops_getmodulehandler('categories', 'quest');
$questionnaires_handler = & xoops_getmodulehandler('questionnaires', 'quest');
$rubrcomment_handler = & xoops_getmodulehandler('rubrcomment', 'quest');

// On commence par les v�rifications
// Chargement de la cat�gorie et du questionnaire
$save_categ  = $categories_handler->get($IdCategorie);
if(!is_object($save_categ)) {	// Cat�gorie introuvable
    redirect_header(XOOPS_URL.'/index.php',2,_QUEST_ERROR2);
    exit();
}

$save_quest = $questionnaires_handler->get($save_categ->getVar('IdQuestionnaire'));
if(!is_object($save_quest)) {
    redirect_header(XOOPS_URL.'/index.php',2,_QUEST_ERROR6);
    exit();
}

// Ensuite on v�rifie que l'utilisateur a le droit de r�pondre � ce questionnaire et donc � cette cat�gorie
if(!$questionnaires_handler->isVisible($save_quest, $uid)) {
    redirect_header(XOOPS_URL.'/index.php',2,_QUEST_ERROR3);	// Pas le droit, on d�gage.
    exit();
}

// On peut passer � la sauvegarde des donn�es *************************************************************************
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('IdRespondant', $uid ,'='));
$criteria->add(new Criteria('IdQuestionnaire', $save_quest->getVar('IdQuestionnaire') ,'='));
$criteria->add(new Criteria('IdCategorie', $save_categ->getVar('IdCategorie') ,'='));
$tbl_reponse = $rubrcomment_handler->getObjects($criteria);

if(count($tbl_reponse) == 1) {	// R�ponse d�j� enregistr�e, il faut mettre � jour
	$reponse = $tbl_reponse[0];
  	if($area == 1) {
  		$reponse->setVar('Comment1', $areavalue);
  	} elseif($area == 2) {
  		$reponse->setVar('Comment2', $areavalue);
  	} else {
  		$reponse->setVar('Comment3', $areavalue);
  	}
  	$reponse->setVar('DateReponse', time());
  	$reponse->setVar('IP', $IP);
  	$rubrcomment_handler->insert($reponse, true);
} else {	// Nouvelle r�ponse, il faut ajouter ******************************
	$reponse = $rubrcomment_handler->create(true);
	$reponse->setVar('IdRespondant', $uid);
	$reponse->setVar('IdQuestionnaire', $IdQuestionnaire);
  	$reponse->setVar('IdCategorie', $IdCategorie);
  	if($area == 1) {
  		$reponse->setVar('Comment1', $areavalue);
  	} elseif($area == 2) {
  		$reponse->setVar('Comment2', $areavalue);
  	} else {
  		$reponse->setVar('Comment3', $areavalue);
  	}
  	$reponse->setVar('DateReponse', time());
  	$reponse->setVar('IP', $IP);
  	$rubrcomment_handler->insert($reponse, true);
}

// Et au final, on r�affichage des donn�es ****************************************************************************
echo '<textarea name="comment1" cols="60" rows="'.$_SESSION['comment_lines'].'" onBlur="areasave(\'comment'.$area.'\','.$area.',this.value);">'.$areavalue.'</textarea>';
?>