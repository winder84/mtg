<?php

namespace Wind\Bundle\MtgparseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cardid
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Cardid
{
	/**
	 * @ORM\ManyToMany(targetEntity="Cardcolor", inversedBy="cardids")
	 */
	private $cardcolors;

	public function __construct() {
		$this->cardcolors = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @var integer
     *
     * @ORM\Column(name="card_id", type="integer")
     */
    private $cardId;


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
     * Set cardId
     *
     * @param integer $cardId
     * @return Cardid
     */
    public function setCardId($cardId)
    {
        $this->cardId = $cardId;

        return $this;
    }

    /**
     * Get cardId
     *
     * @return integer 
     */
    public function getCardId()
    {
        return $this->cardId;
    }

    /**
     * Add cardcolors
     *
     * @param \Wind\Bundle\MtgparseBundle\Entity\Cardcolor $cardcolors
     * @return Cardid
     */
    public function addCardcolor(\Wind\Bundle\MtgparseBundle\Entity\Cardcolor $cardcolors)
    {
        $this->cardcolors[] = $cardcolors;

        return $this;
    }

    /**
     * Remove cardcolors
     *
     * @param \Wind\Bundle\MtgparseBundle\Entity\Cardcolor $cardcolors
     */
    public function removeCardcolor(\Wind\Bundle\MtgparseBundle\Entity\Cardcolor $cardcolors)
    {
        $this->cardcolors->removeElement($cardcolors);
    }

    /**
     * Get cardcolors
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCardcolors()
    {
        return $this->cardcolors;
    }
}
