<?php

namespace App\Tests;

use App\Model\Comment;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Model\User;
use Doctrine\Common\Annotations\AnnotationReader;

class PropertyAccessTest extends KernelTestCase
{
    public function test(): void {
        self::bootKernel();

        $json = '{ "comments": [ {"id":1} , {"id":2} ] }';
        /** @var Serializer $serializer */
        $serializer = $this->getSerializer();

        $userExpected = new User();
        $userExpected->addComment((new Comment())->setId(1));
        $userExpected->addComment((new Comment())->setId(2));

        $userActual = $serializer->deserialize($json, User::class, 'json');

        $this->assertEquals($userExpected, $userActual);
    }

    // in a real project this would be done in a factory
    private function getSerializer(): Serializer {
        $classMetadataFactory = new ClassMetadataFactory(
            new AnnotationLoader(
                new AnnotationReader()
            )
        );

        $normalizers = [
            new ArrayDenormalizer(),
            new ObjectNormalizer(
                $classMetadataFactory,
                new MetadataAwareNameConverter($classMetadataFactory),
                null,
                new ReflectionExtractor()
            )
        ];

        $encoders = [
            new JsonEncoder(),
        ];

        return new Serializer($normalizers, $encoders);
    }
}