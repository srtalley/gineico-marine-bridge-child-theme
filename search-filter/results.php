<?php
/**
 * Search & Filter Pro 
 *
 * Sample Results Template
 * 
 * @package   Search_Filter
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 * 
 * Note: these templates are not full page templates, rather 
 * just an encaspulation of the your results loop which should
 * be inserted in to other pages by using a shortcode - think 
 * of it as a template part
 * 
 * This template is an absolute base example showing you what
 * you can do, for more customisation see the WordPress docs 
 * and using template tags - 
 * 
 * http://codex.wordpress.org/Template_Tags
 *
 */

if ( $query->have_posts() )
{
	?>
	
	Found <?php echo $query->found_posts; ?> Results<br />
	<div class='woocommerce columns-<?php echo esc_attr( wc_get_loop_prop( 'columns')); ?> search-filter-results-list'>
	<ul class="products columns-<?php echo esc_attr( wc_get_loop_prop( 'columns' ) ); ?>">
	<?php
		while ($query->have_posts())
		{
			
			$query->the_post();

			wc_get_template_part( 'content', 'product' );
			?>
			<?php
		} // end while
	?>
	</ul>
	<hr />
	</div> <!-- .search-filter-results-list -->
<?php
}
else
{
	?>
	<div class='search-filter-results-list' data-search-filter-action='infinite-scroll-end'>
		<span>End of Results</span>
	</div>
	<?php
}
?>