<?php

namespace Wind\Bundle\MtgparseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cardtype
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Cardtype
{
	/**
	 * @ORM\ManyToMany(targetEntity="Cardid", mappedBy="cardtypes")
	 */
	private $cardids;

	/**
	 * @ORM\ManyToMany(targetEntity="Card", mappedBy="cardtypes")
	 */
	private $cards;

	public function __construct() {
		$this->cardids = new \Doctrine\Common\Collections\ArrayCollection();
		$this->cards = new \Doctrine\Common\Collections\ArrayCollection();
	}

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Cardtype
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add cardids
     *
     * @param \Wind\Bundle\MtgparseBundle\Entity\Cardid $cardids
     * @return Cardtype
     */
    public function addCardid(\Wind\Bundle\MtgparseBundle\Entity\Cardid $cardids)
    {
        $this->cardids[] = $cardids;

        return $this;
    }

    /**
     * Remove cardids
     *
     * @param \Wind\Bundle\MtgparseBundle\Entity\Cardid $cardids
     */
    public function removeCardid(\Wind\Bundle\MtgparseBundle\Entity\Cardid $cardids)
    {
        $this->cardids->removeElement($cardids);
    }

    /**
     * Get cardids
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCardids()
    {
        return $this->cardids;
    }

    /**
     * Add cards
     *
     * @param \Wind\Bundle\MtgparseBundle\Entity\Card $cards
     * @return Cardtype
     */
    public function addCard(\Wind\Bundle\MtgparseBundle\Entity\Card $cards)
    {
        $this->cards[] = $cards;

        return $this;
    }

    /**
     * Remove cards
     *
     * @param \Wind\Bundle\MtgparseBundle\Entity\Card $cards
     */
    public function removeCard(\Wind\Bundle\MtgparseBundle\Entity\Card $cards)
    {
        $this->cards->removeElement($cards);
    }

    /**
     * Get cards
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCards()
    {
        return $this->cards;
    }
}
