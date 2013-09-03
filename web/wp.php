<?


function wp_get_page($page_id) {

         $connectw=mysql_connect("mysql.openecology.in", "openecologydb","ch3cooh");
         $wordpress_db=mysql_select_db("openecology_main",$connectw );
         $query = "Select post_title,post_content FROM biblio_posts WHERE post_type='page' AND post_status='publish' AND ID='$page_id'";
         $query_result = mysql_query($query);
         mysql_close();

         $page_wordpress[] = mysql_result($query_result, 0, "post_title");
         $page_wordpress[] = mysql_result($query_result, 0, "post_content");
         
         return $page_wordpress;
}


?>