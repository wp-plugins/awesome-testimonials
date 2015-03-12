<div class="wrap">
  <?php
   global $wpdb;	
    $pro_table_prefix=$wpdb->prefix.'pra_';
	
	
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args=array(
  		'post_type' => 'pra_testimonials',
		'post_status' => 'publish',
  		'paged'=>$paged);

		$my_query = null;
		$my_query = new WP_Query($args);
		if( $my_query->have_posts() )
		 {
			$myrows = $wpdb->get_col("SELECT value FROM ".$pro_table_prefix."testimonial_settings" ); 

$display_arrow = $myrows[1];
$show_image = $myrows[2];

			$pauseduration = $myrows[3];
			if($pauseduration=='')
			{
				$pauseduration=9000;
			}
			
			$scrollduration = $myrows[4];
			if($scrollduration=='')
			{
				$scrollduration=1000;
			}  ?>
            
            
  <div class="pra style1 large_image ">
    <div class="caroufredsel_wrapper" >
      
<div class="pra_navigation"  <?php if($display_arrow==1) { echo 'style="display:block"'; } else { echo 'style="display:none"'; } ?> >  
      <a  class="pra_prev " style="display:block" href="#">«</a> <a style="display:block" class="pra_next " href="#">»</a> 
      </div>
      
      <div 	data-transitioneffect="<?php echo $myrows[0]; ?>" 
            data-pauseduration="<?php echo $pauseduration; ?>" 
            data-scrollduration="<?php echo $scrollduration; ?>" 
            data-pauseonhover="<?php echo $myrows[5]; ?>" 
            data-autoplay="<?php echo $myrows[6]; ?>" 
            class="pra_rotator" >
            
        <?php
			foreach($my_query->posts as $postdetail)
			 { 		  
				$img_width = (int) 80;
				$img_height = (int) 80;
				$thumbnail_id = get_post_meta($postdetail->ID,'_thumbnail_id', true );
				$thumb = wp_get_attachment_image( $thumbnail_id, array($img_width, $img_height), true );	?>
        <div class="pra_testimonial">
        
          <div  class="pra_testimonialtext"> 
          
	          	<span class="quote-left"></span> 
            	<q><?php echo $postdetail->post_content; ?> <span class="quote-right"></span></q>
            
            
               </div>
          <span class="pra_arrow"></span>
          
          
          
          <cite>
                    <span class="photo"><?php if($show_image==1) {   echo $thumb; } ?></span>
                    <span class="author">By <span><?php echo $postdetail->post_title; ?></span></span>
                   
          </cite>
          
               
          
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <?php  } ?>
</div>
