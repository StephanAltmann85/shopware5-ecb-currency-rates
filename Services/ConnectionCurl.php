<?php

namespace saltyUpdateCurrencyRates\Services;

/**
 * Class ConnectionCurl
 * @package saltyUpdateCurrencyRates\Services
 */
class ConnectionCurl implements ConnectionServiceInterface {

    /**
     * @var string
     */
    private $resource;

    /**
     * @var ParsingServiceInterface
     */
    private $parsingService;

    /**
     * ConnectionCurl constructor.
     * @param string $resource
     * @param ParsingServiceInterface $parser
     */
    public function __construct(string $resource, ParsingServiceInterface $parser) {
        $this->resource = $resource;
        $this->parsingService = $parser;
    }


    /**
     * @return mixed
     */
    public function get() {
        return $this->parsingService->parse($this->connect());
    }

    /**
     * @return mixed
     */
    public function connect() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->resource);
        curl_setopt($ch, CURLOPT_FAILONERROR,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

}