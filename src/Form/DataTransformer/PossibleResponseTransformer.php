<?php
namespace Prolyfix\GoaBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class PossibleResponseTransformer implements DataTransformerInterface{
    public function transform(mixed $value):mixed
    {
        if($value == null){
            return "";
        }
        $array = implode(",", $value);
        return $array;

    }

    public function reverseTransform(mixed $value): mixed
    {
        return explode(",", $value);
    }


}