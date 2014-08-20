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
		$opts = array(
			'http'=>array(
				'method'=>"GET",
				'header'=>"Accept-language: ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4"
			)
		);
		$context = stream_context_create($opts);
		$cardIdObj = $em->getRepository('WindMtgparseBundle:Cardid');
		$cardColorObj = $em->getRepository('WindMtgparseBundle:Cardcolor');
		$cardTypeObj = $em->getRepository('WindMtgparseBundle:Cardtype');
		$cardRarityObj = $em->getRepository('WindMtgparseBundle:Cardrarity');
		$cardObj = $em->getRepository('WindMtgparseBundle:Card');
		$cardImageObj = $em->getRepository('WindMtgparseBundle:Image');

//		$colors = array('W', 'U', 'B', 'R', 'G');
//		$colors = array('G');
//		$type = 'Tribal';
//		$msgs[] = 'start - ' . date('d.m.Y H:i:s');
//		foreach ($colors as $color) {
//			$newCard = 0;
//			$cardsIds = array();
//			$retrys = array();
//			for ($i=0; $i<=0; $i++) {
//				$siteData = file_get_contents("http://gatherer.wizards.com/Pages/Search/Default.aspx?page={$i}&type=+[{$type}]&output=compact", false, $context);
//				preg_match_all('!href="../Card/Details.aspx\?multiverseid=(\d+)"!si', $siteData, $cardsData);
//				$cardsIds = array_merge($cardsIds, $cardsData[1]);
//			}
//			$msgs[] = 'parced - ' . count(array_unique($cardsIds)) . ' ' . $type . ' ' . date('d.m.Y H:i:s');
//			$msgs[] = 'parced - ' . $color . ' ' . $type . ' ' . date('d.m.Y H:i:s');
//			foreach (array_unique($cardsIds) as $carId) {
//				$cardIdOne = $cardIdObj->findOneBy(array(
//					'cardId' => $carId
//				));
//				$isNewColor = true;
//				$isNewType = true;
//				if (!$cardIdOne) {
//					$cardIdOne = new Cardid();
//					$newCard++;
//				} else {
//					$retrys[$cardIdOne->getId()] = $carId;
//					$cardIdOne = $cardIdOne;
//					foreach ($cardIdOne->getCardcolors()->toArray() as $cc) {
//						if ($cc->getColor() == $color) {
//							$isNewColor = false;
//						}
//					}
//					foreach ($cardIdOne->getCardtypes()->toArray() as $tt) {
//						if ($tt->getType() == $type) {
//							$isNewType = false;
//						}
//					}
//				}
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
//					$cardIdOne->addCardcolor($cardColor);
//				}
//				if ($isNewType) {
//					$cardIdOne->addCardtype($cardType);
//				}
//				$cardIdOne->setCardId($carId);
//				$em->persist($cardColor, true);
//				$em->persist($cardType, true);
//				$em->persist($cardIdOne, true);
//				$em->flush();
//			}
//			$msgs[] = 'writed - ' . $newCard . ' ' . $type . ' ' . date('d.m.Y H:i:s');
//			$msgs[] = 'writed - ' . $color . ' ' . $type . ' ' . date('d.m.Y H:i:s');
//			$msgs[] = $newCard . ' ' . $color . ' ' . $type;
//		}
//		$msgs[] = 'end - ' . date('d.m.Y H:i:s');
//
//		return $this->render('WindMtgparseBundle:Parser:parsing.html.twig', array(
//			'retrys' => $retrys,
//			'msgs' => $msgs
//		));

		for ($i = 400; $i <= 1000; $i++) {
			$cardIdOne = $cardIdObj->findOneById($i);
			$cardId = $cardIdOne->getCardId();
			$cardOne = $cardObj->findOneBy(array(
				'cardId' => $cardId
			));
			if (!$cardOne) {
				$cardOne = new Card();
				$cardUrl = "http://gatherer.wizards.com/Pages/Card/Details.aspx?printed=true&multiverseid={$cardId}";
				$imgUrl = "http://gatherer.wizards.com/Handlers/Image.ashx?multiverseid={$cardId}&type=card";
				$cardData = file_get_contents($cardUrl, false, $context);
				preg_match('!Card Name:</div>\s*<div class="value">\s*(.*?)</div!si', $cardData, $cardsData);
				if (isset($cardsData[1])) {
					$cardOne->setName($cardsData[1]);
				}
				preg_match('!Converted Mana Cost:</div>\s*<div class="value">\s*(.*?)<!si', $cardData, $cardsData);
				if (isset($cardsData[1])) {
					$cardOne->setConvertedmc($cardsData[1]);
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
					}
					$cardOne->addCardtype($cardType);
				}
				preg_match('!Card Text:</div>\s*<div class="value">\s*(.*?)</div!si', $cardData, $cardsData);
				if (isset($cardsData[1])) {
					$cardOne->setCardtext(trim(strip_tags($cardsData[1])));
				}
				preg_match('!Flavor Text:</div>\s*(.*?)</div>\s*</div!si', $cardData, $cardsData);
				if (isset($cardsData[1])) {
					$cardOne->setFlavortext(trim(strip_tags($cardsData[1])));
				}
				preg_match('!P/T:</b>\s*</div>\s*<div class="value">\s*(.*?)</div>\s*</div!si', $cardData, $cardsData);
				if (isset($cardsData[1])) {
					$cardOne->setPt($cardsData[1]);
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
					}
					$cardOne->addCardrarity($cardRarity);
				}

				$isNewImage = true;
				foreach ($cardOne->getImages()->toArray() as $cc) {
					if ($cc->getName() == $cardId) {
						$isNewImage = false;
					}
				}
				if ($isNewImage) {
					$imgData = file_get_contents($imgUrl, false, $context);
					$uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
					if (!is_dir($uploadDir)) {
						mkdir($uploadDir);
					}
					if (file_put_contents($uploadDir . $cardId . '.jpg', $imgData)) {
						$img = $cardImageObj->findOneBy(array(
							'name' => $cardId
						));
						if (!$img) {
							$img = new Image();
							$img->setName($cardId);
						}
						$cardOne->addImage($img);
					}
				}
				foreach ($cardIdOne->getCardcolors()->toArray() as $cc) {
					$cardOne->addCardcolor($cc);
				}
				foreach ($cardIdOne->getCardtypes()->toArray() as $tt) {
					if ($tt->getId() != $cardType->getId()) {
						$cardOne->addCardtype($tt);
					}
				}
				$cardOne->setCardId($cardId);
				$em->persist($cardType, true);
				$em->persist($cardRarity, true);
				$em->persist($img, true);
				$em->persist($cardOne, true);
				$em->flush();
			}
		}

		return $this->render('WindMtgparseBundle:Parser:parsing.html.twig', array(
			'retrys' => array(),
			'msgs' => array()
		));
	}
}
