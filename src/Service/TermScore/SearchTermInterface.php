<?php

namespace App\Service\TermScore;

interface SearchTermInterface
{
    public function searchPositive(string $term): int;
    public function searchNegative(string $term): int;
}