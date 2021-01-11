<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

require "./helpers.php";

//load annotations
AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

$entityManager = makeEntityManager();

$defaultContext = [
    AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
        return $object->getId();
    },
];

//make serializer
$encoders = [new XmlEncoder(), new JsonEncoder()];
$normalizers = [new ObjectNormalizer(null, null, null, null, null, null, $defaultContext)];

$serializer = new Serializer($normalizers, $encoders);