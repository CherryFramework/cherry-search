( function( $, CherryJsCore ) {
	"use strict";

	CherryJsCore.utilites.namespace('cherrySearchBackScripts');
	CherryJsCore.cherrySearchBackScripts = {

		saveHandlerId: 'cherry_search_save_setting',
		resetHandlerId: 'cherry_search_reset_setting',

		saveButtonId: '#cherry-save-buttons',
		resetButtonId: '#cherry-reset-buttons',
		formId: '#chery-search-settings-form',

		saveOptionsInstance: null,
		resetOptionsInstance: null,

		cherryHadlerInit: function () {
			$( document )
				.on( 'CherryHandlerInit', this.init.bind( this ) );
		},

		init: function () {
			this.saveOptionsInstance = new CherryJsCore.CherryAjaxHandler(
					{
						handlerId: this.saveHandlerId,
						successCallback: this.saveSuccessCallback.bind( this )
					}
				),
			this.resetOptionsInstance = new CherryJsCore.CherryAjaxHandler(
					{
						handlerId: this.resetHandlerId,
						successCallback: this.resetSuccessCallback.bind( this )
					}
				);

			this.addEvents();
		},

		addEvents: function () {
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
				valueKey;

			for ( key in defaultSettings ) {
				value = defaultSettings[ key ];
				input = $( '[name="' + key + '"], #' + key );
				type = input.attr('type');

				if ( undefined === type ) {
					type = input.prop('tagName').toLowerCase();
				}

				switch ( type ) {
					case 'radio':
					case 'checkbox':
						input
							.attr( 'checked', false )
							.filter( '[value="' + value + '"]' )
							.attr( 'checked', true );
					break;
					case 'select':
						input
							.find('option')
							.attr( 'selected', false );

						for ( valueKey in value ) {
							input
								.find( '[value="' + value[ valueKey ] + '"]' )
								.attr( 'selected', true );
						}
					break;
					default:
						input.val( value )
					break;
				}
				input.trigger( 'change' );
			}

			this.enableButton( this.resetButtonId );
		},
		saveSuccessCallback: function( data ) {
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
			)
		}
	}
	CherryJsCore.cherrySearchBackScripts.cherryHadlerInit();
} ( jQuery, window.CherryJsCore ) );
