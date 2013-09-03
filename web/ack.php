<?
	include("wp.php");
        $page = wp_get_page('6');
	
?>
<? include("html_header.php"); ?>
<body>
 <div id='container'>

         <? include("header_include.php"); ?>
         <article>
         <div id='main_page'>

		<? print nl2br($page['1']); ?>
	  </div>
          
	
        </article>
        <footer>
		<? include("footer.php"); ?>
        </footer>
   </div>
</body>
</html>


