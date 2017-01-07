<?php
/**
 * Fieldmanager fields that relate to Submenu (Option) pages
 */
class BDTravel_FM_Submenu {
	/**
	 * Register the Fieldmanager actions and callbacks
	 */
	public function __construct() {

		add_action( 'fm_submenu_bdtravel_theme_options', array( $this, 'register_bdtravel_site_options' ) );

		if ( function_exists( 'fm_register_submenu_page' ) ) {
			fm_register_submenu_page( 'bdtravel_theme_options', 'options-general.php', __( 'BDTravel Solutions', 'bdtravel' ) );
		}

	}

	/**
	 * A general theme settings page, use this function
	 * along with tabs to organize theme settings for bdtravel
	 *
	 * @access public
	 * @return void
	 */
	public function register_bdtravel_site_options() {

		$fm = new Fieldmanager_Group( __( 'BDTravel Solutions', 'bdtravel' ),
			array(
				'name' => 'bdtravel_theme_options',
				'tabbed' => 'horizontal',
				'children' => array(
					'general_configuration' => new Fieldmanager_Group(
						array(
							'label' => __( 'General Configuration', 'bdtravel' ),
							'children' => array(
								'general_afcode' => new Fieldmanager_TextField( __( 'Clave de Afiliado', 'bdtravel' ), array(
									'description' => __( 'Ingrese su clave de afiliado.', 'bdtravel' ),
								) ),
								'general_language' => new Fieldmanager_Select( array(
									'name' => 'general_language',
									'label' => 'Lenguaje',
									'description' => 'Lenguaje por default',
									'options' => array(
										'english' => __( 'Ingles', 'bdtravel'),
										'spanish' => __( 'Español', 'bdtravel'),
									)
								)),
							),
						)
					),
					'pages_configuration' => new Fieldmanager_Group(
						array(
							'label' => __( 'Configuración de Páginas', 'bdtravel' ),
							'children' => array(
								'page_hotels' => new Fieldmanager_Select( array(
									'name' => 'page_hotels',
									'fist_empty' => true,
									'label' => __( 'Lista de Hoteles', 'bdtravel' ),
									'description' => __( 'Selecciona una pagina para listar los hoteles', 'bdtravel' ),
									'datasource' => new Fieldmanager_Datasource_Post( array(
										'query_args' => array(
											'post_type' => 'page',
											'posts_per_page' => 100
										),
									)),
								)),
								'page_hotel_details' => new Fieldmanager_Select( array(
									'name' => 'page_hotel_details',
									'fist_empty' => true,
									'label' => __( 'Detalle de Hotel', 'bdtravel' ),
									'description' => __( 'Selecciona una pagina para mostrar los detalles de cada hotel', 'bdtravel' ),
									'datasource' => new Fieldmanager_Datasource_Post( array(
										'query_args' => array(
											'post_type' => 'page',
											'posts_per_page' => 100
										),
									)),
								)),
							),
						)
					),
				),
			)
		);
		$fm->activate_submenu_page();
	}

}

new BDTravel_FM_Submenu();
