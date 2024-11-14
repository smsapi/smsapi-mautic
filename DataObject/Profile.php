<?php

namespace MauticPlugin\MauticSmsapiBundle\DataObject;

class Profile
{
    public $points;

    public function __construct(float $points)
    {
        $this->points = $points;
    }
}
