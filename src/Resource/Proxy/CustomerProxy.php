<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring\Resource\Proxy;

use DateTimeImmutable;
use LauLamanApps\eCurring\eCurringClientInterface;
use LauLamanApps\eCurring\Resource\Customer;
use LauLamanApps\eCurring\Resource\Customer\Gender;
use LauLamanApps\eCurring\Resource\Customer\VerificationMethod;
use LauLamanApps\eCurring\Resource\CustomerInterface;
use LauLamanApps\eCurring\Resource\Transaction\PaymentMethod;

/**
 * @method int getId()
 * @method Gender getGender()
 * @method string getFirstName()
 * @method string|null getMiddleName()
 * @method string getLastName()
 * @method string getCompanyName()
 * @method string getVatNumber()
 * @method PaymentMethod getPaymentType()
 * @method VerificationMethod|null getBankVerificationMethod()
 * @method string getCardHolder()
 * @method string getCardNumber()
 * @method string getPostalcode()
 * @method string getHouseNumber()
 * @method string|null getHouseNumberAdd()
 * @method string getStreet()
 * @method string getCity()
 * @method string getCountryCode()
 * @method string getLanguage()
 * @method string getEmail()
 * @method string getTelephone()
 * @method array getSubscriptions()
 * @method DateTimeImmutable getCreatedAt()
 * @method DateTimeImmutable getUpdatedAt()
 */
final class CustomerProxy extends AbstractProxy implements CustomerInterface
{
    /**
     * @return Customer
     */
    protected function __load(eCurringClientInterface $client, string $id)
    {
        return $client->getCustomer($id);
    }
}
