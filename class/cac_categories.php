<?php
//  ------------------------------------------------------------------------ //
//                        QUEST - MODULE FOR XOOPS 2                         //
//                  Copyright (c) 2005-2006 Herv� Thouzard                   //
//                     <http://www.herve-thouzard.com/>                      //
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

class cac_categories extends MyObject
{
	function cac_categories()
	{
		$this->initVar('IdCac_categories',XOBJ_DTYPE_INT,null,false);
		$this->initVar('IdCAC',XOBJ_DTYPE_INT,null,false);
		$this->initVar('IdCategorie',XOBJ_DTYPE_INT,null,false);
		$this->initVar('DroiteGauche',XOBJ_DTYPE_INT,null,false);
		$this->initVar('Ordre',XOBJ_DTYPE_INT,null,false);
	}
}

class QuestCac_categoriesHandler extends MyXoopsPersistableObjectHandler
{
	function QuestCac_categoriesHandler($db)
	{	//											Table					Classe			Id
		$this->XoopsPersistableObjectHandler($db, 'quest_cac_categories', 'cac_categories', 'IdCac_categories');
	}

}
?>