<?php

namespace Wind\Bundle\MtgparseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Card
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Card
{

	/**
	 * @ORM\ManyToMany(targetEntity="Cardcolor", inversedBy="cardids")
	 */
	private $cardcolors;

	/**
	 * @ORM\ManyToMany(targetEntity="Cardtype", inversedBy="cards")
	 */
	private $cardtypes;

	/**
	 * @ORM\ManyToMany(targetEntity="Image", inversedBy="cards")
	 */
	private $images;

	/**
	 * @ORM\ManyToMany(targetEntity="Cardrarity", inversedBy="cards")
	 */
	private $cardrarities;

	public function __construct() {
		$this->cardcolors = new \Doctrine\Common\Collections\ArrayCollection();
		$this->cardtypes = new \Doctrine\Common\Collections\ArrayCollection();
		$this->images = new \Doctrine\Common\Collections\ArrayCollection();
		$this->cardrarities = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @ORM\Column(name="convertedmc", type="integer", nullable=true)
     */
    private $convertedmc;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="cardtext", type="text", nullable=true)
     */
    private $cardtext;

    /**
     * @var string
     *
     * @ORM\Column(name="flavortext", type="text", nullable=true)
     */
    private $flavortext;

    /**
     * @var string
     *
     * @ORM\Column(name="pt", type="string", length=255, nullable=true)
     */
    private $pt;

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
     * Set convertedmc
     *
     * @param integer $convertedmc
     * @return Card
     */
    public function setConvertedmc($convertedmc)
    {
        $this->convertedmc = $convertedmc;

        return $this;
    }

    /**
     * Get convertedmc
     *
     * @return integer 
     */
    public function getConvertedmc()
    {
        return $this->convertedmc;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Card
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set cardtext
     *
     * @param string $cardtext
     * @return Card
     */
    public function setCardtext($cardtext)
    {
        $this->cardtext = $cardtext;

        return $this;
    }

    /**
     * Get cardtext
     *
     * @return string 
     */
    public function getCardtext()
    {
        return $this->cardtext;
    }

    /**
     * Set flavortext
     *
     * @param string $flavortext
     * @return Card
     */
    public function setFlavortext($flavortext)
    {
        $this->flavortext = $flavortext;

        return $this;
    }

    /**
     * Get flavortext
     *
     * @return string 
     */
    public function getFlavortext()
    {
        return $this->flavortext;
    }

    /**
     * Set pt
     *
     * @param string $pt
     * @return Card
     */
    public function setPt($pt)
    {
        $this->pt = $pt;

        return $this;
    }

    /**
     * Get pt
     *
     * @return string 
     */
    public function getPt()
    {
        return $this->pt;
    }

    /**
     * Set cardId
     *
     * @param integer $cardId
     * @return Card
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
     * @return Card
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

    /**
     * Add cardtypes
     *
     * @param \Wind\Bundle\MtgparseBundle\Entity\Cardtype $cardtypes
     * @return Card
     */
    public function addCardtype(\Wind\Bundle\MtgparseBundle\Entity\Cardtype $cardtypes)
    {
        $this->cardtypes[] = $cardtypes;

        return $this;
    }

    /**
     * Remove cardtypes
     *
     * @param \Wind\Bundle\MtgparseBundle\Entity\Cardtype $cardtypes
     */
    public function removeCardtype(\Wind\Bundle\MtgparseBundle\Entity\Cardtype $cardtypes)
    {
        $this->cardtypes->removeElement($cardtypes);
    }

    /**
     * Get cardtypes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCardtypes()
    {
        return $this->cardtypes;
    }

    /**
     * Add images
     *
     * @param \Wind\Bundle\MtgparseBundle\Entity\Image $images
     * @return Card
     */
    public function addImage(\Wind\Bundle\MtgparseBundle\Entity\Image $images)
    {
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \Wind\Bundle\MtgparseBundle\Entity\Image $images
     */
    public function removeImage(\Wind\Bundle\MtgparseBundle\Entity\Image $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add cardrarities
     *
     * @param \Wind\Bundle\MtgparseBundle\Entity\Cardrarity $cardrarities
     * @return Card
     */
    public function addCardrarity(\Wind\Bundle\MtgparseBundle\Entity\Cardrarity $cardrarities)
    {
        $this->cardrarities[] = $cardrarities;

        return $this;
    }

    /**
     * Remove cardrarities
     *
     * @param \Wind\Bundle\MtgparseBundle\Entity\Cardrarity $cardrarities
     */
    public function removeCardrarity(\Wind\Bundle\MtgparseBundle\Entity\Cardrarity $cardrarities)
    {
        $this->cardrarities->removeElement($cardrarities);
    }

    /**
     * Get cardrarities
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCardrarities()
    {
        return $this->cardrarities;
    }
}
