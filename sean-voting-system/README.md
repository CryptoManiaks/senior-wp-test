
# Senior WP Developer Test

"Voting System" enables users to store and display visitor votes on website posts, enhancing engagement and content relevance.


## Installation - Docker

Install sean-voting-system plugin using Docker Compose:

```bash
  docker-compose up
```
    
## Installation - WordPress

- Add 'sean-voting-system' folder in the **'wp-content/plugins/'** folder.

- Activate plugin from the **Admin Dashboard**

- Plugin will automatically append itself to the end of **the_content()** hook.

## Usage of Plugin

The Plugin is can be easily set up with just one click, requiring **no manual input or configuration.**

### For Developers
If you would like to echo the Voting Section somewhere else within your theme then simply calling the ```view()``` method from the ```VoteWidget``` class.

```php
use App\View\{ VoteWidget };


$widget = new VoteWidget();
$widget->view()
```


#### Plugin Setup
The entire plugin is bootstraped using the ```new Setup( $plugin_name, $plugin_version)``` constructor. **This adds all the actions, metaboxes, styles and js needed for this plugin to work.**
```php
// Bootstrap Plugin
function run_sean_voting_system() {
	return new Setup( __SEAN_VOTING_SYSTEM_NAME__, __SEAN_VOTING_SYSTEM_VERSION__ );
}
run_sean_voting_system();
```


## Tech Stack

**Client:** JS, Jquery, PHP, CSS, AJAX, WordPress, Composer



## Author

- [@seanfarrugia](https://github.com/seanfarrugia/)

