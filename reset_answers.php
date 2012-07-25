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
include('../../mainfile.php');
include_once XOOPS_ROOT_PATH.'/modules/quest/include/functions.php';

/**
 * Remise à zéro de toutes les réponses d'un répondant pour un questionnaire donné
 */


// On commence par vérifier que le questionnaire a été spécifié
$quest_id = 0;
if(!isset($_GET['IdQuestionnaire']) && !isset($_POST['IdQuestionnaire'])) {
   	redirect_header(XOOPS_URL.'/index.php',2,_QUEST_ERROR9);
   	exit();
} else {
	$quest_id = intval($_GET['IdQuestionnaire']);
}
// Ensuite on vérifie que la personne à le droit d'accéder à ce questionnaire
// Déjà, est-ce quelqu'un de connecté ?
$uid = 0;
if(is_object($xoopsUser)) {
	$uid = $xoopsUser->getVar('uid');
} else {	// Accès réservé aux utilisateurs enregistrés
    redirect_header(XOOPS_URL.'/index.php',2,_ERRORS);
    exit();
}

$questionnaires_handler = & xoops_getmodulehandler('questionnaires', 'quest');
$questionnaire = $questionnaires_handler->get($quest_id);
if(!is_object($questionnaire)) {
    redirect_header(XOOPS_URL.'/index.php', 2, _QUEST_ERROR11);
    exit();
}
// Ensuite on vérifie que l'utilisateur a le droit de répondre à ce questionnaire
if(!$questionnaires_handler->isVisible($questionnaire, $uid)) {
    redirect_header(XOOPS_URL.'/index.php',2,_QUEST_ERROR3);	// Pas le droit, on dégage.
    exit();
}

// On temine en vérifiant que le paramétrage du questionnaire autorise la suppression de toutes les réponses d'une personne
if(xoops_trim($questionnaire->getVar('ResetButton')) != '') {
	$reponses_handler = & xoops_getmodulehandler('reponses', 'quest');
	$rubrcomment_handler = & xoops_getmodulehandler('rubrcomment', 'quest');
	// Suppression des réponses
	$criteria = new CriteriaCompo();
	$criteria->add(new Criteria('IdQuestionnaire', $quest_id ,'='));
	$criteria->add(new Criteria('IdRespondant', $uid ,'='));
	$reponses_handler->deleteAll($criteria);
	// Suppression des commentaires
	$rubrcomment_handler->deleteAll($criteria);
    redirect_header(XOOPS_URL.'/index.php', 2, _QUEST_ANSWERS_DELETED);	// Vos réponses ont été supprimées
    exit();
} else {
    redirect_header(XOOPS_URL.'/index.php', 2, _QUEST_ERROR12);	// Suppression non autorisée.
    exit();
}
?>
