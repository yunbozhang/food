<?php
if (!defined('IN_CONTEXT')) die('access violation error!');

if (sizeof($articles) > 0) {
?>
<div class="list_main">
	
<video width=100% height=40% controls="controls" autoplay="autoplay">
  <source src="/images/movie.ogg" type="video/ogg" />
  <source src="/images/movie.mp4" type="video/mp4" />
  <source src="/images/movie.webm" type="video/webm" />
  <object data="/images/movie.mp4" width=100% height=40%>
    <embed width=100% height=40% src="/movie/movie.mp4" />
  </object>

</video>
	
	<div class="list_bot"></div>
</div>
<div class="blankbar"></div><?php } ?>