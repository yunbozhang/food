<?php
if (!defined('IN_CONTEXT')) die('access violation error!');
// for division by zero
//$cols = $p_cols;
$cols = intval($p_cols) ? intval($p_cols) : 3;
$n_prd = sizeof($products);
?>

		<div class="newprod">
				<div class="newprod_top"></div>
				<div class="newprod_con">
			
<?php
if ($n_prd > 0){
?>
<div class="pro_over">
	<table class="media_grid" cellspacing="4" width="100%">
		<?php
		for ($i = 0; $i < $n_prd; $i++) {
			if ($i % $cols == 0) {
				echo '<tr>';
			}
			$_product=$products[$i];
			$_product->loadRelatedObjects(REL_PARENT, array('ProductCategory'));
		?>
			<td>

            <div class="col-md-6 service-box wow fadeInRight animated" data-wow-delay="0.4s" style="visibility: visible; -webkit-animation-delay: 0.4s;">
					<a href="<?php echo Html::uriquery('mod_product', 'view', array('p_id' => $products[$i]->id)); ?>" title="<?php echo $products[$i]->name;?>">
						<figure class="icon">
						<img  src="images/1.png" />
						</figure>
					</a>
                

                	<a href="<?php echo Html::uriquery('mod_product', 'view', array('p_id' => $products[$i]->id)); ?>">
                		<h5><?php echo $products[$i]->name;?></h5>
                		<p><?php echo Toolkit::substr_MB($products[$i]->introduction, 0, 20).((Toolkit::strlen_MB($products[$i]->introduction) > 20)?'...':'');?></p>
                	</a>
</div>

                <?php if( (EZSITE_LEVEL=='2') && $show_price){?><div class="newprod_price"  <?php if( (EZSITE_LEVEL=='2') && $show_price2){?>style="text-decoration :line-through"<?php }?>><?php echo CURRENCY_SIGN; ?><?php echo $products[$i]->price;?></div><?php }?>
				  <?php if( (EZSITE_LEVEL=='2') && $show_price2){?><div class="newprod_price" ><?php _e('Discount：'); ?><?php echo CURRENCY_SIGN; ?><?php echo $products[$i]->discount_price;?></div><?php }?>
				<?php if($show_cate){?><div class="newprod_intr"><?php _e('Category'); ?>: 
                            <?php 
                                if (isset($_product->masters['ProductCategory']->id)){  
                            ?>
                            <a href="<?php echo Html::uriquery('mod_product', 'prdlist', array('cap_id' => $_product->masters['ProductCategory']->id)); ?>"><?php echo $_product->masters['ProductCategory']->name; ?></a>
                            <?php
                            }else{
                                     _e('Uncategorised');
                            }
                           ?>
                           
                    <?php }?>




                           
                    </div>
                <div class="blankbar1"></div>
            </div>
            
			</td>
		<?php
			if (($i % $cols) == ($cols - 1)) {
				echo '</tr>';
			}
		}
		if ($i % $cols != 0) {
			for ($j = 0; $j < ($cols - $i); $j++) {
				echo '<td width="'.intval(100 / $cols).'%">&nbsp;</td>';
			}
			echo '</tr>';
		}
		?>
	</table>
</div>
<?php
} else {
	echo __('No Records!');
}
?>
			</div>
			<div class="list_more"><a href="<?php
		
		echo Html::uriquery('mod_category_p', 'category_p_menu');
	
		?>"><img src="<?php echo P_TPL_WEB; ?>/images/more_37.jpg" width="32" height="9" border="0" /></a></div>
	
	</div>
				<div class="list_bot"></div>
			</div>
			<div class="blankbar"></div>


