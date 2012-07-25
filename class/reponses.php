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

class reponses extends MyObject
{
	function reponses()
	{
		$this->initVar('IdReponse',XOBJ_DTYPE_INT,null,false);
		$this->initVar('IdQuestionnaire',XOBJ_DTYPE_INT,null,false);
		$this->initVar('IdCategorie',XOBJ_DTYPE_INT,null,false);
		$this->initVar('IdRespondant',XOBJ_DTYPE_INT,null,false);
		$this->initVar('IdQuestion',XOBJ_DTYPE_INT,null,false);
		$this->initVar('Id_CAC1',XOBJ_DTYPE_INT,null,false);
		$this->initVar('Id_CAC2',XOBJ_DTYPE_INT,null,false);
		$this->initVar('DateReponse',XOBJ_DTYPE_INT,null,false);
		$this->initVar('IP',XOBJ_DTYPE_TXTBOX, null, false,32);
	}
}

class QuestReponsesHandler extends MyXoopsPersistableObjectHandler
{
	function QuestReponsesHandler($db)
	{	//											Table				Classe			Id
		$this->XoopsPersistableObjectHandler($db, 'quest_reponses', 'reponses', 'IdReponse');
	}


	/**
	 * Renvoie les identifiants (uniques) des utilisateurs qui ont répondus à un questionnaire
	 *
	 * @param int $IdQuestionnaire	Identifiant du questionnaire
	 * @return 	array	Liste des utilisateurs qui ont répondu (Uniquement les ID)
	 */
	function getUsersIdPerQuestionnaire($IdQuestionnaire) {
		$ret = array();
		$sql = 'SELECT distinct(IdRespondant) FROM '.$this->table.' WHERE IdQuestionnaire='.intval($IdQuestionnaire);
        $result = $this->db->query($sql);
        if (!$result) {
            return $ret;
        }
		while ($myrow = $this->db->fetchArray($result)) {
			$ret[] = $myrow['IdRespondant'];
		}
		return $ret;
	}
}
?>