<?php 
$wapl = new WordPressWapl;

$themeoption = get_option('architect_theme');

$linkString = '';
$string = '';

$pagesToShow = get_option('architect_showmenuitems');
$pagesToShowArr = array();

$pagesArray = get_pages(array('sort_column' => 'menu_order', 'parent' => 0));

if($pagesToShow !== false)
{
	$pagesToShowArr = explode('|', $pagesToShow);
}

if(in_array(0, $pagesToShowArr))
{
	$linkString .= '[url='.htmlspecialchars(get_option('home')).']Home[/url]';
	if($themeoption != 'iphoneLight' AND $themeoption != 'iphoneDark')
	{
		if(get_option('architect_showmenudivider'))
		{
			$linkString .= '| ';
		} else
		{
			$linkString .= ' ';
		}
	}
}

foreach($pagesArray as $key => $val)
{
	$page = get_page($val->ID);

	// Only show published pages
	if($page->post_status != 'publish')
	{
		continue;
	}
	
	$url = get_permalink($val->ID);
	
	// Only show pages we've specified (if we've specified)
	if($pagesToShow !== false)
	{
		if(in_array($page->ID, $pagesToShowArr))
		{
			$linkString .= '[url='.htmlspecialchars($url).']'.$wapl->format_text(stripslashes($page->post_title)).'[/url]';
			
			if($themeoption != 'iphoneLight' AND $themeoption != 'iphoneDark')
			{
				if(get_option('architect_showmenudivider'))
				{
					$linkString .= '| ';
				} else
				{
					$linkString .= ' ';
				}
			}
		}
	} else
	{
		$linkString .= '[url='.htmlspecialchars($url).']'.$wapl->format_text(stripslashes($page->post_title)).'[/url]';
		if($themeoption != 'iphoneLight' AND $themeoption != 'iphoneDark')
		{
			if(get_option('architect_showmenudivider'))
			{
				$linkString .= '| ';
			} else
			{
				$linkString .= ' ';
			}
		}
	}
}

if($themeoption != 'iphoneLight' AND $themeoption != 'iphoneDark')
{
	if(get_option('architect_showmenudivider')) $linkString = substr($linkString, 0, (strlen($linkString) - 2));
}

$string .= $wapl->chunk('words', array('class' => 'nav', 'quick_text' => $linkString.'[span=menuEnd] [/span]'));
return $string;
?>