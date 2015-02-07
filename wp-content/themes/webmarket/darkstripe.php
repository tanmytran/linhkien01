<?php
/**
 * Part of the front-template, for displaying latest news/blogposts
 *
 * @package Webmarket
 */

$blog_title = lighted_title( get_single_theme_mod( 'blog_title' ) );

$latest_news = get_posts( array(
	'posts_per_page'   => 6,
) );

?>
	<!--  = Lastest News =  -->
	<div class="darker-stripe blocks-spacer more-space latest-news with-shadows">
		<div class="container">

			<!--  = Title =  -->
			<div class="row">
				<div class="span12">
					<div class="main-titles center-align">
						<h2 class="title">
							<span class="clickable fa fa-chevron-left" id="latestNewsLeft"></span> &nbsp;&nbsp;&nbsp;
							<?php echo $blog_title; ?> &nbsp;&nbsp;&nbsp;
							<span class="clickable fa fa-chevron-right" id="latestNewsRight"></span>
						</h2>
					</div>
				</div>
			</div> <!-- /title -->

			<!--  = News content =  -->
			<div class="row">
				<div class="span12">
					<div class="carouFredSel" data-nav="latestNews" data-autoplay="false">


						<!--  = Slide =  -->
						<div class="slide">
							<div class="row">
								<?php
									$i = 0;
									foreach ( $latest_news as $post ) :
										setup_postdata( $post );
										if ( 0 !== $i && $i % 2 === 0 ) {
											// for every 2 news/posts break for slider
											echo '</div></div><div class="slide"><div class="row">';
										}
										$i++;
								?>
								<div class="span6">
									<div class="news-item">
										<div class="published"><?php the_time( get_option( 'date_format' ) ); ?></div>
										<h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
										<?php the_excerpt(); ?>
									</div>
								</div>
								<?php
									endforeach;
								?>
							</div>
						</div> <!-- /slide -->

					</div>
				</div>
			</div> <!-- /news content -->
		</div>
	</div> <!-- /latest news -->