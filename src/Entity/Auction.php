<?php
/**
 * Created by PhpStorm.
 * User: balashov_a
 * Date: 15.03.2019
 * Time: 18:03
 */

namespace App\Entity;

use Symfony\Component\DomCrawler\Crawler;

class Auction {
	const POST_FIELDS_LIST_AUCTION = 'select_name_table1=0&select_name_table1sub1=0&select_name_table3=4&field1_from=0&field1_to=1000000000000';
	const HOST_RESOURCE = 'http://rlt.by';
	const URL_LIST_AUCTION = '/aukcion/search.php';
	const HOST_PROXY = '192.168.15.240:3128';

	public function list() {
		$html = $this->curlRequest(self::HOST_RESOURCE . self::URL_LIST_AUCTION,self::POST_FIELDS_LIST_AUCTION);
		echo '<pre/>';
		print_r($html['content']);
		exit;
	}



	private function curlRequest($url, $postdata='', $cookie='', $proxy='')
	{
		$uagent = "Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_7; en-US) AppleWebKit/534.16 (KHTML, like Gecko) Chrome/10.0.648.205 Safari/534.16";

		$ch = curl_init( $url );
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   // возвращает веб-страницу
		curl_setopt($ch, CURLOPT_HEADER, 0);           // возвращает заголовки
		@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);   // переходит по редиректам
		curl_setopt($ch, CURLOPT_ENCODING, "");        // обрабатывает все кодировки
		curl_setopt($ch, CURLOPT_USERAGENT, $uagent);  // useragent
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);        // таймаут ответа
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10);       // останавливаться после 10-ого редиректа
		if($_SERVER['USE_PROXY']) {
			curl_setopt($ch, CURLOPT_PROXY, self::HOST_PROXY);
		}
		if(!empty($postdata))
		{
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		}
		if(!empty($cookie))
		{
			//curl_setopt($ch, CURLOPT_COOKIEJAR, $_SERVER['DOCUMENT_ROOT'].'/2.txt');
			//curl_setopt($ch, CURLOPT_COOKIEFILE,$_SERVER['DOCUMENT_ROOT'].'/2.txt');
		}
		$content = curl_exec( $ch );
		$err     = curl_errno( $ch );
		$errmsg  = curl_error( $ch );
		$header  = curl_getinfo( $ch );
		curl_close( $ch );

		$header['errno']   = $err;
		$header['errmsg']  = $errmsg;
		$header['content'] = $content;
		return $header;
	}


}