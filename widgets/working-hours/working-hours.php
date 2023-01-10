<?php 

namespace Designer\Widgets\Pricing_Table;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

class Working_Hours extends Widget_base{
    /**
	 * Get widget name.
	 *
	 * Retrieve list widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'working-hours';
	}

    /**
	 * Get widget title.
	 *
	 * Retrieve list widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Working Hours', 'designer' );
	}

    /**
	 * Get widget icon.
	 *
	 * Retrieve list widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-elementor';
	}

    /**
	 * Get custom help URL.
	 *
	 * Retrieve a URL where the user can get more information about the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget help URL.
	 */
	public function get_custom_help_url() {
		return 'https://developers.elementor.com/docs/widgets/';
	}

    /**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the list widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'designer' ];
	}

     /**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the list widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return ['working hours', 'working', 'hours' ];
    }

    /**
	 * Register list widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
    protected function register_controls(){
        $this->start_controls_section(
			'general_settings',
			[
				'label' => esc_html__( 'General', 'designer' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Subtitle', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Example Subtitle', 'designer' ),
				'dynamic'=>[
					'active'=>true,
				]
			]
		);

         $this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Example Title', 'designer' ),
				'dynamic'=>[
					'active'=>true,
				]
			]
		);

        $this->add_control(
			'text',
			[
				'label' => esc_html__( 'TEXT', 'designer' ),
				'type' => Controls_Manager::WYSIWYG,
                'label_block'=>true,
				'default' => esc_html__( 'Enter your text here.', 'designer' ),
				'dynamic'=>[
					'active'=>true,
				]
			]
		);

        $this->end_controls_section();
    }

    protected function render(){
        $settings=$this->get_settings_for_display(); ?>
        <h1>Working hours </h1>
    <?php }

}