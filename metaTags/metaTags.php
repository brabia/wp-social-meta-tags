<?php
	/***************************************************************
	@
	@	Social Meta Tags
	@	bassem.rabia@gmail.com
	@
	/**************************************************************/
	class metaTags{
		public function __construct($ver){
			$this->Signature = array(
				'pluginName' => 'Social Meta Tags',
				'pluginNiceName' => 'Social Meta Tags',
				'pluginSlug' => 'social-meta-tags',
				'pluginVersion' => $ver
			);
			// echo '<pre>'; print_r($this->Signature);echo '<pre>';
			add_action('admin_enqueue_scripts', array(&$this, 'admin_enqueue'));
			add_action('admin_menu', array(&$this, 'menu'));
			add_action('wp_head', array(&$this, 'init'));
			add_action('add_meta_boxes', array(&$this, 'meta_boxes_setup'));
			add_action('wp_enqueue_scripts', array(&$this, 'enqueue'));
		}
		
		public function meta_boxes_setup(){		
			add_meta_box(
				$this->Signature['pluginSlug'].'-meta_box',
				$this->Signature['pluginNiceName'], 
				array(&$this, 'meta_box'),
					'post',
					'normal',
					'high',
				null
			);
		}
		
		public function meta_box($post, $box){
			// $pluginOptions = get_option($this->Signature['pluginSlug']);
			$fields = array
			(				
				'title' => get_the_title(), 
				'url' => esc_url(get_permalink($post->ID)),
				'image' => wp_get_attachment_url(get_post_thumbnail_id($post->ID))
			);
			// print_r($fields);
			?>
			<table class="form-table">
				<tr>
					<th scope="row"><label for="blogname">Site Name</label></th>
					<td><input type="text" readOnly value="<?php bloginfo('name');?>" class="meta_box-regular-text regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="blogname"><?php _e('Title', 'social-meta-tags');?></label></th>
					<td><input type="text" readOnly value="<?php echo $fields['title'];?>" class="meta_box-regular-text regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="blogname"><?php _e('Description', 'social-meta-tags');?></label></th>
					<td><input type="text" readOnly value="<?php echo strip_tags(get_the_excerpt($post->ID));?>" class="meta_box-regular-text regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="blogname"><?php _e('Image', 'social-meta-tags');?></label></th>
					<td><input type="text" readOnly value="<?php echo $fields['image'];?>" class="meta_box-regular-text regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="blogname"><?php _e('Url', 'social-meta-tags');?></label></th>
					<td><input type="text" readOnly value="<?php echo $fields['url'];?>" class="meta_box-regular-text regular-text"></td>
				</tr>
			</table>
			<?php 
		}
	
		public function admin_enqueue(){
			wp_enqueue_style($this->Signature['pluginSlug'].'-admin-style', plugins_url('css/'.$this->Signature['pluginSlug'].'-admin.css', __FILE__)); 
			wp_enqueue_script($this->Signature['pluginSlug'].'-admin-script', plugins_url('js/'.$this->Signature['pluginSlug'].'-admin.js', __FILE__));
		}
		
		public function menu(){
			add_options_page( 
				$this->Signature['pluginNiceName'], 
				$this->Signature['pluginNiceName'],
				'manage_options',
				strtolower($this->Signature['pluginSlug']).'-main-menu', 
				array(&$this, 'page')
			);
			$pluginOptions = get_option($this->Signature['pluginSlug']);
			if(count($pluginOptions)==1){
				add_option($this->Signature['pluginSlug'], $this->Signature, '', 'yes');
			}
		}
		
		public function page(){
			?>
			<div class="wrap columns-2 <?php echo $this->Signature['pluginSlug'];?>_wrap">
				<div id="<?php echo $this->Signature['pluginSlug'];?>" class="icon32"></div>  
				<h2><?php echo $this->Signature['pluginName'] .' '.$this->Signature['pluginVersion']; //echo get_locale();?></h2>			
				<div id="poststuff">
					<div id="post-body" class="metabox-holder columns-2">
						<div id="postbox-container-1" class="postbox-container <?php echo $this->Signature['pluginSlug'];?>_container">
							<div class="postbox">
								<h3><span><?php _e('User Guide', 'social-meta-tags');?></span></h3>
								<div class="inside"> 
									<ol>
										<li><?php _e('Install', 'social-meta-tags'); ?></li>
										<li><?php _e('Run', 'social-meta-tags'); ?></li>
										<li><?php _e('Enjoy', 'social-meta-tags'); ?></li>
										<li><?php _e('Ask for Support if you need', 'social-meta-tags'); ?> !</li>
									</ol>
								</div>
							</div>
						</div>
						
						<div id="postbox-container-2" class="postbox-container">
							<div id="<?php echo $this->Signature['pluginSlug'];?>_container">
								<?php	
									$pluginOptions = get_option($this->Signature['pluginSlug']);								
									// echo '<pre>';print_r($pluginOptions);echo '</pre>';
									if(isset($_POST[$this->Signature['pluginSlug'].'-enabled'])){
										$pluginOptions['enabled'] = $_POST[$this->Signature['pluginSlug'].'-enabled'];
										// echo '<pre>';print_r($pluginOptions);echo '</pre>';
										update_option($this->Signature['pluginSlug'], $pluginOptions);		
										?>
										<div class="accordion-header accordion-notification accordion-notification-success">
											<i class="fa dashicons dashicons-no-alt"></i>
											<span class="dashicons dashicons-megaphone"></span>
											<?php echo $this->Signature['pluginName'];?>
											<?php echo __('has been successfully updated', 'social-meta-tags');?>.
										</div> <?php
										$pluginOptions = get_option($this->Signature['pluginSlug']);								
										// echo '<pre>';print_r($pluginOptions);echo '</pre>';
									}
								?> 
								<div class="<?php echo $this->Signature['pluginSlug'];?>_service_content">
									 <div class="accordion-header">
										<i class="fa dashicons dashicons-arrow-down"></i>
										<span class="dashicons dashicons-hidden"></span>
										<?php echo __('Enable Scoial Buttons', 'social-meta-tags');?>
									</div>		
									<div class="<?php echo $this->Signature['pluginSlug'];?>_service_content <?php echo $this->Signature['pluginSlug'];?>_service_content_active">
										<form method="POST" action="" />
											<input <?php echo (!isset($pluginOptions['enabled']) || $pluginOptions['enabled'] == 1)?'checked':'';?> type="radio" name="<?php echo $this->Signature['pluginSlug'];?>-enabled" value="1" /> <?php echo __('Enable', 'social-meta-tags');?>
											<input <?php echo ($pluginOptions['enabled'] == 0)?'checked':'';?> type="radio" name="<?php echo $this->Signature['pluginSlug'];?>-enabled" value="0" /> <?php echo __('Disable', 'social-meta-tags');?>
											
											<input class="<?php echo $this->Signature['pluginSlug'];?>_submit" type="submit" value="<?php echo __('Save', 'social-meta-tags');?>" />
											<div class="clear"></div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php 
		}
		
		public function enqueue(){
			wp_enqueue_style($this->Signature['pluginSlug'].'-front-style', plugins_url('css/'.$this->Signature['pluginSlug'].'-front.css', __FILE__));		
			wp_enqueue_script($this->Signature['pluginSlug'].'-front-js', plugins_url('js/'.$this->Signature['pluginSlug'].'-front.js', __FILE__));
		}

		public function init(){
			$pluginOptions = get_option($this->Signature['pluginSlug']);
			// echo '<p&re>';print_r($pluginOptions);echo '</pre>';
			if(is_single()){
				$url = plugin_dir_url(__FILE__).'/images/512.png';
				if(has_post_thumbnail())
					$url = wp_get_attachment_url(get_post_thumbnail_id());
				?> 
				<!-- 
					<?php echo $this->Signature['pluginSlug'].' | '.$this->Signature['pluginVersion'];?>
					Plugin URI: https://ml.wordpress.org/plugins/facebook-ogg-meta-tags/
				--> 
				<!-- Google+ -->
				<meta itemprop="name" content="<?php the_title(); ?>">
				<meta itemprop="description" content="<?php echo strip_tags(get_the_excerpt($post->ID)); ?>">
				<meta itemprop="image" content="<?php echo $url ?>">
				<!-- Facebook -->
				<meta property="og:title" content="<?php the_title(); ?>" />
				<meta property="og:type" content="article" />
				<meta property="og:url" content="<?php the_permalink(); ?>" />
				<meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
				<meta property="og:description" content="<?php echo strip_tags(get_the_excerpt()); ?>" />  
				<meta property="og:image" content="<?php echo $url ?>"/>
				<!-- Twitter -->
				<meta name="twitter:card" content="summary" />
				<meta name="twitter:title" content="<?php the_title(); ?>" />
				<meta name="twitter:description" content="<?php echo strip_tags(get_the_excerpt($post->ID)); ?>" /> 
				<meta name="twitter:image" content="<?php echo $url ?>" /> 
				<!-- ------------------ -->
				<?php 
				// echo $pluginOptions['enabled'].' ==> '.(is_single() AND get_post_type() == 'post' AND $pluginOptions['enabled'] == 1);
				if(get_post_type() == 'post' AND $pluginOptions['enabled'] == 1){
					function my_metaTags($content){
						global $post;
						// echo '<pre>';print_r($post);echo '</pre>';
						return $post->post_content.'<div class="social-meta-tags-container">
							<div class="social-meta-tags-social social-meta-tags-facebook">
								<a target="_blank" href="https://www.facebook.com/sharer.php?u='.urlencode(post_permalink($post->ID)).'">Facebook</a>
								<span></span></div>
							<div class="social-meta-tags-social social-meta-tags-twitter">
								<a target="_blank" href="https://twitter.com/intent/tweet?text='.urlencode($post->post_title).'&url='.urlencode(post_permalink($post->ID)).'">Twitter</a>
								<span></span>
							</div>
							<div class="social-meta-tags-social social-meta-tags-linkedin">						
								<a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&title='.urlencode($post->post_title).'&url='.urlencode(post_permalink($post->ID)).'&summary='.urlencode($post->post_excerpt).'">Linkedin</a>	
								<span></span></div>
							<div class="social-meta-tags-social social-meta-tags-google">
								<a target="_blank" href="https://plus.google.com/share?url='.urlencode(post_permalink($post->ID)).'">Google</a>
								<span></span>
							</div>
						</div>';
					}
					add_action('the_content', 'my_metaTags');
				}
			}
		}
	}
?>