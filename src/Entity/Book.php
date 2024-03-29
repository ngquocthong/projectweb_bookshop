<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]

    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'float')]
    private $price;

    #[ORM\Column(type: 'string', length: 255)]
    private $description;

    #[ORM\Column(type: 'date')]
    private $publishDate;

    
    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\File(
        maxSize: '1024k',
        mimeTypes: ['image/png', 'image/jpeg', 'image/jpg'],
        mimeTypesMessage: 'Please upload a valid images',
    )]
    private $image;

    #[ORM\Column(type: 'string', length: 255, nullable:true)]
    private $rate;

    #[ORM\Column(type: 'integer')]
    private $printlength;

    #[ORM\OneToMany(mappedBy: 'book', targetEntity: Feedback::class)]
    private $feedback;



    #[ORM\OneToMany(mappedBy: 'book', targetEntity: Orderdetails::class)]
    private $orderdetails;


    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'category')]
    private $category;

    #[ORM\ManyToOne(targetEntity: Publisher::class, inversedBy: 'publisher')]
    private $publisher;

    #[ORM\OneToMany(mappedBy: 'book', targetEntity: Cart::class)]
    private $carts;

    #[ORM\Column(length: 255)]
    private ?string $author = null;



    public function __construct()
    {
        $this->feedback = new ArrayCollection();
        $this->orderdetails = new ArrayCollection();
        $this->book = new ArrayCollection();
        $this->carts = new ArrayCollection();
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

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    } 
    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPublishDate(): ?\DateTimeInterface
    {
        return $this->publishDate;
    }

    public function setPublishDate(\DateTimeInterface $publishDate): self
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getRate(): ?string
    {
        return $this->rate;
    }

    public function setRate(string $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getPrintlength(): ?int
    {
        return $this->printlength;
    }

    public function setPrintlength(int $printlength): self
    {
        $this->printlength = $printlength;

        return $this;
    }

    /**
     * @return Collection<int, Feedback>
     */
    public function getFeedback(): Collection
    {
        return $this->feedback;
    }

    public function addFeedback(Feedback $feedback): self
    {
        if (!$this->feedback->contains($feedback)) {
            $this->feedback[] = $feedback;
            $feedback->setBook($this);
        }

        return $this;
    }

    public function removeFeedback(Feedback $feedback): self
    {
        if ($this->feedback->removeElement($feedback)) {
            // set the owning side to null (unless already changed)
            if ($feedback->getBook() === $this) {
                $feedback->setBook(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection<int, OrderDetails>
     */
    public function getOrderdetails(): Collection
    {
        return $this->orderdetails;
    }

    public function addOrderdetail(Orderdetails $orderdetail): self
    {
        if (!$this->orderdetails->contains($orderdetail)) {
            $this->orderdetails[] = $orderdetail;
            $orderdetail->setBook($this);
        }

        return $this;
    }

    public function removeOrderdetail(Orderdetails $orderdetail): self
    {
        if ($this->orderdetails->removeElement($orderdetail)) {
            // set the owning side to null (unless already changed)
            if ($orderdetail->getBook() === $this) {
                $orderdetail->setBook(null);
            }
        }

        return $this;
    }




    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getPublisher(): ?Publisher
    {
        return $this->publisher;
    }

    public function setPublisher(?Publisher $publisher): self
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function __toString() {
        return $this->getName();
    }

    /**
     * @return Collection<int, Cart>
     */
    public function getCarts(): Collection
    {
        return $this->carts;
    }

    public function addCart(Cart $cart): self
    {
        if (!$this->carts->contains($cart)) {
            $this->carts[] = $cart;
            $cart->setBook($this);
        }

        return $this;
    }

    public function removeCart(Cart $cart): self
    {
        if ($this->carts->removeElement($cart)) {
            // set the owning side to null (unless already changed)
            if ($cart->getBook() === $this) {
                $cart->setBook(null);
            }
        }

        return $this;
    }





}
