/* global jQuery */
jQuery(document).ready(function ($) {
	"use strict";
	/* global MPPFeaturedContent  */
	var ajax_url = MPPSMAGCover.ajaxUrl;

	$(document).on('click', 'a.mppsmagc-cover-btn', function () {
		var $this = $(this);

        $.post(ajax_url, {
            action: 'mppsmagc_set_cover',
            media_id: $this.data('item-id'),
            nonce: $this.data('nonce')
        }, function (resp) {
            $this.replaceWith(resp.data.message);
        });

		return false;
	});

});
