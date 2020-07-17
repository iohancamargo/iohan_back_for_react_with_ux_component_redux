<?php

declare(strict_types=1);

namespace UMA\DoctrineDemo\Domain;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * The Product class demonstrates how to annotate a simple
 * PHP class to act as a Doctrine entity.
 *
 * @Entity()
 * @Table(name="product")
 */
class Product implements \JsonSerializable
{
    /**
     * @var int
     *
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(type="string", nullable=false)
     */
    private $name;

    /**
     * @OneToMany(targetEntity="ProductCycle", mappedBy="product", cascade={"ALL"}, indexBy="cycle")
     */
    private $productCycle;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->productCycle = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getProductCycle(): string
    {
        // var_dump($this->productCycle);
        $teste = $this->productCycle->toArray();
        die($teste);
        return $this->productCycle;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
        ];
    }
}
