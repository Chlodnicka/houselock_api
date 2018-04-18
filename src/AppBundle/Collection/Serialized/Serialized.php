<?php
/**
 * Created by PhpStorm.
 * User: majac
 * Date: 30.03.2018
 * Time: 16:52
 */

namespace AppBundle\Collection\Serialized;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class Serialized
{

    public function __construct($object)
    {
        $encoders = array(new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });

        $serializer = new Serializer(array($normalizer), $encoders);

        $serialized = $serializer->serialize($object, 'json');

        return $serialized;
    }
}
