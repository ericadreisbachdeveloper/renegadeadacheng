(function () {
	'use strict';

	var templateString = "\n<%if (typeof lazysizesBlurhash !== 'undefined') {%>\n<span class=\"setting lazysizes-blurhash\">\n\t<span class=\"name\">Lazysizes Blurhash</span>\n\t<span class=\"value\" <%= !lazysizesBlurhash ? 'style=\"padding-top: 0;\"' : '' %>>\n\t\t<%if (!lazysizesBlurhash) {%>\n\t\t\t<span>\n\t\t\t\t<%= lazysizesStrings.notGenerated %>\n\t\t\t</span>\n\t\t\t<button type=\"button\" class=\"button button-primary lazysizes-blurhash-generate\" <%= lazysizesLoading ? 'disabled' : '' %>><%= lazysizesStrings.generate %></button>\n\t\t<%} else {%>\n\t\t\t<div style=\"padding-bottom: 8px;\">\n\t\t\t\t<%= lazysizesStrings.current + lazysizesBlurhash %>\n\t\t\t</div>\n\t\t\t<button type=\"button\" class=\"button lazysizes-blurhash-delete\" <%= lazysizesLoading ? 'disabled' : '' %>><%= lazysizesStrings.delete %></button>\n\t\t<%}%>\n\t\t<span class=\"spinner <%= lazysizesLoading ? 'is-active' : '' %>\" style=\"padding-top: 0; float: none; min-width: 20px;\"></span>\n\t\t<%if (lazysizesError) {%>\n\t\t\t<div>\n\t\t\t\t<%= lazysizesError %>\n\t\t\t</div>\n\t\t<%}%>\n\t</span>\n</span>\n<p class=\"description\">\n\t<%= lazysizesStrings.description %>\n</p>\n<%} else {%>\n<span class=\"setting lazysizes-blurhash\">\n\t<span class=\"name\" style=\"margin-left: 0; margin-right: 0;\">Lazysizes Blurhash</span>\n\t<span class=\"value\" style=\"padding-top: 0;\">\n\t<span class=\"spinner <%= lazysizesLoading ? 'is-active' : '' %>\" style=\"padding-top: 0; float: none; min-width: 20px;\"></span>\n\t</span>\n</span>\n<%}%>\n";

	var templateFunction = _.template(templateString);

	var handleServerRequest = function handleServerRequest(e) {
	  var _this = this;

	  var action = '';

	  if (e === undefined) {
	    action = 'fetch';
	  } else if (e.target.classList.contains('lazysizes-blurhash-generate')) {
	    action = 'generate';
	  } else if (e.target.classList.contains('lazysizes-blurhash-delete')) {
	    action = 'delete';
	  } else {
	    return;
	  }

	  this.lsModel.set('lazysizesLoading', true);
	  lazysizesAjax(action, this.model.attributes.id, this.model.attributes.nonces.lazysizes[action], function (response, status, errorCode) {
	    _this.lsModel.set('lazysizesLoading', false);

	    if (status === 'error') {
	      _this.lsModel.set('lazysizesError', "".concat(lazysizesStrings.error, " (").concat(errorCode, ")"));
	    } else {
	      if (response.success) {
	        if (action === 'fetch' || action === 'generate') {
	          _this.lsModel.set('lazysizesBlurhash', response.blurhash);
	        } else if (action === 'delete') {
	          _this.lsModel.set('lazysizesBlurhash', false);
	        }
	      } else {
	        _this.lsModel.set('lazysizesError', response.data[0].message);
	      }
	    }
	  });
	};

	var initialValues = {
	  lazysizesBlurhash: undefined,
	  lazysizesError: false,
	  lazysizesLoading: false
	}; // Based on code by Thomas Griffin.
	// See https://gist.github.com/sunnyratilal/5650341.

	var mediaTwoColumn = wp.media.view.Attachment.Details.TwoColumn; // In Media Library.

	wp.media.view.Attachment.Details.TwoColumn = mediaTwoColumn.extend({
	  initialize: function initialize() {
	    mediaTwoColumn.prototype.initialize.apply(this, arguments);
	    this.lsModel = new Backbone.Model(initialValues); // Always make sure that our content is up to date.

	    this.listenTo(this.model, 'change', this.render);
	    this.listenTo(this.lsModel, 'change', this.render);
	  },
	  events: {
	    'click .setting.lazysizes-blurhash .button': handleServerRequest
	  },
	  render: function render() {
	    // Ensure that the main attachment fields (and the fields of other plugins) are rendered.
	    mediaTwoColumn.prototype.render.apply(this, arguments); // If first load and the nonces have loaded, get initial data from server.

	    if (typeof this.lsModel.attributes.lazysizesBlurhash === 'undefined' && typeof this.model.attributes.nonces !== 'undefined' && !this.lsModel.attributes.lazysizesLoading) {
	      handleServerRequest.apply(this);
	    } // Detach the views, append our custom fields, make sure that our data is fully updated and re-render the updated view.


	    this.views.detach();

	    if (this.model.attributes.type === 'image') {
	      this.$el.find('.settings').append(templateFunction(this.lsModel.toJSON()));
	    }

	    this.views.render();
	    return this;
	  }
	});
	var mediaAttachmentDetails = wp.media.view.Attachment.Details; // In post editor, when selecting attachment.

	wp.media.view.Attachment.Details = mediaAttachmentDetails.extend({
	  initialize: function initialize() {
	    mediaAttachmentDetails.prototype.initialize.apply(this, arguments);
	    this.lsModel = new Backbone.Model(initialValues); // Always make sure that our content is up to date.

	    this.listenTo(this.model, 'change', this.render);
	    this.listenTo(this.lsModel, 'change', this.render);
	  },
	  events: {
	    'click .setting.lazysizes-blurhash .button': handleServerRequest
	  },
	  render: function render() {
	    // Ensure that the main attachment fields (and the fields of other plugins) are rendered.
	    mediaAttachmentDetails.prototype.render.apply(this, arguments); // If first load and the nonces have loaded, get initial data from server.

	    if (typeof this.lsModel.attributes.lazysizesBlurhash === 'undefined' && typeof this.model.attributes.nonces !== 'undefined' && !this.lsModel.attributes.lazysizesLoading) {
	      handleServerRequest.apply(this);
	    } // Detach the views, append our custom fields, make sure that our data is fully updated and re-render the updated view.


	    this.views.detach();

	    if (this.model.attributes.type === 'image') {
	      this.$el.append(templateFunction(this.lsModel.toJSON()));
	    }

	    this.views.render();
	    return this;
	  }
	});

	function lazysizesAjax(action, attachmentId, nonce, callback) {
	  jQuery.ajax({
	    type: 'POST',
	    url: ajaxurl,
	    data: {
	      action: 'lazysizes_blurhash',
	      nonce: nonce,
	      mode: action,
	      attachmentId: attachmentId
	    },
	    success: callback,
	    error: callback
	  });
	}

}());
