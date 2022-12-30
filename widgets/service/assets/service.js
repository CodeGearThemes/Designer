(function( $ ){

	'use strict';

    const serviceSlider = ($scope, $) => {
        if( $scope.length > 0 ){
            $('.block--service-slider').each(function(){
                var id = $(this).data('selector'),
                config = $(this).data('config');
                new Swiper( '#service_slider_'+id, config );
            })
        }
    }

    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/service.default', serviceSlider );
    });

})(jQuery);