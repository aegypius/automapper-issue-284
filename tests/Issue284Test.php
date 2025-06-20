<?php

declare(strict_types=1);

namespace Tests;

use App\Banana;
use AutoMapper\AutoMapper;
use AutoMapper\Configuration;
use AutoMapper\ConstructorStrategy;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversNothing]
final class Issue284Test extends TestCase
{
    private function createAutoMapper(ConstructorStrategy $constructorStrategy): AutoMapper
    {
        $cacheDirectory = realpath(__DIR__ . '/../var');
        $classPrefix = \sprintf('Mapper_With%sConstructorStrategy_', ucfirst($constructorStrategy->value));

        return AutoMapper::create(
            configuration: new Configuration(
                classPrefix: $classPrefix,
                constructorStrategy: $constructorStrategy,
            ),
            cacheDirectory: $cacheDirectory,
        );
    }

    #[TestWith([new Banana(1), ConstructorStrategy::AUTO], 'with "auto" constructor strategy')]
    #[TestWith([new Banana(2), ConstructorStrategy::ALWAYS], 'with "always" constructor strategy')]
    public function testReversibility(object $subject, ConstructorStrategy $constructorStrategy): void
    {
        $automapper = $this->createAutoMapper($constructorStrategy);
        self::assertEquals($subject, $automapper->map(
            $automapper->map($subject, 'array'),
            $subject::class,
        ));
    }
}
