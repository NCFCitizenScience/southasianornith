<?
	include("wp.php");
        $page = wp_get_page('4');
	
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title>Bibliography of South Asia Ornithology</title>
        <meta name="description" content="">
        <meta name="author" content="">

        <meta name="viewport" content="width=device-width,initial-scale=1">

        <link rel="stylesheet" href="boiler/css/style.css">
        <script src="boiler/js/libs/modernizr-2.0.6.min.js"></script>

<style type="text/css">
#container {
    width:900px;
    margin-left:auto;
    margin-right:auto;
}

#search_section, .paginator,.final_result,  { display:block; float:left; position:relative; width:100%; }

#main_page { width:90%; margin-left:auto;margin-right:auto; padding-right:20px; line-spacing:1.2px; font-size:13px; }

.search_ul{
    list-style:none;
    float:left;
    width:90%;
}

.search_ul>li{
    list-style:none;
    float:left;
    width:23.5%;
    margin-right:10px;
    //text-align:center;
    display:block;
}


.search_ul>li .title { text-align:left; font-weight:bold; }

.search_ul>li input[type=search] {
    margin-top:5px;
    width:90%;
    padding:3px;
}

.search_ul>li input[type=submit] { padding:3px; margin-top:20px; width:100%;}

.search_ul>li select {
    margin-top:5px;
    width:90%;
    padding:3px;
}

.search_results { width:100%; }

.search_results li {
    width:87%;
    padding-left:10px;
    padding-bottom:20px;
    padding-top:20px;
    list-style:none;
    border-bottom: solid 1px #e6e6e6;
    display:block;

}

.bibkey, .bibtype { margin-top:10px; }
.bibkey a{ text-decoration:none; font-size:12px; }
.bibkey a:hover{ text-decoration:underline;  }
.showmore_text { font-size:10px; text-decoration:underline;}
.search_results>li:hover { 
    //background-color:#e6e6e6; 
}

.paginator { 
    width:90%; 
    margin-top:10px; 
    margin-bottom:10px; 
    margin-left:auto;
    margin-right:auto;
}

.paginatorul { 
    list-style:none; 
    float:left; 
    width:100%;
}

.paginatorul>li { 
    float:left; list-style:none; 
    width:49%; 
    display:block;  
}

.paginatorul>li:first-child { 
    padding-top:5px; 
    font-size:12px; 
    font-style:italic; 
    color:#333;
}

.main-title { 
    font-size:20px; 
    margin-top:25px; 
    letter-spacing:1.5px; 
    text-align:center; 
}

.logotext { 
    font-family: "HelveticaNeueBold", "HelveticaNeue-Bold", "Helvetica Neue Bold", "HelveticaNeue", "Helvetica Neue",  "Helvetica";  font-weight:600; 
    font-stretch:normal; 
    font-size:45px; 
    display:block; 
}

.logodesc { 
    font-family: "HelveticaNeueUltraLight", "HelveticaNeue-Ultra-Light", "Helvetica Neue Ultra Light", "HelveticaNeue", "Helvetica Neue", 'TeXGyreHerosRegular', "Arial", sans-serif; font-weight:100; 
    font-stretch:normal;
    font-size:20px; 
    letter-spacing:1.5px; 
    margin-left:-5px;
}

.logo{ 
    list-style:none; 
    float:left; 
    width:90%; 
}

.logo>li { 
    list-style:none; 
    float:left; 
    width:49%;
}

.nav{
    list-style:none;
    float:left;
    width:89%;
}


.nav>li {
    list-style:none;
    float:left;
    width:33%;
    padding-top:5px;
    padding-bottom:5px;
    text-align:center;
    background-color:#000;
}

.nav>li a { color:#fff; text-transform:uppercase; text-decoration:none; }
.nav>li a:hover { text-decoration:underline; }

.descli { 
    text-align:right; 
}

.slno { //font-size:17px; font-weight:bold; }

.bibtext { font-size:13px; }



.error { font-size:14px; font-weight:bold; text-align:center; color:red;}

.pagerpro { text-align:right }
.pagerpro li { list-style-type:none; display:inline; text-align:right }
.pagerpro li a{  list-style-type:none; display:inline; border: solid 1px;  margin-right: 5px;
        margin-bottom: 5px; padding: 0.3em 0.5em;

text-decoration: none;
        border: solid 1px #333;
	color: #000;

}

.pagerpro a{ width:70px; }
.pagerpro li a:hover  {
    background:#333;
    color:#fff;
    a { color : #fff; }


}

.pagerpro .current a  {
    background:#333;
    color:#fff;
}


</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
   <script>
     $(document).ready(function(){
       $(".showmore").hide();
       var t = '0';
       $(".showmore_text").click(function(){
         var id = $(this).attr('id');
	  $('#show_' + id).toggle();
	  var text = $('#' + id).html();
          $('#' + id).html( text == "Show keywords" ? "Hide keywords" : "Show keywords");
       });

       <? if($bib_search_type) { ?>
          $('#bib_search_type').val('<? echo $bib_search_type; ?>');
       <? } ?>

        <? if($bib_search_list) { ?>
       	  $('#bib_search_list').val('<?	echo $bib_search_list; ?>');
       <? } ?>

     });
   </script>
</head>
<body>
 <div id='container'>

         <header>
                <ul class='logo'>
                     <li><img style='width:220px' src='biblio_logo.png' title='Bibliography of South Asian Ornithology'></li>
                     
                     <li class='descli'>
                        <span class='logotext'>bibliography</span>
                        <span class='logodesc'>of south asian ornithology</span>
                     </li>
                </ul>
		<ul class='nav'>
		     <li><a href='about.php'>About</a></li>
		     <li><a href='search.php'>Search</a></li>
		     <li><a href='index.php'>Home</a></li>
		</ul>
         </header>
         <article>
          <div id='main_page'>

		<? print nl2br($page['1']); ?>
	  </div>
          <div id='search_section'>
	     <form method='get' action='search.php' id='search_form'>
	      <ul class='search_ul'>
	       <li>
                   <span class='title'>Type</span>                    
                    <select name='bib_search_type' id='bib_search_type'>
                        <option value=''>All</option>
                        <option value='BOOK'>Book</option>
        		<option value='CHAP'>Chapter</option>
			<option value='JOUR'>Journal article</option>
			<option value='Other'>Others</option>
                    </select>
                </li>
		<li>
                    <span class='title'>Field</span>                    
		    <select name='bib_search_list' id='bib_search_list'>
			<option value=''>All</option>
			<option	value='AU'>Author</option>	
			<option	value='KW'>Keyword</option>
			<option value='PY'>Year</option>
		    </select>		
		</li>
		<li>
                     <span class='title'>Search term</span>
		    <input name="bib_search_word" id='bib_search_word' type="search" placeholder="" value="<? echo $bib_search_word; ?>">
		</li>
		<li>
		    <input type="submit" value="Search" name="search_bib">
		</li>
		</ul>
	     </form>
	</div>
	
        </article>
        <footer>

        </footer>
   </div>
</body>
</html>


