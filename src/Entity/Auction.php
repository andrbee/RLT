<?php
/**
 * Created by PhpStorm.
 * User: balashov_a
 * Date: 15.03.2019
 * Time: 18:03
 */

namespace App\Entity;

use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Client;

class Auction {
//	const POST_FIELDS_LIST_AUCTION = 'select_name_table1=0&select_name_table1sub1=0&select_name_table3=4&field1_from=0&field1_to=1000000000000';
	const HOST_RESOURCE = 'http://rlt.by';
	const URL_LIST_AUCTION = '/aukcion/search.php';
	const HOST_PROXY = '192.168.15.240:3128';

	public function getList() {

        $html = $this->guzzleRequest('POST',self::HOST_RESOURCE . self::URL_LIST_AUCTION, $this->getParamsForAuctions());
        $crawler = new Crawler((string) $html);
        $items = $crawler->filter('.preview');

        $auctions = $items->each(function (Crawler $node, $i){
            $title = $node->filter('.spanfield0');
            $title = trim(str_replace($title->filter('strong')->text(),'',$title->text()));

            $dateAndTime = $node->filter('.spanfield2');
            $dateAndTime = trim(str_replace($dateAndTime->filter('strong')->text(),'',$dateAndTime->text()));

            $region = $node->filter('.spantable1sub1');
            $region = trim(str_replace($region->filter('strong')->text(),'',$region->text()));

            $url = $node->filter('.spantable.link a');
            $url = $url->attr('href');

            return array(
                'title' => $title,
                'dateAndTime' => $dateAndTime,
                'reqion' => $region,
                'url' => self::HOST_RESOURCE . $url
            );
        });

        return $auctions;
    }



	private function guzzleRequest($format, $url, $postdata='')	{
	    $config = [
            'form_params' => $postdata
        ];
	    if(getenv('USE_PROXY')) {
            $config['proxy'] = [
                'http' => getenv('HOST_PROXY'),
                'https' => getenv('HOST_PROXY'),
            ];
        }
	    $client = new Client();
	    $response = $client->request($format, $url, $config);
	    return $response->getBody();
	}

	private function getParamsForAuctions() {

	    return [
	        'select_name_table1' => 0,
	        'select_name_table1sub1' => 0,
	        'select_name_table3' => 4,
	        'field1_from' => 0,
	        'field1_to' => 1000000000000,
        ];
    }


}