<?php 

namespace Designer\Widgets\Drop_Cap;

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


class Drop_Cap extends Widget_base {

    public function __construct($data =[], $args = null){
        parent::__construct($data, $args);
        wp_register_style('drop-cap',\Designer::plugin_url().'widgets/drop-cap/assets/css/dropcap.css',array(),'1.0.0','all');
        wp_enqueue_style('drop-cap');
    }

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
		return 'drop-cap';
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
		return esc_html__( 'Drop Cap', 'designer' );
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
		return ['drop', 'drop cap' ];
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
			'title',
			[
				'label' => esc_html__( 'Text', 'designer' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'designer' ),
			]
		);

		$this->end_controls_section();

		// Content Tab End


		// Style Tab Start

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'designer' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'letter_color',
			[
				'label' => esc_html__( 'Letter Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .designer-letter' => 'color: {{VALUE}};',
				],
			]
		);
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[   'label'=>'Letter Typography',
				'name' => 'letter_typography',
				'selector' => '{{WRAPPER}} .designer-letter',
			]
		);

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'background_type',
                'label'    => __( 'Background type', 'designer' ),
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .drop-cap-content .designer-letter',
            ]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => esc_html__( 'Border', 'designer' ),
				'selector' => '{{WRAPPER}} .designer-letter',
			]
		);

        $this->add_control(
			'letter_border_radius',
			[
				'label' => esc_html__( 'Letter Border radius', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .designer-letter' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'letter_stroke_effect',
			[
				'label'=>esc_html__('Letter Stroke Effect','designer'),
				'type'=>Controls_Manager::SELECT,
				'options'=>[
					'yes'=>__('Yes','designer'),
					'no'=>__('No','designer'),
				],
				'default'=>'no',
			]
		);

		$this->add_control(
			'letter-stroke-color',
			[
				'type'=>Controls_Manager::COLOR,
				'label'=>'Letter Stroke Color',
				'selectors'=>[
					'{{WRAPPER}} .drop-cap-content .designer-letter' =>'-webkit-text-stroke-color: {{VALUE}};',
				],
				'condition'=>[
					'letter_stroke_effect'=>'yes',
				]
			]
		);

		$this->add_control(
		'letter-stroke-width',
		[
			'type'=>Controls_Manager::NUMBER,
			'label'=>'Letter Stroke Width',
			'selectors'=>[
				'{{WRAPPER}} .drop-cap-content .designer-letter' =>'-webkit-text-stroke-width: {{VALUE}}px;',
			],
			'condition'=>[
				'letter_stroke_effect'=>'yes',
			]
		]
		);

		$this->add_control(
			'letter_clip_effect',
			[
				'label'=>__('Letter Clip Effect','designer'),
				'type'=>Controls_Manager::SELECT,
				'options'=>[
					'yes'=>__('Yes','designer'),
					'no'=>__('No','designer'),
				],
				'default'=>'no',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
                'name'     => 'clip_background_type',
                'label'    => __( 'Background type', 'designer' ),
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .drop-cap-content .designer-letter',
				'condition'=>[
					'letter_clip_effect'=>'yes'
				]
            ]
		);

		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .designer-text' => 'color: {{VALUE}};',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[   'label'=>'Text Typography',
				'name' => 'text_typography',
				'selector' => '{{WRAPPER}} .designer-text',
			]
		);

		$this->end_controls_section();

    }

     /**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings=$this->get_settings_for_display();
        $text= $settings['title']; 
		?>
        <div class="drop-cap-content <?php echo $settings['letter_stroke_effect']=='yes'? 'drop-cap-letter-stroke-effect':''; echo $settings['letter_clip_effect']=='yes'?'drop-cap-letter-clip-effect':''; ?>">
            <?php if(!empty($text)){
                ?>
                    <span class="designer-letter">
                        <?php echo esc_html( substr( $text, 0, 1 ) ); ?>
                    </span>
                    <p class="designer-text">
                        <?php  echo esc_html(substr($text, 1)) ;?>
                    </p>
            <?php } ?>
        </div>
        <?php
    }
}