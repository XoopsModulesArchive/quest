<h1><{$smarty.const._QUEST_STATUS_INDEX}></h1>
<br>
<{foreach item=un_questionnaire from=$questionnaires}>
    <hr/>
    <h2><a target='_blank' href="<{$xoops_url}>/modules/quest/export.php?IdQuestionnaire=<{$un_questionnaire.IdQuestionnaire}>" title="<{$smarty.const._QUEST_EXPORT_TOOLTIP}>"><img src="<{$xoops_url}>/modules/quest/images/download.png" alt="<{$smarty.const._QUEST_EXPORT_TOOLTIP}>"
                                                                                                                                                                                     border="0"></a> <{$un_questionnaire.LibelleQuestionnaire}></h2>
    <br>
    <br>
    <b><{$smarty.const._QUEST_QUESTIONNAIRE_DATE_OUVERTURE}></b>
    : <{$un_questionnaire.DateOuverture|date_format:"%d/%m/%Y"}> -
    <b><{$smarty.const._QUEST_QUESTIONNAIRE_DATE_FERMETURE}></b>
    : <{$un_questionnaire.DateFermeture|date_format:"%d/%m/%Y"}>
    <br>
    <b><{$smarty.const._QUEST_QUESTIONNAIRE_ENQUETE}></b>
    : <{$un_questionnaire.Enquete.NomEnquete}> <{$un_questionnaire.Enquete.PrenomEnquete}>
    <h3><{$smarty.const._QUEST_STATUS_GENERAL_STATS}></h3>
    <table border="1" align="center">
        <tr>
            <td><{$smarty.const._QUEST_STATUS_DETAILS_NOREPLY}></td>
            <td align='right'><{$un_questionnaire.stats_globales.users_without_replies}></td>
            <td align='right'><{$un_questionnaire.stats_globales.pourcent_users_without_replies}> %</td>
        </tr>
        <tr>
            <td><{$smarty.const._QUEST_STATUS_DETAILS_STARTED}></td>
            <td align='right'><{$un_questionnaire.stats_globales.users_partially_reply}></td>
            <td align='right'><{$un_questionnaire.stats_globales.pourcent_users_partially_reply}> %</td>
        </tr>
        <tr>
            <td><{$smarty.const._QUEST_STATUS_DETAILS_FINISHED}></td>
            <td align='right'><{$un_questionnaire.stats_globales.users_full_reply}></td>
            <td align='right'><{$un_questionnaire.stats_globales.pourcent_users_full_reply}> %</td>
        </tr>
        <tr>
            <td><b><{$smarty.const._QUEST_STATUS_DETAILS_TOTAL}></b></td>
            <td align='right'><b><{$un_questionnaire.stats_globales.users_to_respond}></b></td>
            <td align='right'><b><{$un_questionnaire.stats_globales.pourcent_users_to_respond}> %</b></td>
        </tr>
    </table>
    <br>
<{/foreach}>
