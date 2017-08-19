<?php

namespace API;

class Configuration {

    private $api;

    /**
     * Configuration constructor.
     */
    public function __construct()
    {
        $this->api = [
            'app_id' => '115716112423039',
            'app_secret' => '2d42f999600aaa28d7834ed4e263a466'
        ];
    }

    /**
     * @return array
     */
    public function getApi(): array
    {
        return $this->api;
    }
}