jQuery(function($) {
	// Tabbed Panels
	$(document.body).on('cej-init-tabbed-panels', function() {
		$('ul.cej-tabs').show();
		$('ul.cej-tabs a').click(function(e) {
			e.preventDefault();
			var panel_wrap = $(this).closest('div.panel-wrap');
			$('ul.cej-tabs li', panel_wrap).removeClass('active');
			$(this ).parent().addClass('active');
			$('div.panel', panel_wrap).hide();
			$($(this).attr('href')).show();
		});
		$('div.panel-wrap').each(function() {
			$(this).find('ul.cej-tabs li').eq(0).find('a').click();
		});
	}).trigger('cej-init-tabbed-panels');

	// Date Picker
	$(document.body).on('cej-init-datepickers', function() {
		$('.date-picker').datepicker({
			dateFormat: 'yy-mm-dd',
			numberOfMonths: 1,
			showButtonPanel: true
		});
	}).trigger('cej-init-datepickers');
});