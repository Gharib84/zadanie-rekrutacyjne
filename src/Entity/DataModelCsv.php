<?php

namespace App\Entity;

use App\Repository\DataModelCsvRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DataModelCsvRepository::class)]
class DataModelCsv
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $customer = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\Column(length: 255)]
    private ?string $customerOrder = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(length: 255)]
    private ?string $customerGroup = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomer(): ?string
    {
        return $this->customer;
    }

    public function setCustomer(string $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getCustomerOrder(): ?string
    {
        return $this->customerOrder;
    }

    public function setCustomerOrder(string $customerOrder): static
    {
        $this->customerOrder = $customerOrder;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCustomerGroup(): ?string
    {
        return $this->customerGroup;
    }

    public function setCustomerGroup(string $customerGroup): static
    {
        $this->customerGroup = $customerGroup;

        return $this;
    }
}
