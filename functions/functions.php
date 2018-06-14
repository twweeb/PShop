<?php
$required_php_version = "7.0.0";
$required_mysql_version = "5.7";
function get_mysql_ver(){
	global $dbh;
	return $dbh->query('select version()')->fetchColumn();
}
function remove_accents( $string ) {
    if ( !preg_match('/[\x80-\xff]/', $string) )
            return $string;

    if (seems_utf8($string)) {
            $chars = array(
            // Decompositions for Latin-1 Supplement
            'ª' => 'a', 'º' => 'o',
            'À' => 'A', 'Á' => 'A',
            'Â' => 'A', 'Ã' => 'A',
            'Ä' => 'A', 'Å' => 'A',
            'Æ' => 'AE','Ç' => 'C',
            'È' => 'E', 'É' => 'E',
            'Ê' => 'E', 'Ë' => 'E',
            'Ì' => 'I', 'Í' => 'I',
            'Î' => 'I', 'Ï' => 'I',
            'Ð' => 'D', 'Ñ' => 'N',
            'Ò' => 'O', 'Ó' => 'O',
            'Ô' => 'O', 'Õ' => 'O',
            'Ö' => 'O', 'Ù' => 'U',
            'Ú' => 'U', 'Û' => 'U',
            'Ü' => 'U', 'Ý' => 'Y',
            'Þ' => 'TH','ß' => 's',
            'à' => 'a', 'á' => 'a',
            'â' => 'a', 'ã' => 'a',
            'ä' => 'a', 'å' => 'a',
            'æ' => 'ae','ç' => 'c',
            'è' => 'e', 'é' => 'e',
            'ê' => 'e', 'ë' => 'e',
            'ì' => 'i', 'í' => 'i',
            'î' => 'i', 'ï' => 'i',
            'ð' => 'd', 'ñ' => 'n',
            'ò' => 'o', 'ó' => 'o',
            'ô' => 'o', 'õ' => 'o',
            'ö' => 'o', 'ø' => 'o',
            'ù' => 'u', 'ú' => 'u',
            'û' => 'u', 'ü' => 'u',
            'ý' => 'y', 'þ' => 'th',
            'ÿ' => 'y', 'Ø' => 'O',
            // Decompositions for Latin Extended-A
            'Ā' => 'A', 'ā' => 'a',
            'Ă' => 'A', 'ă' => 'a',
            'Ą' => 'A', 'ą' => 'a',
            'Ć' => 'C', 'ć' => 'c',
            'Ĉ' => 'C', 'ĉ' => 'c',
            'Ċ' => 'C', 'ċ' => 'c',
            'Č' => 'C', 'č' => 'c',
            'Ď' => 'D', 'ď' => 'd',
            'Đ' => 'D', 'đ' => 'd',
            'Ē' => 'E', 'ē' => 'e',
            'Ĕ' => 'E', 'ĕ' => 'e',
            'Ė' => 'E', 'ė' => 'e',
            'Ę' => 'E', 'ę' => 'e',
            'Ě' => 'E', 'ě' => 'e',
            'Ĝ' => 'G', 'ĝ' => 'g',
            'Ğ' => 'G', 'ğ' => 'g',
            'Ġ' => 'G', 'ġ' => 'g',
            'Ģ' => 'G', 'ģ' => 'g',
            'Ĥ' => 'H', 'ĥ' => 'h',
            'Ħ' => 'H', 'ħ' => 'h',
            'Ĩ' => 'I', 'ĩ' => 'i',
            'Ī' => 'I', 'ī' => 'i',
            'Ĭ' => 'I', 'ĭ' => 'i',
            'Į' => 'I', 'į' => 'i',
            'İ' => 'I', 'ı' => 'i',
            'Ĳ' => 'IJ','ĳ' => 'ij',
            'Ĵ' => 'J', 'ĵ' => 'j',
            'Ķ' => 'K', 'ķ' => 'k',
            'ĸ' => 'k', 'Ĺ' => 'L',
            'ĺ' => 'l', 'Ļ' => 'L',
            'ļ' => 'l', 'Ľ' => 'L',
            'ľ' => 'l', 'Ŀ' => 'L',
            'ŀ' => 'l', 'Ł' => 'L',
            'ł' => 'l', 'Ń' => 'N',
            'ń' => 'n', 'Ņ' => 'N',
            'ņ' => 'n', 'Ň' => 'N',
            'ň' => 'n', 'ŉ' => 'n',
            'Ŋ' => 'N', 'ŋ' => 'n',
            'Ō' => 'O', 'ō' => 'o',
            'Ŏ' => 'O', 'ŏ' => 'o',
            'Ő' => 'O', 'ő' => 'o',
            'Œ' => 'OE','œ' => 'oe',
            'Ŕ' => 'R','ŕ' => 'r',
            'Ŗ' => 'R','ŗ' => 'r',
            'Ř' => 'R','ř' => 'r',
            'Ś' => 'S','ś' => 's',
            'Ŝ' => 'S','ŝ' => 's',
            'Ş' => 'S','ş' => 's',
            'Š' => 'S', 'š' => 's',
            'Ţ' => 'T', 'ţ' => 't',
            'Ť' => 'T', 'ť' => 't',
            'Ŧ' => 'T', 'ŧ' => 't',
            'Ũ' => 'U', 'ũ' => 'u',
            'Ū' => 'U', 'ū' => 'u',
            'Ŭ' => 'U', 'ŭ' => 'u',
            'Ů' => 'U', 'ů' => 'u',
            'Ű' => 'U', 'ű' => 'u',
            'Ų' => 'U', 'ų' => 'u',
            'Ŵ' => 'W', 'ŵ' => 'w',
            'Ŷ' => 'Y', 'ŷ' => 'y',
            'Ÿ' => 'Y', 'Ź' => 'Z',
            'ź' => 'z', 'Ż' => 'Z',
            'ż' => 'z', 'Ž' => 'Z',
            'ž' => 'z', 'ſ' => 's',
            // Decompositions for Latin Extended-B
            'Ș' => 'S', 'ș' => 's',
            'Ț' => 'T', 'ț' => 't',
            // Euro Sign
            '€' => 'E',
            // GBP (Pound) Sign
            '£' => '',
            // Vowels with diacritic (Vietnamese)
            // unmarked
            'Ơ' => 'O', 'ơ' => 'o',
            'Ư' => 'U', 'ư' => 'u',
            // grave accent
            'Ầ' => 'A', 'ầ' => 'a',
            'Ằ' => 'A', 'ằ' => 'a',
            'Ề' => 'E', 'ề' => 'e',
            'Ồ' => 'O', 'ồ' => 'o',
            'Ờ' => 'O', 'ờ' => 'o',
            'Ừ' => 'U', 'ừ' => 'u',
            'Ỳ' => 'Y', 'ỳ' => 'y',
            // hook
            'Ả' => 'A', 'ả' => 'a',
            'Ẩ' => 'A', 'ẩ' => 'a',
            'Ẳ' => 'A', 'ẳ' => 'a',
            'Ẻ' => 'E', 'ẻ' => 'e',
            'Ể' => 'E', 'ể' => 'e',
            'Ỉ' => 'I', 'ỉ' => 'i',
            'Ỏ' => 'O', 'ỏ' => 'o',
            'Ổ' => 'O', 'ổ' => 'o',
            'Ở' => 'O', 'ở' => 'o',
            'Ủ' => 'U', 'ủ' => 'u',
            'Ử' => 'U', 'ử' => 'u',
            'Ỷ' => 'Y', 'ỷ' => 'y',
            // tilde
            'Ẫ' => 'A', 'ẫ' => 'a',
            'Ẵ' => 'A', 'ẵ' => 'a',
            'Ẽ' => 'E', 'ẽ' => 'e',
            'Ễ' => 'E', 'ễ' => 'e',
            'Ỗ' => 'O', 'ỗ' => 'o',
            'Ỡ' => 'O', 'ỡ' => 'o',
            'Ữ' => 'U', 'ữ' => 'u',
            'Ỹ' => 'Y', 'ỹ' => 'y',
            // acute accent
            'Ấ' => 'A', 'ấ' => 'a',
            'Ắ' => 'A', 'ắ' => 'a',
            'Ế' => 'E', 'ế' => 'e',
            'Ố' => 'O', 'ố' => 'o',
            'Ớ' => 'O', 'ớ' => 'o',
            'Ứ' => 'U', 'ứ' => 'u',
            // dot below
            'Ạ' => 'A', 'ạ' => 'a',
            'Ậ' => 'A', 'ậ' => 'a',
            'Ặ' => 'A', 'ặ' => 'a',
            'Ẹ' => 'E', 'ẹ' => 'e',
            'Ệ' => 'E', 'ệ' => 'e',
            'Ị' => 'I', 'ị' => 'i',
            'Ọ' => 'O', 'ọ' => 'o',
            'Ộ' => 'O', 'ộ' => 'o',
            'Ợ' => 'O', 'ợ' => 'o',
            'Ụ' => 'U', 'ụ' => 'u',
            'Ự' => 'U', 'ự' => 'u',
            'Ỵ' => 'Y', 'ỵ' => 'y',
            // Vowels with diacritic (Chinese, Hanyu Pinyin)
            'ɑ' => 'a',
            // macron
            'Ǖ' => 'U', 'ǖ' => 'u',
            // acute accent
            'Ǘ' => 'U', 'ǘ' => 'u',
            // caron
            'Ǎ' => 'A', 'ǎ' => 'a',
            'Ǐ' => 'I', 'ǐ' => 'i',
            'Ǒ' => 'O', 'ǒ' => 'o',
            'Ǔ' => 'U', 'ǔ' => 'u',
            'Ǚ' => 'U', 'ǚ' => 'u',
            // grave accent
            'Ǜ' => 'U', 'ǜ' => 'u',
            );

            // Used for locale-specific rules
            $locale = get_locale();

            if ( 'de_DE' == $locale || 'de_DE_formal' == $locale || 'de_CH' == $locale || 'de_CH_informal' == $locale ) {
                    $chars[ 'Ä' ] = 'Ae';
                    $chars[ 'ä' ] = 'ae';
                    $chars[ 'Ö' ] = 'Oe';
                    $chars[ 'ö' ] = 'oe';
                    $chars[ 'Ü' ] = 'Ue';
                    $chars[ 'ü' ] = 'ue';
                    $chars[ 'ß' ] = 'ss';
            } elseif ( 'da_DK' === $locale ) {
                    $chars[ 'Æ' ] = 'Ae';
                    $chars[ 'æ' ] = 'ae';
                    $chars[ 'Ø' ] = 'Oe';
                    $chars[ 'ø' ] = 'oe';
                    $chars[ 'Å' ] = 'Aa';
                    $chars[ 'å' ] = 'aa';
            } elseif ( 'ca' === $locale ) {
                    $chars[ 'l·l' ] = 'll';
            } elseif ( 'sr_RS' === $locale || 'bs_BA' === $locale ) {
                    $chars[ 'Đ' ] = 'DJ';
                    $chars[ 'đ' ] = 'dj';
            }

            $string = strtr($string, $chars);
    } else {
            $chars = array();
            // Assume ISO-8859-1 if not UTF-8
            $chars['in'] = "\x80\x83\x8a\x8e\x9a\x9e"
                    ."\x9f\xa2\xa5\xb5\xc0\xc1\xc2"
                    ."\xc3\xc4\xc5\xc7\xc8\xc9\xca"
                    ."\xcb\xcc\xcd\xce\xcf\xd1\xd2"
                    ."\xd3\xd4\xd5\xd6\xd8\xd9\xda"
                    ."\xdb\xdc\xdd\xe0\xe1\xe2\xe3"
                    ."\xe4\xe5\xe7\xe8\xe9\xea\xeb"
                    ."\xec\xed\xee\xef\xf1\xf2\xf3"
                    ."\xf4\xf5\xf6\xf8\xf9\xfa\xfb"
                    ."\xfc\xfd\xff";

            $chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";

            $string = strtr($string, $chars['in'], $chars['out']);
            $double_chars = array();
            $double_chars['in'] = array("\x8c", "\x9c", "\xc6", "\xd0", "\xde", "\xdf", "\xe6", "\xf0", "\xfe");
            $double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
            $string = str_replace($double_chars['in'], $double_chars['out'], $string);
    }

    return $string;
}
function pshop_strip_all_tags($string, $remove_breaks = false) {
        $string = preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $string );
        $string = strip_tags($string);

        if ( $remove_breaks )
                $string = preg_replace('/[\r\n\t ]+/', ' ', $string);

        return trim( $string );
}
function sanitize_user( $username, $strict = false ) {
    $raw_username = $username;
    $username = pshop_strip_all_tags( $username );
    $username = remove_accents( $username );
    // Kill octets
    $username = preg_replace( '|%([a-fA-F0-9][a-fA-F0-9])|', '', $username );
    $username = preg_replace( '/&.+?;/', '', $username ); // Kill entities
 
    // If strict, reduce to ASCII for max portability.
    if ( $strict )
        $username = preg_replace( '|[^a-z0-9 _.\-@]|i', '', $username );
 
    $username = trim( $username );
    // Consolidate contiguous whitespace
    $username = preg_replace( '|\s+|', ' ', $username );
 
    return $username;
}
function map_deep( $value, $callback ) {
    if ( is_array( $value ) ) {
        foreach ( $value as $index => $item ) {
            $value[ $index ] = map_deep( $item, $callback );
        }
    } elseif ( is_object( $value ) ) {
        $object_vars = get_object_vars( $value );
        foreach ( $object_vars as $property_name => $property_value ) {
            $value->$property_name = map_deep( $property_value, $callback );
        }
    } else {
        $value = call_user_func( $callback, $value );
    }
 
    return $value;
}
function stripslashes_deep( $value ) {
    return map_deep( $value, 'stripslashes_from_strings_only' );
}
function stripslashes_from_strings_only( $value ) {
    return is_string( $value ) ? stripslashes( $value ) : $value;
}
function is_email($email){
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) return true;
	else return true;
}
function check_php_version($ver){
	
}
function PageNav($total_pages, $page_now){
	if(!empty($_GET['cat'])){
		$query_string = "&cat=".$_GET['cat'];
		$first_query_string = "?cat=".$_GET['cat'];
	}
	else if(isset($_GET['keyword']) && !ctype_space($_GET['keyword'])){
		$query_string = "&keyword=".$_GET['keyword'];
		$first_query_string = "?keyword=".$_GET['keyword'];
	}
	else{
		$query_string = '';
		$new_query_string = '';
	}
	if($total_pages<=7){
		echo "<a href=\"";if(isset($first_query_string)) echo "$first_query_string"; else echo "./"; echo "\" class=\"page-numbers"; if ($page_now == 1)  echo " current"; echo "\" title=\"Page 1\">1</a>";
		for ($i=2; $i<=$total_pages; $i++) {  // print links for all pages
			echo "<a href=\"?page=".$i.$query_string."\" class=\"page-numbers";
			if ($i==$page_now)  echo " current";
			echo "\" title=\"Page ".$i."\">".$i."</a> "; 
		}
	}
	if($total_pages>7){
		if($page_now >= ($total_pages - 3)){
			echo "<a href=\"";if(isset($first_query_string)) echo "$first_query_string"; else echo "./"; echo "\" class=\"page-numbers\" title=\"Page 1\">1</a>… ";
			for ($i=$page_now-2; $i<=$total_pages; $i++) {  // print links for all pages
				echo "<a href=\"?page=".$i.$query_string."\" class=\"page-numbers";
				if ($i==$page_now)  echo " current";
				echo "\" title=\"Page ".$i."\">".$i."</a> "; 
			}
		}
		else if($page_now <= 4){
			echo "<a href=\"";if(isset($first_query_string)) echo "$first_query_string"; else echo "./"; echo "\" class=\"page-numbers"; if ($page_now==1)  echo " current"; echo "\" title=\"Page 1\">1</a>";
			for ($i=2; $i<=$page_now+2; $i++) {  // print links for all pages
				echo "<a href=\"?page=".$i.$query_string."\" class=\"page-numbers";
				if ($i==$page_now)  echo " current";
				echo "\" title=\"Page ".$i."\">".$i."</a> "; 
			}
			echo "… <a href=\"?page=".$total_pages.$query_string."\" class=\"page-numbers\" title=\"Page ".$total_pages."\">".$total_pages."</a>";
		}
		else if($page_now > 4 && $page_now < ($total_pages - 3)){
			echo "<a href=\"";if(isset($first_query_string)) echo "$first_query_string"; else echo "./"; echo "\" class=\"page-numbers\" title=\"Page 1\">1</a>...";
			for ($i=$page_now-2; $i<=$page_now+2; $i++) {  // print links for all pages
				echo "<a href=\"?page=".$i.$query_string."\" class=\"page-numbers";
				if ($i==$page_now)  echo " current";
				echo "\" title=\"Page ".$i."\">".$i."</a> "; 
			}
			echo "… <a href=\"?page=".$total_pages.$query_string."\" class=\"page-numbers\" title=\"Page ".$total_pages."\">".$total_pages."</a>";
		}
	}
}
?>