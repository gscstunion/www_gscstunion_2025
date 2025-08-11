<?php require_once(__DIR__.'/../../vendor/autoload.php');
use Raymondoor\Model\Article;
use Raymondoor\Model\Display;
use Raymondoor\Model\Project;
use function Raymondoor\Func\jpformatWest;
use function Raymondoor\Func\dispStrPur;
use function Raymondoor\Func\pageconfig;
use function Raymondoor\Func\return_header;

if(isset($_GET['id'])):
$id = filter_input(INPUT_GET,'id', FILTER_VALIDATE_INT);
if(empty($id)){
    return_header('/articles/');
}
$art = Article::article('id', $id);
if(empty($art)){
    return_header('/articles/');
}
Article::addview($art['id']);
$pj = Project::project('id', $art['project_id']);
$recommendations = Display::recommend();
pageconfig([
    'TITLE' => $art['title'].' | '.$art['name'].' PJ | '.APP_NAME,
    'INDEX' => 'article',
    'ALIAS' => '記事'
]);

include_once(VIEW_DIR.'/html-head.php');
include_once(VIEW_DIR.'/html-header.php');
?>
<main>
<div id="mainBg" style="background-image: url(<?=IMAGE_URL.'/main/project/'.$pj['thumbnail']?>);">
<?php include_once(VIEW_DIR.'/article.php');?>
</div>
<hr>
<h2 id="recommendations-title" style="text-align:center;">関連記事</h2>
<div id="recomendations">

<?php foreach($recommendations as $art){?>
    <div class="recommendation" style="background-color:<?=$art['color']?>;">
        <div class="thumb" style="background-image:url(<?=IMAGE_URL.'/main/article/'.$art['thumbnail']?>);"></div>
        <h4 class="artDate" style="background-color:<?=$art['color']?>;"><?=jpformatWest($art['date'])?></h4>
        <div class="card" style="background-color:<?=$art['color']?>;">
            <h5 class="artProject"><?=$art['name']?></h5>
            <h3 class="artTitle"><a class="artTitleLink" href="<?=HOME_URL.'/articles/page/?id='.$art['id']?>"><?=dispStrPur($art['title'],24)?></a></h3>
            <p class="artMain"><?=dispStrPur($art['main'],30)?></p>
            <p class="detailsLabel"><a class="detailsLabelLink" href="<?=HOME_URL.'/articles/page/?id='.$art['id']?>">詳しく見る</a></p>
        </div>
    </div>
<?php }?>
</div>
<?php include_once(VIEW_DIR.'/foot-nav.php');?>
</main>
<?php
include_once(VIEW_DIR.'/html-footer.php');
else:
    return_header('/articles/');
endif;