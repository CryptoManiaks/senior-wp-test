<?php
namespace App\Model;

class VoteData
{
    // Add a vote to the postmeta table under the specific post_id
    public static function add_vote( $page_id, $vote_str, $vote_val )
    {
        $_SESSION["vote_" . $page_id] = $vote_str;
        update_post_meta($page_id, "vote$vote_str", $vote_val);
    }

    // Check if post has votes and returns the value or 0
    public static function has_vote( $page_id, $vote_str )
    {
        $vote = get_post_meta( $page_id, "vote$vote_str", true );
        return $vote ? $vote : 0;
    }
}