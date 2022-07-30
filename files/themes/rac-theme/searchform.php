<?php if ( ! defined( 'ABSPATH' ) ) {  exit; } ?>



<form class="search" method="post" action="<?php _e(home_url()); ?>" role="search">

	<a href="#" data-display-search role="button" aria-pressed="false" aria-label="Show/Hide Search Form"></a>

	<div class="search-bg">
		<label for="nav-search" class="sr-only">Type Search </label>
		<input id="nav-search" class="search-input" type="search" name="s" placeholder="<?php _e( 'Search', 'dbllc' ); ?>">
		<button class="search-submit" type="submit" aria-label="Search This Query"><span class="sr-only">Search This Query</span></button>
	</div>

</form>
