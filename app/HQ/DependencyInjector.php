<?php

namespace App\HQ;

class DependencyInjector {
    private $services = [];

    public function register($name, $service) {
        $this->services[$name] = $service;
    }

    public function get($name) {
        return $this->services[$name] ?? null;
    }
}
