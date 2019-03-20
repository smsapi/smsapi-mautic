<?php

namespace MauticPlugin\MauticSmsapiBundle\Core;

class Profile
{
    public $points;

    public function __construct(float $points)
    {
        $this->points = $points;
    }
}