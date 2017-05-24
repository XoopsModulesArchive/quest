<table border="0" align="center">
    <tr>
        <th><{$smarty.const._MB_QUEST_QUESTIONNAIRE_ID}></th>
        <th><{$smarty.const._MB_QUEST_QUESTIONNAIRE_LIBELLE}></th>
        <th><{$smarty.const._MB_QUEST_QUESTIONNAIRE_LIEN}></th>
    </tr>
    <{foreach item=un_questionnaire from=$block.questionnaires}>
        <tr class="<{cycle values="even,odd"}>">
            <td><{$un_questionnaire.IdQuestionnaire}></td>
            <td><{$un_questionnaire.LibelleQuestionnaire}><br><{$un_questionnaire.Introduction}></td>
            <td><a href="<{$xoops_url}>/modules/quest/category.php?IdQuestionnaire=<{$un_questionnaire.IdQuestionnaire}>&categoryid=<{$un_questionnaire.IdCategory}>" title="<{$smarty.const._MB_QUEST_QUESTIONNAIRE_LIEN}>"><{$smarty.const._MB_QUEST_QUESTIONNAIRE_LIEN}></a></td>
        </tr>
    <{/foreach}>
</table>
