<?php

namespace App\Factories\Transformers;

class JsonTransformer
{
    public function transform($jsonData)
    {
        // Transform JSON data from Operator API into our own JSON format

        return json_decode($jsonData);
    }
}
