<?php

namespace App\Rules;

interface  Rule
{
    /**
     * @return float
     */
    public function applyRule() : float;
}
