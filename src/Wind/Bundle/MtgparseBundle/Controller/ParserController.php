<?php

namespace Wind\Bundle\MtgparseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Wind\Bundle\MtgparseBundle\Entity\Cardcolor;
use Wind\Bundle\MtgparseBundle\Entity\Cardid;
use Wind\Bundle\MtgparseBundle\Entity\Cardtype;

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
		$colors = array('W', 'U', 'B', 'R', 'G');
//		$colors = array('G');
		$type = 'Tribal';
		$msgs[] = 'start - ' . date('d.m.Y H:i:s');
		foreach ($colors as $color) {
			$newCard = 0;
			$cardsIds = array();
			$retrys = array();
			for ($i=0; $i<=0; $i++) {
				$siteData = file_get_contents("http://gatherer.wizards.com/Pages/Search/Default.aspx?page={$i}&color=|[{$color}]&output=compact&type=+[{$type}]");
				preg_match_all('!href="../Card/Details.aspx\?multiverseid=(\d+)"!si', $siteData, $cardsData);
				$cardsIds = array_merge($cardsIds, $cardsData[1]);
			}
			$msgs[] = 'parced - ' . $color . ' ' . $type . ' ' . date('d.m.Y H:i:s');
			$em = $this->getDoctrine()->getManager();
			foreach ($cardsIds as $carId) {
				$cardIdObj = $em->getRepository('WindMtgparseBundle:Cardid');
				$cardIdObj = $cardIdObj->findOneBy(array(
					'cardId' => $carId
				));
				$isNewColor = true;
				$isNewType = true;
				if (!$cardIdObj) {
					$cardIdObj = new Cardid();
					$newCard++;
				} else {
					$retrys[$cardIdObj->getId()] = $carId;
					$cardIdObj = $cardIdObj;
					foreach ($cardIdObj->getCardcolors()->toArray() as $cc) {
						if ($cc->getColor() == $color) {
							$isNewColor = false;
						}
					}
					foreach ($cardIdObj->getCardtypes()->toArray() as $tt) {
						if ($tt->getType() == $type) {
							$isNewType = false;
						}
					}
				}
				$cardColorObj = $em->getRepository('WindMtgparseBundle:Cardcolor');
				$cardTypeObj = $em->getRepository('WindMtgparseBundle:Cardtype');
				$cardColor = $cardColorObj->findOneBy(array(
					'color' => $color
				));
				$cardType = $cardTypeObj->findOneBy(array(
					'type' => $type
				));
				if (!$cardColor) {
					$cardColor = new Cardcolor();
					$cardColor->setColor($color);
				}
				if (!$cardType) {
					$cardType = new Cardtype();
					$cardType->setType($type);
				}
				if ($isNewColor) {
					$cardIdObj->addCardcolor($cardColor);
				}
				if ($isNewType) {
					$cardIdObj->addCardtype($cardType);
				}
				$cardIdObj->setCardId($carId);
				$em->persist($cardColor, true);
				$em->persist($cardType, true);
				$em->persist($cardIdObj, true);
				$em->flush();
			}
			$msgs[] = 'writed - ' . $color . ' ' . $type . ' ' . date('d.m.Y H:i:s');
			$msgs[] = $newCard . ' ' . $color . ' ' . $type;
		}
		$msgs[] = 'end - ' . date('d.m.Y H:i:s');

		return $this->render('WindMtgparseBundle:Parser:parsing.html.twig', array(
			'retrys' => $retrys,
			'msgs' => $msgs
		));
	}
}
