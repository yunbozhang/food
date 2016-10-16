<?php
if (!defined('IN_CONTEXT')) die('access violation error!');

if (sizeof($articles) > 0) {
?>
<div class="list_main">
	<div class="list_con">
	<ul class="titlelist">
	<?php
	$count =0;
		foreach ($articles as $article) {
			$article_html = '';
			$article_html .= "\n".'<div class="col-md-3 news-grid wow fadeInLeft animated" data-wow-delay="0.4s" style="visibility: visible; -webkit-animation-delay: 0.4s;">
					<a href="'.Html::uriquery('mod_article', 'article_content', array('article_id' => $article->id)).' "title="'.$article->title.'"> '
        .Toolkit::substr_MB($article->title, 0, 5).((Toolkit::strlen_MB($article->title) > 5)?'...':'').'</a>
					<img src="/upload/image/mark_42.jpg" alt="" />
					<div class="news-info">
						<p>'.Toolkit::substr_MB($article->title, 0, 10).((Toolkit::strlen_MB($article->title) > 10)?'...':'').'</p>
					</div>
				</div>';

		    echo $article_html;
		    $count++;
		    if ($count==4) {
		    	break;
		    }
		}
	?>
	</ul>
    <div class="list_more"><a href="<?php
		if($article_category!=0 && !strpos($article_category,",")){
		echo Html::uriquery('mod_article', 'fullist',array("caa_id"=>$article_category));
	}else{
		echo Html::uriquery('mod_article', 'fullist');
	}	
		?>"><img src="<?php echo P_TPL_WEB; ?>/images/more_37.jpg" width="32" height="9" border="0" /></a></div>
	
	</div>
	<div class="list_bot"></div>
</div>
<div class="blankbar"></div><?php } ?>