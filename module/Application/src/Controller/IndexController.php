<?php

/**
 * This is to demonstrate the use of the LazyControllerAbstractFactory.
 */

declare(strict_types=1);

namespace Application\Controller;

use Application\Controller\Trait\JsonModelTrait;
use Application\Model\ConcreteFactoryExample;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;

use function get_class;

class IndexController extends AbstractActionController
{
    use JsonModelTrait;

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
        return $this->jsonModel([
            'instanceOf' => get_class($this->example),
            'data'       => $this->example,
        ]);
    }
}
