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

if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}

include_once XOOPS_ROOT_PATH.'/class/xoopsobject.php';
if (!class_exists('XoopsPersistableObjectHandler')) {
	include_once XOOPS_ROOT_PATH.'/modules/quest/class/PersistableObjectHandler.php';
}

class questionnaires extends MyObject
{
	function questionnaires()
	{
		$this->initVar('IdQuestionnaire',XOBJ_DTYPE_INT,null,false);
		$this->initVar('LibelleQuestionnaire',XOBJ_DTYPE_TXTBOX, null, false,255);
		$this->initVar('IdEnquete',XOBJ_DTYPE_INT,null,false);
		$this->initVar('DateOuverture',XOBJ_DTYPE_INT,null,false);
		$this->initVar('DateFermeture',XOBJ_DTYPE_INT,null,false);
		$this->initVar('NbSessions',XOBJ_DTYPE_INT,null,false);
		$this->initVar('Etat',XOBJ_DTYPE_INT,null,false);
		$this->initVar('ltor',XOBJ_DTYPE_INT,null,false);
		$this->initVar('SujetRelance',XOBJ_DTYPE_TXTBOX, null, false,255);
		$this->initVar('CorpsRelance',XOBJ_DTYPE_TXTAREA, null, false);
		$this->initVar('SujetOuverture',XOBJ_DTYPE_TXTBOX, null, false,255);
		$this->initVar('CorpsOuverture',XOBJ_DTYPE_TXTAREA, null, false);
		$this->initVar('FrequenceRelances',XOBJ_DTYPE_INT,null,false);
		$this->initVar('DerniereRelance',XOBJ_DTYPE_INT,null,false);
		$this->initVar('NbRelances',XOBJ_DTYPE_INT,null,false);
		$this->initVar('ReplyTo',XOBJ_DTYPE_TXTBOX, null, false,255);
		$this->initVar('Groupe',XOBJ_DTYPE_INT,null,false);
		$this->initVar('PartnerGroup',XOBJ_DTYPE_INT,null,false);
		$this->initVar('RelancesOption',XOBJ_DTYPE_INT,null,false);
		$this->initVar('EmailFrom',XOBJ_DTYPE_TXTBOX, null, false,255);
		$this->initVar('EmailFromName',XOBJ_DTYPE_TXTBOX, null, false,255);
		$this->initVar('Introduction',XOBJ_DTYPE_TXTAREA, null, false);
		$this->initVar('GoOnAfterEnd',XOBJ_DTYPE_TXTAREA, null, false);
		$this->initVar('ResetButton',XOBJ_DTYPE_TXTBOX, null, false,255);
	}
}


class QuestQuestionnairesHandler extends MyXoopsPersistableObjectHandler
{
	function QuestQuestionnairesHandler($db)
	{	//											Table					Classe			Id
		$this->XoopsPersistableObjectHandler($db, 'quest_questionnaires', 'questionnaires', 'IdQuestionnaire');
	}


	/**
	 * Renvoie la liste des questionnaires auxquel l'utilisateur n'a pas répondu, en respectant les droits
	 *
	 * @param 	int		uid		Identifiant de l'utilisateur
	 * @return	array	Liste des questionnaires sous la forme ID Première catégorie => Objet Questionnaire
	 */
	function GetNonAnsweredQuestionnaires($uid)
	{
		include_once XOOPS_ROOT_PATH.'/modules/quest/include/functions.php';
		$ret = array();
		$tbl_questionnaires = array();
		$tbl_categories = array();
		$categories_handler = & xoops_getmodulehandler('categories', 'quest');

		// On commence par récupérer la liste des questionnaires
		$criteria = new CriteriaCompo();
		$criteria->add(quest_getUserGroups());		// Questionnaires auxquels l'utilisateur peut répondre (de part la gestion des droits)
		$criteria->add(new Criteria('DateFermeture', time(),'>'));		// Questionnaires non "périmés"
		$criteria->add(new Criteria('DateOuverture', time(),'<='));		// Questionnaires non "périmés"
		$criteria->setSort('LibelleQuestionnaire');

		$tbl_questionnaires = $this->getObjects($criteria);
		foreach($tbl_questionnaires as $questionnaire) {	// Boucle sur les questionnaires
			// Recherche de ses catégories
			$critere = new Criteria('IdQuestionnaire', $questionnaire->getVar('IdQuestionnaire'),'=');
			$critere->setSort('OrdreCategorie');
			$tbl_categories = $categories_handler->GetObjects($critere);
			foreach($tbl_categories as $one_categorie) {	// Boucle sur les catégories
				// Si le questionnaire n'est pas terminé :
				$etat = $categories_handler->getCategoryState($one_categorie, $uid);
				if($etat != 1) {
					$ret[$one_categorie->getVar('IdCategorie')] = $questionnaire;
					break;	// Pas la peine de boucler sur les catégories
				}
			}
		}
		return $ret;
	}


	/**
	 * Indique si un questionnaire est "visible" d'un utilisateur (s'il a les droits et si le questionnaire n'est pas périmé et s'il est publié)
	 *
	 * @param 	object 	$Questionnaires	Le questionnaire à traiter
	 * @param 	int 		$uid			L'utilisateur courant
	 * @return	booleean	Indique si le questionnaire est accessible/visible de l'utlisateur
	 */
	function isVisible($Questionnaire, $uid)
	{
		include_once XOOPS_ROOT_PATH.'/modules/quest/include/functions.php';
		// Premier test, par rapport aux droits
		if(!in_array($Questionnaire->getVar('Groupe'), quest_getUserGroups($uid, false))) {
			return false;
		} else {
			// Deuxième test, par rapport à la date de fermeture
			if($Questionnaire->getVar('DateFermeture') < time()) {
				return false;
			} else {	// Dernier test, par rapport à la date de mise en service du questionnaire
				if($Questionnaire->getVar('DateOuverture') <= time()) {
					return true;
				} else {
					return false;
				}
			}
		}
	}
}
?>