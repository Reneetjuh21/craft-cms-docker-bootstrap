<?php
declare(strict_types=1);

namespace modules\sitemodule\services;

use craft\base\Component;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ApiService extends Component
{
    private Client $client;
    private string $token;
    private string $clientId;

    public function __construct()
    {
        parent::__construct();
        $this->client = new Client([
            'base_uri' => 'https://data.sportlink.com/',
        ]);
        $this->token = 'fpsepgl1ghoieil1vfpc20ja6';
        $this->clientId = 'KuZ96hoyUZ';
    }

    public function send(
        string $method,
        string $uri,
        array $headers = [],
        array $body = [],
        array $query = [],
    ): array {
        try {
            $query['clientId'] = $this->clientId;
            $options = [
                'headers' => $headers,
                'query' => $query
            ];

            if (!empty($body)) {
                $options['body'] = $body;
            }

            $result = $this->client->request(
                $method,
                $uri,
                $options
            );
            return json_decode($result->getBody()->getContents(), true);
        } catch (GuzzleException $exception) {
            dump($exception->getMessage());
            return [];
        }
    }
}
