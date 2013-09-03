<?
	include("db.php");
	include("pagination.php");

	if( $_GET['page'] ) {
	    $cur_page = $_GET['page'];
	} else {
   	    $cur_page = 1;
        }

        $per_page = '20';

	
	$url='';
	foreach ($_GET as $key=>$value) {
	   if($key !='page') {
	     if($url) {	      
	       $url .= "&" . $key . "=" . $value;
	     } else {
	       $url = $key . "=" . $value;
	     }
	    }
	}

	$kw_url='';
	foreach ($_GET as $key=>$value) {
	   if($key !='page' && $key != 'bib_search_list' && $key != 'bib_search_word') {
	     if($kw_url) {	      
	       $kw_url .= "&" . $key . "=" . $value;
	     } else {
	       $kw_url = $key . "=" . $value;
	     }
	    }
	}

	
	$base_url = "http://www.openecology.in/indianorthobib/search.php?" . $url;

	$keyword_url = "http://www.openecology.in/indianorthobib/search.php?" . $kw_url;

	$docs_per_page = '20';
	$skip = (int)($docs_per_page * ($cur_page - 1));
	$limit = $docs_per_page;


	    $bib_search_list = $_REQUEST['bib_search_list'];
	    $bib_search_word = trim(htmlentities($_REQUEST['bib_search_word']));
	    $bib_search_type = $_REQUEST['bib_search_type'];
	 
	 if( $bib_search_list || $bib_search_word || $bib_search_type ) {

	    if($bib_search_type) {
	     if(strtolower($bib_search_type) != 'other') { 
	       if($bib_search_list) {
	          if($bib_search_word) {
		        $search_results = $collection->find(array( $bib_search_list => new MongoRegex('/'.$bib_search_word.'/i'), "TY" => $bib_search_type))->sort(array("AU"=>1, "PY"=>1))->limit($limit)->skip($skip);
			
		  } else {
			$error = "Please enter the search term";
		  }

	       } else {
	       	 if($bib_search_word) {
		        $search_results = $collection->find(array( '$or' => array( array('AU' =>  new MongoRegex('/'.$bib_search_word.'/i')), array('PY' =>  new MongoRegex('/'.$bib_search_word.'/i')), array('KW' =>  new MongoRegex('/'.$bib_search_word.'/i'))), "TY" => $bib_search_type))->sort(array("AU"=>1, "PY"=>1))->limit($limit)->skip($skip);
		    
		 } else {
                       $search_results = $collection->find(array("TY" => $bib_search_type))->sort(array("AU"=>1, "PY"=>1))->limit($limit)->skip($skip);
		 }
	       }
	     } else {
	       
	        if($bib_search_list) {
                  if($bib_search_word) {
                        $search_results = $collection->find(array( $bib_search_list => new MongoRegex('/'.$bib_search_word.'/i'), "TY" =>  array('$ne' => 'BOOK', '$ne' => 'CHAP', '$ne' => 'JOUR')))->sort(array("AU"=>1, "PY"=>1))->limit($limit)->skip($skip);
		

                  } else {
                        $error = "Please enter the search term";
                  }

               } else {
                 if($bib_search_word) {
                        $search_results = $collection->find(array( '$or' => array( array('AU' =>  new MongoRegex('/'.$bib_search_word.'/i')), array('PY' =>  new MongoRegex('/'.$bib_search_word.'/i')), array('KW' =>  new MongoRegex('/'.$bib_search_word.'/i'))), "TY" =>  array('$ne' => 'BOOK', '$ne' => 'CHAP', '$ne' => 'JOUR')))->sort(array("AU"=>1, "PY"=>1))->limit($limit)->skip($skip);
		
                 } else {
                       $search_results = $collection->find(array("TY" =>  array('$ne' => 'BOOK')))->sort(array("AU"=>1, "PY"=>1))->limit($limit)->skip($skip);
		      
                 }
               }

	     }
	    } else {
	       if($bib_search_list) {
                  if($bib_search_word) {
		       $search_results = $collection->find(array( $bib_search_list => new MongoRegex('/'.$bib_search_word.'/i')))->sort(array("AU"=>1, "PY"=>1))->limit($limit)->skip($skip);
                  } else {
                        $error = "Please enter the search term";
                  }
	       } else {
                    if($bib_search_word) {
                        $search_results = $collection->find(array( '$or' => array( array('AU' =>  new MongoRegex('/'.$bib_search_word.'/i')), array('PY' =>  new MongoRegex('/'.$bib_search_word.'/i')), array('KW' =>  new MongoRegex('/'.$bib_search_word.'/i')))))->sort(array("AU"=>1, "PY"=>1))->limit($limit)->skip($skip);

                    } else {
               	        $search_results = $collection->find()->sort(array("AU"=>1, "PY"=>1))->limit($limit)->skip($skip);
                    }
               }

	    }
	 } else {
	    $search_results = $collection->find()->sort(array("AU"=>1, "PY"=>1))->limit($limit)->skip($skip);
	 }
	    
	 if($search_results) {
              $result_count = $search_results->count();
         }
	 

         $total_items =  $result_count;
         $start_num = 1 + ($cur_page-1)*$per_page;
         $end_num = $start_num + $per_page - 1;
         if ($end_num > $total_items) $end_num = $total_items;

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

#search_section, .paginator,.final_result { display:block; float:left; position:relative; width:100%; }

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
		     <li><a href='#'>About</a></li>
		     <li><a href='search.php'>Search</a></li>
		     <li><a href='index.php'>Home</a></li>
		</ul>
         </header>
         <article>
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
	<div class='paginator'>
	    <? 

	       if($search_results) { 
	       	  echo paginator($base_url, $cur_page, $result_count, "10", false, "documents"); 
	       } else {
	          if($error) {
		  	echo "<div class='error'>" . $error . "</div>";
		  } else {
		        echo "<div class='error'>No results found.</div>";
		  }
	       }

	    ?>
	</div>
        <div class='final_result'>
	    <ul class='search_results'>
		<?

		   if($search_results) {
                             $sl_no = $start_num;
		     foreach ($search_results as $sri) {
                            
                             $obj_id = $sri['_id'];

			     $authors = '';
			     if( count($sri['AU']) == '1' ) {
			     	 $authors = $sri['AU'];
 
			     } else if( count($sri['AU']) > '1' ){
			    
			       for($i=0; $i < count($sri['AU']); $i++) {
			     	  $authors .= $sri['AU'][$i] . ",";
			       }
			     } else {
			          $authors = "Authors unknown";
			     }

			     $pb =  $sri['PB'];
			     if(!$pb) {
			         $pb = "Publication unknown"; 
			     }
                             $pub_year = $sri['PY'];
			     if(!$pub_year) {
                               	       $pub_year = "Year unknown";
                             }

			     $title = $sri['TI'];
			     if(!$title) {
                                       $title = "Title unknown";
                             }

			     $journal_title =  $sri['JF'];
			     if(!$journal_title) {
                                       $journal_title = "Title unknown";
                             }

			     $vol_no =  $sri['VL'];
			     if(!$vol_no) {
                                       $vol_no = "";
                             }

			     $city =  $sri['CY'];    
			     if(!$city) {
                                       $city = "City unknown";
                             }

			     $pub_name = $sri['PB'];
			     if(!$pub_name) {
                                       $pub_name = "Publication unknown";
                             }

                             $chap_title = $sri['BT'];
			     if(!$chap_title) {
			               $chap_title = "Title unknown";	
			     }

			     $editors = '';
			     if( count($sri['ED']) == '1' ) {
			     	 $editors = $sri['ED'];
			     } else if( count($sri['ED']) > '1' ){	    
			       for($i=0; $i < count($sri['ED']); $i++) {
			     	  $editors .= $sri['ED'][$i] . ",";
			       }
			     } else {
			          $editors = "Editors unknown";
			     }
			     $sk='';
			     
			     foreach($sri['KW'] as $sk_1) {
			          if(is_array($sk_1)) {
				     foreach($sk_1 as $sk_2) {
				        $sk[] = $sk_2;

				     }
				  } else {
				      $sk[] = $sk_1;
				  }

			     }
			     
		             $keywords = '';
			     if( count($sk) == '1' ) {
			     	 $keywords = "<a href='#x' id='" . $obj_id . "' class='showmore_text'>Show keywords</a> <span class='showmore' id='show_" . $obj_id . "'><a href='" . $keyword_url . "&bib_search_list=KW&bib_search_word=" . strtolower($sk) . "'>" . $sk[0] . "</a></span> ";
 
			     } else if( count($sk) > 1) {
                                 //print_r($sri['KW']);
                                 $iter_count = count($sk);
                                $keywords = "<a href='#x' id='" . $obj_id . "' class='showmore_text'>Show keywords</a> <span class='showmore' id='show_" . $obj_id . "'>";
			        for($i=0; $i < $iter_count; $i++) {      
				
			     	   	$keywords .= "<a href='" . $keyword_url . "&bib_search_list=KW&bib_search_word=" . strtolower($sk[$i]) . "'>" . $sk[$i] . "</a>, ";
                                }
			         
				$keywords .= "</span>";
				 
                               } else {
			         $keywords = '';
			      }
                         $to_display = '';

		         if($sri['TY'] == 'JOUR') {
			        if($authors) {
                                   $to_display .= $authors . ". ";
				}
				$to_display = $authors . ". " . $pub_year . ". <i>" . $title . "</i>. " . $journal_title . ". " . $vol_no;
			 } else if($sri['TY'] == 'BOOK') {
		  	        $to_display = $authors . ". " . $pub_year . ". <i>" . $chap_title . "</i>. " . $pb . ", " . $city;
		      	 } else if($sri['TY'] == 'CHAP') {
			         $to_display = $editors . ". " . $pub_year . ". <em>" . $chap_title . "</em>. " .$pub_name . ". " . $city;
			 } else {
                                 $to_display = $authors . ". " . $pub_year . ". <em>" . $title . "</em>. " .$pub_name . ". " . $city;
	                 }
		         
			 echo "<li>";
		         echo "<div class='bibtext'><span class='slno'>" . $sl_no . ".  </span>" . $to_display . " (" . $sri['TY'] . ")</div>";
			 //echo "<div class='bibtype'>Type: " . $sri['TY'] . "</div>";
			 echo "<div class='bibkey'><span class='bibkey_text'>" . $keywords . "</span></div>";
			 echo "</li>";

                         $sl_no = $sl_no + 1;
		     }
		   }
		?>
	    </ul>
	</div>
        </article>
        <footer>

        </footer>
   </div>
</body>
</html>


