jQuery(document.body).ready(function ($) {

	// Add duplicate link to zone rows
	const zoneObserver = new MutationObserver(function (mutations) {
		mutations.forEach(function (mutation) {
			mutation.addedNodes.forEach(function (node) {
				if (node.matches && node.matches('tr[data-id]')) { // Check for zone row changes to add link
					var zoneId = $(node).attr('data-id');
					var link = jQuery('<a>').attr('href', '?action=duplicate-zone&zone-id=' + zoneId).html(szdwc.i18n.duplicate);
					$(node).find('.row-actions').append(' | ').append(link); // < WC 8.4
					$(node).find('.wc-shipping-zone-actions .wc-shipping-zone-action-edit').after(link).after(' | '); // WC 8.4+
				}
			});
		});
	});

	const zoneRows = document.querySelector('.wc-shipping-zones tbody.wc-shipping-zone-rows');
	if (zoneRows) {
		zoneObserver.observe(zoneRows, {childList: true, subtree: true});
	}

	// Add duplicate link to method rows
	const methodObserver = new MutationObserver(function (mutations) {
		mutations.forEach(function (mutation) {
			mutation.addedNodes.forEach(function (node) {
				if (node.matches && node.matches('tr[data-id]')) { // Check for zone row changes to add link
					var zoneId = $(node).attr('data-id');
					var link = jQuery('<a>').attr('href', '?action=duplicate-method&instance-id=' + zoneId).html(szdwc.i18n.duplicate);
					$(node).find('.row-actions').append(' | ').append(link); // < WC 8.4
					$(node).find('.wc-shipping-zone-actions .wc-shipping-zone-action-edit').after(link).after(' | '); // WC 8.4+
				}
			});
		});
	});

	const methodRows = document.querySelector('.wc-shipping-zone-method-rows');
	if (methodRows) {
		methodObserver.observe(methodRows, {childList: true, subtree: true});
	}

});
