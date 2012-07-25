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

$modversion['name'] = 'quest';
$modversion['version'] = 1;
$modversion['description'] = "Gestion de questionnaires";
$modversion['credits'] = '';
$modversion['author'] = 'Devconcept (Herv� Thouzard, Christian Edom)';
$modversion['help'] = '';
$modversion['license'] = 'Commercial';
$modversion['official'] = 0;
$modversion['image'] = 'images/quest.jpg';
$modversion['dirname'] = 'quest';

$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

// Tables created by sql file
$modversion['tables'][0] = "quest_cac";					// Dictionnaire des cases � cocher
$modversion['tables'][1] = "quest_cac_categories";		// Lien entre les cat�gories et les cases � cocher
$modversion['tables'][2] = "quest_categories";			// Dictionnaire des cat�gories
$modversion['tables'][3] = "quest_enquetes";			// Table des enqu�t�s
$modversion['tables'][4] = "quest_questionnaires";		// Liste de tous les questionnaires
$modversion['tables'][5] = "quest_questions";			// Questions par cat�gorie
$modversion['tables'][6] = "quest_reponses";			// R�ponses par personne/questionnaire/cat�gorie/question
$modversion['tables'][7] = "quest_respondquestionn";	// Liste des personnes qui ont termin� de r�pondre
$modversion['tables'][8] = "quest_rubrcomment";			// R�ponses aux commentaires

// Admin things
$modversion['hasAdmin'] = 0;							// Pas pour l'instant
//$modversion['adminindex'] = "admin/index.php";
//$modversion['adminmenu'] = "admin/menu.php";

// Menu
$modversion['hasMain'] = 1;

// Search
$modversion['hasSearch'] = 0;
// Comments
$modversion['hasComments'] = 0;
// Notifications
$modversion['hasNotification'] = 0;


// Templates
$modversion['templates'][1]['file'] = 'quest_index.html';
$modversion['templates'][1]['description'] = "Index du module";

$modversion['templates'][2]['file'] = 'quest_category.html';
$modversion['templates'][2]['description'] = "Liste les questions d'une cat�gorie pour y r�pondre";

$modversion['templates'][3]['file'] = 'quest_status.html';
$modversion['templates'][3]['description'] = "Page permettant au(x) commanditaire(s) de voir le statut des questionnaires";


/**
 * Affiche la liste liste questionnaires non r�pondus (les questionnaires r�pondus ne sont pas visibles)
 */
$modversion['blocks'][1]['file'] = "quest_questionnaires_list.php";
$modversion['blocks'][1]['name'] = _MI_QUEST_BNAME1;
$modversion['blocks'][1]['description'] = "Affiche la liste des questionnaires non r�pondus";
$modversion['blocks'][1]['show_func'] = 'b_quest_questionnaires_list_show';
$modversion['blocks'][1]['edit_func'] = 'b_quest_questionnaires_list_edit';
$modversion['blocks'][1]['options'] = "1";	// Trier par
$modversion['blocks'][1]['template'] = 'quest_block_questionnaire_list.html';

/**
 * Affiche la liste des cat�gories (du questionnaire en cours) qui n'ont pas �t� r�pondues
 */
$modversion['blocks'][2]['file'] = "quest_categories_list.php";
$modversion['blocks'][2]['name'] = _MI_QUEST_BNAME2;
$modversion['blocks'][2]['description'] = "Affiche la liste des cat�gories non r�pondues";
$modversion['blocks'][2]['show_func'] = "b_quest_categories_list_show";
$modversion['blocks'][2]['edit_func'] = "b_quest_categories_list_edit";
$modversion['blocks'][2]['options'] = "1";	// 1=Tri� par
$modversion['blocks'][2]['template'] = 'quest_block_categories_list.html';

?>