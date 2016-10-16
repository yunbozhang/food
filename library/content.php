<?php
//加密方式：php源码混淆类加密。免费版地址:http://www.zhaoyuanma.com/phpjm.html 免费版不能解密,可以使用VIP版本。
//此程序由【找源码】http://Www.ZhaoYuanMa.Com (免费版）在线逆向还原，QQ：7530782 
?>
<?php


if (!defined('IN_CONTEXT')) die('access violation error!');

/**
 * The general content processing class
 *
 * @package content
 */
class Content {
    /**
     * The request dispatcher
     *
     * @access public
     * @static
     */
    public static function dispatch() {
    	
        $module = strtolower(ParamHolder::get('_m', DEFAULT_MODULE));
        $action = strtolower(ParamHolder::get('_a', DEFAULT_ACTION));
        define('R_MOD', $module);
        define('R_ACT', $action);

        $request_type = strtolower(ParamHolder::get('_r', '_page'));
        define('R_TPE', $request_type);

        if (file_exists(P_MOD.'/'.$module.'.php')) {
            include_once(P_MOD.'/'.$module.'.php');
        } else {
//			die("content2=".P_MOD.'/'.$module.'.php');
            self::redirect(PAGE_404);
        }
        $module_name_part = explode('_', $module);
        $module_class_name = '';
        foreach ($module_name_part as $name_part) {
            $module_class_name .= ucfirst($name_part);
        }
        $module_class = new $module_class_name();
        if ($request_type == '_ajax') {
            @header('Content-Type: text/html; charset='.__('charset'));
            $module_class->execute($action, false);
        } else if($module_class_name=='ModContent'){
            $module_class->execute('content',true);//添加新页面全部触发content方法
        }else{
			$module_class->execute($action);
		}
    }

    /**
     * The request dispatcher
     *
     * @access public
     * @static
     */
    public static function admin_dispatch() {
        $module = strtolower(ParamHolder::get('_m', 'frontpage'));
        $action = strtolower(ParamHolder::get('_a', 'index'));
        define('R_MOD', $module);
        define('R_ACT', $action);

        $request_type = strtolower(ParamHolder::get('_r', '_page'));
        define('R_TPE', $request_type);

        if (file_exists(P_MOD.'/'.$module.'.php')) {
            include_once(P_MOD.'/'.$module.'.php');
        } else {
//			die("content1=".P_MOD.'/'.$module.'.php');
            self::redirect(PAGE_404);
        }
        $module_name_part = explode('_', $module);
        $module_class_name = '';
        foreach ($module_name_part as $name_part) {
            $module_class_name .= ucfirst($name_part);
        }
        $module_class = new $module_class_name();
        if ($request_type == '_ajax') {
            @header('Content-Type: text/html; charset='.__('charset'));
            $module_class->execute($action, false);
        } else {
            $module_class->execute($action);
        }
    }

    /**
     * Render module content in the current context
     *
     * @access public
     * @static
     * @param string $module The module name that requested
     * @param string $action The action name that requested
     * @param array $params The maunal parameters that will be used and in key=>value pairs
     */
    public static function render($module, $action, $params = array(),$block_id = 0) {
		if(Toolkit::getAgent() === 'agent')
		{
			$params['html'] .= '';
		}else if(isset($params['block_pos'])&&$params['block_pos'] == 'footer' && !Toolkit::getCorp()) {
			if(strpos($params['html'],'http://www.sitestar.cn/')){
				$params['html']='';
			}
		}
		/*
		if(Toolkit::getCorp()){
		if($params['block_pos'] == 'footer'){
			$domain = $_SERVER['HTTP_HOST'];
			$checkfooter = @file_get_contents('"http://'.$domain.'/"');
			if(!strpos($checkfooter,'www.sitestar.cn')){
				die('Power by
<a style="display:inline;" title="建站之星(sitestar)网站建设系统" target="_blank" href="http://www.sitestar.cn/">建站之星</a>
|
<a style="display:inline;" title="域名注册|域名申请|域名尽在“美橙互联”" target="_blank" href="http://www.cndns.com/">美橙互联</a>
 版权所有
</div>');
			}
		}
		}
		*/
        $module_name_part = explode('_', $module);
        $module_class_name = '';
        foreach ($module_name_part as $name_part) {
            $module_class_name .= ucfirst($name_part);
        }
		if($params['block_pos'] == 'footer' && $params['html']!=''){
			Toolkit::checkLicenceTimely();
		}
        if(isset($params['block_pos'])&&$params['block_pos'] == 'banner')
        {
        	//--------------------构造当前页面的url参数[start]-------------------
        	if(empty($_GET) || (isset($_GET['_m']) && $_GET['_m'] == 'frontpage' && empty($_GET['_a'])) || (isset($_GET['_a']) && $_GET['_a'] == 'index' && empty($_GET['_m'])))
        	{
        		$url_addr = '_m=frontpage&_a=index';
        	}
        	else
        	{
				$url_addr='';
        		foreach($_GET as $k => $v)
        		{
        			if($k == '_l' || $k == '_v') continue;
        			$url_addr .= "{$k}={$v}&";
        		}
        		$url_addr = substr($url_addr,0,strlen($url_addr)-1);
        	}
	
	
			 ManualParamHolder::set('single_img_src', '');
			 ManualParamHolder::set('img_src', '');
			 ManualParamHolder::set('geshi', '');
			 ManualParamHolder::set('flv_src', '');
			 
	
			/* */
        	//--------------------构造当前页面的url参数[end]---------------------
        	if(!empty($params))
        	{
        		if(!empty($params[$url_addr]) && count($params[$url_addr]) > 0)//找到此页面banner
        		{
	        		foreach ($params[$url_addr] as $key => $value) 
		            {
		                ManualParamHolder::set($key, $value);
		            }

		            if(!empty($params['block_title']))  ManualParamHolder::set('block_title', $params['block_title']);
		            if(!empty($params['block_pos']))  ManualParamHolder::set('block_pos', $params['block_pos']);
		            
		            if($block_id > 0) {
						ManualParamHolder::set("block_id", $block_id);
					}

			        $module_class = new $module_class_name();
			        $module_class->execute($params[$url_addr]['action'], false);
        		}
        		else//没有找到此页面banner,试图取默认(在所有页面显示)banner
        		{
        			if(!empty($params['_all']))//找到默认(在所有页面显示)banner
        			{
        				foreach ($params['_all'] as $key => $value)
        				{
        					ManualParamHolder::set($key, $value);
        				}
        			}
        			
        			if(!empty($params['block_title']))  ManualParamHolder::set('block_title', $params['block_title']);
		            if(!empty($params['block_pos']))  ManualParamHolder::set('block_pos', $params['block_pos']);
		            
		            if($block_id > 0) {
						ManualParamHolder::set("block_id", $block_id);
					}

			        $module_class = new $module_class_name();
			        $module_class->execute($params['_all']['action'], false);
        		}
        		
        		
        	}
        }
        else
        { 
	        if (sizeof($params) > 0) 
	        {
	            foreach ($params as $key => $value) 
	            {
	                ManualParamHolder::set($key, $value);
	            }
	        }
	        
	        if($block_id > 0) {
				ManualParamHolder::set("block_id", $block_id);
			}
	
	        $module_class = new $module_class_name();
	        $module_class->execute($action, false);
        }

		
        return true;
    }

    /**
     * Redirect content to specified URL
     *
     * @access public
     * @static
     * @param string $url The target URL address
     */
    public static function redirect($url) {
        @header('Location: '.$url);
        exit();
    }

    /**
     * Load data of modules assigned to the position
     *
     * @access public
     * @static
     * @param string $position
     * @return array
     */
    private static function &_loadModules($position) {
		self::fetchModules();	
		$curmods=self::$curmodules;
		if($position=='right' && R_MOD=="frontpage"){
			$retmods=$curmods[$position];
			$ret_arr=array_keys($curmods);
			$poss = TplInfo::$positions;
			$_ret_arr = array_diff($ret_arr, $poss);
			foreach($_ret_arr as $_ret_pos){
				$retmods=array_merge($retmods,$curmods[$_ret_pos]);
			}
			usort($retmods,array('Content','mod_order_by_iorder'));
			return $retmods;
		}else{
			return $curmods[$position];
		}
    }
	
	public static function mod_order_by_iorder($mod1,$mod2){
			return intval($mod1->i_order) - intval($mod2->i_order);
	}	
		
	public static $curmodules=array();	
	/*
	 * 优化sitestar获取ss_module_blocks逻辑
	 */
	private static function fetchModules(){
		if(!empty(self::$curmodules)) return;
		$o_mod_block = new ModuleBlock();
		$user_role = trim(SessionHolder::get('user/s_role', '{guest}'));
		$user_role1=$user_role;
		if(ACL::isRoleAdmin($user_role)) $user_role1='{admin}';
		$mq_hash = Toolkit::calcMQHash($_SERVER['QUERY_STRING']);
		if(ACL::requireRoles(array('admin'))){
			$mod_blocks = $o_mod_block->findAll("(`s_locale`=? OR `s_locale`='_ALL') AND "
					."(`s_query_hash`=? OR `s_query_hash`='_ALL') AND (`module`<>? OR `action`<>?)",
					//."published='1' AND for_roles LIKE ?",
				array(SessionHolder::get('_LOCALE', DEFAULT_LOCALE),
					$mq_hash,  R_MOD, R_ACT),
				"ORDER BY `i_order`");
		}else{
			$mod_blocks = $o_mod_block->findAll("(`s_locale`=? OR `s_locale`='_ALL') AND "
					."(`s_query_hash`=? OR `s_query_hash`='_ALL') AND for_roles LIKE ? AND (`module`<>? OR `action`<>?)",
					//."published='1' AND for_roles LIKE ?",
				array(SessionHolder::get('_LOCALE', DEFAULT_LOCALE),
					$mq_hash, '%'.$user_role1.'%', R_MOD, R_ACT),
				"ORDER BY `i_order`");
		}
		foreach($mod_blocks as $amod){
			$modpos=$amod->s_pos;
			if(empty(self::$curmodules[$modpos])) self::$curmodules[$modpos]=array();
			self::$curmodules[$modpos][]=$amod;
		}
		
		
	}
	
    /**
     * Count module number at the specified position
     *
     * @access public
     * @static
     * @param string $position
     * @return int
     */
    public static function countModules($position) {
			self::fetchModules();	
			$curmods=self::$curmodules;
			$n_block =count($curmods[$position]);
			return $n_block;
    }

    /**
     * Load modules assigned to the position
     *
     * @access public
     * @static
     * @param string $position The position string
     */
   public static function loadModules($position) {
        global $limited_pos;
        
        $pos_blocks =& self::_loadModules($position);

        if (SessionHolder::get('page/status', 'view') == 'edit' && !in_array($position, $limited_pos)) {
        	$add_mod_gif = 'add_mod.en.gif';
        	$curr_locale = SessionHolder::get('_LOCALE', DEFAULT_LOCALE);
        	if (file_exists(ROOT.'/images/add_mod.'.$curr_locale.'.gif')) {
        		$add_mod_gif = 'add_mod.'.$curr_locale.'.gif';
        	}
        	echo '<div id="MODBLK_WRAPPER_'.$position.'" class="pos_wrapper">'."\n";
        }

        if (sizeof($pos_blocks) > 0) {
        	$content_edit = self::getEditContents();
        	$arr = array_keys($content_edit);
        	foreach ($pos_blocks as $block) {
        		if(!check_mod($block->module)) continue;
        		$is_mar = 0;
        		if($block->module=='mod_marquee'){
        			$is_mar = 1;
        		}
        		// for media overflow
        		$extra_css = ($block->module == 'mod_media') ? 'media_image ' : '';
        		$_block_title = empty($block->title)?'':__($block->title);
        		$content_edit_title = $_block_title . '&nbsp;&nbsp;'. __('Edit Content');
				$nopermissionstr=__('No Permission');
                $urllink="alert('".$nopermissionstr."');return false;";
        		if(in_array($block->module,$arr)){
        			if(($block->module == 'mod_static') && (($block->s_pos != 'nav') && ($block->s_pos != 'footer'))){
        				if (!in_array($block->action, array('custom_html', 'company_intro'))) continue;
        			}
        			if (!in_array($block->action, array('custom_html', 'company_intro'))) {
        				if((($content_edit[$block->module]['action'] == 'admin_list') && ($content_edit[$block->module]['module'] == 'mod_category_a')) || (($content_edit[$block->module]['action'] == 'admin_list') && ($content_edit[$block->module]['module'] == 'mod_category_p')) || (($content_edit[$block->module]['action'] == 'admin_list') && ($content_edit[$block->module]['module'] == 'mod_product')) || (($content_edit[$block->module]['module'] == 'mod_article') && ($content_edit[$block->module]['action'] == 'admin_list'))){
        					
                            $content_mod=$content_edit[$block->module]['module'];
                            $content_action=$content_edit[$block->module]['action'];
                            if(ACL::isAdminActionHasPermission($content_mod, $content_action)) $urllink='popup_window(\'admin/index.php?_m='.$content_edit[$block->module]['module'].'&_a='.$content_edit[$block->module]['action'].'\',\''.$content_edit_title.'\',\'\',\'500\',true);return false;';
        					$str_content_edit = '<a href="#" title="'.__('Edit Content').'" onclick="'.$urllink.'"><img src="images/edit_icon.gif" border="0" alt="'.__('Edit Content').'"/>&nbsp;'.__('Edit Content').'</a>';
        				}else{
        					
                            $content_mod=$content_edit[$block->module]['module'];
                            $content_action=$content_edit[$block->module]['action'];
                            if(ACL::isAdminActionHasPermission($content_mod, $content_action)){
								if($content_mod=='mod_user'&&$content_action=='admin_list'){
									$urllink='popup_window(\'admin/index.php?_m='.$content_edit[$block->module]['module'].'&_a='.$content_edit[$block->module]['action'].'\',\''.$content_edit_title.'\',\'884\',\'\',true);return false;';
								}else{
									$urllink='popup_window(\'admin/index.php?_m='.$content_edit[$block->module]['module'].'&_a='.$content_edit[$block->module]['action'].'\',\''.$content_edit_title.'\',\'\',\'\',true);return false;';
								}
							}
        					$str_content_edit = '<a href="#" title="'.__('Edit Content').'" onclick="'.$urllink.'"><img src="images/edit_icon.gif" border="0" alt="'.__('Edit Content').'"/>&nbsp;'.__('Edit Content').'</a>';
        				}
        				
        			}elseif($block->action == 'company_intro') {
        				
                        $content_mod='mod_media';
                        $content_action='admin_company_introduction';
                        if(ACL::isAdminActionHasPermission($content_mod, $content_action)) $urllink='popup_window(\'admin/index.php?_m=mod_media&_a=admin_company_introduction&sc_id=2\',\''.$content_edit_title.'\',\'\',\'\',true);return false;';
        				$str_content_edit = '<a href="#" title="'.__('Edit Content').'" onclick="'.$urllink.'"><img src="images/edit_icon.gif" border="0" alt="'.__('Edit Content').'"/>&nbsp;'.__('Edit Content').'</a>';
        			}elseif(($block->action == 'custom_html') && ($block->alias == "mb_foot") ){
						$_s_param = unserialize($block->s_param);
						if(strpos($_s_param['html'],"www.sitestar.cn")>0){
							
							$str_content_edit = '';
						}else{
							
                            $content_mod=$content_edit[$block->module]['module'];
                            $content_action=$content_edit[$block->module]['action'];
                            if(ACL::isAdminActionHasPermission($content_mod, $content_action)) $urllink='popup_window(\'admin/index.php?_m='.$content_edit[$block->module]['module'].'&_a='.$content_edit[$block->module]['action'].'\',\''.$content_edit_title.'\',\'\',\'\',true);return false;';
        					$str_content_edit = '<a href="#" title="'.__('Edit Content').'" onclick="'.$urllink.'"><img src="images/edit_icon.gif" border="0" alt="'.__('Edit Content').'"/>&nbsp;'.__('Edit Content').'</a>';}
        			}else{
        				$str_content_edit = '';
        			}

        			if(($block->module == 'mod_media') && (($block->s_pos != 'banner') && ($block->s_pos != 'logo'))) {
        				$str_content_edit = '';
        			} elseif(($block->module == 'mod_media') && ($block->s_pos == 'banner')) {//banner 添加隐藏显示处理
        				$content_edit_title = 'Banner&nbsp;&nbsp;'.__('Edit Content');
	        			if(!empty($_GET)){
							if((isset($_GET['_m']) && $_GET['_m'] == 'frontpage' && empty($_GET['_a'])) || (isset($_GET['_a']) && $_GET['_a'] == 'index' && empty($_GET['_m']))){
								$url_str1 = "_m=frontpage&_a=index";
							}else{
								$url_str1='';
								foreach($_GET as $k => $v){
									if($k == '_l' || $k == '_v') continue;
									$url_str1 .= "{$k}={$v}&";
								}
								$url_str1 = substr($url_str1, 0,strlen($url_str1)-1);
							}
						}else{
							$url_str1 = "_m=frontpage&_a=index";
						}
						$g_url = $url_str1;
						$key_url = base64_encode($url_str1);
						$url_str1 = urlencode($url_str1);
						$content_mod='mod_media';
                        $content_action='admin_banner';
                        $banner_dis_arr = unserialize($block->s_param);//得到是否隐藏标志
                        if ($banner_dis_arr['display_banner'][$key_url]!=0 ||!isset($banner_dis_arr['display_banner'][$key_url])) {
                        	$banner_dis['dis'] = 1;
                        }else{
                        	$banner_dis['dis'] = 0;
                        }
                        $banner_dis['id'] = $block->id;
                        if ($banner_dis['dis']==1) {
                        	SessionHolder::set("display_banner",$banner_dis['dis']);
                        	if(ACL::isAdminActionHasPermission($content_mod, $content_action)) $urllink='popup_window(\'admin/index.php?_m=mod_media&_a=admin_banner&_url='.$url_str1.'\',\''.$content_edit_title.'\',\'\',\'\',true);return false;';		
        					$str_content_edit = '<a href="#" title="'.__('Edit Content').'" onclick="'.$urllink.'"><img src="images/edit_icon.gif" border="0" alt="'.__('Edit Content').'"/>&nbsp;'.__('Edit Content').'</a>';
        					$str_content_edit_show = '<a href="javascript:;" id="banner_display" title="'.__('Display').'" onclick="operate_banner(0,'.$banner_dis['id'].',\''.$g_url.'\')"><img src="images/hide_icon.png" border="0" alt=""/>&nbsp;'.__('Hidden').'</a>';
                        }else{
                        	SessionHolder::set("display_banner",$banner_dis['dis']);
                        	$block->s_param='';
                        	$str_content_edit = '<div id="MODBLK_operate228" class="mod_block media_image mb_logo_block" style="cursor: pointer; position: relative; display: block;"><div id="" class="" style="width: 80px; height: 28px; position: absolute;left:10px;background: none repeat scroll 0% 0% rgb(199, 222, 252); display: block;"><a href="javascript:;" id="banner_display" title="" onclick="operate_banner(1,'.$banner_dis['id'].',\''.$g_url.'\')"><img src="images/hide_icon.png" border="0" alt=""/>&nbsp;'.__('Show').'</a></div>';
						}
        			} elseif(($block->module == 'mod_media') && ($block->s_pos == 'logo')) {//添加logo隐藏显示处理
        				$content_edit_title = 'Logo&nbsp;&nbsp;'.__('Edit Content');
                        $content_mod='mod_media';
                        $content_action='admin_logo';
                        $logo_dis_arr = unserialize($block->s_param);//得到是否隐藏标志
                        if ($logo_dis_arr['display_logo']!=0||!isset($logo_dis_arr['display_logo'])) {
                        	$logo_dis['dis'] = 1;
                        }else{
                        	$logo_dis['dis'] = 0;
                        }
                        $logo_dis['id'] = $block->id;
                        if ($logo_dis['dis']==1) {
                        	SessionHolder::set("display_logo",$logo_dis['dis']);
                        	if(ACL::isAdminActionHasPermission($content_mod, $content_action)) $urllink='popup_window(\'admin/index.php?_m=mod_media&_a=admin_logo\',\''.$content_edit_title.'\',\'\',\'\',true);return false;';		
        				$str_content_edit = '<a href="#" title="'.__('Edit Content').'" onclick="'.$urllink.'"><img src="images/edit_icon.gif" border="0" alt="'.__('Edit Content').'"/>&nbsp;'.__('Edit Content').'</a>';
        				$str_content_edit_show = '<a href="javascript:;" id="log_display" title="" onclick="operate_logo(0,'.$logo_dis['id'].')"><img src="images/hide_icon.png" border="0" alt=""/>&nbsp;'.__('Hidden').'</a>';
                        }else{
                        	SessionHolder::set("display_logo",$logo_dis['dis']);
                        	$block->s_param='';
                        	$str_content_edit = '<div id="MODBLK_operate227" class="mod_block media_image mb_logo_block" style="cursor: pointer; position: relative; display: block;"><div id="" class="" style="width: 80px; height: 28px; position: absolute; right: 2px;background: none repeat scroll 0% 0% rgb(199, 222, 252); display: block;"><a href="javascript:;" id="banner_display" title="" onclick="operate_logo(1,'.$logo_dis['id'].')"><img src="images/hide_icon.png" border="0" alt=""/>&nbsp;'.__('Show').'</a></div>';
						}
                        
        			}
        		} else {
        			$str_content_edit = '';
        		}
				$propurllink="alert('".$nopermissionstr."');return false;";
				if(ACL::isAdminActionHasPermission('edit_block',  'process')){
					$propurllink='popup_window(\'index.php?'.Html::xuriquery('mod_tool', 'edit_prop', array('mb_id' => $block->id,'mar'=>$is_mar)).'\', '.'\''.$_block_title.' '.__('Properties').'\', 720, \'\',true);return false;';
				}
				
	        	$str_property_remove='';
				$str_remove_block='';
	        	if(!in_array($position, $limited_pos)){
	        		$str_property_remove = '<a href="#" title="'.__('Properties').'" onclick="'.$propurllink.'">'.'<img src="images/properties.gif" alt="'.__('Properties').'" border="0" />&nbsp;'.__('Properties').'</a>&nbsp;';
					$removelink="alert('".$nopermissionstr."');return false;";
					if(ACL::isAdminActionHasPermission('edit_block', 'process')) $removelink='remove_block(\''.$block->id.'\',\''.DEFAULT_LOCALE.'\');return false;';
					$str_remove_block='<a href="#" title="'.__('Remove').'" onclick="'.$removelink.'">'.'<img src="images/remove.gif" alt="'.__('Remove').'" border="0" />&nbsp;'.__('Remove').'</a>';
	        	}


				$drag_to_move='';
				if(!ACL::isAdminActionHasPermission('edit_block', 'process')&& SessionHolder::get('page/status')=='edit'&&!in_array($position, $limited_pos)){
					$drag_to_move= 'title="'.__('No permission to Move').'"';
				}
				if(!in_array($position, $limited_pos) && SessionHolder::get('page/status')=='edit'&&ACL::isAdminActionHasPermission('edit_block', 'process')){
					$drag_to_move = 'title="'.__('Drag to Move').'"';
				}
				//这里对logo和banner进行选择性处理----------------------------------------------------------
				if (($block->module == 'mod_media') && ($block->s_pos == 'logo')&&$logo_dis['dis']==0) {
					if ($logo_dis['dis']==0) {//logo
						if (SessionHolder::get('page/status', 'view') == 'edit'&&!strpos($block->s_param,"www.sitestar.cn")) {
							echo $str_content_edit;
							echo "\n".'</div>'."\n";
							continue;
						}else{
							echo "<div>";//这里防止div标签没有配对导致页面错乱
						}
					}
				}elseif(($block->module == 'mod_media') && (($block->s_pos == 'banner') && ($block->s_pos != 'logo'))&&$banner_dis['dis']==0){//banner
					if ($banner_dis['dis']==0) {
						if (SessionHolder::get('page/status', 'view') == 'edit'&&!strpos($block->s_param,"www.sitestar.cn")) {
						echo $str_content_edit;

						}
					}
				}else{
		       		echo '<div id="MODBLK_'.$block->id.'" class="mod_block '.$extra_css.$block->alias.'_block"'.$drag_to_move.'>'."\n";
		       		if (SessionHolder::get('page/status', 'view') == 'edit'&&!strpos($block->s_param,"www.sitestar.cn")) {
		       			
		       			echo '<div id="tb_'.$block->alias.'" class="mod_toolbar" style="display:none;">'."\n".$str_content_edit.$str_property_remove.$str_remove_block.$str_content_edit_show.'</div>';
		        	}
				}
	        	if (intval($block->show_title) == 1) {
	        		echo '<h3 class="blk_t">'.$_block_title.'</h3>'."\n";
	        	}
	        	if (strlen(trim($block->s_param)) > 0) {
	        		self::render($block->module, $block->action,array_merge(unserialize($block->s_param), array('block_title' => $_block_title,'block_pos'=> $block->s_pos)),$block->id);
	        	} else {
	        		self::render($block->module, $block->action, array('block_title' => $_block_title),$block->id);
	        	}
	        	if (SessionHolder::get('page/status', 'view') == 'edit' && !in_array($position, $limited_pos)) {
	        		echo "\n".'<div style="margin:0px;padding:0px;border:0px;clear:both;"></div>'."\n";
	        	}
	        	if(($block->module == 'mod_media') && (($block->s_pos == 'banner') && ($block->s_pos != 'logo'))&&$banner_dis['dis']==0){
	        		if (SessionHolder::get('page/status', 'view') == 'edit'&&!strpos($block->s_param,"www.sitestar.cn")) {
	        			echo "\n".'</div>'."\n";
	        		}
	        	}else{
	        		echo "\n".'</div>'."\n";
				}
	        }
    	}
         
	    if (SessionHolder::get('page/status', 'view') == 'edit' && !in_array($position, $limited_pos)) {
	        	echo '<div class="placeholder"></div>'."\n"	.'</div>'."\n";
	    }
    }

    /**
     * Load modules assigned to the position (Horizontal)
     *
     * @access public
     * @static
     * @param string $position The position string
     */
    public static function loadModules_H($position) {
        $pos_blocks =& self::_loadModules($position);

echo <<<H_TABLE
    <table id="tbl_{$position}_modules" class="tbl_module_wrapper" cellspacing="0">
        <tbody><tr>

H_TABLE;
        if (sizeof($pos_blocks) > 0) {
            foreach ($pos_blocks as $block) {
                echo '<td>'."\n".'<div id="mod_'.$block->alias.'" class="mod_block '.$block->alias.'_block">'."\n";
                if (intval($block->show_title) == 1) {
                    echo '<h3>'.__($block->title).'</h3>'."\n";
                }
                if (strlen(trim($block->s_param)) > 0) {
                    self::render($block->module, $block->action,
                        unserialize($block->s_param));
                } else {
                    self::render($block->module, $block->action, array());
                }
                echo "\n".'</div>'."\n".'</td>'."\n";
            }
        }
echo <<<H_TABLE

        </tr></tbody>
    </table>
H_TABLE;
    }

	 /**
     * find all s_pos diff
     *
     * @access public
     * @static
     * @param string $position The position string
	 * @zhangjc@2010-6-9
     */
    private static function findPos($positions) {
		$ret_arr = array();
		foreach($positions as $val){
			if(!in_array($val->s_pos,$ret_arr)){
			array_push($ret_arr,$val->s_pos);
			}
		}
		$poss = TplInfo::$positions;
		$_ret_arr = array_diff($ret_arr, $poss);
		if(sizeof($_ret_arr)>0){
			$ret_str="";
			foreach($_ret_arr as $val){
				$ret_str = $ret_str."','".$val;
			}
			return "right".$ret_str;
		} else {
			return 'right';
		}
    }
    
    public static function getEditContents()
    {
    	//有内容编辑模块
    	$edit_contents = array(
			'mod_auth' => array('module' => 'mod_user','action' => 'admin_list'),
			//'mod_lang' => array('module' => '','action' => ''),
			'mod_message' => array('module' => 'mod_message','action' => 'admin_list'),//
			'mod_friendlink' => array('module' => 'mod_friendlink','action' => 'admin_list'),
			'mod_qq' => array('module' => 'mod_qq','action' => 'admin_list'),
			'mod_download' => array('module' => 'mod_download','action' => 'admin_list'),
			'mod_category_a' => array('module' => 'mod_category_a','action' => 'admin_list'),
			'mod_article' => array('module' => 'mod_article','action' => 'admin_list'),
			'mod_category_p' => array('module' => 'mod_category_p','action' => 'admin_list'),
			'mod_product' => array('module' => 'mod_product','action' => 'admin_list'),
			'company_intro' => array('module' => '','action' => ''),
			'mod_bulletin' => array('module' => 'mod_bulletin','action' => 'admin_list'),
    		'mod_media' => array('module' => '','action' => ''),//开放logo和banner
    		'mod_static' => array('module' => 'mod_media','action' => 'admin_foot'),//footer
    		'mod_menu' => array('module' => 'mod_menu_item','action' => 'admin_list'),//nav
		);
		return $edit_contents;
    }
}
?>