/**
 * @package    hubzero-cms
 * @copyright  Copyright (c) 2005-2020 The Regents of the University of California.
 * @license    http://opensource.org/licenses/MIT MIT
 */

jQuery(document).ready(function ($) {
	var mod_wishlist_charts = [];

	$('.mod_wishlist-chart').each(function(i, el){
		var data = $('#' + $(el).attr('data-datasets')).html();
		var datasets = JSON.parse(data);
		var mod_wishlist_chart = $.plot(
			$(el),
			datasets.datasets,
			{
				legend: {
					show: false
				},
				series: {
					pie: {
						innerRadius: 0.5,
						show: true,
						label: {
							show: false
						},
						stroke: {
							color: '#efefef'
						}
					}
				},
				grid: {
					hoverable: false
				}
			}
		);

		mod_wishlist_charts.push(mod_wishlist_chart);
	});
});