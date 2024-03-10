<?php

namespace App\Service\TermScore\SearchProvider;

use App\Service\TermScore\SearchTermInterface;
use Github\Client;

class GithubSearchProvider implements SearchTermInterface
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function searchPositive(string $term): int
    {
        $results = $this->client->api('search')->issues("$term rocks");
        
        return array_key_exists('total_count', $results)
            ? $results['total_count']
            : 0;
    }

    public function searchNegative(string $term): int
    {
        $results = $this->client->api('search')->issues("$term sucks");
        
        return array_key_exists('total_count', $results)
            ? $results['total_count']
            : 0;
    }
}