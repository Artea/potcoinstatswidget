<?php
class PTSWSettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Potcoin Stats Widget',
            'Potcoin Stats Widget',
            'manage_options',
            'potsw-setting-admin',
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'potsw_option_name' );
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>Potcoin Stats Widget Settings</h2>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'my_option_group' );
                do_settings_sections( 'my-setting-admin' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            'my_option_group', // Option group
            'potsw_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id_cryptorush', // ID
            '<a href="http://cryptorush.in">Cryptorush.in</a> API Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'my-setting-admin' // Page
        );

        add_settings_field(
            'user_id_cryptorush', // ID
            'Cryptorush.in User ID', // Title
            array( $this, 'user_id_cryptorush_callback' ), // Callback
            'my-setting-admin', // Page
            'setting_section_id_cryptorush' // Section
        );

        add_settings_field(
            'api_key_cryptorush',
            'Cryptorush.in API Key',
            array( $this, 'api_key_cryptorush_callback' ),
            'my-setting-admin',
            'setting_section_id_cryptorush'
        );

        add_settings_section(
            'setting_section_id_swissecex', // ID
            '<a href="http://swissecex.com">Swissecex.com</a> API Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'my-setting-admin' // Page
        );

        add_settings_field(
            'api_key_swissecex',
            'Swissecex.com API Key',
            array( $this, 'api_key_swissecex_callback' ),
            'my-setting-admin',
            'setting_section_id_swissecex'
        );

    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['user_id_cryptorush'] ) )
            $new_input['user_id_cryptorush'] = absint( $input['user_id_cryptorush'] );

        if( isset( $input['api_key_cryptorush'] ) )
            $new_input['api_key_cryptorush'] = sanitize_text_field( $input['api_key_cryptorush'] );

        if( isset( $input['api_key_swissecex'] ) )
            $new_input['api_key_swissecex'] = sanitize_text_field( $input['api_key_swissecex'] );

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your API settings below:';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function user_id_cryptorush_callback()
    {
        printf(
            '<input type="text" id="user_id_cryptorush" name="potsw_option_name[user_id_cryptorush]" value="%s" />',
            isset( $this->options['user_id_cryptorush'] ) ? esc_attr( $this->options['user_id_cryptorush']) : ''
        );
    }

    /*
     * Get the settings option array and print one of its values
     */
    public function api_key_cryptorush_callback()
    {
        printf(
            '<input type="text" id="api_key_cryptorush" name="potsw_option_name[api_key_cryptorush]" value="%s" />',
            isset( $this->options['api_key_cryptorush'] ) ? esc_attr( $this->options['api_key_cryptorush']) : ''
        );
    }

    public function api_key_swissecex_callback()
    {
        printf(
            '<input type="text" id="api_key_swissecex" name="potsw_option_name[api_key_swissecex]" value="%s" />',
            isset( $this->options['api_key_swissecex'] ) ? esc_attr( $this->options['api_key_swissecex']) : ''
        );
    }

}

if( is_admin() )
    $settings_page = new PTSWSettingsPage();
