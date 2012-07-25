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
 * Affichage du statut de chaque questionnaire duquel l'utilisateur courant est commanditaire
 */

include('../../mainfile.php');
$xoopsOption['template_main'] = 'quest_status.html';
include_once XOOPS_ROOT_PATH.'/header.php';
include_once XOOPS_ROOT_PATH.'/modules/quest/include/functions.php';

$uid = 0;
if(is_object($xoopsUser)) {
	$uid = $xoopsUser->getVar('uid');
} else {	// Acc�s r�serv� aux utilisateurs enregistr�s
    redirect_header(XOOPS_URL.'/index.php',2,_ERRORS);
    exit();
}

// Initialisation des handlers
$cac_categories_handler = & xoops_getmodulehandler('cac_categories', 'quest');
$categories_handler = & xoops_getmodulehandler('categories', 'quest');
$enquetes_handler = & xoops_getmodulehandler('enquetes', 'quest');
$questionnaires_handler = & xoops_getmodulehandler('questionnaires', 'quest');
$questions_handler = & xoops_getmodulehandler('questions', 'quest');
$reponses_handler = & xoops_getmodulehandler('reponses', 'quest');
$rubrcomment_handler = & xoops_getmodulehandler('rubrcomment', 'quest');
// Handler Xoops
$member_handler =& xoops_gethandler('member');


// D�but des travaux
// On commence par rechercher les questionnaires desquels l'utilisateur est commanditaire
$groups = quest_getUserGroups();
$tbl_questionnaires = array();
$tbl_questionnaires = $questionnaires_handler->getObjects($groups);
foreach($tbl_questionnaires as $one_questionnaire) {
	$tbl = array();
	$tbl_solutions = array();
	$tbl = $one_questionnaire->toArray();
	// R�cup�ration des informations sur l'enqu�t�
	$enquete = $enquetes_handler->get($one_questionnaire->getVar('IdEnquete'));
	$tbl['Enquete'] = $enquete->toArray();

	$tbl_categories = array();
	$critere = new Criteria('IdQuestionnaire', $one_questionnaire->getVar('IdQuestionnaire'),'=');
	$critere->setSort('OrdreCategorie');
	$tbl_categories = $categories_handler->GetObjects($critere);

	// ****************************************************************************************************************
	// Statistiques globales
	// ****************************************************************************************************************
	// R�cup�ration de la liste des utilisateurs
	$list_users = $list_users2 = array();
	$tbl_users = array();
	$tbl_users = $member_handler->getUsersByGroup($one_questionnaire->getVar('Groupe'), true);	// En tant qu'objet

	foreach($tbl_users as $one_user) {
		$list_users[] = xoops_trim($one_user->getVar('name')) != '' ? $one_user->getVar('name') : $one_user->getVar('uname');
		$list_users2[] = $one_user->getVar('uid');
	}

	natcasesort($list_users);	// Tri naturel de la liste
	$tbl['respondants'] = $list_users;
	// Solution 1
	$tbl_solutions['users_to_respond'] = count($list_users);	// Nombre de personnes devant r�pondre
	$tbl['respondants_count'] = $tbl_solutions['users_to_respond'];

	// Recherche des personnes qui n'ont pas r�pondu

	// On commence par chercher la liste des personnes qui ont r�pondu
	$tbl_repondu = $reponses_handler->getUsersIdPerQuestionnaire($one_questionnaire->getVar('IdQuestionnaire'));
	// Normalement la diff�rence entre la liste des personnes qui doivent r�pondre et la liste des personnes qui ont r�pondu
	// est �gale � la liste des personnes qui n'ont pas du tout r�pondu
	$tbl_non_repondus = array_diff($list_users2, $tbl_repondu);

	// Solution 2
	$tbl_solutions['users_without_replies'] = count($tbl_non_repondus);		// Nombre d'utilisateurs qui n'ont pas du tout r�pondu
	$tbl_solutions['users_partially_reply'] = 0;
	$tbl_solutions['users_full_reply'] = 0;

	// Recherche du nombre total de questions du questionnaire
	$criteria = new CriteriaCompo();
	$criteria->add(new Criteria('IdQuestionnaire', $one_questionnaire->getVar('IdQuestionnaire') ,'='));
	$questionnaire_questions_count = $questions_handler->getCount($criteria);

	// Recherche du nombre de questions par cat�gorie pour ce questionnaire
	$tbl_questions_count_per_category = array();	// Cl�=Id Cat�gorie, Valeur = Nb questions
	$tbl_questions_count_per_category = $questions_handler->QuestionsCountPerQuestionnaire($one_questionnaire->getVar('IdQuestionnaire'));

	// Ensuite, on regarde pour chaque personne qui a r�pondu pour savoir si elle a r�pondu � tout ou partiellement
	foreach($tbl_repondu as $one_uid) {
		$tout_repondu = true;	// On part du postulat que la personne a r�pondu � tout
		foreach($tbl_categories as $one_category) {	// Boucle sur les cat�gories
			if($one_category->getVar('AfficherDroite') || $one_category->getVar('AfficherGauche')) {
				$criteria = new CriteriaCompo();
				$critere = new Criteria('IdQuestionnaire', $one_questionnaire->getVar('IdQuestionnaire') ,'=');
				$criteria->add(new Criteria('IdRespondant', $one_uid ,'='));
				$criteria->add(new Criteria('IdCategorie', $one_category->getVar('IdCategorie') ,'='));
				if($one_category->getVar('AfficherDroite')) {
					$criteria->add(new Criteria('Id_CAC1', 0 ,'<>'));
				}
				if($one_category->getVar('AfficherGauche')) {
					$criteria->add(new Criteria('Id_CAC2', 0 ,'<>'));
				}
				$answers_count = $reponses_handler->getCount($criteria);	// Nombre de r�ponses de cette personne
				if($answers_count != $tbl_questions_count_per_category[$one_category->getVar('IdCategorie')]) {
					$tout_repondu = false;
					break;	// Pas la peine de continuer, cette personne n'a pas r�pondu sur cette cat�gorie
				}
			}
			// V�rification des commentaires
			if($tout_repondu && (xoops_trim($one_category->getVar('comment1'))!='' || xoops_trim($one_category->getVar('comment2'))!='' || xoops_trim($one_category->getVar('comment3'))!='')) {
				$criteria = new CriteriaCompo();
				$criteria->add(new Criteria('IdRespondant', $one_uid ,'='));
				$criteria->add(new Criteria('IdQuestionnaire', $one_questionnaire->getVar('IdQuestionnaire') ,'='));
				$criteria->add(new Criteria('IdCategorie', $one_category->getVar('IdCategorie') ,'='));
				if(xoops_trim($one_category->getVar('comment1'))!='') {
					$criteria->add(new Criteria('LENGTH(TRIM(Comment1))', 0 ,'>'));
				}
				if(xoops_trim($one_category->getVar('comment2'))!='') {
					$criteria->add(new Criteria('LENGTH(TRIM(Comment2))', 0 ,'>'));
				}
				if(xoops_trim($one_category->getVar('comment3'))!='') {
					$criteria->add(new Criteria('LENGTH(TRIM(Comment3))', 0 ,'>'));
				}
				$cnt = $rubrcomment_handler->getCount($criteria);
				if($cnt == 0) {
					$tout_repondu = false;
				}
			}
		}

		if($tout_repondu) {
			$tbl_solutions['users_full_reply']++;
		} else {
			$tbl_solutions['users_partially_reply']++;
		}
	}
	// Calcul des pourcentages
	$tbl_solutions['pourcent_users_to_respond'] = 100;	// Nombre de personnes devant r�pondre
	$tbl_solutions['pourcent_users_without_replies'] = ($tbl_solutions['users_without_replies'] / $tbl_solutions['users_to_respond']) * 100;			// Nombre d'utilisateurs qui n'ont pas du tout r�pondu
	$tbl_solutions['pourcent_users_partially_reply'] =  ($tbl_solutions['users_partially_reply'] / $tbl_solutions['users_to_respond']) * 100;
	$tbl_solutions['pourcent_users_full_reply'] = ($tbl_solutions['users_full_reply'] / $tbl_solutions['users_to_respond']) * 100;
	$tbl['stats_globales'] = $tbl_solutions;

	// ****************************************************************************************************************
	// Statistiques d�taill�e cat�gorie par cat�gorie
	// ****************************************************************************************************************
	$tbl_total = array();


	foreach($tbl_categories as $one_category) {		// Boucle sur les cat�gories
		// Recherche du nombre de personnes qui ont r�pondu � cette cat�gorie
		$criteria = new CriteriaCompo();
		$critere = new Criteria('IdQuestionnaire', $one_questionnaire->getVar('IdQuestionnaire') ,'=');
		$criteria->add(new Criteria('IdCategorie', $one_category->getVar('IdCategorie') ,'='));
		if($one_category->getVar('AfficherDroite')) {
			$criteria->add(new Criteria('Id_CAC1', 0 ,'<>'));
		}
		if($one_category->getVar('AfficherGauche')) {
			$criteria->add(new Criteria('Id_CAC2', 0 ,'<>'));
		}
		$answers_count = $reponses_handler->getCount($criteria);



		$tbl2 = array();
		$tbl2 = $one_category->toArray();
		// Recherche du nombre de commentaires r�pondus
		if(xoops_trim($one_category->getVar('comment1'))!='') {
			$criteria = new CriteriaCompo();
			$criteria->add(new Criteria('IdQuestionnaire', $one_questionnaire->getVar('IdQuestionnaire') ,'='));
			$criteria->add(new Criteria('IdCategorie', $one_category->getVar('IdCategorie') ,'='));
			$criteria->add(new Criteria('LENGTH(TRIM(Comment1))', 0 ,'>'));
			$cnt = $rubrcomment_handler->getCount($criteria);
			$tbl2['Comment1Count'] = $cnt;
		} else {
			$tbl2['Comment1Count'] = 0;
		}

		if(xoops_trim($one_category->getVar('comment2'))!='') {
			$criteria = new CriteriaCompo();
			$criteria->add(new Criteria('IdQuestionnaire', $one_questionnaire->getVar('IdQuestionnaire') ,'='));
			$criteria->add(new Criteria('IdCategorie', $one_category->getVar('IdCategorie') ,'='));
			$criteria->add(new Criteria('LENGTH(TRIM(Comment2))', 0 ,'>'));
			$cnt = $rubrcomment_handler->getCount($criteria);
			$tbl2['Comment2Count'] = $cnt;
		} else {
			$tbl2['Comment2Count'] = 0;
		}

		if(xoops_trim($one_category->getVar('comment3'))!='') {
			$criteria = new CriteriaCompo();
			$criteria->add(new Criteria('IdQuestionnaire', $one_questionnaire->getVar('IdQuestionnaire') ,'='));
			$criteria->add(new Criteria('IdCategorie', $one_category->getVar('IdCategorie') ,'='));
			$criteria->add(new Criteria('LENGTH(TRIM(Comment3))', 0 ,'>'));
			$cnt = $rubrcomment_handler->getCount($criteria);
			$tbl2['Comment3Count'] = $cnt;
		} else {
			$tbl2['Comment3Count'] = 0;
		}


		// Recherche du nombre de questions
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('IdQuestionnaire', $one_questionnaire->getVar('IdQuestionnaire') ,'='));
		$criteria->add(new Criteria('IdCategorie', $one_category->getVar('IdCategorie') ,'='));
		$questions_count = $questions_handler->getCount($criteria);
		$tbl2['questions_count'] = $questions_count;

		// Recherche du nombre de r�ponses que l'on devrait avoir
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('IdCategorie', $one_category->getVar('IdCategorie') ,'='));
		$cac_count = $cac_categories_handler->getCount($criteria);

		if($one_category->getVar('AfficherDroite') && $one_category->getVar('AfficherGauche')) {
			$tbl2['cac_count'] = $questions_count * 2;
		} else {
			$tbl2['cac_count'] = $questions_count;
		}


		// R�cup�ration du nombre de r�ponses
		$criteria = new CriteriaCompo();
		$critere = new Criteria('IdQuestionnaire', $one_questionnaire->getVar('IdQuestionnaire') ,'=');
		$criteria->add(new Criteria('IdCategorie', $one_category->getVar('IdCategorie') ,'='));
		if($one_category->getVar('AfficherDroite')) {
			$criteria->add(new Criteria('Id_CAC1', 0 ,'<>'));
		}
		if($one_category->getVar('AfficherGauche')) {
			$criteria->add(new Criteria('Id_CAC2', 0 ,'<>'));
		}
		$answers_count = $reponses_handler->getCount($criteria);
		$tbl2['answers_count'] = $answers_count;

		$tbl_total['questions'] .= $questions_count;
		$tbl_total['reponses'] .= $answers_count;

		$tbl['categories'][] = $tbl2;
	}
	$tbl['total_questions'] = $tbl_total['questions'];
	$tbl['total_reponses'] = $tbl_total['reponses'];
	$tbl['total_nonrepondus'] = $tbl_total['questions'] - $tbl_total['reponses'];
	$xoopsTpl->append('questionnaires', $tbl);
}

$xoopsTpl->assign('xoops_pagetitle', $xoopsModule->getVar('name').' - '._QUEST_STATUS_INDEX);
include_once(XOOPS_ROOT_PATH.'/footer.php');

?>