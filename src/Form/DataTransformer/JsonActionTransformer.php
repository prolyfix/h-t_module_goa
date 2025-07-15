<?php
namespace Prolyfix\GoaBundle\Form\DataTransformer;

class JsonActionTransformer
{
    public function transform($value)
    {
        return json_encode($value);
    }

    public function reverseTransform($value)
    {
        return json_decode($value, true);
    }
}