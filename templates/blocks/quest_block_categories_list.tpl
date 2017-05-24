<table border="0" align="center">
    <tr>
        <th>Libelle Catégorie</th>
        <th>Libellé complémentaire catégorie</th>
        <th>Etat (0=pas répondu, 1=Tout répondu, 2=En partie)</th>
        <th>Image pour l'état</th>
        <th>Lien pour répondre</th>
    </tr>
    <{foreach item=une_categorie from=$block.categories}>
        <tr class="<{cycle values="even,odd"}>">
            <td><{$une_categorie.LibelleCategorie}></td>
            <td><{$une_categorie.LibelleCompltCategorie}></td>
            <td><{$une_categorie.etat}></td>
            <td><img src="<{$xoops_url}>/modules/quest/images/etat<{$une_categorie.etat}>.gif" alt="" border="0"></td>
            <td><a href="<{$xoops_url}>/modules/quest/category.php?categoryid=<{$une_categorie.IdCategorie}>" title="<{$smarty.const._MB_QUEST_QUESTIONNAIRE_LIEN}>"><{$smarty.const._MB_QUEST_QUESTIONNAIRE_LIEN}></a></td>
        </tr>
    <{/foreach}>
</table>
