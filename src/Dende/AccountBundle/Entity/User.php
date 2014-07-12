<?php

namespace Dende\AccountBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Dende\AccountBundle\Model\InvoiceData;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @UniqueEntity(
 *     fields={"email"},
 *     message="user.email_exists"
 * )
 * @UniqueEntity(
 *     fields={"username"},
 *     message="user.username_exists"
 * )
 * @codeCoverageIgnore
 */
class User extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Assert\NotBlank(message = "user.firstname.field_cannot_be_empty", groups = {"Profile"})
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     * @var string $firstname
     */
    protected $firstname;

    /**
     * Assert\NotBlank(message = "user.lastname.field_cannot_be_empty", groups = {"Profile"})
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     * @var string $lastname
     */
    protected $lastname;

    /**
     * @ORM\OneToMany(
     *  targetEntity="Dende\SubscriptionBundle\Entity\SubscriptionBase",
     *  mappedBy="user", cascade={"remove"}, orphanRemoval=true
     * )
     */
    protected $subscriptions;

    /**
     * @ORM\Column(name="invoiceData", type="object", nullable=true)
     * @var InvoiceData $invoiceData
     */
    protected $invoiceData;

    public function __construct()
    {
        parent::__construct();

        $this->setSubscriptions(new ArrayCollection());
        $this->setInvoiceData(new InvoiceData());
    }

    public function getSubscriptions()
    {
        return $this->subscriptions;
    }

    public function setSubscriptions($subscriptions)
    {
        $this->subscriptions = $subscriptions;
        return $this;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getInvoiceData()
    {
        return clone($this->invoiceData);
    }

    public function setInvoiceData(InvoiceData $invoiceData)
    {
        $this->invoiceData = $invoiceData;
        return $this;
    }
}
