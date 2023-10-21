<?php
namespace App\View;

use App\Controller\VoteController;

class VoteWidget
{
    // Set the Controller class for this instance
    function __construct()
    {
        $this->controller = new VoteController;
    }

    // Voting AJAX Callback
    function register_callback()
    {
        $controller = new VoteController;
        add_action('wp_ajax_vote_callback', [$this->controller, 'vote_callback']);
        add_action('wp_ajax_nopriv_vote_callback', [$this->controller, 'vote_callback']);
    }

    function view()
    {
        // Set defaults
        $page_id = get_the_ID();
        $img_path = plugin_dir_url(__DIR__) . '/View/assets/images/';

        $yes_class = '';
        $yes_text = 'YES';

        $no_class = '';
        $no_text = 'NO';

        $widget_text = 'Was this article helpful?';

        // Check if User Voted and change fields accordingly
        if( isset($_SESSION['vote_' . $page_id]) )
        { 
            $vote_percentages = $this->controller->get_vote_percentages();
            $yes_class = $_SESSION['vote_' . $page_id] == 'Yes' ? 'active' : 'disabled';
            $no_class = $_SESSION['vote_' . $page_id] == 'No' ? 'active' : 'disabled';

            $yes_text = $vote_percentages['yes'] . '%';
            $no_text = $vote_percentages['no'] . '%';
            $widget_text = 'Thank you for your feedback!';
        }

        // Return View using Dynamic Content
        return <<<TEXT
            <div class='s-vote-container'>
                <p>$widget_text</p>
                <button class='s-vote-btn $yes_class' data-id='{$page_id}' aria-label='Yes'>  
                    <img src='{$img_path}happy_face.png' alt='Happy Face Image' > 
                    $yes_text
                </button>
                <button class='s-vote-btn $no_class' data-id='{$page_id}' aria-label='No'>
                    <img src='{$img_path}sad_face.png' alt='Sad Face Image' >
                    $no_text
                </button>
            </div>
        TEXT;
    }
}