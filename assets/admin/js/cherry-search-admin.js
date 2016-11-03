( function( $, CherryJsCore ) {
	'use strict';

	CherryJsCore.utilites.namespace( 'cherrySearchBackScripts' );
	CherryJsCore.cherrySearchBackScripts = {

		saveHandlerId: 'cherry_search_save_setting',
		resetHandlerId: 'cherry_search_reset_setting',

		saveButtonId: '#cherry-save-buttons',
		resetButtonId: '#cherry-reset-buttons',
		formId: '#chery-search-settings-form',

		saveOptionsInstance: null,
		resetOptionsInstance: null,

		init: function() {
			this.saveOptionsInstance = new CherryJsCore.CherryAjaxHandler(
					{
						handlerId: this.saveHandlerId,
						successCallback: this.saveSuccessCallback.bind( this )
					}
				);
			this.resetOptionsInstance = new CherryJsCore.CherryAjaxHandler(
					{
						handlerId: this.resetHandlerId,
						successCallback: this.resetSuccessCallback.bind( this )
					}
				);

			this.addEvents();
		},

		addEvents: function() {
			$( 'body' )
				.on( 'click', this.saveButtonId, this.saveOptionsHandler.bind( this ) )
				.on( 'click', this.resetButtonId, this.resetOptionsHandler.bind( this ) );
		},

		saveOptionsHandler: function( event ) {
			this.disableButton( event.target );
			this.saveOptionsInstance.sendFormData( this.formId );
		},
		resetOptionsHandler: function( event ) {
			this.disableButton( event.target );
			this.resetOptionsInstance.send();
		},

		resetSuccessCallback: function( data ) {
			var defaultSettings = data.data,
				key,
				input,
				type,
				value,
				valueKey,
				iconPickerAddon,
				baseClass;

			for ( key in defaultSettings ) {
				input = $( '[name="' + key + '"], #' + key );

				if ( ! input[0] ) {
					continue;
				}

				value = defaultSettings[ key ];
				type = input.attr( 'type' );

				if ( undefined === type ) {
					type = input.prop( 'tagName' );
				}

				switch ( type.toLowerCase() ) {
					case 'radio':
					case 'checkbox':
						input
							.attr( 'checked', false )
							.filter( '[value="' + value + '"]' )
							.attr( 'checked', true );
					break;
					case 'select':
						input
							.find( 'option' )
							.attr( 'selected', false );

						for ( valueKey in value ) {
							input
								.find( '[value="' + value[ valueKey ] + '"]' )
								.attr( 'selected', true );
						}
					break;
					default:
						input.val( value );

						iconPickerAddon = input.siblings( '.input-group-addon' );
						if ( iconPickerAddon[0] ) {
							baseClass = $( 'i', iconPickerAddon )[0].classList[0];

							$( 'i', iconPickerAddon )
								.removeClass()
								.addClass( baseClass + ' ' + value );
						}
					break;
				}

				input.trigger( 'change' );
			}

			this.enableButton( this.resetButtonId );
		},

		saveSuccessCallback: function() {
			this.enableButton( this.saveButtonId );
		},

		disableButton: function( button ) {
			$( button )
				.attr( 'disabled', 'disabled' );
		},

		enableButton: function( button ) {
			var timer = null;

			$( button )
				.removeAttr( 'disabled' )
				.addClass( 'success' );

			timer = setTimeout(
				function() {
					$( button ).removeClass( 'success' );
					clearTimeout( timer );
				},
				1000
			);
		}
	};

	CherryJsCore.cherrySearchBackScripts.init();
}( jQuery, window.CherryJsCore ) );
