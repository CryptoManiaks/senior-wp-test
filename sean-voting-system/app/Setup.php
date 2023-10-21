<?php
namespace App;
use App\View\{ VoteWidget, VoteMetabox };

class Setup
{
    private $plugin_name;
	private $version;

	public function __construct( $plugin_name, $version ) {
        // Set Version / Name of Plugin
		$this->plugin_name = $plugin_name;
		$this->version = $version;
        $this->widget = new VoteWidget();
        
        // Enqueue Required Scripts and CSS
        add_action( 'wp_enqueue_scripts', [$this, 'enqueue_styles'] );
        add_action( 'wp_enqueue_scripts', [$this, 'enqueue_scripts'] );

        // Add Widget to Frontend
        add_filter( 'the_content', [$this, 'add_voting_to_content'] );

        // Add Metabox
        add_action( 'load-post.php', [$this, 'add_metaboxes'] );
        add_action( 'load-post-new.php', [$this, 'add_metaboxes'] );

        // Registers AJAX Callback
        add_action( 'init', [$this->widget, 'register_callback']);
	}

    // Add Voting Metabox to Pages/Posts
    public function add_metaboxes()
    {
        add_meta_box(
            'sean-voting-system',
            esc_html__( 'Post Votes', 'sean-voting-system' ),
            [new VoteMetabox, 'view'], null, 'side'       
        );
    }

	// Register the stylesheets for the public-facing side of the site.
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'View/assets/css/sean-voting.css', array(), $this->version, 'all' );
	}

	// Register the JavaScript for the public-facing side of the site.
	public function enqueue_scripts() {
		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'View/assets/js/sean-voting.js', array( 'jquery' ), $this->version, false );
        wp_localize_script( $this->plugin_name, 'script_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' )) );
        wp_enqueue_script( $this->plugin_name );
	}

    // Appends Voting Form to bottom of the_content()
    function add_voting_to_content( $content ) {
        if(is_single()){
            return $content .= $this->widget->view();
        }
        return $content;
    }
}