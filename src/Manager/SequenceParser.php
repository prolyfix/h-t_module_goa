<?php

namespace Prolyfix\GoaBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Prolyfix\GoaBundle\Entity\Number;
use Prolyfix\GoaBundle\Entity\Sequence;
use Prolyfix\GoaBundle\Entity\SequenceEntry;

class SequenceParser
{
    public function __construct(private EntityManagerInterface $em){}


    public function parseSequence(string $sequenceString, float $defaultFactor = 1): Sequence
    {
        $sequence = new Sequence();
        $sequenceArray = explode(',', $sequenceString);
        foreach ($sequenceArray as $sequenceEntryString) {
            $sequenceEntry = $this->parseSequenceEntry($sequenceEntryString, $defaultFactor);
            $sequence->addSequenceEntry($sequenceEntry);
        }
        return $sequence;
    }

    private function parseSequenceEntry(string $sequenceEntryString, $defaultFactor): SequenceEntry
    {
        $sequenceEntryString = str_replace(')', '', $sequenceEntryString);
        $sequenceEntryArray = explode('(', $sequenceEntryString);
        $sequenceEntry = (new SequenceEntry())->setQuantity(1)->setFactor(1);
        foreach ($sequenceEntryArray as $sequenceEntryPart) {
            $keyArray = explode(':', $sequenceEntryPart);
            if (count($keyArray) == 1) {
                $number = $this->em->getRepository(Number::class)->findOneByNumber(str_replace(' ','',$keyArray[0]));
                $sequenceEntry->setNumber($number);
                switch($defaultFactor){
                    case 'Schwellenwert':
                        $sequenceEntry->setFactor($number->getThreshold());
                        break;
                    case 'Grenzwert':
                        $sequenceEntry->setFactor($number->getLimit());
                        break;
                    default:
                        $sequenceEntry->setFactor(1);
                        break;
                }
            } else {
                $key = $keyArray[0];
                $value = $keyArray[1];
                switch ($key) {
                    case 'q':
                        $sequenceEntry->setQuantity($value);
                        break;
                    case 'Faktor':
                        $sequenceEntry->setFactor($value);
                        break;
                    case 'c':
                        $sequenceEntry->setComment($value);
                        break;
                }
            }
        }


        return $sequenceEntry;
    }
}
