<?php
namespace App\View;

use App\Controller\VoteController;

class VoteMetabox
{
    // Returns View
    function view()
    { 
        // Get Parsed Votes Array from Controller
        $vote_controller = new VoteController();
        $votes = $vote_controller->get_votes();
        ?>
        <!-- Output for Votes Metabox -->
        <p>Visitor Votes for Page:</p>
        <div style='display:grid; grid-template-columns:1fr 1fr; grid-gap:5px;'>
            <span style='padding:5px 10px; border: 1px dotted;'>Positive: <?= $votes['yes'] ? $votes['yes'] : 0 ?></span>
            <span style='padding:5px 10px; border: 1px dotted;'>Negative: <?= $votes['no'] ? $votes['no'] : 0 ?></span>
        </div>
    <?php }
}