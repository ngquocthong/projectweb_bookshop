<?php

namespace App\Entity;

use App\Repository\PublisherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PublisherRepository::class)]
class Publisher
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'publisher', targetEntity: Book::class)]
    private $publisher;

    public function __construct()
    {
        $this->publisher = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getPublisher(): Collection
    {
        return $this->publisher;
    }

    public function addPublisher(Book $publisher): self
    {
        if (!$this->publisher->contains($publisher)) {
            $this->publisher[] = $publisher;
            $publisher->setPublisher($this);
        }

        return $this;
    }

    public function removePublisher(Book $publisher): self
    {
        if ($this->publisher->removeElement($publisher)) {
            // set the owning side to null (unless already changed)
            if ($publisher->getPublisher() === $this) {
                $publisher->setPublisher(null);
            }
        }

        return $this;
    }
    public function __toString() {
        return $this->getName();
    }

}
