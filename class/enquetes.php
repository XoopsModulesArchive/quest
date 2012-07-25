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

class enquetes extends MyObject
{
	function enquetes()
	{
		$this->initVar('IdEnquete',XOBJ_DTYPE_INT,null,false);
		$this->initVar('NomEnquete',XOBJ_DTYPE_TXTBOX, null, false,150);
		$this->initVar('PrenomEnquete',XOBJ_DTYPE_TXTBOX, null, false,150);
		$this->initVar('TypeEnquete',XOBJ_DTYPE_INT,null,false);
		$this->initVar('login',XOBJ_DTYPE_TXTBOX, null, false,255);
		$this->initVar('password',XOBJ_DTYPE_TXTBOX, null, false,40);
	}
}

class QuestEnquetesHandler extends MyXoopsPersistableObjectHandler
{
	function QuestEnquetesHandler($db)
	{	//											Table			Classe			Id
		$this->XoopsPersistableObjectHandler($db, 'quest_enquetes', 'enquetes', 'IdEnquete');
	}

}
?>