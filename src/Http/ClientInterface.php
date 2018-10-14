<?php

namespace LauLamanApps\eCurring\Http;

use LauLamanApps\eCurring\Http\Exception\ApiCallException;
use LauLamanApps\eCurring\Resource\Curser\Pagination;
use Psr\Http\Message\ResponseInterface;

interface ClientInterface
{
    /**
     * @throws ApiCallException
     */
    public function getEndpoint(string $endpoint, ?array $urlBits = [], ?Pagination $page = null): ResponseInterface;

    /**
     * @throws ApiCallException
     */
    public function getUrl(string $url): ResponseInterface;

    /**
     * @throws ApiCallException
     */
    public function postEndpoint(string $endpoint, array $param, ?array $urlBits = []);

    /**
     * @throws ApiCallException
     */
    public function patchEndpoint(string $endpoint, array $param, ?array $urlBits = []);

    /**
     * @throws ApiCallException
     */
    public function deleteEndpoint(string $endpoint, array $param, ?array $urlBits = []);

    public function getJson(ResponseInterface $response): string;
}
