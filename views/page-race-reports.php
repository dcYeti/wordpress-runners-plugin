<?php
/**
 * Template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">

				<!--Adjust race-header, race-container and race-text in race_report_display CSS.  THis was designed for a custom theme -->
				<?php 
					$postNeeds = array('post_type' => 'race_report', 'orderby' => 'date', 'order' => 'DESC');
					$newQuery = new WP_Query($postNeeds);
					if ($newQuery->have_posts()):					
						while ( $newQuery->have_posts() ) : 
						  $newQuery->the_post(); 
						  //Get race report meta data and store in array
						  $race_meta = get_post_meta(get_the_ID()); ?>
						  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					      <header class="entry-header"  id="race-header">
						  <h3 class="entry-title" ><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
						</header>
						<div class="entry-content" id='race-container'>
						<div id="race-basics">	
							<p class="race-text"><em><?php echo "A " . get_term($race_meta['race_typing'][0])->name . 
							" of " . esc_attr($race_meta['race_distance'][0]) . " " . esc_attr($race_meta['distance_type'][0]); ?></em>
							<?php if (!empty($race_meta['race_infosite'][0])) { ?> &nbsp;&nbsp;&nbsp;
								<a href=<?php echo '"' . esc_attr($race_meta['race_infosite'][0]) . '"'; ?> >View Race Website</a>	
							<?php } 
							if (!empty($race_meta['race_resultsite'][0])) { ?>	&nbsp;&nbsp;&nbsp;
								<a href=<?php echo '"' . esc_attr($race_meta['race_resultsite'][0]) . '"'; ?> >View Full Results</a>
							<?php } 
							if (!empty($race_meta['bib_no'][0])) { ?>	&nbsp;&nbsp;&nbsp;
								<strong>Bib: </strong> <?php echo esc_attr($race_meta['bib_no'][0]); 
							} ?> <br/>
							 
							<strong>Date:</strong> <?php echo esc_attr( $race_meta['race_date'][0]); ?> 
							<strong>&nbsp;Entrants:</strong> <?php echo esc_attr( $race_meta['race_entrants'][0]); ?>
							<strong>&nbsp;Finishers:</strong> <?php echo esc_attr( $race_meta['race_finishers'][0]); ?> 
							<br/><strong>Location:</strong> <?php echo esc_attr( $race_meta['race_location'][0]); 
							if (!empty($race_meta['weather_cond'][0])) {
								echo "&nbsp;&nbsp;<strong>Weather Conditions: </strong>" . esc_attr( $race_meta['weather_cond'][0]);
							}	
							?></p>
							</div>
							
							<div id="rankings">
								<h3>My Finish and Time Info</h3>	
									<p class="race-text"><strong>Overall Finish: </strong><?php echo esc_attr( $race_meta['race_finish'][0]); ?> / 
									<?php echo esc_attr( $race_meta['race_finishers'][0]); ?>&nbsp;&nbsp;
									<strong>Chip Time: </strong><?php echo esc_attr( $race_meta['finish_time_chip'][0]); ?>&nbsp;&nbsp;
									<strong>Gun Time: </strong><?php echo esc_attr( $race_meta['finish_time_gun'][0]); ?>&nbsp;&nbsp;
									<strong>Pace(mi): </strong><?php echo esc_attr( $race_meta['mile_pace'][0]);
						        if ($race_meta['opt_genderfinish'][0] == 'true'){
									echo "<br/><strong>Gender Group " . ucfirst(esc_attr( $race_meta['gender'][0])) . ":</strong> " . 
									esc_attr( $race_meta['gender_rank'][0]) . " out of " . esc_attr( $race_meta['gender_finishers'][0]);
									echo "&nbsp;&nbsp;&nbsp;";
								}
							    if ($race_meta['opt_agefinish'][0]  == 'true'){
									echo "<strong>Age Group " . esc_attr( $race_meta['age_group'][0]) . ":</strong> " . 
									esc_attr( $race_meta['age_rank'][0]) . " out of " . esc_attr( $race_meta['age_finishers'][0]);
								} 
								if ($race_meta['opt_split1'][0] == 'true'){
									echo "<br/><strong>Split 1:</strong> " . esc_attr( $race_meta['split1time'][0]) . " at " . 
									esc_attr( $race_meta['split1distance'][0]) . " " . esc_attr( $race_meta['split1type'][0]);
								}
								if ($race_meta['opt_split2'][0] == 'true'){
									echo "&nbsp;&nbsp;&nbsp;<strong>Split 2:</strong> " . esc_attr( $race_meta['split2time'][0]) . " at " . 
									esc_attr( $race_meta['split2distance'][0]) . " " . esc_attr( $race_meta['split2type'][0]);
								}
								if ($race_meta['opt_split3'][0] == 'true'){
									echo "<br/><strong>Split 3:</strong> " . esc_attr( $race_meta['split3time'][0]) . " at " . 
									esc_attr( $race_meta['split3distance'][0]) . " " . esc_attr( $race_meta['split3type'][0]);
								}
								if ($race_meta['opt_split4'][0] == 'true'){
									echo "&nbsp;&nbsp;&nbsp;<strong>Split 4:</strong> " . esc_attr( $race_meta['split4time'][0]) . " at " . 
									esc_attr( $race_meta['split4distance'][0]) . " " . esc_attr( $race_meta['split4type'][0]);
								} ?>
									</p>
							</div><br/>
							<?php 
							echo do_shortcode($race_meta['racestory'][0]);
							
							wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
						</div><!-- .entry-content -->
						<footer class="entry-meta">
						<?php $show_sep = false; ?>
						<?php if ( is_object_in_taxonomy( get_post_type(), 'category' ) ) : // Hide category text when not supported ?>
						<?php
							/* translators: used between list items, there is a space after the comma */
							$categories_list = get_the_category_list( __( ', ', 'twentyeleven' ) );
							if ( $categories_list ):
						?>
						<span class="cat-links">
							<?php printf( __( '<span class="%1$s">Posted in</span> %2$s', 'twentyeleven' ), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list );
							$show_sep = true; ?>
						</span>
						<?php endif; // End if categories ?>
						<?php endif; // End if is_object_in_taxonomy( get_post_type(), 'category' ) ?>
						<?php if ( is_object_in_taxonomy( get_post_type(), 'post_tag' ) ) : // Hide tag text when not supported ?>
						<?php
							/* translators: used between list items, there is a space after the comma */
							$tags_list = get_the_tag_list( '', __( ', ', 'twentyeleven' ) );
							if ( $tags_list ):
							if ( $show_sep ) : ?>
						<span class="sep"> | </span>
							<?php endif; // End if $show_sep ?>
						<span class="tag-links">
							<?php printf( __( '<span class="%1$s">Tagged</span> %2$s', 'twentyeleven' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list );
							$show_sep = true; ?>
						</span>
						<?php endif; // End if $tags_list ?>
						<?php endif; // End if is_object_in_taxonomy( get_post_type(), 'post_tag' ) ?>
					</footer><!-- .entry-meta -->
			     </article><!-- #post-<?php the_ID(); ?> -->
				 	<?php			twentyeleven_content_nav( 'nav-below' ); ?>
					<?php	endwhile; // end of the loop. 
					else:
						_e('Sorry, no posts matched your criteria');
					endif;
	
					?>

			</div><!-- #content -->
		</div><!-- #primary -->
		
<?php get_sidebar('racelist'); ?>
<?php get_footer(); ?>