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

class cac extends MyObject
{
	function cac()
	{
		$this->initVar('IdCAC',XOBJ_DTYPE_INT,null,false);
		$this->initVar('LibelleCAC',XOBJ_DTYPE_TXTBOX, null, false,50);
		$this->initVar('LibelleCourtCac',XOBJ_DTYPE_TXTBOX, null, false,3);
	}
}

class QuestCacHandler extends MyXoopsPersistableObjectHandler
{
	function QuestCacHandler($db)
	{	//											Table		Classe	Id
		$this->XoopsPersistableObjectHandler($db, 'quest_cac', 'cac', 'IdCAC');
	}

}
?>