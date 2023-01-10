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

	public function __construct($data=[], $args =null){
		parent::__construct($data, $args);
		wp_register_style('pricing-table',\Designer::plugin_url().'widgets/pricing-table/assets/css/pricing-table.css',array(),'1.0.0','all');

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
     * Widget Style.
     *
     * @return string
     */
    public function get_style_depends() {
        return [ 'pricing-table' ];
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

		/* section for button starts here*/
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
		/* section for button ends here*/

		/*section for button icon */ 
		$this->start_controls_section(
			'button_icon_settings',
			[
				'label' => esc_html__( 'Button Icon', 'designer' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
            'button_icon',
            [
                'label' => __( 'Icon', 'designer' ),
                'type' => Controls_Manager::ICONS,
			]
		);

		$this->add_control(
			'icon_position',
			[
				'label'     => __( 'Icon Position', 'designer' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'left'        => __( 'Left', 'designer' ),
					'right'        => __( 'Right', 'designer' ),
				],
				'default'   => 'left',
			]
		);
		$this->end_controls_section();
		/*section for button icon ends here*/ 

		/* Style Tab Start
		Style for title start here */
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
			[   'label'=>esc_html__('Title Typography','designer'),
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
                    '{{WRAPPER}} .pt-container .pt-title' => 'margin:{{TOP}}{{UNIT}}{{RIGHT}}{{UNIT}}{{BOTTOM}}{{UNIT}}{{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->end_controls_section();
		/*Style for title ends here */

		/*Style for Price starts here*/
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
			[   'label'=>esc_html__('Currency Typography','designer'),
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
					'{{WRAPPER}} .pt-container .pt-price .pt-price-wrapper'=>'flex-direction:{{VALUE}}',
				],
			]
		);

		$this->add_control(
			'period_position',
			[
				'label'=>__('Period Position','designer'),
				'type' => Controls_Manager::SELECT,
				'options'=>[
					'side'=>esc_html__('Side','designer'),
					'bottom'=>esc_html__('Botton','designer'),
				],
				'default_value'=>'side',
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
			[   'label'=>esc_html__('Period Typography','designer'),
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
		/* Style for price ends here*/

		/* Style for List starts here */
		$this->start_controls_section(
			'section_list_style',
			[
				'label' => esc_html__( 'List Style', 'designer' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'list_type',
			[
				'label' => esc_html__('List Type','designer'),
				'type' =>Controls_Manager::SELECT,
				'options'=>[
					'unordered'=>__('Unordered','designer'),
					'ordered'=>__('Ordered','designer'),
					'none'=>__('none', 'designer'),
				],
				'default'=>'unordered',

			]
		);

		$this->add_control(
			'items_icon',
			[
				'label' => __( 'Items Icon', 'designer' ),
                'type' => Controls_Manager::ICONS,
				'default' => [
                    'value' => 'fab fa-elementor',
                    'library' => 'fa-brands',
                ],
				'condition'=>[
					'list_type'=>'unordered'
				]
			]
		);

		$this->add_control(
			'items_icon_color',
			[
				'label'=>__('Items Icon Color','designer'),
				'type'=>Controls_Manager::COLOR,
				'selectors'=>[
					'{{WRAPPER}} .pt-li-icon'=>'color:{{VALUE}}'
				],
				'condition'=>[
					'list_type'=>'unordered'
				]
			]
		);

		$this->add_control(
			'items_icon_size',
			[
				'label'=>__('Items Icon Size', 'designer'),
				'type'=>Controls_Manager::SLIDER,
				'size_units'=>['px','em'],
				'default'   => [
					'size' => 50,
					'unit' => 'px'
				],
				'selectors'=>[
					'{{WRAPPER}} .pt-li-icon'=>'font-size:{{SIZE}}{{UNIT}}'
				],
				'condition'=>[
					'list_type'=>'unordered',
				]
			]
		);

		$this->add_control(
			'items_icon_margin_right',
			[
				'label'=>__('Items Icon Margin Right','designer'),
				'type'=>Controls_Manager::SLIDER,
				'size_units'=>['px','em','%'],
				'default'=>[
					'size'=>50,
					'unit'=>'px'
				],
				'selectors'=>[
					'{{WRAPPER}} .pt-li-icon'=>'margin-right:{{SIZE}}{{UNIT}};',
				],
				'condition'=>[
					'list_type'=>'unordered',
				]
			]
		);

		$this->add_control(
			'icon_vertical_offset',
			[
				'label'=>__('Icon Vertical Offset','designer'),
				'type'=>Controls_Manager::SLIDER,
				'size_units'=>['px','em'],
				'range'=>[
					'px'=>[
						'min'=>-50,
						'max'=>50,
					],
					'em'=>[
						'min'=> -10,
						'max'=> 10,
					]
					],
					'selectors'=>[
						'{{WRAPPER}} .pt-li-icon' =>'transform:translateY({{SIZE}}{{UNIT}});'
					],
					'condition'=>[
						'list_type'=>'unordered'
					]
			]
		);

		$this->end_controls_section();
		/* style for List ends here */

		/*style for label starts here */
		$this->start_controls_section(
			'section_label_style',
			[
				'label'=> esc_html__('Label Style', 'designer'),
				'tab'=>Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'label_type',
			[
				'label'=>__('Label Badge','designer'),
				'type'=>Controls_Manager::SELECT,
				'options'=>[
					'badge'=>__('Badge','designer'),
					'ribbon'=>__('Ribbon','designer'),
				],
				'default'=>'badge',
			]
			);
		
		$this->add_control(
			'label_color',
			[
				'label'=>esc_html__('Label Color','designer'),
				'type'=>Controls_Manager::COLOR,
				'selectors'=>[
					'{{WRAPPER}} .pt-label'=>'color:{{VALUE}}'
				],
			]
		);
		$this->add_control(
			'label_background_color',
			[
				'label'=>esc_html__('Label Background Color','designer'),
				'type'=>Controls_Manager::COLOR,
				'selectors'=>[
					'{{WRAPPER}} .pt-label'=>'background-color:{{VALUE}}'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[   'label'=>esc_html__('Label Typography','designer'),
				'name' => 'label_typography',
				'selector' => '{{WRAPPER}} .pt-container .pt-label',
			]
		);

		$this->add_control(
			'label_padding',
			[
				'label'=>esc_html__('Label Padding','designer'),
				'type'=>Controls_Manager::DIMENSIONS,
				'size_units'=>['px','%'],
				'selectors'=>['{{WRAPPER}} .pt-label' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
			]
		);

		$this->add_control(
			'label_border_radius',
			[
				'label'=>esc_html__('Label Border Radius','designer'),
				'type'=>Controls_Manager::DIMENSIONS,
				'size_units'=>['px','%'],
				'selectors'=>['{{WRAPPER}} .pt-label'=>'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
				'condition'=>[
					'label_type'=>'badge',
				]
			],
		);
		$this->add_control(
			'label_position',
			[
				'label'=>esc_html__('Label Position', 'designer'),
				'type'=>Controls_Manager::DIMENSIONS,
				'size_units'=>['px','%'],
				'selectors'=>['{{WRAPPER}} .pt-label'=>'top:{{TOP}}{{UNIT}}; right:{{RIGHT}}{{UNIT}}; '],
			]
		);

		$this->end_controls_section();
		/*style for label ends here */

		/*style for Table start here */
		$this->start_controls_section(
			'section_table_style',
			[
				'label'=>esc_html__('Table Style','designer'),
				'tab'=>Controls_Manager::TAB_STYLE,
			]
			);
		
		$this->add_responsive_control(
            'table-alignment',
            [
                'label'     => __( 'Alignment', 'designer' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left' => [
                        'title' => __( 'Left', 'designer' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'designer' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .pt-container' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .pt-container .pt-price' => 'justify-content: {{VALUE}}; align-items:{{VALUE}};',
					'{{WRAPPER}} .pt-container .pt-button-container'=>'justify-content:{{VALUE}};'
                ],
            ]
        );

		$this->add_control(
			'table_background_color',
			[
				'label'=>esc_html__('Background Color', 'designer'),
				'type'=>Controls_Manager::COLOR,
				'selectors'=>[
					'{{WRAPPER}} .pt-container'=>'background-color:{{VALUE}};'
				],
			]
		);

		$this->add_control(
			'table_border_type',
			[
				'label'=>esc_html__('Border Type', 'designer'),
				'type'=>Controls_Manager::SELECT,
				'options'=>[
					'default'=>__('Default','designer'),
					'none'=>__('None','designer'),
					'solid'=>__('Solid','designer'),
					'double'=>__('Double','designer'),
					'dotted'=>__('dotted','designer'),
					'dashed'=>__('Dashed','designer'),
					'groove'=>__('Groove','designer'),
				],
				'default'=>'none',
				'selectors'=>[
					'{{WRAPPER}} .pt-container'=>'border-style:{{VALUE}};'
				],
			]
		);

		$this->add_control(
			'table_border_width',
			[
				'label'=>__('Width','designer'),
				'type'=>Controls_Manager::DIMENSIONS,
				'selectors'=>[
					'{{WRAPPER}} .pt-container'=>'border-width:{{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;'
				],
			]
		);

		$this->add_control(
			'table_border_width',
			[
				'label'=>__('Color', 'designer'),
				'type'=>Controls_Manager::COLOR,
				'selectors'=>[
					'{{WRAPPER}} .pt-container'=>'border-color:{{VALUE}}'
				],
			]
		);

		$this->add_control(
			'table_border_radius',
			[
				'label'=>__('Border Radius', 'designer'),
				'type'=>Controls_Manager::DIMENSIONS,
				'size_units'=>['px','%'],
				'selectors'=>[
					'{{WRAPPER}} .pt-container'=>'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
				);

		$this->end_controls_section();
		/*style for Table end here */

		/*style for the button starts here*/
		$this->start_controls_section(
			'section_button_style',
			[
				'label'=>__('Button', 'designer'),
				'tab'=>Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[   
				'label'=>esc_html__('Typography','designer'),
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .pt-container .pt-button-container',
			]
		);
		$this->start_controls_tabs('button_tabs');
		$this->start_controls_tab(
			'button_tab_normal',
			[
				'label'=>esc_html__('Normal','designer'),
			]
		);
		$this->add_control(
			'button_text_color',
			[
				'label'=>esc_html__('Text Color', 'designer'),
				'type'=>Controls_Manager::COLOR,
				'selectors'=>[
					'{{WRAPPER}} .pt-button-container .pt-button-text'=>'color:{{VALUE}};'
				]
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'=>esc_html__('Background Color', 'designer'),
				'type'=>Controls_Manager::COLOR,
				'selectors'=>[
					'{{WRAPPER}} .pt-button-container > a'=>'background:{{VALUE}};'
				]
			]
		);
		$this->end_controls_tab();
		
		$this->start_controls_tab(
			'button_tab_hover',
			[
				'label'=>esc_html__('Hover','designer'),
			]
		);
		$this->add_control(
			'button_text_hover_color',
			[
				'label'=>esc_html__('Text Hover Color', 'designer'),
				'type'=>Controls_Manager::COLOR,
				'selectors'=>[
					'{{WRAPPER}} .pt-button-container .pt-button-text:hover'=>'color:{{VALUE}};'
				]
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'=>esc_html__('Background Hover Color', 'designer'),
				'type'=>Controls_Manager::COLOR,
				'selectors'=>[
					'{{WRAPPER}} .pt-button-container > a:hover'=>'background:{{VALUE}};'
				]
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
	
		

		$this->add_control(
			'button_border_color',
			[
				'label'=>__('Border Color','designer'),
				'type'=>Controls_Manager::COLOR,
				'selectors'=>[
					'{{WRAPPER}} .pt-button-container'=>'border-color:{{VALUE}}'
				],
			]
		);

		$this->add_control(
			'button_border_type',
			[
				'label'=>esc_html__('Button Border Type', 'designer'),
				'type'=>Controls_Manager::SELECT,
				'options'=>[
					'none'=>__('None','designer'),
					'solid'=>__('Solid','designer'),
					'double'=>__('Double','designer'),
					'dotted'=>__('dotted','designer'),
					'dashed'=>__('Dashed','designer'),
					'groove'=>__('Groove','designer'),
				],
				'default'=>'none',
				'selectors'=>[
					'{{WRAPPER}} .pt-container .pt-button-container>a '=>'border-style:{{VALUE}};'
				],
			]
		);

		$this->add_control(
			'button_border_width',
			[
				'label'=>__('Border Width','designer'),
				'type'=>Controls_Manager::DIMENSIONS,
				'selectors'=>[
					'{{WRAPPER}} .pt-button-container>a'=>'border-width:{{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px'
				],
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'=>__('Border Radius','designer'),
				'type'=>Controls_Manager::DIMENSIONS,
				'size_units'=>['px','%'],
				'selectors'=>[
					'{{WRAPPER}} .pt-button-container>a'=>'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
				],
			]
		);

		$this->add_control(
			'button_padding',
			[
				'label'=>__('Padding','designer'),
				'type'=>Controls_Manager::DIMENSIONS,
				'size_units'=>['px','%'],
				'selectors'=>[
					'{{WRAPPER}} .pt-button-container>a'=>'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
				],
			]
		);

		$this->end_controls_section();
		/*style for the button ends here */

		/* style for button icon start here */
		$this->start_controls_section(
			'section_button_icon_style',
			[
				'label'=>__('Button Icon Style', 'designer'),
				'tab'=>Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'button_icon_size',
			[
				'label'=>__('Icon Size', 'designer'),
				'type'=>Controls_Manager::SLIDER,
				'size_units'=>['px','em','rem','vw'],
				'selectors'=>[
					'{{WRAPPER}} .pt-button-icon-inner>i'=>'font-size:{{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_control(
			'button_icon_color',
			[
				'label'=>__('Icon Color','designer'),
				'type'=>Controls_Manager::COLOR,
				'selectors'=>[
					'{{WRAPPER}} .pt-button-icon-inner>i'=>'color:{{VALUE}};'
				]
			]
		);

		$this->add_control(
			'button_icon_background_color',
			[
				'label'=>__('Icon Background Color', 'designer'),
				'type'=>Controls_Manager::COLOR,
				'selectors'=>[
					'{{WRAPPER}} .pt-button-icon'=>'background-color:{{VALUE}};'
				]
			]
		);

		$this->end_controls_section();
		/*style for button icon ends here */

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
			<div class="pt-container <?php echo $settings['label_type'] =='ribbon'?'pt-label-type--ribbon':'pt-label-type--badge';?>">
				<!-- html for title starts here -->
				<?php $title_tag = isset($title_tag) && !empty($title_tag) ? $title_tag : 'h2'; 
					  if(!empty($settings['title'])){ ?>
						<<?php echo esc_attr($title_tag); ?> class="pt-title"> 
							<?php echo esc_html($settings['title']); ?>
						</<?php echo esc_attr($title_tag); ?>>
					<?php } ?>
				<!-- html for price ends here -->

				<!-- html for price starts here -->
				<?php if($settings['price'] !== '') {?>	
					<div class="pt-price <?php echo $settings['period_position'] == 'bottom'? 'pt-period-bottom':'';?>">
						<div class="pt-price-wrapper">
							<?php if(!empty($settings['currency'])) { ?>
								<span class="pt-price-currency"><?php echo esc_html($settings['currency']);?></span>
							<?php } ?>
							<span class="pt-price-value"><?php echo esc_html($settings['price']);?></span>
						</div>
						<?php if(!empty($settings['period'])) { ?>
							<span class="pt-price-period"><?php echo esc_html($settings['period']); ?></span>
						<?php } ?>	
					</div>
				<?php } ?>
				<!-- html for price ends here -->

				<!-- content html starts here -->
				<<?php echo $settings['list_type']=='unordered'? "ul": "ol";?> class="pt-content <?php echo $settings['list_type']=='none'?'pt-lt-style-none':''; ?>" >
					<?php foreach($items as $item) {//var_dump($item);?>
						<li class="pt-items <?php echo $settings['list_type']=='unordered' && !empty($settings['items_icon'])?'pt-lt-style-none':'';?>" <?php echo $item['excluded']=='yes'?'data-exclude=pt-excluded-item':'';?>>
							<?php if($settings['list_type']=='unordered' && !empty($settings['items_icon'])) { ?>
								<span class="pt-li-icon"><?php \Elementor\Icons_Manager::render_icon($settings['items_icon'],array('aria-hidden'=>'true'));?></span>
							<?php } ?>	
							<span class="pt-li-item-text"><?php echo esc_html($item['item_text']); ?> </span>
						</li>
					<?php } ?>
				</ul>
				<!-- content html ends here -->

				<!--Button html starts here -->
				<?php if($settings['button_text'] !== ''){ ?>
					<div class="pt-button-container">
						<a href="<?php echo isset($settings['link']['url']) && !empty($settings['link']['url'])?$settings['link']['url']:'#';?>">
							<span class="pt-button-text"><?php echo esc_html($settings['button_text']); ?></span>
							<?php if(isset($settings['button_icon'])){ ?>
								<span class="pt-button-icon">
									<span class="pt-button-icon-inner">
										<?php \Elementor\Icons_Manager::render_icon($settings['button_icon'], array('aria-hidden'=>'true'));?>
									</span>		
								</span>
							<?php } ?> 	
						</a>
					</div>
				<?php } ?>
				<!--Button html ends here -->

				<!-- label html starts here -->
				<?php if(!empty($settings['label'])){ ?>
					<span class="pt-label"><?php echo esc_html($settings['label']);?></span>
				<?php } ?>	
				<!-- label html ends here -->
			</div>
		<?php

    }

}