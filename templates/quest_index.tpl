<{if $action == 1}>         <{* Tout a été répondu *}>
    <h1><{$smarty.const._QUEST_ALL_REPLYED}></h1>
<{elseif $action == 2}>     <{* Il ne reste qu'un seul questionnaire, on liste les catégories *}>
    <{if $tout_repondu}>    <{* Sauf que l'utilisateur a déjà répondu à toutes les catégories *}>
        <h1><{$smarty.const._QUEST_THANK_YOU}></h1>
    <{else}>                <{* L'utilisateur n'a pas répondu à tout, on lui affiche donc les catégories *}>
        <h1><{$smarty.const._QUEST_PLEASE_REPLY}></h1>
        <{* Pour info, on commence par afficher les données du questionnaire *}>
        <table border="0" align="center">
            <tr>
                <th><{$smarty.const._QUEST_QUESTIONNAIRE_ID}></th>
                <th><{$smarty.const._QUEST_QUESTIONNAIRE_LIBELLE}></th>
                <th><{$smarty.const._QUEST_QUESTIONNAIRE_ID_ENQUETE}></th>
                <th><{$smarty.const._QUEST_QUESTIONNAIRE_DATE_OUVERTURE}></th>
                <th><{$smarty.const._QUEST_QUESTIONNAIRE_DATE_FERMETURE}></th>
                <th><{$smarty.const._QUEST_QUESTIONNAIRE_NB_SESSIONS}></th>
                <th><{$smarty.const._QUEST_QUESTIONNAIRE_ETAT}></th>
                <th><{$smarty.const._QUEST_QUESTIONNAIRE_LTOR}></th>
                <th><{$smarty.const._QUEST_QUESTIONNAIRE_SUJET_RELANCE}></th>
                <th><{$smarty.const._QUEST_QUESTIONNAIRE_CORPS_RELANCE}></th>
                <th><{$smarty.const._QUEST_QUESTIONNAIRE_SUJET_OUVERTURE}></th>
                <th><{$smarty.const._QUEST_QUESTIONNAIRE_CORPS_OUVERTURE}></th>
                <th><{$smarty.const._QUEST_QUESTIONNAIRE_FREQUENCES_RELANCES}></th>
                <th><{$smarty.const._QUEST_QUESTIONNAIRE_DERNIERE_RELANCE}></th>
                <th><{$smarty.const._QUEST_QUESTIONNAIRE_REPLY_TO}></th>
                <th><{$smarty.const._QUEST_QUESTIONNAIRE_LIEN}></th>
                <th><{$smarty.const._QUEST_QUESTIONNAIRE_INTRODUCTION}></th>
            </tr>
            <tr class="<{cycle values="even,odd"}>">
                <td><{$questionnaire.IdQuestionnaire}></td>
                <td><{$questionnaire.LibelleQuestionnaire}></td>
                <td><{$questionnaire.IdEnquete}></td>
                <td><{$questionnaire.DateOuverture|date_format:"%d/%m/%Y"}></td>
                <td><{$questionnaire.DateFermeture|date_format:"%d/%m/%Y"}>s</td>
                <td><{$questionnaire.NbSessions}></td>
                <td><{$questionnaire.Etat}></td>
                <td><{$questionnaire.ltor}></td>
                <td><{$questionnaire.SujetRelance}></td>
                <td><{$questionnaire.CorpsRelance}></td>
                <td><{$questionnaire.SujetOuverture}></td>
                <td><{$questionnaire.CorpsOuverture}></td>
                <td><{$questionnaire.FrequenceRelances}></td>
                <td><{$questionnaire.DerniereRelance|date_format:"%d/%m/%Y"}></td>
                <td><{$questionnaire.ReplyTo}></td>
                <td><a href="<{$xoops_url}>/modules/quest/category.php?categoryid=<{$questionnaire.IdCategory}>" title="<{$smarty.const._QUEST_QUESTIONNAIRE_LIEN}>"><{$smarty.const._QUEST_QUESTIONNAIRE_LIEN}></a></td>
                <td><{$questionnaire.Introduction}></td>
            </tr>
        </table>
        <h2><{$smarty.const._QUEST_CATEGORIES_LIST}></h2>
        <{* Ensute on affiche la liste des catégories *}>
        <table border="0" align="center">
            <tr>
                <th>Id Categorie</th>
                <th>Id Questionaire</th>
                <th>Libelle Catégorie</th>
                <th>Libellé complémentaire catégorie</th>
                <th>Ordre Catégorie</th>
                <th>Afficher à droite ?</th>
                <th>Afficher à gauche ?</th>
                <th>Commentaire 1</th>
                <th>Commentaire 2</th>
                <th>Commentaire 3</th>
                <th>Etat (0=pas répondu, 1=Tout répondu, 2=En partie)</th>
                <th>Lien pour répondre</th>
            </tr>
            <{foreach item=une_categorie from=$categories}>
                <tr class="<{cycle values="even,odd"}>">
                    <td><{$une_categorie.IdCategorie}></td>
                    <td><{$une_categorie.IdQuestionnaire}></td>
                    <td><{$une_categorie.LibelleCategorie}></td>
                    <td><{$une_categorie.LibelleCompltCategorie}></td>
                    <td><{$une_categorie.OrdreCategorie}></td>
                    <td><{$une_categorie.AfficherDroite}></td>
                    <td><{$une_categorie.AfficherGauche}></td>
                    <td><{$une_categorie.comment1}></td>
                    <td><{$une_categorie.comment2}></td>
                    <td><{$une_categorie.comment3}></td>
                    <td><{$une_categorie.etat}></td>
                    <td><a href="<{$xoops_url}>/modules/quest/category.php?categoryid=<{$une_categorie.IdCategorie}>" title="<{$smarty.const._QUEST_QUESTIONNAIRE_LIEN}>"><{$smarty.const._QUEST_QUESTIONNAIRE_LIEN}></a></td>
                </tr>
            <{/foreach}>
        </table>
    <{/if}>

<{elseif $action == 3}>     <{* Il reste plusieurs questionnaires, on en dresse la liste *}>
    <table border="0" align="center">
        <tr>
            <th><{$smarty.const._QUEST_QUESTIONNAIRE_ID}></th>
            <th><{$smarty.const._QUEST_QUESTIONNAIRE_LIBELLE}></th>
            <th><{$smarty.const._QUEST_QUESTIONNAIRE_ID_ENQUETE}></th>
            <th><{$smarty.const._QUEST_QUESTIONNAIRE_DATE_OUVERTURE}></th>
            <th><{$smarty.const._QUEST_QUESTIONNAIRE_DATE_FERMETURE}></th>
            <th><{$smarty.const._QUEST_QUESTIONNAIRE_NB_SESSIONS}></th>
            <th><{$smarty.const._QUEST_QUESTIONNAIRE_ETAT}></th>
            <th><{$smarty.const._QUEST_QUESTIONNAIRE_LTOR}></th>
            <th><{$smarty.const._QUEST_QUESTIONNAIRE_SUJET_RELANCE}></th>
            <th><{$smarty.const._QUEST_QUESTIONNAIRE_CORPS_RELANCE}></th>
            <th><{$smarty.const._QUEST_QUESTIONNAIRE_SUJET_OUVERTURE}></th>
            <th><{$smarty.const._QUEST_QUESTIONNAIRE_CORPS_OUVERTURE}></th>
            <th><{$smarty.const._QUEST_QUESTIONNAIRE_FREQUENCES_RELANCES}></th>
            <th><{$smarty.const._QUEST_QUESTIONNAIRE_DERNIERE_RELANCE}></th>
            <th><{$smarty.const._QUEST_QUESTIONNAIRE_REPLY_TO}></th>
            <th><{$smarty.const._QUEST_QUESTIONNAIRE_LIEN}></th>
            <th><{$smarty.const._QUEST_QUESTIONNAIRE_INTRODUCTION}></th>
        </tr>
        <{foreach item=un_questionnaire from=$questionnaires}>
            <tr class="<{cycle values="even,odd"}>">
                <td><{$un_questionnaire.IdQuestionnaire}></td>
                <td><{$un_questionnaire.LibelleQuestionnaire}></td>
                <td><{$un_questionnaire.IdEnquete}></td>
                <td><{$un_questionnaire.DateOuverture|date_format:"%d/%m/%Y"}></td>
                <td><{$un_questionnaire.DateFermeture|date_format:"%d/%m/%Y"}>s</td>
                <td><{$un_questionnaire.NbSessions}></td>
                <td><{$un_questionnaire.Etat}></td>
                <td><{$un_questionnaire.ltor}></td>
                <td><{$un_questionnaire.SujetRelance}></td>
                <td><{$un_questionnaire.CorpsRelance}></td>
                <td><{$un_questionnaire.SujetOuverture}></td>
                <td><{$un_questionnaire.CorpsOuverture}></td>
                <td><{$un_questionnaire.FrequenceRelances}></td>
                <td><{$un_questionnaire.DerniereRelance}></td>
                <td><{$un_questionnaire.ReplyTo}></td>
                <td><a href="<{$xoops_url}>/modules/quest/category.php?categoryid=<{$un_questionnaire.IdCategory}>" title="<{$smarty.const._QUEST_QUESTIONNAIRE_LIEN}>"><{$smarty.const._QUEST_QUESTIONNAIRE_LIEN}></a></td>
                <td><{$un_questionnaire.Introduction}></td>
            </tr>
        <{/foreach}>
    </table>
<{/if}>
