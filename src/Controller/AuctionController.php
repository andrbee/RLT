<?php
/**
 * Created by PhpStorm.
 * User: balashov_a
 * Date: 15.03.2019
 * Time: 11:26
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Auction;

class AuctionController extends Controller {

    /**
     * @Route("/auction/maps")
     */
    public function mapsAction(Request $request) {

        if ($request->isXmlHttpRequest() || $request->query->get('urls')) {
            $jsonData = array('aaa');

            return new JsonResponse($jsonData);
        } else {
            die('DIE');
        }


    }

}
