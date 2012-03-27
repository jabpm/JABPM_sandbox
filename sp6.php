<?php

require('functions.php');
//require('atom_array.php');

// , '2043528'

// list array -- , '6212959', '6205203', '6206006', '6205932', '6206016', '6203899', '6205432', '6205940', '6205093', '6204635', '6204605', '6204456', '6203896', '5768045', '6199112', '6198631', '6198611', '6198151', '6198262', '6197011', '6205203', '6212959', '6205940', '6204605', '6204635', '6205093', '6203865', '6198151', '6198262', '6198631', '6197011', '6204456', '6198611', '6200799', '6200813', '6200806', '6199112', '6197709', '6200813', '6212959', '6203894', '6212068', '6203896', '6203899', '6203924', '6203922', '6203932', '6203923', '6203920', '6205932', '6212490'

$output = '';
$post_item_output = '';
$attachment_item_output = '';

global $atom_array;
$atom_array  = array('6212959' /*, '6205203', '6206006', '6205932', '6206016', '6203899', '6205432', '6205940', '6205093', '6204635', '6204605', '6204456', '6203896', '5768045', '6199112', '6198631', '6198611', '6198151', '6198262', '6197011', '6205203', '6212959', '6205940', '6204605', '6204635', '6205093', '6203865', '6198151', '6198262', '6198631', '6197011', '6204456', '6198611', '6200799', '6200813', '6200806', '6199112', '6197709', '6200813', '6212959', '6203894', '6212068', '6203896', '6203899', '6203924', '6203922', '6203932', '6203923', '6203920', '6205932', '6212490' */); 

//print_r($atom_array);

global $feed_array;
$feed_array = array('2040443' /*, '959893', '2043465', '981251', '960850', '977134', '2040180', '2043524', '960290', '960585', '2043533', '2040386', '4412352', '981388', '2043436'*/);


$author_id = 10;
$category_id = 10;
$tag_id = 10;


//header ("Content-Type:text/xml");


foreach ( $feed_array as $feed_me ){

$post_item_output = '<?xml version="1.0" encoding="utf-8" xmlns="http://www.w3.org/2005/Atom"?><rss version="2.0"
	xmlns:excerpt="http://wordpress.org/export/1.1/excerpt/"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:wp="http://wordpress.org/export/1.1/">

        <channel>
            <title>dose3</title>
            <link>http://localhost/dose3</link>
            <description>Just another WordPress site</description>
            <pubDate>'.date( DATE_RFC2822 ).'</pubDate> 
            <language>en</language>
            <wp:wxr_version>1.1</wp:wxr_version>
            <wp:base_site_url>http://localhost/dose3</wp:base_site_url>
            <wp:base_blog_url>http://localhost/dose3</wp:base_blog_url>';
    


//,strtotime($games['shortdate'])

$xml = simplexml_load_file("http://www2.dose.ca/scripts/feeds/fullatomfeed.ashx?id=".$feed_me);

global $author_array;

$author_array = array();



foreach ($xml->entry as $x) {

	
	foreach ($x->author as $author) {
		
		foreach ($author->name as $a_name) {
					
			$insert = $a_name;
			
			array_push( $author_array, $insert  );
			//$author_id ++;
				
		}
	
	}
	
	
	
	
	
	

}



$author_array = array_unique($author_array);

array_pop($author_array);

//print_r ($author_array);


$output .= '<wp:author><wp:author_id>1</wp:author_id><wp:author_login>admin</wp:author_login><wp:author_email>lemonman150@gmail.com</wp:author_email><wp:author_display_name><![CDATA[admin]]></wp:author_display_name><wp:author_first_name><![CDATA[]]></wp:author_first_name><wp:author_last_name><![CDATA[]]></wp:author_last_name></wp:author>';

foreach ( $author_array as $author => $aname){

	if ( $aname!='' && $author !='' ){
	
	$firstlast = explode (' ', $aname);
	
	}	elseif ( $aname!='' && $author !='' ){
	
	$firstlast = explode ('/', $aname);
	
	}
	else{
	
	$placeholder = 'Dose Dotca';
	$firstlast = explode (' ', $placeholder);
	
	}

	//echo $first .' last='. $last;
	//exit();
	if ( !empty($firstlast[0]) && !empty($firstlast[1]) ){
	
	
	$post_item_output .= "<wp:author>\n\n

<wp:author_id>".$author_id."</wp:author_id>\r\n

<wp:author_login>".  strtolower($firstlast[0].$firstlast[1]) ."</wp:author_login>\r\n

<wp:author_email>".$author_id."@number.com</wp:author_email>\r\n

<wp:author_display_name><![CDATA[". $firstlast[0].' '.$firstlast[1] ."]]></wp:author_display_name>\r\n

<wp:author_first_name><![CDATA[". strtolower ( $firstlast[0] )."]]></wp:author_first_name>\r\n

<wp:author_last_name><![CDATA[".strtolower ( $firstlast[1] )."]]></wp:author_last_name>\r\n

</wp:author>\r\n\n";
	
	$author_id++;
	}
}


/**
 * Setup the Categories
 */

global $category_array;

$category_array = array();

foreach ($xml->entry as $x) {

	foreach ($x->link as $catlink) {
		
		 //&& ( $catlink['title'] == '[ more ]' )
		
		
		//echo $catlink['title'];
		
		//now that were pulling the atom feed from local, and have access to more tags generate dby the infoprm plugin, letss check to see what category we should use by checking the href attribute.
		//look for : celebrity, music, style, music, movies, tv, games
		
		
		if ( !empty ( $catlink['href'] ) && ( $catlink['title'] == '[ more ]' )){
		$category_name = explode ('/', $catlink['href']);
		$c = 0;
		
			
		if ( $category_name[3] != 'scripts' ){	
		
			//echo $category_name[3]."\n";
			array_push( $category_array, $category_name[3]  );
			//$category_id ++;
			
		}
		
		//exit();
		//$insert = $a_name;
		

		
		
		}
	}

}


$category_array = array_unique($category_array);

foreach ( $category_array as $category => $cname){

	//echo $first .' last='. $last;
	//exit();
	$post_item_output .= "<wp:category>\n\n

<wp:term_id>".$category_id."</wp:term_id>\r\n

<wp:category_nicename>".str_replace(' ','-',$cname)."</wp:category_nicename>\r\n

<wp:category_parent>0</wp:category_parent>\r\n

<wp:category_name>".  ucfirst( $cname ) ."</wp:category_name>\r\n

</wp:category>\r\n\n";
	
	$category_id++;
	
}

// 1. run through the articles base don the list feed, to create posts and attachment posts for accompanying featured images

// for each post and accompanying attachment post in the list array of article, branch out and load that atom file so we can grab the category,  content, tags that are 100% relevant, and image details ( abstract, photo credit and proper caption for the attachment post )
//$attachment_item_output



//address post items first
foreach ( $xml->entry as $post_item ) {
	
	
$post_item_output .= "<item>

<title>". $post_item -> title."</title>\n\n

<pubDate>". wp_friendly_time ( $post_item -> updated )/*Tue, 21 Feb 2012 18:14:08 +0000*/ ."</pubDate>\n\n

<dc:creator>admin</dc:creator>\n\n

<guid isPermaLink=\"false\">http://localhost/dose3/?p=". jb_postid ( $post_item -> id )  ."</guid>\n\n

<description></description>\n\n

<wp:post_id>". jb_postid ( $post_item -> id )  ."</wp:post_id>\n\n

<wp:post_date>".wp_friendly_time ( $post_item -> updated )."</wp:post_date>\n\n

<wp:post_date_gmt>".wp_friendly_time ( $post_item -> updated )."</wp:post_date_gmt>\n\n

<wp:comment_status>open</wp:comment_status>\n\n";


// cleanup the title for a nice looking slug

$post_item_output .= "<wp:ping_status>open</wp:ping_status>\n
<wp:post_name>". strtolower( jb_slugs ( $post_item->title ) ) ."</wp:post_name>\n
<wp:status>publish</wp:status>\n
<wp:post_parent>0</wp:post_parent>\n
<wp:menu_order>0</wp:menu_order>\n
<wp:post_type>post</wp:post_type>\n
<wp:post_password></wp:post_password>\n
<wp:is_sticky>0</wp:is_sticky>\n\n";

// now we have to go to the atom for the full details of image, content, and tags so let start a new SimpleXMLElement to load the local version of the atom file in question


if ( file_exists ( jb_postid ( $post_item-> id ).'.atom' ) ){
	
	$xml_details = simplexml_load_file( jb_postid ( $post_item-> id ) . '.atom' );

	//echo '<b>we have this file '. jb_postid ( $x-> id ).'.atom</b><br/>';

	//echo $xml_details->entry[0]->category[7]['relevance'];  /* as $article_details; */
	
	 
		
		if ( jb_postid ( $xml_details->id ) == jb_postid ( $post_item-> id ) ){
		
		//echo 'list Article ID:'. jb_postid ( $post_item-> id ) . ' >> atom ID:' . jb_postid ( $xml_details->id ) . '<br/>';
		
				foreach ( $xml_details ->category as $category_term ){
					
					if ( $category_term ['relevance'] != "" && $category_term ['relevance'] > 80 ) {
							
						//echo 'term(slug):'. jb_puncfree( strtolower( jb_slugs ( $category_term['term'] ) ) ).' relevance:'. $category_term['relevance'] .'<br/>';
						$post_item_output .= "<category domain=\"post_tag\" nicename=\"". jb_puncfree( strtolower( jb_slugs ( $category_term['term'] ) ) ) ."\"><![CDATA[" . jb_puncfree ( $category_term['term'] ). "]]></category>\n\n";
						
					}
					
				}
		
		//echo $article_details->category['relevance'];
		//="44" term="Los Angeles" label="City"
		

			
			$post_item_output .= "<content:encoded><![CDATA[" .  $xml_details->entry[0]->content->div . "]]></content:encoded>\n\n

			<excerpt:encoded><![CDATA[" .  $xml_details->entry[0]->source->subtitle . "]]></excerpt:encoded>\n\n\n";

/*


<category domain=\"category\" nicename=\"".strtolower( jb_slugs ( $x->category['term'] ) )."\"><![CDATA[".jb_puncfree ( $x->category['term'] )."]]></category>\n\n";
*/


		} else {
			
			$post_item_output .= '<DNE></DNE>';//echo '<i><b>file does not exist<br/></i></b>'; 
		}
		
}

$post_item_output .= "<wp:postmeta>
			<wp:meta_key>_edit_last</wp:meta_key>
			<wp:meta_value><![CDATA[1]]></wp:meta_value>
		</wp:postmeta>		
		
		<wp:postmeta>\n\n

<wp:meta_key>_thumbnail_id</wp:meta_key>\n\n

<wp:meta_value><![CDATA[";


foreach ( $post_item -> link as $linktype ){


if ( $linktype['type'] == 'image/jpeg' ){

$post_item_output .= str_replace ( '.bin', '', jb_featureimage ( $linktype['href'] ) );

}


}

$post_item_output .= "]]></wp:meta_value>

</wp:postmeta>\n\n\r

</item>\n\n\n\n\n\n\n";


	
}


}

echo $post_item_output;































?>
</channel>
</rss>
