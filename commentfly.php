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
 * Enregistrement d'un commentaire à la volée pour une catégorie dans un questionnaire et pour une personne
 */
include_once '../../mainfile.php';
include_once XOOPS_ROOT_PATH.'/modules/quest/include/functions.php';

$uid = 0;
if(is_object($xoopsUser)) {
	$uid = $xoopsUser->getVar('uid');
} else {	// Accès réservé aux utilisateurs enregistrés
    redirect_header(XOOPS_URL.'/index.php',2,_ERRORS);
    exit();
}

// Paramètres recus
$IdQuestionnaire = intval($_POST['IdQuestionnaire']);
$IdCategorie = intval($_POST['IdCategorie']);
$area = intval($_POST['area']);		// De 1 à 3
$areavalue = $_POST['areavalue'];

$IP = Quest_IP();

// Initialisation des handlers
$categories_handler = & xoops_getmodulehandler('categories', 'quest');
$questionnaires_handler = & xoops_getmodulehandler('questionnaires', 'quest');
$rubrcomment_handler = & xoops_getmodulehandler('rubrcomment', 'quest');

// On commence par les vérifications
// Chargement de la catégorie et du questionnaire
$save_categ  = $categories_handler->get($IdCategorie);
if(!is_object($save_categ)) {	// Catégorie introuvable
    redirect_header(XOOPS_URL.'/index.php',2,_QUEST_ERROR2);
    exit();
}

$save_quest = $questionnaires_handler->get($save_categ->getVar('IdQuestionnaire'));
if(!is_object($save_quest)) {
    redirect_header(XOOPS_URL.'/index.php',2,_QUEST_ERROR6);
    exit();
}

// Ensuite on vérifie que l'utilisateur a le droit de répondre à ce questionnaire et donc à cette catégorie
if(!$questionnaires_handler->isVisible($save_quest, $uid)) {
    redirect_header(XOOPS_URL.'/index.php',2,_QUEST_ERROR3);	// Pas le droit, on dégage.
    exit();
}

// On peut passer à la sauvegarde des données *************************************************************************
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('IdRespondant', $uid ,'='));
$criteria->add(new Criteria('IdQuestionnaire', $save_quest->getVar('IdQuestionnaire') ,'='));
$criteria->add(new Criteria('IdCategorie', $save_categ->getVar('IdCategorie') ,'='));
$tbl_reponse = $rubrcomment_handler->getObjects($criteria);

if(count($tbl_reponse) == 1) {	// Réponse déjà enregistrée, il faut mettre à jour
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
} else {	// Nouvelle réponse, il faut ajouter ******************************
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

// Et au final, on réaffichage des données ****************************************************************************
echo '<textarea name="comment1" cols="60" rows="'.$_SESSION['comment_lines'].'" onBlur="areasave(\'comment'.$area.'\','.$area.',this.value);">'.$areavalue.'</textarea>';
?>