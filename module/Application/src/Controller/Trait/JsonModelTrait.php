<?php

/**
 * This trait can be used in any controller to return a JsonModel
 * with custom response headers ;)
 */

declare(strict_types=1);

namespace Application\Controller\Trait;

use Laminas\View\Model\JsonModel;

trait JsonModelTrait
{
    /**
     * @param mixed $data
     * @return string
     */
    public function jsonModel(array $vars): JsonModel
    {
        /**
         * since this will be used in a controller we have access to its properties
         * and methods
         */
        $headers = $this->getResponse()->getHeaders();
        $headers->addHeaderLine('X-Powered-By', 'Webinertia');
        return new JsonModel($vars);
    }
}
