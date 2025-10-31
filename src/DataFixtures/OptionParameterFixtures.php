<?php

namespace App\DataFixtures;

use App\Api\OptionParameter\Entity\OptionParameter;
use App\Api\OptionParameter\Entity\OptionValue;
use App\Api\OptionParameter\Entity\OptionValueRelation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class OptionParameterFixtures extends Fixture
{
    private const array PARAMETER_NAMES = [
        'power',
        'curve',
        'diameter',
        'width',
    ];

    private const int PER_LEVEL_VALUE_COUNT = 5;

    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        $parameters = $this->buildOptionParameters($manager);
        $values = $this->buildOptionValues($manager, $parameters);
        $this->buildOptionValueRelations($manager, $parameters, $values);

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     *
     * @return array<OptionParameter>
     */
    private function buildOptionParameters(ObjectManager $manager): array
    {
        $parameters = [];
        foreach (self::PARAMETER_NAMES as $index => $name) {
            $parameter = new OptionParameter();
            $parameter->setName($name);
            $parameter->setLevel($index);
            $manager->persist($parameter);
            $parameters[] = $parameter;
        }

        return $parameters;
    }

    /**
     * @param ObjectManager $manager
     * @param array<OptionParameter> $parameters
     *
     * @return array<array<OptionValue>>
     */
    private function buildOptionValues(
        ObjectManager $manager,
        array $parameters,
    ): array {
        $values = [];
        foreach ($parameters as $parameter) {
            for ($i = 0; $i < self::PER_LEVEL_VALUE_COUNT; $i++) {
                $value = new OptionValue();
                $value->setParameter($parameter);
                $value->setValue(sprintf('%s-%d', substr($parameter->getName(), 0, 3), $i));
                $manager->persist($value);
                $values[$parameter->getLevel()][] = $value;
            }
        }

        return $values;
    }

    /**
     * @param ObjectManager $manager
     * @param array<OptionParameter> $parameters
     * @param array<array<OptionValue>> $values
     *
     * @return void
     */
    private function buildOptionValueRelations(
        ObjectManager $manager,
        array $parameters,
        array $values,
    ): void {
        foreach ($parameters as $index => $parameter) {
            if ($index === count($parameters) - 1) {
                break;
            }

            $currentLevelValues = $values[$parameter->getLevel()];
            $nextLevelValues = $values[$parameter->getLevel() + 1];

            foreach ($currentLevelValues as $parentValue) {
                $childCount = $this->faker->numberBetween(1, count($nextLevelValues));
                $childSubset = $this->faker->randomElements($nextLevelValues, $childCount);

                foreach ($childSubset as $childValue) {
                    $relation = new OptionValueRelation();
                    $relation->setParent($parentValue);
                    $relation->setChild($childValue);
                    $manager->persist($relation);
                }
            }
        }
    }
}
