/*jshint forin:true, noarg:true, noempty:true, eqeqeq:true, bitwise:true, strict:true, undef:true, unused:true, curly:true, browser:true, jquery:true, indent:4, maxerr:50 */
/* global _, WebmarketPriceSlider */

//  ==========
//  = Custom JS and jQuery =
//  ==========
// variables

jQuery(document).ready(function($) {
	'use strict';

	/**
	 * Below the first responsive break we assume touch behaviour
	 */
	var isBelowDesktopSize = function() {
		return $(window).width() < 980 ? true : false;
	};


	/**
	 * Append the right class to the document
	 */
	var determineScreenClass = function() {
		$('html').toggleClass('large-screen', !isBelowDesktopSize());
	};


	/**
	 * Smooth scroll to the top of the page & scroll menu
	 */
	$('#toTheTop').click(function() {
		$('html, body').animate({
			scrollTop: 0
		}, 2e3);
		return false;
	});
	$('#spyMenu a').click(function() {
		var $this = $(this);
		$('html, body').animate({
			scrollTop: $($this.attr('href')).offset().top - 70
		}, 700);
		return false;
	});

	/**
	 * Carousel
	 */
	$(window).load(function() {
		var configuration = {
			debug: false,
			auto: {
				play: false
			},
			width: '100%',
			height: 'variable',
			items: {
				height: 'variable'
			},
			prev: {},
			next: {},
			pagination: {},
			scroll: {
				duration: 1e3,
				items: 1
			},
			transition: true
		};
		$('.carouFredSel').each(function() {
			var $this = $(this);
			// prev and next buttons
			configuration.prev.button = $('#' + $this.data('nav') + 'Left');
			configuration.next.button = $('#' + $this.data('nav') + 'Right');
			// responsive param
			if ($this.data('responsive')) {
				configuration.responsive = true;
			} else {
				configuration.responsive = false;
			}
			// autoplay param
			if (true === $this.data('autoplay')) {
				configuration.auto.play = true;
			}
			// onCreate the slides should not be wider than the container, no matter what
			configuration.onCreate = function() {
				$this.find('.slide').css({
					width: $this.parent().width()
				});
			};
			// RUN THE CAROUSEL
			$this.carouFredSel(configuration);
		});
	});



	//  ==========
	//  = Revolution Slider =
	//  ==========
	if (jQuery().revolution) {
		var $mainSlider = $('.fullwidthbanner').revolution({
			delay: 1e4,
			startheight: 377,
			startwidth: 1400,
			navigationType: 'bullet',
			navigationStyle: 'round',
			navigationVAlign: 'bottom',
			touchenabled: 'on',
			onHoverStop: 'on',
			navigationArrows: 'none',
			soloArrowLeftHalign: 'left',
			soloArrowLeftValign: 'center',
			soloArrowRightHalign: 'right',
			soloArrowRightValign: 'center',
			navigationVOffset: $('body').hasClass('boxed') ? 10 : 60,
			navOffsetHorizontal: 0,
			navOffsetVertical: 20,
			// no captions for mobile devices
			hideAllCaptionAtLilmit: 481,
			hideSliderAtLimit: 300,
			stopAtSlide: -1,
			stopAfterLoops: -1,
			shadow: 0,
			fullWidth: 'on'
		});

		$('#sliderRevLeft').on('click', function() {
			$mainSlider.revprev();
			return false;
		});
		$('#sliderRevRight').on('click', function() {
			$mainSlider.revnext();
			return false;
		});

	}


	//  ==========
	//  = Accordion group toggle classes =
	//  ==========
	$('.accordion-group .accordion-toggle').click(function() {
		var $accordionGroup = $(this).parent().parent();
		if ($accordionGroup.hasClass('active')) {
			$accordionGroup.removeClass('active');
		} else {
			$accordionGroup.addClass('active').siblings().removeClass('active');
		}
	});



	//  ==========
	//  = Nav Search =
	//  ==========
	$(document).on('focus', '.large-screen .js-nav-search', function() {
		$(this).parent().parent().addClass('search-mode');
		repositionLine();
	});
	$(document).on('blur', '.large-screen .js-nav-search', function() {
		$(this).parent().parent().removeClass('search-mode');
		repositionLine();
	});
	var repositionLine = function() {
		setTimeout(function() {
			$('#mainNavigation > li.current-menu-item, #mainNavigation > .current-menu-ancestor').trigger('mouseover');
		}, 200);
	};



	//  ==========
	//  = Navbar stays at the top when scrolled down =
	//  ==========
	var stickyNavbar = function() {
		if (isBelowDesktopSize()) {
			$(window).off('scroll.onlyDesktop');
		} else {
			var $headerHeight = $('#header').height(),
				$navbarHeight = $('#stickyNavbar').height();

			$(window).on('scroll.onlyDesktop', function() {
				var scrollX = $(window).scrollTop();
				if (scrollX > $headerHeight) {
					$('#stickyNavbar').removeClass('navbar-static-top').addClass('navbar-fixed-top');
					$('.large-screen #header').css({
						marginBottom: $navbarHeight
					});
				} else {
					$('#stickyNavbar').removeClass('navbar-fixed-top').addClass('navbar-static-top');
					$('.large-screen #header').css({
						marginBottom: 0
					});
				}
			});
		}
	};



	//  ==========
	//  = Thumbnail selector =
	//  ==========
	$('.product-preview .thumbs a').click(function(ev) {
		ev.preventDefault();
		$($(this).attr('href')).attr('src', $(this).find('img').attr('src'));
		$(this).parent().addClass('active').siblings('.active').removeClass('active');
	});



	//  ==========
	//  = Forms =
	//  ==========
	$('.qty-selection-with-controls > .clickable').click(function(ev) {
		ev.preventDefault();
		var number = parseInt($(this).siblings('input[type="text"]').val(), 10);
		if (isNaN(number)) {
			number = 1;
		}
		if ($(this).hasClass('add-one')) {
			$(this).siblings('input[type="text"]').val(number + 1);
		} else {
			number = number < 2 ? 2 : number;
			$(this).siblings('input[type="text"]').val(number - 1);
		}
	});


	//  ==========
	//  = Filters for WooCommerce =
	//  ==========
	(function() {
		var $filterForm     = $( '.js--filter-form-webmarket' ),
			getFilterData = function () {

			var $hiddenFields = $( '.js--filter-form-webmarket-fields' );

			$hiddenFields.empty();

			$( '.filter-attribute' ).each( function() {
				var attribute = $( this ).attr( 'data-attribute' );
				var content   = [];
				$( 'input[data-attribute="' + attribute + '"]:checked' ).each( function() {
					content.push( $( this ).val() );
				} );

				if ( content.length ) {
					$hiddenFields.append( '<input type="hidden" name="' + attribute + '" value="' + content.join( ',' ) + '" />' );
				}
			} );
		};

		$( 'input[data-attribute]' ).on( 'change', function() {
			getFilterData();
		} );

		$filterForm.on( 'submit.tmpDisable', function( ev ) {
			ev.preventDefault();
			getFilterData();
			$filterForm.off( 'submit.tmpDisable' );
			$filterForm.submit();
		} );
	})();



	//  ==========
	//  = Check all the children for shop filter categories =
	//  ==========
	(function() {
		$( '.js--categories-checkboxes' ).on( 'change', '.js--cat', function () {
			var $this     = $(this),
				$children = $this.parent().siblings( '.js--categories-checkboxes' ).find( '.js--cat' );

			if ( $this.is(':checked') ) {
				$children.prop( 'checked', true );
			} else {
				$children.prop( 'checked', false );
			}
		} );
	})();



	//  ==========
	//  = Cart =
	//  ==========
	$('body').on('added_to_cart', function() {
		$('.js--cart-container').addClass('opened-via-js');
		setTimeout(function () {
			$('.js--cart-container').removeClass('opened-via-js');
		}, 1200);
	});



	//  ==========
	//  = Checkout Process Effects =
	//  ==========
	// delete the item from review table
	$('.table-items .icon-remove-sign').click(function() {
		var elmToRemove = $(this).parents('tr');
		if( !! $(this).data('delete-next') ) {
			elmToRemove = elmToRemove.add(elmToRemove.next());
		}
		elmToRemove.animate({
			opacity: 0
		}, 'swing', function() {
			$(this).remove();
		});

		return false;
	});
	$('.card-num-input').on('keyup', function() {
		if ($(this).val().length > 3) {
			$(this).next('.card-num-input').focus();
		}
	});
	$('.add-tooltip').tooltip({
		title: $(this).attr('data-title'),
		placement: 'right',
		trigger: 'manual'
	}).tooltip('show');



	//  ==========
	//  = Functions which has to be reinitiated when the window size is changed =
	//  ==========
	var triggeredOnResize = function() {
		if ($('html').hasClass('lt-ie9')) {
			// do never this for IE8
			return;
		}
		// rebuild carousels
		$('.carouFredSel').each(function() {
			var $this = $(this);
			$this.trigger('configuration', [ 'debug', false, true ]);
		});
		//  = Embedded video iframes =
		$('iframe[src*="vimeo.com"], iframe[src*="youtube.com"]').each(function() {
			var $this = $(this);
			if ($this.is(':visible')) {
				$this.css('height', parseInt($this.width() * $this.attr('height') / $this.attr('width'), 10));
			}
		});
		// sticky navbar
		stickyNavbar();


		//  ==========
		//  = Magic Line =
		//  ==========
		/**
		 * @see http://css-tricks.com/jquery-magicline-navigation/
		 */
		(function() {
			if( isBelowDesktopSize() ) {
				return;
			}

			var $el,
				leftPos,
				newWidth,
				$mainNav    = $('#mainNavigation'),
				$currentElm = $mainNav.find('> .current-menu-item');

			if($('#magic-line').length < 1) {
				$mainNav.prepend('<li id="magic-line"></li>');
			}
			var $magicLine = $('#magic-line');

			if (1 !== $currentElm.length) {
				$currentElm = $mainNav.find('> .current-menu-ancestor');
			}
			if (1 === $currentElm.length) {
				$magicLine.width($currentElm.width()).css('left', $currentElm.position().left).data('origLeft', $magicLine.position().left).data('origWidth', $magicLine.width());
				$(document).on({
					mouseenter: function() {
						$el      = $(this);
						leftPos  = $el.position().left;
						newWidth = $el.width();
						$magicLine.stop().animate({
							left:  leftPos,
							width: newWidth
						});
					},
					mouseleave: function() {
						$magicLine.stop().animate({
							left:  $magicLine.data('origLeft'),
							width: $magicLine.data('origWidth')
						});
					}
				}, '.large-screen #mainNavigation > li');
			}
		})();

		// width of carousel slides
		$('.carouFredSel').each(function() {
			var $this = $(this);
			$this.find('.slide').css({
				width: $this.parent().width()
			});
			$this.trigger('configuration', [ 'debug', false, true ]);
		});

		// position of the bullets in the slider revolution
		if ($(window).width() < 768) {
			$('.fullwidthbanner-container .tp-bullets').css({
				bottom: 10
			});
		}


		var recalculateFromBottom = function() {
			if ( !isBelowDesktopSize() ) {
				$('.large-screen #spyMenu').affix({
					offset : {
						top: $('.large-screen #spyMenu').offset().top - 70,
						bottom: function() {
							return $('footer').outerHeight(true) + 30;
						}
					}
				});
			}
			setTimeout(recalculateFromBottom, 2000); // recalculate every 2 seconds
		};
		if($('#spyMenu').length > 0) {
			recalculateFromBottom();
		}

	};
	var fromLastResize;
	// counter in miliseconds
	$(window).resize(function() {
		determineScreenClass();
		clearTimeout(fromLastResize);
		fromLastResize = setTimeout(function() {
			triggeredOnResize();
		}, 250);
	});

	$(window).on('scroll', function() {
		if( $('#spyMenu').hasClass('affix-bottom') ) {
			$('#spyMenu').css({
				bottom: $('footer').outerHeight(true) + 30
			});
		} else {
			$('#spyMenu').removeAttr('style');
		}
	});


	//  ==========
	//  = The language and currency switcher =
	//  ==========
	$('.js-selectable-dropdown').on('click', '.js-possibilities a', function (ev) {
		if( '#' === $(this).attr('href') ) {
			ev.preventDefault();
			var parent = $(this).parents('.js-selectable-dropdown');
			parent.find('.js-change-text').html($(this).html());
		}
	});

	//  ==========
	//  = Last but not the least - trigger the page scroll and resize =
	//  ==========
	$(window)
		.trigger('scroll')
		.trigger('resize');

});