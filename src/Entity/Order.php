<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $date;

    #[ORM\Column(type: 'decimal', precision: 10, scale: '0')]
    private $total;

    #[ORM\ManyToOne(targetEntity: reader::class, inversedBy: 'orders')]
    private $reader;

    #[ORM\OneToMany(mappedBy: 'orders', targetEntity: orderdetails::class)]
    private $orderdetails;

    public function __construct()
    {
        $this->orderdetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(string $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getReader(): ?reader
    {
        return $this->reader;
    }

    public function setReader(?reader $reader): self
    {
        $this->reader = $reader;

        return $this;
    }

    /**
     * @return Collection<int, orderdetails>
     */
    public function getOrderdetails(): Collection
    {
        return $this->orderdetails;
    }

    public function addOrderdetail(orderdetails $orderdetail): self
    {
        if (!$this->orderdetails->contains($orderdetail)) {
            $this->orderdetails[] = $orderdetail;
            $orderdetail->setOrders($this);
        }

        return $this;
    }

    public function removeOrderdetail(orderdetails $orderdetail): self
    {
        if ($this->orderdetails->removeElement($orderdetail)) {
            // set the owning side to null (unless already changed)
            if ($orderdetail->getOrders() === $this) {
                $orderdetail->setOrders(null);
            }
        }

        return $this;
    }
}
