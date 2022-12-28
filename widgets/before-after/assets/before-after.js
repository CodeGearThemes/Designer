(function( $ ){

	'use strict';

    const beforeAfter = ($scope, $) => {
        if( $scope.length > 0 ){
            var before_text = $scope.find('.before_text').text();
			var after_text = $scope.find('.after_text').text();
			$scope.find('.block-before__after').twentytwenty({
				'before_label' : before_text,
				'after_label'  : after_text
			});
        }
    }

    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/before-after.default', beforeAfter );
    });

})(jQuery);