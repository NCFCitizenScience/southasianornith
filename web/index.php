<?
	include("wp.php");
        $page = wp_get_page('4');
	
?>
<? include("html_header.php"); ?>
<body>
<style> #ahome { text-decoration:underline;	} </style>
 <div id='container'>

         <? include("header_include.php"); ?>
         <article>
	<? include("bib_search_include.php"); ?>
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


