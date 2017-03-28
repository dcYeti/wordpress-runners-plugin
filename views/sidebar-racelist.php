<?php
/**
 * Sidebar for the hiking blog 
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */


$options = twentyeleven_get_theme_options();
$current_layout = $options['theme_layout'];

if ( 'content' != $current_layout ) :
?>
		<div id="secondary" class="widget-area" role="complementary">
		<!-- This sidebar will eschew dynamic_sidebar to include only hiking entries -->
				<aside id="archives" class="widget">
					<h3 class="widget-title"><?php _e( 'View Race Reports by Type', 'twentyeleven' ); ?></h3>
					<ul>
						<?php 
							//Get the taxonomies associated with race_type
							$raceTypes = get_terms(array('taxonomy' => 'race_type'));
							foreach ($raceTypes as $raceType) {
								echo '<h3>' . $raceType->name . '</h3>';
								
								$raceReportArgs = array(
									'tax_query'=>array(array('taxonomy'=>'race_type','terms'=>$raceType)),
									'orderby'=>'date', 
									'order'=>'DESC');
								$catQ = new WP_Query($raceReportArgs);
								while ($catQ->have_posts()){
									$catQ->the_post();
									$urlQ = get_the_ID();
									echo "<a href='/index.php?p=$urlQ'>" . '<h5>' . get_the_title() . '</h5></a><hr/>';
								}
								echo "<br/>";
								wp_reset_postdata();
							}
							 ?>
					</ul>
				</aside>

		</div><!-- #secondary .widget-area -->
<?php endif; ?>