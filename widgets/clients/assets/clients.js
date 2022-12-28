(function( $ ){

	'use strict';

    const clientSlider = ($scope, $) => {
        if( $scope.length > 0 ){
            $('.block--clients-slider').each(function(){
                var id = $(this).data('selector'),
                config = $(this).data('config');
                new Swiper( '#clients_slider_'+id, config );
            })
        }
    }

    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/clients.default', clientSlider );
    });

})(jQuery);