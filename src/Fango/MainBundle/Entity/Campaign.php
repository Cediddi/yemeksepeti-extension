<?php

namespace Fango\MainBundle\Entity;

/**
 * Campaign
 */
class Campaign
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $logo;


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
     * Set name
     *
     * @param string $name
     * @return Campaign
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
     * Set logo
     *
     * @param string $logo
     * @return Campaign
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string 
     */
    public function getLogo()
    {
        return $this->logo;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $userCampaigns;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userCampaigns = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add userCampaigns
     *
     * @param \Fango\MainBundle\Entity\UserCampaign $userCampaigns
     * @return Campaign
     */
    public function addUserCampaign(\Fango\MainBundle\Entity\UserCampaign $userCampaigns)
    {
        $this->userCampaigns[] = $userCampaigns;

        return $this;
    }

    /**
     * Remove userCampaigns
     *
     * @param \Fango\MainBundle\Entity\UserCampaign $userCampaigns
     */
    public function removeUserCampaign(\Fango\MainBundle\Entity\UserCampaign $userCampaigns)
    {
        $this->userCampaigns->removeElement($userCampaigns);
    }

    /**
     * Get userCampaigns
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserCampaigns()
    {
        return $this->userCampaigns;
    }
}
