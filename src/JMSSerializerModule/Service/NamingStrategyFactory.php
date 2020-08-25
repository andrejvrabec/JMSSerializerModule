<?php

namespace JMSSerializerModule\Service;

use JMS\Serializer\Naming\PropertyNamingStrategyInterface;
use JMSSerializerModule\Options\PropertyNaming;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Martin Parsiegla <martin.parsiegla@gmail.com>
 */
class NamingStrategyFactory extends AbstractFactory
{
    /**
     * {@inheritdoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var $options PropertyNaming */
        $options = $this->getOptions($serviceLocator, 'property_naming');
        /** @var $namingStrategy PropertyNamingStrategyInterface */
        $namingStrategy = $serviceLocator->get('jms_serializer.serialized_name_annotation_strategy');

        return $namingStrategy;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptionsClass()
    {
        return 'JMSSerializerModule\Options\PropertyNaming';
    }
}
