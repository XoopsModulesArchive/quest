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

/*
 * Fonction, incompl�te, pour g�n�rer un fichier csv
 *
 */
class csv
{
	var $escapetrings;			// Bool�en, faut il �chapper les chaines de caract�res ?
	var $stringsseparator;		// S'il faut �chapper les chaines de caract�res, indique avec quel caract�re
	var $lineseparator;			// S�parateur de lignes
	var $fieldseparator;		// S�parateur de champs
	var $header;				// Ent�te
	var $line;					// Ligne de donn�es
	var $filename;				// Nom du fichier
	var $fp;					// Pointeur de fichier

	function csv($filename='', $fieldseparator='|', $lineseparator = "\n", $escapestring = false, $stringseparator='') {
		$this->filename = $filename;
		$this->fieldseparator = $fieldseparator;
		$this->lineseparator = $lineseparator;
		$this->escapetrings = $escapestring;
		$this->stringsseparator = $stringseparator;
		$this->header = array();
		$this->line = array();
	}

	function openCSV()
	{
		$this->fp = fopen($this->filename, 'w') or die('Error, impossible to create the requested file');
	}

	function closeCSV()
	{
		fclose($this->fp);
	}

	function addHeader($field)
	{
		$this->header[] = $field;
	}

	function writeHeader()
	{
		fwrite($this->fp, implode($this->fieldseparator, $this->header).$this->lineseparator);
	}

	function addData($data)
	{
		if($this->escapetrings && is_string($data)) {
			$this->line[] = $this->stringsseparator . $data . $this->stringsseparator;
		} else {
			$this->line[] = $data;
		}
	}

	function clearData()
	{
		$this->line = array();
	}

	function writeData()
	{
		fwrite($this->fp, implode($this->fieldseparator, $this->line).$this->lineseparator);
		$this->clearData();
	}
}
?>