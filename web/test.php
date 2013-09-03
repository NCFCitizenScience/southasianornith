<?

include("wp.php");



$page = wp_get_page('4');


print_r($page);

print nl2br($page['post_content']);

?>