const { addFilter } = wp.hooks;



apply_filters( 'render_block', string $block_content, array $block )



jQuery(document).ready(function(){


/*
addFilter(
  "filter.toHookInto",
  "custom/filter-name",
  customFilterFunction
);
*/


function gutenbergBlocks( element, blockType, attributes  ) {
	// Check if that is not a table block.
	if (blockType.name !== 'core/table') {
		return element;
	}

	// Return the table block with div wrapper.
	return;
}


});
