<?php 

function snowreports_shortcode($atts){
    extract( shortcode_atts( array(
        'count' => -1,
	), $atts) );
	
	$list = '';
	
	if(!empty($_GET['a_name'])){
		$a_name = $_GET['a_name'];
	}else{
		$a_name = '';
	}

	if(!empty($_GET['categories'])){
		$s_categories = $_GET['categories'];
	}else{
		$s_categories = '';
	}

	if(!empty($_GET['practiceareas'])){
		$s_practiceareas = $_GET['practiceareas'];
	}else{
		$s_practiceareas = '';
	}

	$tax_query = array('relation' => 'OR');

	if(!empty($s_categories)){
		$tax_query[] = array(
			'taxonomy' => 'categories',
			'fields' => 'id',
			'terms' => $s_categories
		);
	}

	if(!empty($s_practiceareas)){
		$tax_query[] = array(
			'taxonomy' => 'practiceareas',
			'fields' => 'id',
			'terms' => $s_practiceareas
		);
	}
	
	$q = new WP_Query(
        array(
			'posts_per_page' => $count,
			'post_type' => 'people',
			's' => $a_name,
			'tax_query' => $tax_query
        )
	);
	
	$list .='
		<form action="" class="search-form">
			<div class="search-element">
				<input value="'.$a_name.'" type="text" name="a_name" placeholder="Type Name">
			</div>';
			$categories = get_terms('categories');
			if(!empty($categories) && !is_wp_error($categories)){
				$list .=' <div class="search-element"> <select name="categories">
						<option value="">All Categories</option>';
					foreach($categories as $category){
						if($s_categories == $category->term_id){
							$selected = 'selected="selected"';
						}else{
							$selected = '';
						}
						$list .='<option '.$selected.' value="'.$category->term_id.'">'.$category->name.'</option>';
					}
				
				$list .= '</select></div>';
			}
			$practiceareas = get_terms('practiceareas');
			if(!empty($practiceareas) && !is_wp_error($practiceareas)){
				$list .=' <div class="search-element"> <select name="practiceareas">
						<option value="">All PracticAareas</option>';
					
					foreach($practiceareas as $practicearea){
						if($s_practiceareas == $practicearea->term_id){
							$selected = 'selected="selected"';
						}else{
							$selected = '';
						}
						$list .='<option '.$selected.' value="'.$practicearea->term_id.'">'.$practicearea->name.'</option>';
					}
				
				$list .= '</select></div>';
			}
			
			$list .='
			<div class="search-element">
				<button type="submti">Search</button>
			</div>
		</form>
	';
          
    $list .= '<div class="custom-post-list">';
    while($q->have_posts()) : $q->the_post();
        $list .= '
        <div class="single-post-item">
            <h2><a href="'.get_permalink().'">' .get_the_title(). '</a></h2>
        </div>
        ';        
    endwhile;  
     
     
    $list.= '</div>';
    wp_reset_query();
    return $list;
}
add_shortcode('people_search', 'snowreports_shortcode');