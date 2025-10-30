<?php

namespace App\DataFixtures;

use App\Api\OptionParameter\Entity\OptionParameter;
use App\Api\OptionParameter\Entity\OptionValue;
use App\Api\OptionParameter\Entity\OptionValueRelation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class OptionParameterFixtures extends Fixture
{
    public const PARAMETER_NAMES = [
        'Power',
        'Base Curve',
        'Diameter',
        'Cylinder',
        'Axis',
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $parameters = [];
        foreach (self::PARAMETER_NAMES as $index => $name) {
            $parameter = new OptionParameter();
            $parameter->setName($name);
            $parameter->setLevel($index + 1);
            $manager->persist($parameter);
            $parameters[] = $parameter;
        }

        $values = [];
        foreach ($parameters as $parameter) {
            $count = 10;
            for ($i = 0; $i < $count; $i++) {
                $value = new OptionValue();
                $value->setParameter($parameter);
                $value->setValue(strtoupper(substr($parameter->getName(), 0, 2)) . '-' . $faker->numberBetween(1, 99));
                $value->setUuid($faker->uuid());
                $manager->persist($value);
                $values[$parameter->getLevel()][] = $value;
            }
        }

        foreach ($parameters as $index => $parameter) {
            if ($index === count($parameters) - 1) {
                break;
            }

            $currentLevelValues = $values[$parameter->getLevel()];
            $nextLevelValues = $values[$parameter->getLevel() + 1];

            foreach ($currentLevelValues as $parentValue) {
                $childCount = $faker->numberBetween(2, 5);
                $childSubset = $faker->randomElements($nextLevelValues, $childCount);

                foreach ($childSubset as $childValue) {
                    $relation = new OptionValueRelation();
                    $relation->setParent($parentValue);
                    $relation->setChild($childValue);
                    $manager->persist($relation);
                }
            }
        }

        $manager->flush();
    }
}
