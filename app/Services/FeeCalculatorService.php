<?php

namespace App\Services;

use GuzzleHttp\Client;

class FeeCalculatorService
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('services.fee_calculator.base_uri'),
            'timeout'  => config('services.fee_calculator.timeout'),
        ]);
    }

    public function getCountries()
    {
        $res = $this->client->get('countries');
        return json_decode($res->getBody(), true);
    }

    public function getTerms(array $params)
    {
        $res = $this->client->get('terms', ['query' => $params]);
        return json_decode($res->getBody(), true);
    }

    // Program levels, faculties, departments, dorms, meals, payment plans...
    // calculate(array $payload) → POST 'calculate'
}
