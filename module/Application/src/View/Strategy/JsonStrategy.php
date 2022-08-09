<?php

declare(strict_types=1);

namespace Application\View\Strategy;

use Application\View\Model\JsonModel;
use Laminas\Http\Response;
use Laminas\View\Strategy\JsonStrategy as LaminasJsonStrategy;
use Laminas\View\ViewEvent;

use function in_array;
use function is_string;
use function strtoupper;

class JsonStrategy extends LaminasJsonStrategy
{
    protected const CUSTOM_HEADER_TYPE = 'X-Powered-By';
    protected const CUSTOM_HEADER_LINE = 'The Webinertia Development Team';

    /**
     * Detect if we should use the JsonRenderer based on model type
     *
     * @return null|JsonRenderer
     */
    public function selectRenderer(ViewEvent $e)
    {
        $model = $e->getModel();
        // insure we are using our model and not the frameworks
        if (! $model instanceof JsonModel) {
            // no JsonModel; do nothing
            return;
        }

        // JsonModel found
        return $this->renderer;
    }

    /**
     * Inject the response with the JSON payload and appropriate Content-Type header
     *
     * @return void
     */
    public function injectResponse(ViewEvent $e)
    {
        $renderer = $e->getRenderer();
        if ($renderer !== $this->renderer) {
            // Discovered renderer is not ours; do nothing
            return;
        }

        $result = $e->getResult();
        if (! is_string($result)) {
            // We don't have a string, and thus, no JSON
            return;
        }

        // Populate response
        /** @var Response $response */
        $response = $e->getResponse();
        $response->setContent($result);
        $headers = $response->getHeaders();

        if ($this->renderer->hasJsonpCallback()) {
            $contentType = 'application/javascript';
        } else {
            $contentType = 'application/json';
        }

        $contentType .= '; charset=' . $this->charset;
        $headers->addHeaderLine('content-type', $contentType);
        $headers->addHeaderLine(self::CUSTOM_HEADER_TYPE, self::CUSTOM_HEADER_LINE);

        if (in_array(strtoupper($this->charset), $this->multibyteCharsets)) {
            $headers->addHeaderLine('content-transfer-encoding', 'BINARY');
        }
    }
}
