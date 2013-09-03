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
