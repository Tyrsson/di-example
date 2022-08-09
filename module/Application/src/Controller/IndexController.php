<?php

/**
 * This is to demonstrate the use of the LazyControllerAbstractFactory.
 */

declare(strict_types=1);

namespace Application\Controller;

use Application\Controller\Trait\JsonModelTrait;
use Application\Model\ConcreteFactoryExample;
use Application\View\Model\JsonModel;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

use function get_class;

class IndexController extends AbstractActionController
{
    use JsonModelTrait;

    /** @var bool $useTrait */
    private $useTrait = false;

    /** @var ConcreteFactoryExample $example */
    public function __construct(ConcreteFactoryExample $example)
    {
        $this->example = $example;
    }

    public function indexAction(): ViewModel
    {
        return new ViewModel(['example' => $this->example]);
    }

    /** @return JsonModel */
    public function jsonAction()
    {
        if (! $this->useTrait) {
            return new JsonModel([
                'instanceOf' => get_class($this->example),
                'data'       => $this->example,
            ]);
        }
        // return $this->jsonModel([
        //     'instanceOf' => get_class($this->example),
        //     'data'       => $this->example,
        // ]);
    }
}
