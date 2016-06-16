<?php

namespace BackEndBundle\Entity;

/**
 * Order
 */
class Order
{
    const STATUS_PLACED = 'placed';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_CANCELLED = 'cancelled';

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
     * @var string
     */
    private $status = self::STATUS_PLACED;

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
     * Get orderInfo
     *
     * @return \BackEndBundle\Entity\OrderInfo
     */
    public function getOrderInfo()
    {
        return $this->orderInfo;
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

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Order
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
}
