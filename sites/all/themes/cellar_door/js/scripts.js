var locale = {
  CLOSE: {
    ca: "Tanca",
    es: "Cerrar",
    en: "Close"
  },
  COOKIES_MESSAGE: {
    ca: "El nostre portal web utilitza cookies amb la finalitat de millorar l'experiència de l'usuari. Al fer servir els nostres serveis acceptes l'ús que fem de les 'cookies'.",
    es: "Nuestro sitio web utiliza cookies con el fin de mejorar la experiencia del usuario. Al utilizar nuestros servicios aceptas el uso que hacemos de las 'cookies'.",
    en: "Our web site uses cookies to improve the user experience. Using our services you agree to the use of the 'cookies'."
  },
  COOKIES_MORE_INFO: {
  	ca: "Més informació",
    es: "Más información",
    en: "More information"
  },
  COOKIES_ACCEPT: {
  	ca: "Accepta política de cookies",
    es: "Aceptar política de cookies",
    en: "Accept cookies policy"
  },
  COOKIES_ACCEPT_SHORT: {
    ca: "Accepta",
    es: "Aceptar",
    en: "Accept"
  }
}
var config = {
  LANGUAGE: 'ca',
  THEME_URL: '/sites/all/themes/MY_THEME/',
  WINDOW_MEASURES: [],
  RESIZE_THRESHOLD: 20 //miliseconds
};

(function($){
	// ON READY
	$(window).ready(function(){
		// this always on top
		config.LANGUAGE = $('html').attr('lang');
    setWindowMeasures();
    //-------------------

		// For all links with rel external, open link in new tab
	  $('body').on('click', 'a[rel="external"]', function(e){
	  	e.preventDefault();
      window.open($(this).attr('href'));
	  });

	  // cookies
	  /*if (getCookie('cookie_message') != 'accepted'){
	    $('#page').prepend('<div class="cookies-message"><p>'+locale.COOKIES_MESSAGE[config.LANGUAGE]+' <a href="/node/650">'+locale.COOKIES_MORE_INFO[config.LANGUAGE]+'</a><button data-action="close" title="'+locale.CLOSE[config.LANGUAGE]+'">X</button></p></div>');
	    setCookie('cookie_message', 'accepted', 90);
	    var $cookies_message = $('.cookies-message');
	    $cookies_message.on('click', 'button[data-action="close"]', function(e){
	      e.preventDefault();
	      $cookies_message.fadeOut(300);
	    });
	  }*/

	  // tabs
	  /*var most_tabs = new GrouppedTabs(
			{
		    selector: '.pane-omitsis-weloba-most-block .most-block',
		  	block_name: 'tabs-most'
		  }
		);
	  most_tabs.init();*/
	  
	  // responsive menu
	  /*$('#page').prepend('<div class="mobile-menu"><button data-action="open-mobile-menu">Menu</button></div>');
	  var $mobile_menu = $('.mobile-menu');
	  var $main_menu = $('#block-system-main-menu > .content');
	  $mobile_menu.append($main_menu.html());
	  $('button[data-action="open-mobile-menu"]').click(function(e){
	    $mobile_menu.toggleClass('opened');
	  });*/

	});

	// ON LOAD
	$(window).load(function(){
		// FOR ALL IMAGE LOADING DEPENDANT SCRIPTS
	});

	// ON RESIZE
  $(window).resize(debounce(onWindowResize, config.RESIZE_THRESHOLD)); // for all events that trigger continuosly, we debounce the functions called, for a better performance

  // This is done exclusively for the people who loves to see if the site is responsive :P
  function onWindowResize(){
    // this first
    setWindowMeasures();
    // and then the rest to respond to these measures:
    // ...
  }

  function setWindowMeasures(){
    config.WINDOW_MEASURES = [window.innerWidth, window.innerHeight];
  }
})(jQuery);
