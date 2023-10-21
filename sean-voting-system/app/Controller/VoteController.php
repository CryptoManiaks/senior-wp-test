<?php
namespace App\Controller;

use App\Model\VoteData;

class VoteController
{
    // Set the Data class for this instance
    function __construct()
    {
        $this->data = new VoteData();
    }

    // AJAX Callback called when Vote Button is Clicked
    public function vote_callback()
    {
        $vote_str = $_POST['vote'];
        $page_id = $_POST['page'];
        if( !empty($vote_str) && !empty($page_id) )
        {   
            // Get Vote Value and Increment by 1
            $vote_val = $this->data::has_vote( $page_id, $vote_str );
            $vote_val += 1;

            // Inserts new Vote Value to postmeta table
            $this->data::add_vote( $page_id, $vote_str, $vote_val );

            // Returns updated votes as a json string including selected value
            $votes = $this->get_votes(); 
            $votes[strtolower($vote_str)] += 1;

            $response = $this->get_vote_percentages( $votes );
            $response['value'] = $vote_str;
            echo json_encode( $response, true );
        }
        wp_die();
    }

    // Returns an array of Yes and No votes ( [ "Yes" => $yes_value, "No" => $no_value ] )
    public function get_votes()
    {
        $yes_votes = $this->data::has_vote( get_the_ID(), 'Yes' );
        $no_votes = $this->data::has_vote( get_the_ID(), 'No' );

        return [ 
            "yes" => $yes_votes ? $yes_votes : 0, 
            "no" => $no_votes ? $no_votes : 0
        ];
    }

    // Returns an array of Yes and No vote percentages ( [ "Yes" => $yes_value_percent, "No" => $no_value_percent ] )
    public function get_vote_percentages( $votes = array() )
    {
        $yes_votes = ( empty($votes) ) ? $this->data::has_vote( get_the_ID(), 'Yes' ) : $votes['yes'];
        $no_votes = ( empty($votes) ) ? $this->data::has_vote( get_the_ID(), 'No' ) : $votes['no'];
        
        // Percentage Calculation
        if( $yes_votes || $no_votes )
        {
            $total_votes = ( $yes_votes + $no_votes );
            $yes_votes = $yes_votes ? round(($yes_votes / $total_votes) * 100) : 0;
            $no_votes = $no_votes ? round(($no_votes / $total_votes) * 100) : 0;
        }

        return [ 
            "yes" => $yes_votes,
            "no" => $no_votes
        ]; 
    }
}