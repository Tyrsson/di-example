<?php

declare(strict_types=1);

namespace Di;

use Di\Exception\ConfigInterfaceNotInitializedException;
use Di\Exception\EmptyConfigException;
use Di\Exception\ServiceCantNotBeReturnedException;
use Di\Exception\UnSupportedContainerException;
use Laminas\Di\ConfigInterface;
use Laminas\Di\DefaultContainer;
use Laminas\Di\Definition\DefinitionInterface;
use Laminas\Di\Definition\RuntimeDefinition;
use Laminas\Di\Exception\ClassNotFoundException;
use Laminas\Di\Injector as LaminasInjector;
use Psr\Container\ContainerInterface;
use RuntimeException;

use function get_class;
use function sprintf;

final class Injector extends LaminasInjector
{
    public function definitions(): DefinitionInterface
    {
        return $this->definition ?? new RuntimeDefinition();
    }

    /**
     * This method SHOULD check if you want the instance from the container
     * if that is true (default) it will return it if its found
     * if not then it will attempt to create it via the DI and return it
     * If neither occures it will throw an exception
     * Laminas\Di\DefaultContainer usuage is not supported.
     *
     * @throws ClassNotFoundException
     * @throws RuntimeException
     * @throws ServiceCantNotBeReturnedException
     * @throws UnSupportedContainerException
     * @return mixed Entry.
     */
    public function get(string $name, bool $fromContainer = true): object
    {
        if ($fromContainer) {
            /**
             * By this point in processing we should have the Psr\Container\ContainerInterface
             * set as the container for the Injector thanks to the ConfigProvider.
             * This is to insure that we have an instance if you use this in ways I can not forsee
             */
            if (empty($this->container)) {
                throw new RuntimeException('Di\Injector does not have a container set');
            }
            // insure we only work with the Psr\Container\ContainerInterface
            if ($this->container instanceof DefaultContainer) {
                throw new UnSupportedContainerException(sprintf(
                    '%s is not supported by %s',
                    get_class($this->container),
                    static::class
                ));
            }
            /**
             * In a perfect world this would not be needed, however,
             * Due to the extremely flexible nature of the Framework
             * the Psr\Container\ContainerInterface could be overridden by the developer
             */
            if (! $this->container instanceof ContainerInterface) {
                throw new UnSupportedContainerException(
                    'Container must be an instance of Psr\Container\ContainerInterface'
                    . 'Received ' . sprintf(
                        '%s',
                        get_class($this->container)
                    )
                );
            }
            if ($this->container->has($name)) {
                return $this->container->get($name);
            } else {
                return $this->get($name, false);
            }
        } else {
            // should prevent the ClassNotFoundException, but I included it in the comment for completeness
            if ($this->canCreate($name)) {
                return $this->create($name);
            }
        }
        // I feel this could be improved...
        throw new ServiceCantNotBeReturnedException(
            sprintf(
                'Service %s can not be returned',
                $name
            )
        );
    }

    /**
     * Convience method to check configuration
     * Throws the below exceptions if the interface is not
     * initialized by the config provider or if the config is empty
     * Has been tested for both conditions
     *
     * @throws ConfigInterfaceNotInitializedException
     * @throws EmptyConfigException
     */
    public function getConfig(): ConfigInterface
    {
        /**
         * By this point we absolutely should have a ConfigInterface set
         */
        if ($this->config instanceof ConfigInterface) {
            if (! empty($this->container)) {
                if (
                    ! isset($this->container->get('config')['dependencies']['auto'])
                    || $this->container->get('config')['dependencies']['auto'] === []
                ) {
                    throw new EmptyConfigException(
                        'You have not configured the Di\Injector'
                    );
                }
            }
            return $this->config;
        } else {
            throw new ConfigInterfaceNotInitializedException(
                'ConfigInterface has not been initialized'
            );
        }
    }
}
