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
 * G�n�ration automatique des relances de tous les questionnaires
 */

include('../../../mainfile.php');
include_once XOOPS_ROOT_PATH.'/modules/quest/include/functions.php';
include XOOPS_ROOT_PATH."/class/xoopsmailer.php";

echo "<br />Initialisation des handlers\n";
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

if(function_exists('xoops_getMailer')) {
	$xoopsMailer = xoops_getMailer();
} else {
	$xoopsMailer =& getMailer();
}

$xoopsMailer->useMail();

echo "<br />R�cup�ration de la liste des questionnaires\n";
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('DateFermeture', time(),'>='));
$criteria->add(new Criteria('DateOuverture', time(),'<='));
$tbl_questionnaires = $questionnaires_handler->getObjects($criteria);
foreach($tbl_questionnaires as $one_questionnaire) {
	echo "<br />Traitement du questionnaire ".$one_questionnaire->getVar('LibelleQuestionnaire');
	// On commence par v�rifier que les relances sur le questionnaire n'ont pas d�j� �t� faites
	if($one_questionnaire->getVar('DerniereRelance') != 0) {
		$date_reference = $one_questionnaire->getVar('DerniereRelance');
	} else {
		$date_reference = $one_questionnaire->getVar('DateOuverture');
	}
	$prochaine_relance =  $date_reference + ($one_questionnaire->getVar('FrequenceRelances') * 86400);
	if(time() >= $prochaine_relance) {	// Il faut relancer
		// Les param�tres du mailer
		$xoopsMailer->setFromEmail($one_questionnaire->getVar('EmailFrom'));
		$xoopsMailer->setFromName($one_questionnaire->getVar('EmailFromName'));
		$xoopsMailer->setSubject($one_questionnaire->getVar('SujetRelance'));

		// On commence par mettre � jour le questionnaire pour indiquer que les relances ont �t� faites
		$one_questionnaire->setVar('DerniereRelance', time());
		$one_questionnaire->setVar('NbRelances', $one_questionnaire->getVar('NbRelances')+1);
		$questionnaires_handler->insert($one_questionnaire, true);

		// Ensuite on r�cup�re la liste compl�te des personnes qui doivent r�pondre � ce questionnaire
		$tbl_repondu = $tbl_relances = $tbl_users = $list_users = $tbl_non_repondus = $tbl_users2 = array();
		$tbl_users = $member_handler->getUsersByGroup($one_questionnaire->getVar('Groupe'), true);	// En tant qu'objet

		foreach ($tbl_users as $one_user) {
			$list_users[] = $one_user->getVar('uid');
			$tbl_users2[$one_user->getVar('uid')] = $one_user;
		}

		// Liste des personnes qui ont r�pondu (partiellement ou totalement)
		$tbl_repondu = $reponses_handler->getUsersIdPerQuestionnaire($one_questionnaire->getVar('IdQuestionnaire'));

		// Normalement la diff�rence entre la liste des personnes qui doivent r�pondre et la liste des personnes qui ont r�pondu
		// est �gale � la liste des personnes qui n'ont pas du tout r�pondu
		$tbl_non_repondus = array_diff($list_users, $tbl_repondu);
		if($one_questionnaire->getVar('RelancesOption') == 2) {		// On ne doit relancer que ceux qui n'ont pas du tout r�pondu
			$tbl_relances = $tbl_non_repondus;
		} else {	// On relance tout le monde
			$tbl_relances = $tbl_non_repondus;
			$tbl_questions_count_per_category = array();	// Cl�=Id Cat�gorie, Valeur = Nb questions
			$tbl_questions_count_per_category = $questions_handler->QuestionsCountPerQuestionnaire($one_questionnaire->getVar('IdQuestionnaire'));
			$tbl_categories = array();
			$critere = new Criteria('IdQuestionnaire', $one_questionnaire->getVar('IdQuestionnaire'),'=');
			$critere->setSort('OrdreCategorie');
			$tbl_categories = $categories_handler->GetObjects($critere);
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
				if(!$tout_repondu) {
					$tbl_relances[] = $one_uid;
				}
			}
		}
		// Les relances
		foreach($tbl_relances as $one_uid) {
			//TODO: Voir si on peut utiliser le champs replyTo mais cela ne semble pas possible
			$user = $tbl_users2[$one_uid];
			echo "<br />Relance de ".$user->getVar('uname');
			$body = $one_questionnaire->getVar('CorpsRelance');
			$body = str_replace('{SITE_URL}', XOOPS_URL , $body);
			$body = str_replace('{USER_LOGIN}', $user->getVar('uname'), $body);
			$body = str_replace('{USER_FULLNAME}', $user->getVar('name'), $body);
			$body = str_replace('{LAST_RESTART}', formatTimestamp($date_reference), $body);
			$body = str_replace('{QUESTIONNAIRE_NAME}', $one_questionnaire->getVar('LibelleQuestionnaire'), $body);
			$body = str_replace('{QUESTIONNAIRE_START}', formatTimestamp($one_questionnaire->getVar('DateOuverture')), $body);
			$body = str_replace('{QUESTIONNAIRE_END}', formatTimestamp($one_questionnaire->getVar('DateFermeture')), $body);
			$xoopsMailer->setBody($body);
			$xoopsMailer->setToEmails($user->getVar('email'));
			$xoopsMailer->send();
		}
	}
}
echo "<br /><b>Action termin�e</b>\n";
?>