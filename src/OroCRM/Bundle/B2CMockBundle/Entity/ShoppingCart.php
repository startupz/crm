<?php

namespace OroCRM\Bundle\B2CMockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use OroCRM\Bundle\MagentoBundle\Entity\Customer;
use OroCRM\Bundle\B2CMockBundle\Entity\SaleAddress;

/**
 * ShoppingCart
 *
 * @ORM\Table("orocrm_b2c_shopping_cart")
 * @ORM\Entity
 */
class ShoppingCart
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Customer
     *
     * @ORM\ManyToOne(targetEntity="OroCRM\Bundle\MagentoBundle\Entity\Customer")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    protected $customer;

    /**
     * @var SaleAddress
     *
     * @ORM\ManyToOne(targetEntity="OroCRM\Bundle\B2CMockBundle\Entity\SaleAddress", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="billing_address_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    protected $billingAddress;

    /**
     * @var SaleAddress
     *
     * @ORM\ManyToOne(targetEntity="OroCRM\Bundle\B2CMockBundle\Entity\SaleAddress", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="shipping_address_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    protected $shippingAddress;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
