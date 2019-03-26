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

class DefaultController extends Controller {

	/**
	 * @Route("/")
	 */
	public function indexAction (Request $request) {

		$auction = new Auction();
		echo '<pre>';
		print_r($auction->getList());
		exit();

		return $this->render('base.html.twig');
	}

}
