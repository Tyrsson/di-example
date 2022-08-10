<?php

declare(strict_types=1);

namespace Di\Service;

use Di\Service\Bar;
use Laminas\Hydrator\HydratorPluginManager;
use Laminas\Hydrator\ObjectPropertyHydrator;

class TypeExample
{
    /** @var Bar $bar */
    public $bar;
    /** @var HydratorPluginManager $hydratorPluginManager */
    protected $hydratorPluginManager;
    /** @var ObjectPropertyHydrator $hydrator */
    protected $hydrator;
    public function __construct(HydratorPluginManager $hydratorManager)
    {
        $this->hydratorManager = $hydratorManager;
        $this->hydrator        = $this->hydratorManager->get(ObjectPropertyHydrator::class);
    }

    public function hydrateBar(array $data, Bar $bar)
    {
        $this->bar = $this->hydrator->hydrate($data, $bar);
    }

    public function getBar(): Bar
    {
        return $this->bar;
    }

    public function getFoo(): string
    {
        return 'foo';
    }
}
