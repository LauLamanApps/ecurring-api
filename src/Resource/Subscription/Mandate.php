<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring\Resource\Subscription;

use DateTimeImmutable;

final class Mandate
{
    /**
     * @var string
     *
     * The unique mandate code which is generated when creating a subscription.
     */
    private $code;

    /**
     * @var bool
     *
     * Indicates whether the mandate has been accepted.
     * A mandate can be accepted by the customer or automatically by using the API.
     */
    private $accepted;

    /**
     * @var DateTimeImmutable
     *
     * The date on which the mandate has been accepted.
     */
    private $acceptedDate;

    public function __construct(string $code, bool $accepted, DateTimeImmutable $acceptedDate)
    {
        $this->code = $code;
        $this->accepted = $accepted;
        $this->acceptedDate = $acceptedDate;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function isAccepted(): bool
    {
        return $this->accepted;
    }

    public function getAcceptedDate(): DateTimeImmutable
    {
        return $this->acceptedDate;
    }
}
