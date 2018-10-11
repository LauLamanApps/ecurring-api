<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring\Resource;

use DateTimeImmutable;
use LauLamanApps\eCurring\Resource\Customer\Gender;
use LauLamanApps\eCurring\Resource\Customer\VerificationMethod;
use LauLamanApps\eCurring\Resource\Transaction\PaymentMethod;

final class Customer implements CustomerInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Gender
     *
     * The gender of the customer.
     * Used to determine the salutation in communication with the customer. Possible values: m / f
     */
    private $gender;

    /**
     * @var string
     *
     * The first name of the customer
     */
    private $firstName;

    /**
     * @var string|null
     *
     * The middle name of the customer
     */
    private $middleName;

    /**
     * @var string
     *
     * The last name of the customer
     */
    private $lastName;

    /**
     * @var string
     *
     * The name of the company of the customer
     */
    private $companyName;

    /**
     * @var string
     *
     * The vat number of the company of the customer
     */
    private $vatNumber;

    /**
     * @var PaymentMethod
     *
     * The payment type used to collect the funds from the customer.
     */
    private $paymentType;

    /**
     * @var VerificationMethod|null
     *
     * The method used used by the customer to validate their bankaccount or creditcard.
     * Empty when IBAN is manually entered.
     */
    private $bankVerificationMethod;

    /**
     * @var string
     *
     * The name of the holder of the bank account or creditcard.
     * Replaces the deprecated bankHolder.
     */
    private $cardHolder;

    /**
     * @var string
     *
     * The last 4 digits of the bank account or creditcard of the client.
     */
    private $cardNumber;

    /**
     * @var string
     *
     * The postalcode of the address of the customer
     */
    private $postalcode;

    /**
     * @var string
     *
     * The house number of the address of the customer
     */
    private $houseNumber;

    /**
     * @var string|null
     *
     * The house number addition of the address of the customer
     */
    private $houseNumberAdd;

    /**
     * @var string
     *
     * The street of the address of the customer
     */
    private $street;

    /**
     * @var string
     *
     * The city of the address of the customer
     */
    private $city;

    /**
     * @var string
     *
     * The 2 letter ISO code of the country of residence of the customer
     */
    private $countryCode;

    /**
     * @var string
     *
     * The preferred communication language of the customer.
     * Any notifications sent to the customer will be in this language.
     * Possible values: nl / en.
     */
    private $language;

    /**
     * @var string
     *
     * The email address of the customer
     */
    private $email;

    /**
     * @var string
     *
     * The telephone number of the customer
     */
    private $telephone;

    /**
     * @var Subscription[]
     *
     * The subscriptions of the customers
     */
    private $subscriptions;

    /**
     * @var DateTimeImmutable
     *
     * The date on which the customer was created
     */
    private $createdAt;

    /**
     * @var DateTimeImmutable
     *
     * The date on which the customer was last updated
     */
    private $updatedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function getGender(): Gender
    {
        return $this->gender;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    public function getVatNumber(): string
    {
        return $this->vatNumber;
    }

    public function getPaymentType(): PaymentMethod
    {
        return $this->paymentType;
    }

    public function getBankVerificationMethod(): ?VerificationMethod
    {
        return $this->bankVerificationMethod;
    }

    public function getCardHolder(): string
    {
        return $this->cardHolder;
    }

    public function getCardNumber(): string
    {
        return $this->cardNumber;
    }

    public function getPostalcode(): string
    {
        return $this->postalcode;
    }

    public function getHouseNumber(): string
    {
        return $this->houseNumber;
    }

    public function getHouseNumberAdd(): ?string
    {
        return $this->houseNumberAdd;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function getSubscriptions(): array
    {
        return $this->subscriptions;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
