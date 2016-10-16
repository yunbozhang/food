<style type="text/css">
.copyright .list_bot{display:none;}
</style>
<?php
if (!defined('IN_CONTEXT')) die('access violation error!');
$html = str_replace(FCK_UPLOAD_PATH,"",$html);
if(strpos($html,'www.sitestar.cn')){
echo '<div class="com_con_sq" id="com_con_sq">'.$html.'</div><div class="list_bot"></div>';
}else{
echo '<div class="com_con1">'.'<div class="col-md-6 footer-left  wow fadeInLeft animated" data-wow-delay="0.4s" style="visibility: visible; -webkit-animation-delay: 0.4s;">
				<ul>
					<li><a href="index.php">Home</a></li>
					<li><a href="index.php?_m=mod_static&_a=view&sc_id=2">About</a></li>
					<li><a href="index.php?_m=mod_category_p&_a=category_p_menu">Services</a></li>
					<li><a href="index.php?_m=mod_article&_a=fullist">News</a></li>
					<li><a href="tel:18910403461">Mail Us</a></li>
				</ul>
				<form>
					<input type="text" placeholder="Email" required="">
					<input type="submit" value="Subscribe">
				</form>
			</div>
			<div class="col-md-3 footer-middle wow bounceIn animated" data-wow-delay="0.4s" style="visibility: visible; -webkit-animation-delay: 0.4s;">
				<h3>Address</h3>
				<div class="address">
					<p>756 gt globel Place,
						<span>CD-Road,M 07 435.</span>
					</p>
				</div>
				<div class="phone">
					<p>+1(100)2345-6789</p>
				</div>
			</div>
			<div class="col-md-3 footer-right  wow fadeInRight animated" data-wow-delay="0.4s" style="visibility: visible; -webkit-animation-delay: 0.4s;">
				<a href="#"><img src="images/logo2.png" alt="" /></a>
				<p>Proin eget ipsum ultrices, aliquet velit eget, tempus tortor. Phasellus non velit sit amet diam faucibus molestie tincidunt efficitur nisi.</p>
			</div>
			<div class="clearfix"> </div>'.'</div><div class="list_bot"></div>';
}
?>