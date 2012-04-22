<?php 
add_action('wp_ajax_nopriv_count_posts', 'count_posts');
add_action('wp_ajax_count_posts', 'count_posts');

function count_posts() {
		
	global $wpdb;	
	$values = $_POST['val'];
	$controls = $_POST['ctrl'];
	
	for ($i=0;$i<count($controls);$i++)
		$controls[$i][value] = $values[$i][value];
	
	$q = test($controls);
	//echo $q;
	$c = $wpdb->get_var($q);
	echo $c;
	die();
}

function test($controls)
{
	global $wpdb;
	
	// Build the query
	$select = "SELECT COUNT(*) FROM $wpdb->posts";
	$join = "";
	$where = " WHERE 1=1 AND post_type='ad_listing' AND (post_status='publish' OR post_status='private')";
	
	for ($i=0;$i<count($controls);$i++)
	{
		//
		$name = $controls[$i][name];
		$value = $controls[$i][value];
		$joiner	= $controls[$i][params][joiner];
		$numeric = $controls[$i][params][numeric];
		$comp = $controls[$i][params][comparison];
		$params = $controls[$i][params];
		$input = $controls[$i][params][input];
				
		if (!empty($value))
		{
			switch ($joiner)
			{
				case "PostDataJoiner":
					$where.= getPostDataJoinerWhere($comp, $name, $value);
					break;
				case "CustomFieldJoiner":
					$join.= " JOIN wp_postmeta m".$i." ON m".$i.".post_id=id";
					//$where.= " AND (m".$i.".meta_key='".$name."' AND m".$i.".meta_value".getComp($comp, $name, $value)."')";
					$where.= getCustomFieldJoinerWhere($name, $value, $i, $comp, $numeric, $params);
					break;
				case "CategoryJoiner":
					$table = 'm'.$i;
					$rel = 'rel'.$i;
					$tax = 'tax'.$i;
					$join.= " JOIN $wpdb->term_relationships $rel ON $rel.object_id=id JOIN $wpdb->term_taxonomy $tax ON $tax.term_taxonomy_id=$rel.term_taxonomy_id JOIN $wpdb->terms $table ON $table.term_id=$tax.term_id AND $tax.taxonomy='ad_cat'";
					$where.= getCategoryJoinerWhere($name, $value, $i, $comp);
					break;
				case "TagJoiner":
					$table = 'm'.$i;
					$rel = 'rel'.$i;
					$tax = 'tax'.$i;
					$join.= " JOIN $wpdb->term_relationships $rel ON $rel.object_id=id JOIN $wpdb->term_taxonomy $tax ON $tax.term_taxonomy_id=$rel.term_taxonomy_id JOIN $wpdb->terms $table ON $table.term_id=$tax.term_id AND $tax.taxonomy='ad_tag'";
					$where.= getCategoryJoinerWhere($name, $value, $i, $comp);
					break;
				case "PostTypeJoiner":
					//preg_replace(); 
					break;
				default: 
					break;		
			}	
			
		}// end if
	}
	return $select.$join.$where;	  
}

function getPostDataJoinerWhere($comp, $name,$value)
{
	$suggestedFields = array('all'=>'All Fields',
							 'post_content'=>'Body Text',
							 'post_title'=>'Title',
							 'post_author'=>'Author',
							 'post_date'=>'Date');
	// similar for checkbox!
	if ($name = 'all')
	{
		$logic = array();
		foreach($suggestedFields as $name=>$desc)
		{
				if($name=='all') continue;
				$logic[] =  "( ".getComp($comp, $name,$value).") ";
		}
		$logic = " AND (".join(" OR ",$logic).")";
		return $logic;
		
	}
	else
		return " AND ( ".getComp($comp, $name, $value). ") ";
}

function getCategoryJoinerWhere($name, $value, $index, $comp)
{
	$res ="";
	
	if ($value)
	{
		$table = 'm'.$index;
		/* CHECKBOX
		if ($params[input] == 'CheckBoxField')
		{
			
			   $logic = array();
			   foreach($params[options] as $name=>$value)
				{
					if($name=='all') continue;
					$logic[] =  "( ".getComp($comp, $name,$value).") ";
				}
				$logic = " AND (".join(" OR ",$logic).")";
				//return $logic;
		}
		else*/ 
		$res.= " AND (".getComp($comp, "$table.name", $value).")";		
	}
	return $res;	
}

function getCustomFieldJoinerWhere($name, $value, $index, $comp, $numeric, $params)
{
	$res = "";		
	$table = 'm'.$index;
	$field = "$table.meta_value".(isNumeric($params, $numeric, false) ? '*1':'');
	$res = " AND ".getComp($comp, $field, $value);
	if ($name!='all') 
		$res = " AND ($table.meta_key='$name' ".$res.") "; 
	
	return $res;
}
//
function isNumeric($params, $key, $default=null)
{
	if (array_key_exists($numeric, $params)) return $params[$key];
	return $default;
	
}

// COMPARISON FUNCTIONS
function getComp($comparison, $f, $v)
{
	switch ($comparison)
	{
		case "EqualComparison": 
			return getEqualComparison($f, $v);
			break;
		case "NotEqualComparison":
				return getNotEqualComparison($f, $v);
			break;
		case "LikeComparison":
				return getLikeComparison($f, $v);
			break;
		case "WordsLikeComparison":
				return getWordsLikeComparison($f, $v);
			break;
		case "LessThanComparison":
				return getLessThanComparison($f, $v);
			break;
		case "MoreThanComparison":
				return getMoreThanComparison($f, $v);
			break;
		case "AtMostComparison":
				return getAtMostComparison($f, $v);
			break;
		case "AtLeastComparison":
				return getAtLeastComparison($f, $v);
			break;	
		case "RangeComparison":
				return getRangeComparison($f, $v);
			break;
		default: break;
	}
}

function getEqualComparison($field, $value)
{
	return "$field = '$value'";	
}

function getNotEqualComparison($field, $value)
{
	return "$field != '$value'";	
}

function getLikeComparison($field, $value)
{
	return "$field LIKE '%$value%'";
}

function getWordsLikeComparison($field, $value)
{
	$words = explode(" ", $value);
	$like = array(1);
	foreach($words as $w)
		$like[] = getLikeComparison($field, $w);
		
	return "(".join(" AND ", $like).")";
}

function getLessThanComparison($field, $value)
{
	return "$field < '$value'";
}

function getMoreThanComparison($field, $value)
{
	return "$field > '$value'";
}
function getAtMostComparison($field, $value)
{
	return "$field <= '$value'";
}
function getAtLeastComparison($field, $value)
{
	return "$field >= '$value'";
}

function getRangeComparison($field, $value)
{
	list($min, $max)= explode("-", $value);
	$where = 1;
	if(strlen($min)>0)  $where.= " AND $field >= $min";
	if(strlen($max)>0)  $where.= " AND $field <= $max";
	return $where;
}
?>