<?php

namespace JMSSerializerModule\Service;

use InvalidArgumentException;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\VisitorInterface;
use PhpCollection\Map;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Martin Parsiegla <martin.parsiegla@gmail.com>
 */
class SerializerFactory extends AbstractFactory
{

    /**
     * {@inheritdoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var $options \JMSSerializerModule\Options\Visitors */
        $options = $this->getOptions($serviceLocator, 'visitors');

        /** @var SerializerBuilder $builder */
        $builder = $serviceLocator->get('jms_serializer.builder');

        $builder->setPropertyNamingStrategy($serviceLocator->get('jms_serializer.naming_strategy'));

        foreach ($options->getSerialization() as $format => $factory) {
            $builder->setSerializationVisitor($format, $serviceLocator->get($factory));
        }

        foreach ($options->getDeserialization() as $format => $factory) {
            $builder->setDeserializationVisitor($format, $serviceLocator->get($factory));
        }

        $builder->setMetadataDriverFactory($serviceLocator->get('jms_serializer.default_driver_factory'));

        $builder->setMetadataCache($serviceLocator->get('jms_serializer.metadata.cache'));

        return $builder->build();
    }

    /**
     * {@inheritdoc}
     */
    public function getOptionsClass()
    {
        return 'JMSSerializerModule\Options\Visitors';
    }
}
