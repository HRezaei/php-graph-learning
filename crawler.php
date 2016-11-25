<?php


require_once 'simple_php/simple_html_dom.php';

function crawl($url) {
	$res = curl_init($url);
	curl_setopt($res, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($res, CURLOPT_FOLLOWLOCATION, true);
	$content = curl_exec($res);
	$info = curl_getinfo($res);

	if($info['http_code'] != 200) {
		exit("Could not download $url <br /> status_code = $info[http_code]<br/>Content: $content");
	}
	return $content;
}


function parse($content) {
	$html = str_get_html($content);
		
	$div = $html->find('.rating-point');
	if(!$div) {
		exit('No rating found'); 
	}
	$div = $div[0];
	$output = [];
	foreach ($div->find('li') as $factor) {
		$title = $factor->find('span')[0]->innertext();
		$output['attrs'][$title] = $factor->find('div span.rating-number')[0]->innertext();
	}
	
	return $output;
}


function extract_id($url) {
	preg_match ( '/DKP-\d*/' , $url , $matches);
	if(!$matches) {
		exit("Could not extract product id from URL<br/>$url");
	}
	
	return substr($matches[0], 4);
}


$urls['lexar'] = 'https://goo.gl/VW3Rg8';
$urls['silicon'] = 'https://www.digikala.com/Product/DKP-20547';
$urls['hp'] = 'https://www.digikala.com/Product/DKP-133711';

$properties = [];
foreach ($urls as $key => $url) {
	$item = parse(crawl($url));
	foreach ($item['attrs'] as $property => $value) {
		$properties[$property][] = [
			'label' => $key,
			'value' => $value
		];
	}
}




