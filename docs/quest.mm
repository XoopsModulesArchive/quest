<map version="0.8.0">
<!-- To view this file, download free mind mapping software FreeMind from http://freemind.sourceforge.net -->
<node CREATED="1146761969906" ID="Freemind_Link_1595261042" MODIFIED="1146762691250" TEXT="Quest">
<hook NAME="accessories/plugins/NodeNote.properties">
<text>Dans un premier temps le module ne dispose pas de partie administrative (pour gagner en temps de d&#xe9;veloppement)</text>
</hook>
<node CREATED="1146762371046" ID="_" MODIFIED="1146762373843" POSITION="right" TEXT="Blocs">
<node CREATED="1146762375656" ID="Freemind_Link_1373977189" MODIFIED="1146764521812" TEXT="Etat d&apos;avancement">
<hook NAME="accessories/plugins/NodeNote.properties">
<text>Bloc r&#xe9;serv&#xe9; &#xe0; certains groupes (comme les clients et les admins), pour qu&apos;ils puissent voir en ligne l&apos;&#xe9;tat d&apos;avancement&#xa;Il faut d&#xe9;finir comment afficher cet etat d&apos;avancement. &#xa;Id&#xe9;e :&#xa;- Afficher le nombre total de personnes devant r&#xe9;pondre&#xa;- puis lister toutes les cat&#xe9;gories et par cat&#xe9;gorie, le nombre de questions ainsi que le nombre de r&#xe9;ponses et le nombre de r&#xe9;ponses attendues&#xa;Par exemple :&#xa;Cat&#xe9;gorie 1 : 5 / 12 / 48&#xa;Cat&#xe9;gorie 2 : 7 / 24 / 76&#xa;&#xa;</text>
</hook>
</node>
<node CREATED="1146762420984" ID="Freemind_Link_778306811" MODIFIED="1146763376656" TEXT="Liste des questionnaires">
<hook NAME="accessories/plugins/NodeNote.properties">
<text>Un questionnaire pour lequel toutes les r&#xe9;ponses ont &#xe9;t&#xe9; donn&#xe9;es n&apos;est plus visible dans la liste&#xa;Chaque ligne listant un questionnaire contient un lien vers la premi&#xe8;re cat&#xe9;gorie non r&#xe9;pondue&#xa;Note : le bloc est recalcul&#xe9; &#xe0; chaque mise &#xe0; jour / affichage d&apos;une page</text>
</hook>
</node>
<node CREATED="1146762459484" ID="Freemind_Link_1889473009" MODIFIED="1146764161484" TEXT="Liste des cat&#xe9;gories">
<hook NAME="accessories/plugins/NodeNote.properties">
<text>Tout comme la liste des questionnaires, cette liste n&apos;est plus visible si on a r&#xe9;pondu &#xe0; tout.&#xa;Chaque cat&#xe9;gorie est pr&#xe9;c&#xe9;d&#xe9;e d&apos;une image qui indique son &#xe9;tat &quot;Pas r&#xe9;pondu&quot;, &quot;en cours de r&#xe9;ponse&quot;, &quot;tout r&#xe9;pondu&quot;&#xa;Le nom de chaque cat&#xe9;gorie est cliquable afin que l&apos;on puisse aller r&#xe9;pondre (ou modifier ses r&#xe9;ponses) aux questions&#xa;Note : le bloc est recalcul&#xe9; &#xe0; chaque mise &#xe0; jour / affichage d&apos;une page&#xa;</text>
</hook>
</node>
</node>
<node CREATED="1146762615859" ID="Freemind_Link_196427223" MODIFIED="1146763426656" POSITION="left" TEXT="Status">
<hook NAME="accessories/plugins/NodeNote.properties">
<text>Page (non publique) permettant au client (Art&#xe9;mia ou Christophe) de r&#xe9;cup&#xe9;rer un export csv des r&#xe9;ponses.&#xa;Note, l&apos;acc&#xe8;s &#xe0; cette page est soumit &#xe0; un login et un mot de passe communiqu&#xe9; au client &#xe0; la cr&#xe9;ation du questionnaire&#xa;</text>
</hook>
</node>
<node CREATED="1146762817390" ID="Freemind_Link_606333498" MODIFIED="1146762821796" POSITION="right" TEXT="Import d&apos;un questionnaire"/>
<node CREATED="1146762728375" ID="Freemind_Link_1789356609" MODIFIED="1146763408937" POSITION="right" TEXT="Administration">
<hook NAME="accessories/plugins/NodeNote.properties">
<text>En pr&#xe9;vision</text>
</hook>
<node CREATED="1146762745953" ID="Freemind_Link_266499285" MODIFIED="1146762750750" TEXT="Ajouter un questionnaire"/>
<node CREATED="1146762754796" ID="Freemind_Link_629289321" MODIFIED="1146762759437" TEXT="Supprimer un questionnaire"/>
<node CREATED="1146762760703" ID="Freemind_Link_905802369" MODIFIED="1146762763984" TEXT="Editer un questionnaire"/>
<node CREATED="1146762784953" ID="Freemind_Link_226992488" MODIFIED="1146762795125" TEXT="Gestion des questionn&#xe9;s"/>
<node CREATED="1146762764640" ID="Freemind_Link_359906089" MODIFIED="1146762768953" TEXT="Stats sur un questionnaire"/>
<node CREATED="1146762805218" ID="Freemind_Link_297967540" MODIFIED="1146762809781" TEXT="Export CSV pour client"/>
<node CREATED="1146763004859" ID="Freemind_Link_1602074858" MODIFIED="1146763006671" TEXT="Relances"/>
</node>
<node CREATED="1146762828859" ID="Freemind_Link_1800334682" MODIFIED="1146764665406" POSITION="left" TEXT="Index">
<hook NAME="accessories/plugins/NodeNote.properties">
<text>- Dans le cas o&#xf9; il y a plusieurs questionnaires auxquel toutes les r&#xe9;ponses n&apos;ont pas &#xe9;t&#xe9; faites, la page &#xa;liste les questionnaires (sous forme de lien). Chaque questionnaire renvoie alors vers la page category&#xa;- Dans le cas o&#xf9; il n&apos;y a qu&apos;un seul questionnaire qui n&apos;a pas &#xe9;t&#xe9; totalement r&#xe9;pondu, la page liste les cat&#xe9;gories afin &#xa;de renvoyer vers la page category&#xa;- Dans le cas o&#xf9; il y a de 1 &#xe0; n questionnaires r&#xe9;pondus, le respondant ne doit plus rien pouvoir faire. &#xa;Question, que faut faire, lui interdire l&apos;acc&#xe8;s ou lui afficher un message de remerciement (auquel cas il faut le pr&#xe9;voir&#xa;dans la table des questionnaires)</text>
</hook>
</node>
<node CREATED="1146763043906" ID="Freemind_Link_1180428020" MODIFIED="1146933645046" POSITION="left" TEXT="restart">
<hook NAME="accessories/plugins/NodeNote.properties">
<text>Page (non publique) servant &#xe0; faire les relances par email (relances aux personnes qui doivent r&#xe9;pondre)&#xa;Il faut trouver un cron&#xa;</text>
</hook>
</node>
<node CREATED="1146763102859" ID="Freemind_Link_1188628609" MODIFIED="1146764745234" POSITION="right" TEXT="state">
<hook NAME="accessories/plugins/NodeNote.properties">
<text>Script lanc&#xe9; en auto par un cron et qui envoie un email au client (Christophe/Art&#xe9;mia) pour lui indiquer l&apos;&#xe9;tat d&apos;avancement des r&#xe9;ponses&#xa;</text>
</hook>
</node>
<node CREATED="1146763142343" ID="Freemind_Link_962583915" MODIFIED="1146933704921" POSITION="left" TEXT="Formulaire de contact">
<hook NAME="accessories/plugins/NodeNote.properties">
<text>Permet aux respondants de rentrer en contact avec le client (Christophe ou Art&#xe9;mia)&#xa;Utiliser le module contact de Xoops</text>
</hook>
</node>
<node CREATED="1146763182984" ID="Freemind_Link_1863516734" MODIFIED="1146764803640" POSITION="right" TEXT="init">
<hook NAME="accessories/plugins/NodeNote.properties">
<text>Script qui suite &#xe0; la cr&#xe9;ation d&apos;un questionnaire envoie les emails aux respondants pour leur indiquer qu&apos;il faut saisir&#xa;Le mail contient tout un tas d&apos;informations (style l&apos;adresse du site, login, mot de passe etc)&#xa;Penser &#xe0; mettre le client (Christophe/Art&#xe9;mia) en &quot;reply to&quot;</text>
</hook>
</node>
<node CREATED="1146763296640" ID="Freemind_Link_1552037601" MODIFIED="1146764230468" POSITION="left" TEXT="category">
<hook NAME="accessories/plugins/NodeNote.properties">
<text>Page listant les questions d&apos;une cat&#xe9;gorie afin d&apos;y r&#xe9;pondre&#xa;L&apos;acc&#xe8;s &#xe0; la page n&apos;est possible que si la cat&#xe9;gorie n&apos;a pas &#xe9;t&#xe9; r&#xe9;pondue&#xa;La page est directement accessible depuis les blocs&#xa;Note, si la cat&#xe9;gorie ne contient qu&apos;une seule zone de texte (dans les commentaires), alors cette&#xa;zone doit &#xea;tre plus grande.&#xa;NOTE IMPORTANTE : L&apos;ancienne application mettait &#xe0; jour son bloc de gauche (qui liste les cat&#xe9;gories) lorsque &#xa;la cat&#xe9;gorie &#xe9;tait saisie, en changeant l&apos;image de la cat&#xe9;gorie (image verte).&#xa;Cela ne sera possible qu&apos;en lancant un rechargement de la page ou en utilisant de l&apos;ajax (voir la faisabilit&#xe9; &#xa;car c&apos;est la page centrale du module qui doit mettre &#xe0; jour le bloc)&#xa;Il faut mettre du javascript dans les cases &#xe0; cocher afin de scruter l&apos;&#xe9;tat de r&#xe9;ponse &#xa;pour recharger la page (et donc mettre &#xe0; jour le bloc).</text>
</hook>
</node>
</node>
</map>
