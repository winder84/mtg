<?php

namespace Wind\Bundle\MtgparseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Wind\Bundle\MtgparseBundle\Entity\Card;
use Wind\Bundle\MtgparseBundle\Entity\Cardcolor;
use Wind\Bundle\MtgparseBundle\Entity\Cardid;
use Wind\Bundle\MtgparseBundle\Entity\Cardrarity;
use Wind\Bundle\MtgparseBundle\Entity\Cardtype;
use Wind\Bundle\MtgparseBundle\Entity\Image;

class ParserController extends Controller
{
	public function questionAction(Request $request)
	{
		$form = $this->createFormBuilder()
			->add('task', 'choice', array(
				'choices' => array(
					true => 'Да',
					false => 'Нет'
				),
				'expanded' => true,
				'multiple' => false,
				'label' => 'Начать?'
			))
			->add('save', 'submit', array('label' => 'Ответить'))
			->getForm();

		$form->handleRequest($request);

		if ($form->isValid()) {

			$requestForm = $request->get('form');
			if ($requestForm['task']) {
				return $this->redirect($this->generateUrl('wind_mtgparse_parsing'));
			}
		}

		return $this->render('WindMtgparseBundle:Parser:question.html.twig', array(
			'form' => $form->createView(),
		));
		return $this->render('WindMtgparseBundle:Parser:question.html.twig', array('name' => '1'));
	}

	public function parsingAction() {
		$em = $this->getDoctrine()->getManager();
//		$colors = array('W', 'U', 'B', 'R', 'G');
//		$colors = array('G');
//		$type = 'Tribal';
//		$msgs[] = 'start - ' . date('d.m.Y H:i:s');
//		foreach ($colors as $color) {
//			$newCard = 0;
//			$cardsIds = array();
//			$retrys = array();
//			for ($i=0; $i<=0; $i++) {
//				$siteData = file_get_contents("http://gatherer.wizards.com/Pages/Search/Default.aspx?page={$i}&color=|[{$color}]&output=compact&type=+[{$type}]");
//				preg_match_all('!href="../Card/Details.aspx\?multiverseid=(\d+)"!si', $siteData, $cardsData);
//				$cardsIds = array_merge($cardsIds, $cardsData[1]);
//			}
//			$msgs[] = 'parced - ' . $color . ' ' . $type . ' ' . date('d.m.Y H:i:s');
//			foreach ($cardsIds as $carId) {
//				$cardIdObj = $em->getRepository('WindMtgparseBundle:Cardid');
//				$cardIdObj = $cardIdObj->findOneBy(array(
//					'cardId' => $carId
//				));
//				$isNewColor = true;
//				$isNewType = true;
//				if (!$cardIdObj) {
//					$cardIdObj = new Cardid();
//					$newCard++;
//				} else {
//					$retrys[$cardIdObj->getId()] = $carId;
//					$cardIdObj = $cardIdObj;
//					foreach ($cardIdObj->getCardcolors()->toArray() as $cc) {
//						if ($cc->getColor() == $color) {
//							$isNewColor = false;
//						}
//					}
//					foreach ($cardIdObj->getCardtypes()->toArray() as $tt) {
//						if ($tt->getType() == $type) {
//							$isNewType = false;
//						}
//					}
//				}
//				$cardColorObj = $em->getRepository('WindMtgparseBundle:Cardcolor');
//				$cardTypeObj = $em->getRepository('WindMtgparseBundle:Cardtype');
//				$cardColor = $cardColorObj->findOneBy(array(
//					'color' => $color
//				));
//				$cardType = $cardTypeObj->findOneBy(array(
//					'type' => $type
//				));
//				if (!$cardColor) {
//					$cardColor = new Cardcolor();
//					$cardColor->setColor($color);
//				}
//				if (!$cardType) {
//					$cardType = new Cardtype();
//					$cardType->setType($type);
//				}
//				if ($isNewColor) {
//					$cardIdObj->addCardcolor($cardColor);
//				}
//				if ($isNewType) {
//					$cardIdObj->addCardtype($cardType);
//				}
//				$cardIdObj->setCardId($carId);
//				$em->persist($cardColor, true);
//				$em->persist($cardType, true);
//				$em->persist($cardIdObj, true);
//				$em->flush();
//			}
//			$msgs[] = 'writed - ' . $color . ' ' . $type . ' ' . date('d.m.Y H:i:s');
//			$msgs[] = $newCard . ' ' . $color . ' ' . $type;
//		}
//		$msgs[] = 'end - ' . date('d.m.Y H:i:s');
//
//		return $this->render('WindMtgparseBundle:Parser:parsing.html.twig', array(
//			'retrys' => $retrys,
//			'msgs' => $msgs
//		));



		for ($i = 1; $i <= 3000; $i++) {
			$cardObj = $em->getRepository('WindMtgparseBundle:Card');
			$cardIdObj = $em->getRepository('WindMtgparseBundle:Cardid');
			$cardTypeObj = $em->getRepository('WindMtgparseBundle:Cardtype');
			$cardRarityObj = $em->getRepository('WindMtgparseBundle:Cardrarity');
			$cardIdObj = $cardIdObj->findOneById($i);
			$cardId = $cardIdObj->getCardId();
			$cardObj = $cardObj->findOneBy(array(
				'cardId' => $cardId
			));
			if (!$cardObj) {
				$cardObj = new Card();
				$cardUrl = "http://gatherer.wizards.com/Pages/Card/Details.aspx?multiverseid={$cardId}";
				$imgUrl = "http://gatherer.wizards.com/Handlers/Image.ashx?multiverseid={$cardId}&type=card";
				$cardData = file_get_contents($cardUrl);
				preg_match('!Card Name:</div>\s*<div class="value">\s*(.*?)</div!si', $cardData, $cardsData);
				if (isset($cardsData[1])) {
					$cardObj->setName($cardsData[1]);
				}
				preg_match('!Converted Mana Cost:</div>\s*<div class="value">\s*(.*?)<!si', $cardData, $cardsData);
				if (isset($cardsData[1])) {
					$cardObj->setConvertedmc($cardsData[1]);
				}
				preg_match('!Types:</div>\s*<div class="value">\s*(.*?)<!si', $cardData, $cardsData);
				if (isset($cardsData[1])) {
					$type = $cardsData[1];
					$cardType = $cardTypeObj->findOneBy(array(
						'type' => $type
					));
					if (!$cardType) {
						$cardType = new Cardtype();
						$cardType->setType($type);
						$cardObj->addCardtype($cardType);
					}
				}
				preg_match('!Card Text:</div>\s*<div class="value">\s*(.*?)</div!si', $cardData, $cardsData);
				if (isset($cardsData[1])) {
					$cardObj->setCardtext(trim(strip_tags($cardsData[1])));
				}
				preg_match('!Flavor Text:</div>\s*(.*?)</div>\s*</div!si', $cardData, $cardsData);
				if (isset($cardsData[1])) {
					$cardObj->setFlavortext(trim(strip_tags($cardsData[1])));
				}
				preg_match('!P/T:</b>\s*</div>\s*<div class="value">\s*(.*?)</div>\s*</div!si', $cardData, $cardsData);
				if (isset($cardsData[1])) {
					$cardObj->setPt($cardsData[1]);
				}
				preg_match('!Rarity:</div>\s*<div class="value">\s*(.*?)</div>\s*</div!si', $cardData, $cardsData);
				if (isset($cardsData[1])) {
					$rarity = trim(strip_tags($cardsData[1]));
					$cardRarity = $cardRarityObj->findOneBy(array(
						'rariry' => $rarity
					));
					if (!$cardRarity) {
						$cardRarity = new Cardrarity();
						$cardRarity->setRariry($rarity);
						$cardObj->addCardrarity($cardRarity);
					}
				}

				$isNewImage = true;
				foreach ($cardObj->getImages()->toArray() as $cc) {
					if ($cc->getName() == $cardId) {
						$isNewImage = false;
					}
				}
				if ($isNewImage) {
					$imgData = file_get_contents($imgUrl);
					$uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
					if (!is_dir($uploadDir)) {
						mkdir($uploadDir);
					}
					if (file_put_contents($uploadDir . $cardId . '.jpg', $imgData)) {
						$img = new Image();
						$img->setName($cardId);
						$cardObj->addImage($img);
					}
				}
				foreach ($cardIdObj->getCardcolors()->toArray() as $cc) {
					$cardObj->addCardcolor($cc);
				}
				foreach ($cardIdObj->getCardtypes()->toArray() as $tt) {
					$cardObj->addCardtype($tt);
				}
				$cardObj->setCardId($cardId);
				$em->persist($cardType, true);
				$em->persist($cardRarity, true);
				$em->persist($img, true);
				$em->persist($cardObj, true);
				$em->flush();
			}
		}

		return $this->render('WindMtgparseBundle:Parser:parsing.html.twig', array(
			'retrys' => array(),
			'msgs' => array()
		));
	}
}
