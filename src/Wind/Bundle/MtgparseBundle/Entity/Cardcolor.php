<?php

namespace Wind\Bundle\MtgparseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cardcolor
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Cardcolor
{
	/**
	 * @ORM\ManyToMany(targetEntity="Cardid", mappedBy="cardcolors")
	 */
	private $cardids;

	public function __construct() {
		$this->cardids = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @ORM\Column(name="color", type="string", length=255)
     */
    private $color;


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
     * Set color
     *
     * @param string $color
     * @return Cardcolor
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Add cardids
     *
     * @param \Wind\Bundle\MtgparseBundle\Entity\Cardid $cardids
     * @return Cardcolor
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
}
