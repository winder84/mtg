<?php

namespace Wind\Bundle\MtgparseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cardrarity
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Cardrarity
{
	/**
	 * @ORM\ManyToMany(targetEntity="Card", mappedBy="cardrarities")
	 */
	private $cards;

	public function __construct() {
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
     * @ORM\Column(name="rarity", type="string", length=255)
     */
    private $rariry;


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
     * Set rariry
     *
     * @param string $rariry
     * @return Cardrarity
     */
    public function setRariry($rariry)
    {
        $this->rariry = $rariry;

        return $this;
    }

    /**
     * Get rariry
     *
     * @return string 
     */
    public function getRariry()
    {
        return $this->rariry;
    }

    /**
     * Add cards
     *
     * @param \Wind\Bundle\MtgparseBundle\Entity\Card $cards
     * @return Cardrarity
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
