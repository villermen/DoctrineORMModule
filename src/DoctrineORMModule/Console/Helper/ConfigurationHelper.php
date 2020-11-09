<?php

declare(strict_types=1);

namespace DoctrineORMModule\Console\Helper;

use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Tools\Console\Helper\ConfigurationHelperInterface;
use Interop\Container\ContainerInterface;
use Symfony\Component\Console\Helper\HelperInterface;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;

class ConfigurationHelper implements
    HelperInterface,
    ConfigurationHelperInterface
{
    protected $helperSet;
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function setHelperSet(HelperSet $helperSet = null): ConfigurationHelper
    {
        $this->helperSet = $helperSet;

        return $this;
    }

    public function getHelperSet()
    {
        return $this->helperSet;
    }

    public function getName()
    {
        return 'configuration';
    }

    public function getMigrationConfig(InputInterface $input): Configuration
    {
        $objectManagerAlias = $input->getOptions()['object-manager'] ?? 'doctrine.entitymanager.orm_default';
        $objectManagerName = substr($objectManagerAlias, strrpos($objectManagerAlias, '.') + 1);

        return $this->container->get('doctrine.migrations_configuration.' . $objectManagerName);
    }
}
