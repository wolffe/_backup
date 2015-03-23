<?php
class Paginator {
	var $items_per_page;
	var $items_total;
	var $current_page;
	var $num_pages;
	var $mid_range;
	var $low;
	var $high;
	var $limit;
	var $return;
	var $default_ipp;
	var $querystring;
	var $url_next;

	function Paginator() {
		$this->current_page = 1;
		$this->mid_range = 7;
		$this->items_per_page = $this->default_ipp;
		$this->url_next = $this->url_next;
	}
	function paginate() {
		if(!is_numeric($this->items_per_page) or $this->items_per_page <= 0)
			$this->items_per_page = $this->default_ipp;
		$this->num_pages = ceil($this->items_total/$this->items_per_page);

		if($this->current_page < 1 or !is_numeric($this->current_page))
			$this->current_page = 1;
		if($this->current_page > $this->num_pages)
			$this->current_page = $this->num_pages;
		$prev_page = $this->current_page - 1;
		$next_page = $this->current_page + 1;

		if($this->num_pages > 10) {
			$this->return = ($this->current_page != 1 && $this->items_total >= 10) ? '<a class="gb-paginate" href="' . $this->url_next . $prev_page . '">&laquo; ' . __('Previous', 'gbcart') . '</a> ' : '<span class="inactive" href="#">&laquo; ' . __('Previous', 'gbcart') . '</span> ';

			$this->start_range = $this->current_page - floor($this->mid_range/2);
			$this->end_range = $this->current_page + floor($this->mid_range/2);

			if($this->start_range <= 0) {
				$this->end_range += abs($this->start_range) + 1;
				$this->start_range = 1;
			}
			if($this->end_range > $this->num_pages) {
				$this->start_range -= $this->end_range - $this->num_pages;
				$this->end_range = $this->num_pages;
			}
			$this->range = range($this->start_range, $this->end_range);

			for($i=1;$i<=$this->num_pages;$i++) {
				if($this->range[0] > 2 and $i == $this->range[0])
					$this->return .= ' ... ';
				if($i==1 Or $i==$this->num_pages or in_array($i, $this->range)) {
					$this->return .= ($i == $this->current_page and $_GET['pagenum'] != 'All') ? "<a class=\"current\" href=\"#\">$i</a> ":"<a class=\"gb-paginate\" href=\"".$this->url_next.$i."\">$i</a> ";
				}
				if($this->range[$this->mid_range-1] < $this->num_pages-1 And $i == $this->range[$this->mid_range-1]) $this->return .= " ... ";
			}
			$this->return .= (($this->current_page != $this->num_pages And $this->items_total >= 10) And ($_GET['pagenum'] != 'All')) ? "<a class=\"gb-paginate\" href=\"".$this->url_next.$next_page."\">" . __('Next', 'gbcart') . " &raquo;</a>\n":"<span class=\"inactive\" href=\"#\">&raquo; " . __('Next', 'gbcart') . "</span>\n";
		}
		else {
			for($i=1;$i<=$this->num_pages;$i++) {
				$this->return .= ($i == $this->current_page) ? "<a class=\"current\" href=\"#\">$i</a> ":"<a class=\"gb-paginate\" href=\"".$this->url_next.$i."\">$i</a> ";
			}
		}
		$this->low = ($this->current_page - 1) * $this->items_per_page;
		$this->high = ($this->current_page * $this->items_per_page) - 1;
		$this->limit = " LIMIT $this->low,$this->items_per_page";
	}

	function display_pages() {
		return $this->return;
	}
}
?>
