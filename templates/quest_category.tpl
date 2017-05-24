<{if $preloaded_cac}>
    <script type="text/javascript">
        <{foreach item=one_preloaded_cac from=$preloaded_cac}>
        pre_img = new Image;
        pre_img.src = "images/cac/<{$one_preloaded_cac}>";
        <{/foreach}>
    </script>
<{/if}>


<form method="post" action="<{$xoops_url}>/modules/quest/category.php" id="frm_category" name="frm_category">
    <h1>Informations sur la catégorie</h1>
    <div align="center"><{$category.LibelleCategorie}><br><{$category.LibelleCompltCategorie}></div>
    <br>

    <h1><{$smarty.const._QUEST_LEGEND}></h1>
    <table border="0">
        <tr>
            <{if $LegendeGauche}>
                <td>
                    <b>Gauche</b>
                    <ul>
                        <{foreach item=une_legende from=$LegendeGauche}>
                            <li><{$une_legende.LibelleCourt}> - <{$une_legende.LibelleLong}></li>
                        <{/foreach}>
                    </ul>
                </td>
            <{/if}>
            <{if $LegendeDroite}>
                <td>
                    <b>Droite</b>
                    <ul>
                        <{foreach item=une_legende from=$LegendeDroite}>
                            <li><{$une_legende.LibelleCourt}> => <{$une_legende.LibelleLong}></li>
                        <{/foreach}>
                    </ul>
                </td>
            <{/if}>
        </tr>
    </table>
    <{if $comments_count==1}>
        <div align="center"><a href='#comments' title="<{$smarty.const._QUEST_COMMENT}>"><{$smarty.const._QUEST_COMMENT}></a></div>
    <{elseif $comments_count>1}>
        <div align="center"><a href='#comments' title="<{$smarty.const._QUEST_COMMENTS}>"><{$smarty.const._QUEST_COMMENTS}></a></div>
    <{/if}>

    <{if $text_to_delete_answers!=''}>
        <a href="<{$xoops_url}>/modules/quest/reset_answers.php?IdQuestionnaire=<{$questionnaire.IdQuestionnaire}>" <{$confirmation_to_delete_answers}> title="<{$text_to_delete_answers}>"><{$text_to_delete_answers}></a>
    <{/if}>

    <h1><{$smarty.const._QUEST_QUESTIONS}></h1>
    <{if $questions_reponses}>
        <table border="0" width="100%" align="center">
            <{foreach item=une_question_reponse from=$questions_reponses}>
                <tr class="<{cycle values="even,odd"}>">
                    <{if $CAC_Gauche}>
                        <td>
                            <div id='q<{$une_question_reponse.IdQuestion}>g'>
                                <{foreach item=une_CAC from=$CAC_Gauche}>
                                    <img src="<{$xoops_url}>/modules/quest/images/cac/l<{$une_CAC.IdCAC}><{if $une_question_reponse.Id_CAC2 == $une_CAC.IdCAC}>s<{else}>n<{/if}>.png" alt="<{$une_CAC.LibelleLong}>" border="0"
                                         onclick="changeme('q<{$une_question_reponse.IdQuestion}>g', <{$une_CAC.IdCAC}>, <{$une_question_reponse.IdQuestion}>,2);"/>
                                <{/foreach}>
                            </div>
                        </td>
                    <{/if}>
                    <td><{$une_question_reponse.TexteQuestion}><{if $une_question_reponse.ComplementQuestion}><br><{$une_question_reponse.ComplementQuestion}><{/if}></td>
                    <{if $CAC_Droite}>
                        <td>
                            <div id='q<{$une_question_reponse.IdQuestion}>d'>
                                <{foreach item=une_CAC from=$CAC_Droite}>
                                    <img src="<{$xoops_url}>/modules/quest/images/cac/r<{$une_CAC.IdCAC}><{if $une_question_reponse.Id_CAC1 == $une_CAC.IdCAC}>s<{else}>n<{/if}>.png" alt="<{$une_CAC.LibelleLong}>" border="0"
                                         onclick="changeme('q<{$une_question_reponse.IdQuestion}>d', <{$une_CAC.IdCAC}>, <{$une_question_reponse.IdQuestion}>,1);"/>
                                <{/foreach}>
                            </div>
                        </td>
                    <{/if}>
                </tr>
            <{/foreach}>
        </table>
    <{/if}>

    <script type="text/javascript">
        function changeme(qlayer, IdCAC, IdQuestion, DG)    <{* qlayer=Nom du div sur lequel on travaille, IdCAC=Id de la CAC choisie, IdQuestion=Id de la question courante, DG=Droite ou Gauche *}>
        {
            var pars = 'IdQuestionnaire=<{$questionnaire.IdQuestionnaire}>&IdCategorie=<{$category.IdCategorie}>&IdCAC=' + IdCAC + '&IdQuestion=' + IdQuestion + '&DG=' + DG;
            var myAjax1 = new Ajax.Updater(qlayer, '<{$xoops_url}>/modules/quest/categoryfly.php', {method: 'post', parameters: pars});
        }

        function areasave(qlayer, area, areavalue) {
            var pars = 'IdQuestionnaire=<{$questionnaire.IdQuestionnaire}>&IdCategorie=<{$category.IdCategorie}>&area=' + area + '&areavalue=' + areavalue;
            var myAjax2 = new Ajax.Updater(qlayer, '<{$xoops_url}>/modules/quest/commentfly.php', {method: 'post', parameters: pars});
        }
    </script>

    <{if $comments_count==1}>
        <a name='comments'></a>
        <h1><{$smarty.const._QUEST_COMMENT}></h1>
    <{elseif $comments_count>1}>
        <a name='comments'></a>
        <h1><{$smarty.const._QUEST_COMMENTS}></h1>
    <{/if}>


    <{if $category.comment1}>
        <h2><{$category.comment1}></h2>
        <br>
        <div id="comment1"><textarea name="comment1" cols="60" rows="<{$comment_lines}>" onBlur="areasave('comment1',1,this.value);"><{$commentaire1}></textarea></div>
    <{/if}>
    <{if $category.comment2}>
        <h2><{$category.comment2}></h2>
        <br>
        <div id="comment2"><textarea name="comment2" cols="60" rows="<{$comment_lines}>" onBlur="areasave('comment2',2,this.value);"><{$commentaire2}></textarea></div>
    <{/if}>
    <{if $category.comment3}>
        <h2><{$category.comment3}></h2>
        <br>
        <div id="comment3"><textarea name="comment3" cols="60" rows="<{$comment_lines}>" onBlur="areasave('comment3',3,this.value);"><{$commentaire3}></textarea></div>
    <{/if}>
    <input type="hidden" name="category" value="<{$category.IdCategorie}>"/>
    <input type="hidden" name="quest" value="<{$questionnaire.IdQuestionnaire}>"/>
    <input type="hidden" name="action" value="save"/>
    <br><br>
    <div align="center">
        <{* <div align="center"><input type="reset" name="btnraz" value="<{$smarty.const._QUEST_RESET}>" /> <input type="submit" name="btnsubmit" value="<{$smarty.const._QUEST_SUBMIT}>" /></div> *}>
        <{if $btn_prev}>
            <a href='<{$btn_prev}>' title="<{$smarty.const._QUEST_PREVIOUS}>"><img alt="<{$smarty.const._QUEST_PREVIOUS}>" src='<{$xoops_url}>/modules/quest/images/back.gif' border='0'/></a>
        <{/if}>
        &nbsp;
        <{if $btn_suiv}>
            <a href='<{$btn_suiv}>' title="<{$smarty.const._QUEST_NEXT}>"><img alt="<{$smarty.const._QUEST_NEXT}>" src='<{$xoops_url}>/modules/quest/images/next.gif' border='0'/></a>
        <{/if}>
        &nbsp;
        <img alt="<{$smarty.const._QUEST_PRINT}>" src='<{$xoops_url}>/modules/quest/images/print.gif' border='0' Onclick="window.print();"/>
    </div>
</form>
<br>
