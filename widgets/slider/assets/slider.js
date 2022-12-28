(function( $ ){

	'use strict';

    const blockSlider = ($scope, $) => {
        if( $scope.length > 0 ){
            $('.block--image-slider').each(function(){
                var id = $(this).data('selector'),
                config = $(this).data('config');
                new Swiper( '#block_slider_'+id, config );
            })
        }
    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/slider.default', blockSlider );
    });

})(jQuery);