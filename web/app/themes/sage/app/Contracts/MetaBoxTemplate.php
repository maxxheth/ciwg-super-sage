<?php

namespace App\Contracts;

interface MetaBoxTemplate
{
    /**
     * Get the meta box configuration
     * 
     * @return array
     */
    public function getConfig(): array;
}