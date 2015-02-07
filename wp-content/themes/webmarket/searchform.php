<?php 
/**
 * Search form
 *
 * @package Webmarket
 */
?>
<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>" class="form">
	<input name="s" class="input-block-level" id="appendedInputButton" type="text" placeholder="Search for posts ..." />
	<button type="submit">
		<i class="fa fa-search"></i>
	</button>
</form>