<?php

namespace JMSSerializerModule\Service;

use JMSSerializerModule\Options\Metadata;
use Metadata\Cache\FileCache;
use RuntimeException;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Martin Parsiegla <martin.parsiegla@gmail.com>
 */
class MetadataCacheFactory extends AbstractFactory
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var $options Metadata */
        $options = $this->getOptions($serviceLocator, 'metadata');
        if ($options->getCache() === 'none') {
            return null;
        }

        if ($options->getCache() === 'file') {
            $fileCache = $options->getFileCache();
            $dir = $fileCache['dir'];
            if (!file_exists($dir) && !$rs = @mkdir($dir, 0777, true)) {
                throw new RuntimeException(sprintf('Could not create cache directory "%s".', $dir));
            }
            return new FileCache($dir);
        }

        return $serviceLocator->get($options->getCache());
    }

    /**
     * {@inheritDoc}
     */
    public function getOptionsClass()
    {
        return 'JMSSerializerModule\Options\Metadata';
    }
}
