<?
function paginator($base_path, $cur_page, $total_items, $per_page=5, $footer_bar=false, $name) {
  $remainder = $total_items % $per_page;
  $total_pages = ($total_items - $remainder)/$per_page;
  if($remainder > 0) $total_pages += 1;

  $start_num = 1 + ($cur_page-1)*$per_page;
  $end_num = $start_num + $per_page - 1;
  if ($end_num > $total_items) $end_num = $total_items;

  $next_page = $cur_page + 1;
  $prev_page = $cur_page - 1;

  $start_page = $cur_page - 2;
  $end_page = $cur_page + 2;

  if($end_page > $total_pages) {
    $end_page = $total_pages;
    $start_page = $total_pages - 4;
  } 

  if($start_page < 1) {
    $start_page = 1;
    if ($total_pages >= 5) $end_page = 5;
    else $end_page = $total_pages;
  }
      
  $class = $footer_bar ? "footer_bar" : "summary_bar";

  $ret  = '<ul class="paginatorul bar clearfix ' . $class . '">';
  if(!$footer_bar) $ret .= '<li class="summary">Displaying ' . $name . ' ' . $start_num . ' - ' . $end_num . ' of ' . $total_items . '.</li>';

  if($total_pages > 1) {
   $ret .= '<li><ul class="pagerpro">';
    if($cur_page != 1) $ret .= '<li><a href="' . $base_path . '&page=' . $prev_page . '">Prev</a>';
    for($i=$start_page;$i<=$end_page;$i++) {
      $ret .= '<li';
      if($i == $cur_page) $ret .= ' class="current"';
      $ret .= '>';
      $ret .= '<a href="' . $base_path . '&page=' . $i . '">' . $i . '</a></li>';
    }
    if ($cur_page != $total_pages) $ret .= '<li><a href="' . $base_path . '&page=' . $next_page . '">Next</a></li>';
    $ret .= '</ul></li>';

  }

  $ret .= '</ul>';

  return $ret;
}


?>
