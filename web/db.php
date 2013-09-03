<?


$username = "";
$password = "";

$m = new Mongo("mongodb://${username}:${password}@localhost");

$db = $m->orthobib;
$collection = $db->ver3;

?>