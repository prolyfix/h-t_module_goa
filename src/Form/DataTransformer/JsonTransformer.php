<?php

namespace Prolyfix\GoaBundle\Form\DataTransformer;

use Prolyfix\GoaBundle\Entity\UntersuchungsQuestion;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class JsonTransformer implements DataTransformerInterface
{
    /**
     * Transforms an array of actions into a JSON string.
     *
     * @param array|null $actions
     *
     * @return string
     */
    public function transform(mixed $actions):mixed
    {

        if (null === $actions || !is_array($actions)) {
            return new UntersuchungsQuestion();
            return '';
        }
    }

    /**
     * Transforms a JSON string into an array of actions.
     *
     * @param string $jsonString
     *
     * @return array
     *
     * @throws TransformationFailedException if the transformation fails.
     */
    public function reverseTransform($jsonString): array
    {
        if (!$jsonString) {
            return [];
        }

        $array =$jsonString;

        return $array;
    }
}