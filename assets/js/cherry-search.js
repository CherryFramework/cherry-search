( function( $ ){
	"use strict"

	CherryJsCore.utilites.namespace('cherrySearch');
	CherryJsCore.cherrySearch = {
		settings: {
			searchFormWrapperClass: '.cherry-search',
			searchFormClass: '.cherry-search__form',
			inputClass: '.cherry-search__field',
			submitClass: '.cherry-search__submit',
			listClass: '.cherry-search__results-list',
			itemClass: '.cherry-search__results-item',
			messageHolder: '.cherry-search__message',
			spinner: '.cherry-search__spinner',
			searchHandlerId: 'cherry_search_public_action'
		},

		init: function () {
			$( 'body' ).on( 'focus' + this.settings.searchFormWrapperClass, this.settings.inputClass, this.initCherrySearch.bind( this ) );
		},

		initCherrySearch: function( event ) {
			var search = $( event.target ).closest( this.settings.searchFormWrapperClass );

			search.cherrySearch( this.settings );
		}
	}
	CherryJsCore.cherrySearch.init();

	$.fn.cherrySearch = function( args ) {
		var self = this[0];

		if ( ! self.isInit ) {
			self.isInit       = true;

			var settings      = args,
				messages      = cherrySearchMessages,
				timer         = null,
				itemTemplate  = wp.template( 'search-form-results-item' ),
				resultsList   = $( settings.listClass, self ),
				messageHolder = $( settings.messageHolder, resultsList),
				spinner = $( settings.spinner, resultsList);


			self.inputChangeHandler = function( event ){
				var value = event.target.value;

				$( 'ul', resultsList ).html( '' );
				self.outputMessage( '', '' );

				if ( value ) {
					self.showList();
					spinner.addClass('show');

					clearTimeout( timer );
					timer = setTimeout( function() {
						self.searchAjaxInstancer.sendData( value );
					}, 450 );
				} else {
					self.hideList();
				}
			};

			self.successCallback = function( response ){
				var date       = response.data,
					error      = date.error,
					message    = date.message,
					posts      = date.posts,
					post       = null,
					outputHtml = '',
					postData   = null;

				if ( 0 === date.post_count || error ) {
					self.outputMessage( message, 'show' );
				}else{
					messageHolder.removeClass('show');
					for ( post in posts ) {
						if ( 'more_button' === post ) {
							outputHtml += posts[ post ];
						} else {
							outputHtml += itemTemplate( posts[ post ] );
						}
					}
				}

				spinner.removeClass('show');
				$( 'ul', resultsList ).html( outputHtml );
			};

			self.errorCallback = function( data ){
				console.log(self.searchAjaxInstancer);
				spinner.removeClass('show');
				self.outputMessage( messages.serverError, 'error show' );
			};

			self.hideList = function(){
				resultsList.removeClass( 'show' );
			}

			self.showList = function(){
				resultsList.addClass( 'show' );
			}

			self.focusHandler = function(){
				if ( 0 !== $( 'ul > li', resultsList ).length ) {
					self.showList();
				}
			}

			self.outputMessage = function( message, messageClass ){
				messageHolder
					.removeClass('error show')
					.addClass( messageClass )
					.html( message );
			}

			self.formClick = function( event ){
				event.stopPropagation();
			}

			self.searchAjaxInstancer = new CherryJsCore.CherryAjaxHandler(
				{
					handlerId: settings.searchHandlerId,
					successCallback: self.successCallback,
					errorCallback: self.errorCallback
				}
			);

			$( settings.inputClass, self )
				.on( 'input', self.inputChangeHandler )
				.on( 'focus', self.focusHandler );

			$( self )
				.on( 'click' + settings.searchFormWrapperClass, self.formClick );

			$( 'body' )
				.on( 'click' + settings.searchFormWrapperClass, self.hideList );

		} else {
			return 'is init: true';
		};
	}
}( jQuery ) )
