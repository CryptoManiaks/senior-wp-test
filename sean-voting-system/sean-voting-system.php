<?php
session_start();
include(__DIR__ .'/vendor/autoload.php');
use App\Model\VoteData;
use App\Setup;
/**
 * @package           Sean_Voting_System
 *
 * @wordpress-plugin
 * Plugin Name:       Voting System
 * Version:           1.0.0
 * Description:		  Voting System enables users to store and display visitor votes on website posts, enhancing engagement and content relevance."
 * Author:            Sean Farrugia
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sean-voting-system
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
// Define Constants
define( '__SEAN_VOTING_SYSTEM_VERSION__', '1.0.0' );
define( '__SEAN_VOTING_SYSTEM_NAME__', 'Voting System' );

// Bootstrap Plugin
function run_sean_voting_system() {
	return new Setup( __SEAN_VOTING_SYSTEM_NAME__, __SEAN_VOTING_SYSTEM_VERSION__ );
}
run_sean_voting_system();
