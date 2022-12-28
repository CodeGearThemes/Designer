(function( $ ){

	'use strict';

    const testimonialSlider = ($scope, $) => {
        if( $scope.length > 0 ){
            $('.block-testimonial-slider').each(function(){
                var id = $(this).data('selector'),
                config = $(this).data('config');
                new Swiper( '#testimonial_slider_'+id, config );
            })
        }
    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/testimonial-slider.default', testimonialSlider );
    });

})(jQuery);
