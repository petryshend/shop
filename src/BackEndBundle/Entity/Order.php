<?php

namespace BackEndBundle\Entity;

/**
 * Order
 */
class Order
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \BackEndBundle\Entity\OrderInfo
     */
    private $orderInfo;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $orderItems;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->orderItems = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set orderInfo
     *
     * @param \BackEndBundle\Entity\OrderInfo $orderInfo
     *
     * @return Order
     */
    public function setOrderInfo(\BackEndBundle\Entity\OrderInfo $orderInfo = null)
    {
        $this->orderInfo = $orderInfo;

        return $this;
    }

    /**
     * Get orderInfo
     *
     * @return \BackEndBundle\Entity\OrderInfo
     */
    public function getOrderInfo()
    {
        return $this->orderInfo;
    }

    /**
     * Add orderItem
     *
     * @param \BackEndBundle\Entity\OrderItem $orderItem
     *
     * @return Order
     */
    public function addOrderItem(\BackEndBundle\Entity\OrderItem $orderItem)
    {
        $this->orderItems[] = $orderItem;

        return $this;
    }

    /**
     * Remove orderItem
     *
     * @param \BackEndBundle\Entity\OrderItem $orderItem
     */
    public function removeOrderItem(\BackEndBundle\Entity\OrderItem $orderItem)
    {
        $this->orderItems->removeElement($orderItem);
    }

    /**
     * Get orderItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrderItems()
    {
        return $this->orderItems;
    }
}
