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

class Pricing_Table extends Widget_base{

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
		return 'pricing-table';
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
		return esc_html__( 'Pricing Table', 'designer' );
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
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Title', 'designer' ),
				'dynamic'=>[
					'active'=>true,
				]
			]
		);

        $this->add_control(
			'price',
			[
				'label' => esc_html__( 'Price', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'placeholder'=>'100'
			]
		);

        $this->add_control(
			'currency',
			[
				'label' => esc_html__( 'Currency', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '$', 'designer' ),
				'dynamic'=>[
					'active'=>true,
				]
			]
		);

		$this->add_control(
			'period',
			[
				'label' => esc_html__( 'Period', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '/mo', 'designer' ),
				'dynamic'=>[
					'active'=>true,
				]
			]
		);

        $this->add_control(
            'label',
          [ 
            'label'=> esc_html__('Label','designer'),
            'type'=>Controls_Manager::TEXT,
            'default'=>esc_html('new','designer')
          ]
        );

		$repeater = new Repeater();

		$repeater->add_control(
			'item_text',
			[
				'label' => esc_html__( 'Text', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Item Description' , 'designer' ),
				'label_block' => false,
				'dynamic' => [
					'active' => true,
				]
			]
		);

		$repeater->add_control(
			'excluded',
			[
				'label' => esc_html__( 'Excluded', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options'=>[
					'no'=>__('No','designer'),
					'yes'=>__('Yes','designer'),
				],
				'default'=>'no',
			]
		);


		$this->add_control(
			'items',
			[
				'show_label' => false,
				'label' => esc_html__( 'Items', 'designer' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'item_text' => esc_html__( 'item', 'designer' ),
					],
					[
						'item_text' => esc_html__( 'item', 'designer' ),
					]	
				],
			]
		);
		
        $this->end_controls_section();
		/* section for button */
        $this->start_controls_section(
			'button_settings',
			[
				'label' => esc_html__( 'Button', 'designer' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
            'button_text',
          [ 
            'label'=> esc_html__('Button Text','designer'),
            'type'=>Controls_Manager::TEXT,
            'default'=>esc_html('new','designer')
          ]
        );
		$this->add_control(
			'link',
			[
				'label' => __( 'Button Link', 'designer' ),
				'type' => Controls_Manager::URL,
				'label_block' => true,
				'placeholder' => 'Paste URL or type',
			]
		);

        $this->end_controls_section();
		/*section for button icon */ 
		$this->start_controls_section(
			'button_icon_settings',
			[
				'label' => esc_html__( 'Button Icon', 'designer' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
            'icon',
            [
                'label' => __( 'Scroll icon', 'designer' ),
                'type' => Controls_Manager::ICONS,
				'default' => [
                    'value' => 'fab fa-elementor',
                    'library' => 'fa-brands',
                ],
			]
		);

		$this->add_control(
			'layout',
			[
				'label'     => __( 'Layout', 'designer' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'left'        => __( 'Left', 'designer' ),
					'right'        => __( 'Right', 'designer' ),
				],
				'default'   => 'left',
			]
		);
		$this->end_controls_section();

		// Style Tab Start
		//Style for title 
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title Style', 'designer' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label' => __( 'Title Tag', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div'
				],
				'default' => 'h2',
			]
		);
		$this->add_control(
			'title_style',
			[
				'label' => esc_html__( 'Title Style', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt-container .pt-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[   'label'=>'Title Typography',
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .pt-container .pt-title',
			]
		);

		$this->add_control(
            'title_margin',
            [
                'label'      => __( 'Title Margin', 'designer' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .pt-container .pt-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->end_controls_section();

		//Style for Price 
		$this->start_controls_section(
			'section_price_style',
			[
				'label' => esc_html__( 'Price Style', 'designer' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'price_color',
			[
				'label' => esc_html__( 'Price Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt-container .pt-price .pt-price-wrapper .pt-price-value' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[   'label'=>'Price Typography',
				'name' => 'price_typography',
				'selector' => '{{WRAPPER}} .pt-container .pt-price .pt-price-wrapper .pt-price-value',
			]
		);

		$this->add_control(
			'currency_color',
			[
				'label' => esc_html__( 'Currency Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt-container .pt-price .pt-price-wrapper .pt-price-currency' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[   'label'=>'Currency Typography',
				'name' => 'currency_typography',
				'selector' => '{{WRAPPER}} .pt-container .pt-price .pt-price-wrapper .pt-price-currency',
			]
		);

		$this->add_control(
			'currency_position',
			[
				'label'=>__('Currency Position', 'designer'),
				'type'=>Controls_Manager::SELECT,
				'options'=>[
					'row'=>esc_html__('Left from Price','designer'),
					'row-reverse'=>esc_html__('Right from Price','designer')
				],
				'default'=>'row',
				'selectors'=>[
					'{{WRAPPER}} .pt-container .pt-price .pt-price-wrapper .pt-price-currency'=>'flex-direction:{{VALUE}}',
				],
			]
		);

		$this->add_control(
			'period_color',
			[
				'label' => esc_html__( 'Period Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt-container .pt-price .pt-price-wrapper .pt-price-period' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[   'label'=>'Period Typography',
				'name' => 'period_typography',
				'selector' => '{{WRAPPER}} .pt-container .pt-price .pt-price-period',
			]
		);

		$this->add_control(
            'price_margin',
            [
                'label'      => __( 'Price Margin', 'designer' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .pt-container .pt-price .pt-price-wrapper .pt-price-value' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->add_control(
            'currency_margin',
            [
                'label'      => __( 'Currency Margin', 'designer' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .pt-container .pt-price .pt-price-wrapper .pt-price-currency' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->add_control(
            'period_margin',
            [
                'label'      => __( 'Period Margin', 'designer' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .pt-container .pt-price .pt-price-period' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
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
		$items=$settings['items'];
		$title_tag=$settings['title_tag'];
		// echo "<pre>";
		// print_r($settings);
		// echo "</pre>";
		// die();
		?>
			<div class="pt-container">
				<?php $title_tag = isset($title_tag) && !empty($title_tag) ? $title_tag : 'h2'; 
					  if(!empty($settings['title'])){ ?>
						<<?php echo esc_attr($title_tag); ?> class="pt-title"> 
							<?php echo esc_html($settings['title']); ?>
						</<?php echo esc_attr($title_tag); ?>>
					<?php } ?>
				<div class="pt-price">
					<div class="pt-price-wrapper">
						<span class="pt-price-currency"><?php echo esc_html($settings['currency']);?></span>
						<span class="pt-price-value"><?php echo esc_html($settings['price']);?></span>
					</div>
					<span class="pt-price-period"><?php echo esc_html($settings['period']); ?></span>
				</div>
				<ul>
					<?php foreach($items as $item) {?>
					<li>
						<span class="pt-li-icon"></span>
						<span><?php echo esc_html($item['item_text']); ?> </span>
					</li>
					<?php } ?>
				</ul>
				<div class="pt-button-container">
					<a href=#>
						<span class="pt-button-text">Click here</span>
						<span class="pt-button-icon">
							<span class="pt-button-icon-inner">
								<i aria-hidden="true" class="far fa-address-book"></i>
							</span>		
						</span>
					</a>
				</div>
				<span class="pt-label"><?php echo esc_html($settings['label']);?></span>
			</div>
		<?php

    }

}