<?php

namespace Tbd\Main\Recommendations;

use GuzzleHttp\Client;

class RecommendationsService implements RecommendationsServiceInterface
{
    private $httpClient;

    public function __construct(string $address){
        $this->httpClient = new Client([
            'base_uri' => $address
        ]);
    }

    public function createImpression(int $id): bool
    {
        $response = $this->httpClient->request('POST', '/impression/'.$id);
        if(200 == $response->getStatusCode()){
            return true;
        }
        return false;
    }

    /**
     * @return int[]
     */
    public function getRecommendations(int $id): array
    {
        $response = $this->httpClient->request('GET', '/recommendations/'.$id);
        if(200 == $response->getStatusCode()) {
            $body = $response->getBody();
            return json_decode($body, true);
        }
        return [];
    }
}