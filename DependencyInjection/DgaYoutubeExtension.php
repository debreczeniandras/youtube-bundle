<?php

namespace Dga\YoutubeBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * @author    Andras Debreczeni <dev@debreczeniandras.hu>
 */
class DgaYoutubeExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $params['base_url']      = $config['base_url'];
        $params['token_uri']     = $config['token_uri'];
        $params['client_id']     = $config['client_id'];
        $params['refresh_token'] = $config['refresh_token'];
        $params['client_secret'] = $config['client_secret'];
        $params['channel_id']    = $config['channel_id'];

        $params += $config['additional_params'];

        $container->setParameter('dga.youtube.client.params', $params);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
    }
}
