<?php

declare(strict_types=1);

namespace UMA\DoctrineDemo\Domain;

/**
 * The ProductCycle class demonstrates how to annotate a simple
 * PHP class to act as a Doctrine entity.
 *
 * @Entity()
 * @Table(name="product_cycle")
 */
class ProductCycle implements \JsonSerializable
{
    /**
     * @var int
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ManyToOne(targetEntity="Product", inversedBy="productCycle") */
    private $cycle;

    /**
     * @var int
     * @Column(type="integer")
     */
    private $months;

    /**
     * @var number
     * @number
     * @Column(type="float", nullable=false)
     */
    private $priceRenew;

    /**
     * @var number
     * @number
     * @Column(type="float", nullable=false)
     */
    private $priceOrder;

    public function __construct(integer $cycle, integer $months, number $priceRenew, number $priceOrder)
    {
        $this->cycle = $cycle;
        $this->months = $months;
        $this->priceRenew = $priceRenew;
        $this->priceOrder = $priceOrder;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCycle(): string
    {
        return $this->cycle;
    }

    public function getMonths(): string
    {
        return (String) $this->months;
    }

    public function getPriceRenew(): string
    {
        return (String) $this->priceRenew;
    }

    public function getPriceOrder(): string
    {
        return (String) $this->priceOrder;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'cycle' => $this->getCycle(),
            'months' => $this->getMonths(),
            'priceRenew' => $this->getPriceRenew(),
            'priceOrder' => $this->getPriceOrder(),
        ];
    }
}
