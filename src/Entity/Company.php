<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Translation\Util\ArrayConverter;

/**
 * @ORM\Entity(repositoryClass=CompanyRepository::class)
 */
class Company
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=125)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $zip_code;

    /**
     * @ORM\Column(type="string", length=125)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=125)
     */
    private $state;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * Many Users have Many Groups.
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="members")
     * @ORM\JoinTable(name="company_category")
     */
    private $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zip_code;
    }

    public function setZipCode(string $zip_code): self
    {
        $this->zip_code = $zip_code;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

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

    public function getCategories(): ArrayCollection
    {
        return $this->categories;
    }

    public function joinCategory(Category $category): void
    {
        // $category->addMember($this);

        $this->categories[] = $category;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    // public function getCategoriesFromCompany(CompanyCategory $companyCategory): ArrayCollection
    // {

    //     dd($companyCategory->findOneById(1));
    //     dd($this->id);
    //     return $this->categories;
    // }

    public function getCompanyCategory(): ?CompanyCategory
    {
        return $this->company_category;
    }

    public function setCompanyCategory(?CompanyCategory $company_category): self
    {
        $this->company_category = $company_category;

        return $this;
    }
}
