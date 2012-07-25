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

class categories extends MyObject
{
	function categories()
	{
		$this->initVar('IdCategorie',XOBJ_DTYPE_INT,null,false);
		$this->initVar('IdQuestionnaire',XOBJ_DTYPE_INT,null,false);
		$this->initVar('LibelleCategorie',XOBJ_DTYPE_TXTBOX, null, false,255);
		$this->initVar('LibelleCompltCategorie',XOBJ_DTYPE_TXTBOX, null, false,255);
		$this->initVar('OrdreCategorie',XOBJ_DTYPE_INT,null,false);
		$this->initVar('AfficherDroite',XOBJ_DTYPE_INT,null,false);
		$this->initVar('AfficherGauche',XOBJ_DTYPE_INT,null,false);
		$this->initVar('comment1',XOBJ_DTYPE_TXTBOX, null, false,255);
		$this->initVar('comment2',XOBJ_DTYPE_TXTBOX, null, false,255);
		$this->initVar('comment3',XOBJ_DTYPE_TXTBOX, null, false,255);
		$this->initVar('comment1mandatory',XOBJ_DTYPE_INT,null,false);
		$this->initVar('comment2mandatory',XOBJ_DTYPE_INT,null,false);
		$this->initVar('comment3mandatory',XOBJ_DTYPE_INT,null,false);
	}
}


class QuestCategoriesHandler extends MyXoopsPersistableObjectHandler
{
	function QuestCategoriesHandler($db)
	{	//											Table				Classe			Id
		$this->XoopsPersistableObjectHandler($db, 'quest_categories', 'categories', 'IdCategorie');
	}

	/**
	 * Renvoie la liste des catégories d'un questionnaire avec son état
	 *
	 * @param 	int		IdQuestionnaire		L'identifiant du questionnaire dont on veut récupérer les infos
	 * @param 	int		uid					L'identifiant de la personne
	 * @param 	boolean	toutrepondu			Indique si la personne a répondu à toutes les catégories du questionnaire
	 * @return 	array	Liste des catégories sous la forme Id Catégorie-Etat de la catégorie (pas saisie/en cours/terminé) / Objet catégorie
	 */
	function getCategoriesAndState($IdQuestionnaire, $uid, &$toutrepondu)
	{
		$ret = array();
		$tbl_categories = array();
		// 1) Il faut commencer par vérifier si l'utilisateur n'a pas déjà répondu à tout, auquel cas il ne faut rien lui afficher
		$tout_repondu = true;
		// On commence par récupérer la liste complète de toutes les catégories de ce questionnaire
		$crit_categ = new Criteria('IdQuestionnaire', $IdQuestionnaire,'=');
		$crit_categ->setSort('OrdreCategorie');
		$tbl_categories = $this->getObjects($crit_categ);
		foreach($tbl_categories as $one_category) {
			$etat = $this->getCategoryState($one_category, $uid);
			if($etat == 0 || $etat == 2) {
				$tout_repondu = false;
			}
			$ret[$one_category->getVar('IdCategorie').'-'.$etat] = $one_category;
		}
		return $ret;
	}


	/**
	 * Renvoie l'état d'une catégorie
	 *
	 * 0=Aucune réponse, 1=Tout répondu, 2= Partiellement répondu
	 *
	 * @param 	object	$category	La catégorie à tester
	 * @param 	int		$uid		L'utilisateur à tester
	 */
	function getCategoryState(&$one_category, $uid)
	{
		$etat = 0;
		$quest_questions_handler = & xoops_getmodulehandler('questions', 'quest');
		$quest_reponses_handler = & xoops_getmodulehandler('reponses', 'quest');
		$quest_rubrcomment_handler = & xoops_getmodulehandler('rubrcomment', 'quest');

		// Recherche du nombre de questions pour cette catégorie
		$criteria2 = new CriteriaCompo();
		$criteria2->add(new Criteria('IdQuestionnaire', $one_category->getVar('IdQuestionnaire'),'='));
		$criteria2->add(new Criteria('IdCategorie', $one_category->getVar('IdCategorie'),'='));
		$quest_count = $quest_questions_handler->getCount($criteria2);	// Nombre de questions de cette catégorie
		// Nombre de réponses faites pour cette catégorie (de ce questionnaire) pour cet utilisateur
		$criteria3 = new CriteriaCompo();
		$criteria3->add(new Criteria('IdQuestionnaire', $one_category->getVar('IdQuestionnaire'),'='));
		$criteria3->add(new Criteria('IdCategorie', $one_category->getVar('IdCategorie'),'='));
		$criteria3->add(new Criteria('IdRespondant', $uid, '='));
		$answers_count = $quest_reponses_handler->getCount($criteria3);
		if($answers_count == 0 && $quest_count>0) {	// Aucune réponse mais il y a des questions
			$etat = 0;
		} elseif($answers_count == $quest_count) {	// Le nombre de réponses correspond au nombre de questions
			// Il faut vérifier que toutes les questions ont bien été répondues
			$criteria4 = new CriteriaCompo();
			$criteria4->add(new Criteria('IdQuestionnaire', $one_category->getVar('IdQuestionnaire'),'='));
			$criteria4->add(new Criteria('IdCategorie', $one_category->getVar('IdCategorie'),'='));
			$criteria4->add(new Criteria('IdRespondant', $uid, '='));
			if($one_category->getVar('AfficherDroite') == 1) {
				$criteria4->add(new Criteria('Id_CAC1', 0, '<>'));
			}
			if($one_category->getVar('AfficherGauche') == 1) {
				$criteria4->add(new Criteria('Id_CAC2', 0, '<>'));
			}
			$answers_count2 = $quest_reponses_handler->getCount($criteria4);
			if($answers_count2 == $quest_count) {	// Le nombre de réponses correspond au nombre de questions
				// Reste à vérifier les réponses aux commentaires
				$etat = 1;	// On part du postulat qu'effectivement tout est répondu
				$tbl_rubr_comment = array();
				$criteria5 = new CriteriaCompo();
				$criteria5->add(new Criteria('IdQuestionnaire', $one_category->getVar('IdQuestionnaire'),'='));
				$criteria5->add(new Criteria('IdCategorie', $one_category->getVar('IdCategorie'),'='));
				$criteria5->add(new Criteria('IdRespondant', $uid, '='));
				$criteria5->add(new Criteria('IdCategorie', $one_category->getVar('IdCategorie'),'='));
				$tbl_rubr_comment = $quest_rubrcomment_handler->getObjects($criteria5);
				//echo "<br>".$criteria5->render();

				if(count($tbl_rubr_comment) > 0) {	// Ca se présente bien, il y a un enregistrement
					$rubrcomment = $tbl_rubr_comment[0];
					if($one_category->getVar('comment1mandatory') && xoops_trim($rubrcomment->getVar('Comment1')) == '') {
						$etat = 2;
					}
					if($one_category->getVar('comment2mandatory') && xoops_trim($rubrcomment->getVar('Comment2')) == '') {
						$etat = 2;
					}
					if($one_category->getVar('comment3mandatory') && xoops_trim($rubrcomment->getVar('Comment3')) == '') {
						$etat = 2;
					}
				} else {	// Il n'y a pas d'enregistrement pour les commentaires, reste à vérifier qu'on attendait un ou des commentaires
					if(xoops_trim($one_category->getVar('comment1')) != '') {	// On devait avoir un commentaire et il n'y en a pas eu
						$etat = 2;
					} elseif(xoops_trim($one_category->getVar('comment2')) != '') {	// On devait avoir un commentaire et il n'y en a pas eu
						$etat = 2;
					} elseif(xoops_trim($one_category->getVar('comment3')) != '') {	// On devait avoir un commentaire et il n'y en a pas eu
						$etat = 2;
					}
				}
			} else {
				$etat = 2;	// Partiellement répondu
			}
		} else {	// Partiellement répondu
			$etat = 2;
		}
		return $etat;
	}
}
?>