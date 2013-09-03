<?

include("db.php"); 


$sl = $db->command(array("distinct" => "ver2", "key" => "TY"));



for($i=0; $i < count($sl['values']); $i++) {
echo $sl['values'][$i] . "<br>";

}

?>