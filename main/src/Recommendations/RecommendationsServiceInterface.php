<?php

namespace Tbd\Main\Recommendations;

interface RecommendationsServiceInterface
{
    public function createImpression(int $id): bool;

    /**
     * @return int[]
     */
    public function getRecommendations(int $id): array;
}