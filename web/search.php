<?
	include("db.php");
	include("pagination.php");

	if( $_GET['page'] ) {
	    $cur_page = $_GET['page'];
	} else {
   	    $cur_page = 1;
        }

        $per_page = '20';

	$v_types = $db->types->find();
	$get_ex = '';
	foreach ($v_types as $vt) {
	   foreach($vt as $key=>$val) {
	     $get_ex[$key] = $val;
	   }
	}
	
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

	
	$base_url = "http://www.southasiaornith.in/search.php?" . $url;

	$keyword_url = "http://www.southasiaornith.in/search.php?" . $kw_url;

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
		        $search_results = $collection->find(array( $bib_search_list => new MongoRegex('/'.$bib_search_word.'/i'), "TY" => $bib_search_type))->sort(array("AU"=>1,  "PY"=>1))->limit($limit)->skip($skip);
			
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
                        $search_results = $collection->find(array( 
			   $bib_search_list => new MongoRegex('/'.$bib_search_word.'/i'), 

		           'TY' => array( '$nin' => array('BOOK','CHAP','JOUR'))))->sort(array("AU"=>1,"PY"=>1))->limit($limit)->skip($skip);
		

                  } else {
                        $error = "Please enter the search term";
                  }

               } else {
                 if($bib_search_word) {
                        $search_results = $collection->find( array(
					
					'$or' => array( array('AU' =>  new MongoRegex('/'.$bib_search_word.'/i')), array('PY' =>  new MongoRegex('/'.$bib_search_word.'/i')), array('KW' =>  new MongoRegex('/'.$bib_search_word.'/i'))),

					'TY' => array( '$nin' => array('BOOK','CHAP','JOUR'))))->sort(array("AU"=>1, "PY"=>1))->limit($limit)->skip($skip);
		
                 } else {
		      
                       $search_results = $collection->find(array( '$or' => array( array('TY' =>  'ADVS'), array('TY' =>  'COMP'), array('TY' =>  'CONF'), array('TY' =>  'DATA'),array('TY' =>  'ELEC'), array('TY' =>  'GEN'), array('TY' =>  'GEN1992'), array('TY' =>  'GEN1997'),array('TY' =>  'GEN1998'), array('TY' =>  'GENUnknown'), array('TY' =>  'MGZN'), array('TY' =>  'NEWS'),array('TY' =>  'PCOMM'), array('TY' =>  'RPT'), array('TY' =>  'THES'), array('TY' =>  'UNPB'), array('TY' =>  'VIDEO'))))->sort(array("AU"=>1, "PY"=>1))->limit($limit)->skip($skip);
		      
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
                        $search_results = $collection->find(array( '$or' => array( array('AU' =>  new MongoRegex('/'.$bib_search_word.'/i')), array('PY' =>  new MongoRegex('/'.$bib_search_word.'/i')), array('KW' =>  new MongoRegex('/'.$bib_search_word.'/i')))))->sort(array("AU"=>1,"PY"=>1))->limit($limit)->skip($skip);

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
<? include("html_header.php"); ?>
<body>
  <style> #asearch { text-decoration:underline; } </style>

 <div id='container'>

         <? include("header_include.php"); ?>
         <article>
          <? include("bib_search_include.php"); ?>
	<div class='paginator'>
	    <? 

	       if($search_results) { 
	       	  echo paginator($base_url, $cur_page, $result_count, "20", false, "documents"); 
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
                             //print_r($sri);                   
                             $obj_id = $sri['_id'];

			     $authors = '';
			     if( count($sri['AU']) == '1' ) {
			     	 $authors = $sri['AU'];
 
			     } else if( count($sri['AU']) > '1' ){
			    
			       for($i=0; $i < count($sri['AU']); $i++) {
			          if($i == (count($sri['AU']) - 1)) {
			     	    $authors .= $sri['AU'][$i];
                                  } else {
				    $authors .= $sri['AU'][$i] . "; ";
				  }
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
                               	       $pub_year = ". Year unknown";
                             }

			     $title = $sri['TI'];
			     if(!$title) {
                                       $title = "Title unknown";
                             }

			     $journal_title =  $sri['JF'];
			     if(!$journal_title) {
                                       $journal_title = "Title unknown";
                             }

			     $chap_title =  $sri['CT'];
			     if($chap_title) {
			     	   $chap_title = $chap_title . ". ";

			     }

			     $vol_no =  $sri['VL'];
			     if(!$vol_no) {
                                       $vol_no = "";
                             }


			     $isu_no =  $sri['IS'];
                             if(!$isu_no) {
                                       $isu_no = "";
                             } else {
			       	       $isu_no = "(" . $isu_no . ")";
			     }


			     $city =  $sri['CY'];    
			     if(!$city) {
                                       $city = "City unknown";
                             }

			     $pub_name = $sri['PB'];
			     if(!$pub_name) {
                                       $pub_name = "Publication unknown";
                             }

                             $chap_book_title = $sri['BT'];
			     if(!$chap_book_title) {
			               $chap_book_title = $title;
			     }

			     

			     $page_no = $sri['SP'];
			     if(!$page_no) {
			     		$page_no = '';
			     }

			     $editors = '';
			     if( count($sri['ED']) == '1' ) {
			     	 $editors = $sri['ED'];
			     } else if( count($sri['ED']) > '1' ){	    
			       for($i=0; $i < count($sri['ED']); $i++) {
			     	  $editors .= $sri['ED'][$i] . ",";
			       }
			     } else {
			          $editors = "";
			     }

			     $editors = " " . $editors . " (ed.)";

			     $sk='';
			     if(is_array($sri['KW'])) {
			     foreach($sri['KW'] as $sk_1) {
			          if(is_array($sk_1)) {
				     foreach($sk_1 as $sk_2) {
				        $sk[] = $sk_2;

				     }
				  } else {
				      $sk[] = $sk_1;
				  }

			     }} else { $sk[] = $sri['KW']; }
			     
		             $keywords = '';
			     if( count($sk) == '1' ) {
			     	 $keywords = "<a href='#x' id='" . $obj_id . "' class='showmore_text'>Show keywords</a> <span class='showmore' id='show_" . $obj_id . "'><a href='" . $keyword_url . "&bib_search_list=KW&bib_search_word=" . strtolower($sk[0]) . "'>" . $sk[0] . "</a></span> ";
 
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
				
				if($page_no) { $page_no = $vol_no . $isu_no .": " . $page_no; }
				$to_display = $authors . " " . $pub_year . ". " . $title . ". " . $journal_title . ". " . $page_no;
			 } else if($sri['TY'] == 'BOOK') {
		  	        $to_display = $authors . " " . $pub_year . ". " . $chap_book_title . ". " . $pb . ", " . $city;
		      	 } else if($sri['TY'] == 'CHAP') {
			         //if($page_no) { $page_no = "Pp: " . $page_no; }
			         $to_display = $authors . " " . $pub_year . ". " . $chap_title . "In: " . $chap_book_title . ". " . $page_no . $editors  .  " " .$city . ": " . $pub_name;
			 } else {
                                 $to_display = $authors . " " . $pub_year . ". " . $title . ". " .$pub_name . ". " . $city;
	                 }
		         
			 echo "<li>";
		         echo "<div class='bibtext'><span class='slno'>" . $sl_no . ".  </span>" . $to_display . " (" . $get_ex[$sri['TY']] . ")</div>";
			 //echo "<div class='bibtype'>Type: " . $sri['TY'] . "</div>";
			 echo "<div class='bibkey'><span class='bibkey_text'>" . $keywords . "</span></div>";
			 echo "</li>";

                         $sl_no = $sl_no + 1;
		     }
		   }
		?>
	    </ul>
	</div>
	<div class='paginator'>
	 <?      if($search_results) { 
	       	  echo paginator($base_url, $cur_page, $result_count, "20", false, "documents"); 
	         } 
	?>
	</div> 
       
        </article>
        <footer>
		 <? include("footer.php"); ?>
        </footer>
   </div>
</body>
</html>


