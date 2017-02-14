(function( $, CherryJsCore ) {
	'use strict';

	CherryJsCore.utilites.namespace( 'cherrySearch' );
	CherryJsCore.cherrySearch = {
		settings: {
			searchFormWrapperClass: '.cherry-search-wrapper',
			searchFormClass: '.cherry-search__form',
			inputClass: '.cherry-search__field',
			submitClass: '.cherry-search__submit',
			listClass: '.cherry-search__results-list',
			itemClass: '.cherry-search__results-item',
			messageHolder: '.cherry-search__message',
			spinner: '.cherry-search__spinner',
			moreButton: '.cherry-search__more-button',
			searchHandlerId: 'cherry_search_public_action'
		},

		init: function() {
			$( 'body' ).on( 'focus' + this.settings.searchFormWrapperClass, this.settings.inputClass, this.initCherrySearch.bind( this ) );
		},

		initCherrySearch: function( event ) {
			var search = $( event.target ).closest( this.settings.searchFormWrapperClass );

			search.cherrySearch( this.settings );
		}
	};

	CherryJsCore.cherrySearch.init();

	$.fn.cherrySearch = function( args ) {
		var self = this[0],
			settings      = args,
			messages      = window.cherrySearchMessages,
			timer         = null,
			itemTemplate  = null,
			resultsList   = $( settings.listClass, self ),
			messageHolder = $( settings.messageHolder, resultsList ),
			spinner       = $( settings.spinner, resultsList ),
			data          = $( self ).data( 'args' ) || [];

		if ( ! self.isInit ) {
			self.isInit       = true;

			self.inputChangeHandler = function( event ) {
				var value = event.target.value;

				$( 'ul', resultsList ).html( '' );
				self.outputMessage( '', '' );

				if ( value ) {
					self.showList();
					spinner.addClass( 'show' );

					clearTimeout( timer );
					timer = setTimeout( function() {
						data.value = value;
						self.searchAjaxInstancer.sendData( data );
					}, 450 );
				} else {
					self.hideList();
				}
			};

			self.successCallback = function( response ) {
				var date       = response.data,
					error      = date.error,
					message    = date.message,
					posts      = date.posts,
					post       = null,
					outputHtml = '';

				if ( 'error-notice' !== response.type ) {
					if ( 0 === date.post_count || error ) {
						self.outputMessage( message, 'show' );
					} else {
						messageHolder.removeClass( 'show' );
						for ( post in posts ) {
							if ( 'more_button' === post ) {
								outputHtml += posts[ post ];
							} else {
								itemTemplate = wp.template( 'search-form-results-item-' + data.id );
								outputHtml += itemTemplate( posts[ post ] );
							}
						}
					}

					spinner.removeClass( 'show' );
					$( 'ul', resultsList ).html( outputHtml );
				} else {
					self.outputMessage( messages.serverError, 'error show' );
				}
			};

			self.errorCallback = function( jqXHR ) {
				if ( 'abort' !== jqXHR.statusText ) {
					spinner.removeClass( 'show' );
					self.outputMessage( messages.serverError, 'error show' );
				}
			};

			self.hideList = function() {
				resultsList.removeClass( 'show' );
			};

			self.showList = function() {
				resultsList.addClass( 'show' );
			};

			self.focusHandler = function() {
				if ( 0 !== $( 'ul > li', resultsList ).length ) {
					self.showList();
				}
			};

			self.outputMessage = function( message, messageClass ) {
				messageHolder.removeClass( 'error show' ).addClass( messageClass ).html( message );
			};

			self.formClick = function( event ) {
				event.stopPropagation();
			};

			self.clickMoreButton = function() {
				$( settings.searchFormClass, self ).submit();
			};

			self.searchAjaxInstancer = new CherryJsCore.CherryAjaxHandler( {
				handlerId: settings.searchHandlerId,
				successCallback: self.successCallback,
				errorCallback: self.errorCallback
			} );

			$( settings.inputClass, self )
				.on( 'input', self.inputChangeHandler )
				.on( 'focus', self.focusHandler )
				/*.on( 'blur', self.hideList )*/;

			$( self )
				.on( 'click' + settings.searchFormWrapperClass, self.formClick )
				.on( 'click' + settings.searchFormWrapperClass, settings.moreButton, self.clickMoreButton );

			$( 'body' )
				.on( 'click' + settings.searchFormWrapperClass, self.hideList );

		} else {
			return 'is init: true';
		}
	};
}( jQuery, window.CherryJsCore ) );
