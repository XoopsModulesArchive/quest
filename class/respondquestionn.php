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

class respondquestionn extends MyObject
{
	function respondquestionn()
	{
		$this->initVar('IdRespondQuestion',XOBJ_DTYPE_INT,null,false);
		$this->initVar('IdQuestionnaire',XOBJ_DTYPE_INT,null,false);
		$this->initVar('IdRespondant',XOBJ_DTYPE_INT,null,false);
		$this->initVar('DateDebut',XOBJ_DTYPE_INT,null,false);
		$this->initVar('DateFin',XOBJ_DTYPE_INT,null,false);
		$this->initVar('Statut',XOBJ_DTYPE_INT,null,false);
	}
}

class QuestRespondquestionnHandler extends MyXoopsPersistableObjectHandler
{
	function QuestRespondquestionnHandler($db)
	{	//											Table					Classe				Id
		$this->XoopsPersistableObjectHandler($db, 'quest_respondquestionn', 'respondquestionn', 'IdRespondQuestion');
	}

}
?>