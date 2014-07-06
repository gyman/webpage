<?php

namespace Dende\AccountBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

class InvoiceData
{

    /**
     * @Assert\NotBlank(message = "invoiceData.field_cannot_be_empty")
     * @var string $companyName
     */
    protected $companyName;

    /**
     * @Assert\NotBlank(message = "invoiceData.field_cannot_be_empty")
     * @var string $nip
     */
    protected $nip;

    /**
     * @Assert\NotBlank(message = "invoiceData.field_cannot_be_empty")
     * @var string $street
     */
    protected $street;

    /**
     * @var string $zipcode
     * @Assert\Length(max=6, min=6, minMessage="Kod pocztowy musi zawierać 6 znaków",maxMessage="Kod pocztowy musi zawierać 6 znaków")
     * @Assert\Regex(
     *           pattern= "/\d{2}\-\d{3}/",
     *           match=   true,
     *           message= "Kod pocztowy musi być w formacie AB-CDE"
     * )
     */
    protected $zipcode;

    /**
     * @Assert\NotBlank(message = "invoiceData.field_cannot_be_empty")
     * @var string $city
     */
    protected $city;

    /**
     * @Assert\NotBlank(message = "invoiceData.field_cannot_be_empty")
     * @var string $country
     */
    protected $country;

    public function getCompanyName()
    {
        return $this->companyName;
    }

    public function getNip()
    {
        return $this->nip;
    }

    public function getStreet()
    {
        return $this->street;
    }

    public function getZipcode()
    {
        return $this->zipcode;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
        return $this;
    }

    public function setNip($nip)
    {
        $this->nip = $nip;
        return $this;
    }

    public function setStreet($street)
    {
        $this->street = $street;
        return $this;
    }

    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
        return $this;
    }

    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }
}
