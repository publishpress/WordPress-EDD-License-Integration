<?php
/**
 * @package WordPress-EDD-License-Integration
 * @author  PublishPress
 *
 * Copyright (c) 2018 PublishPress
 *
 * This file is part of WordPress-EDD-License-Integration
 *
 * WordPress-EDD-License-Integration is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * WordPress-EDD-License-Integration is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with WordPress-EDD-License-Integration.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace PublishPress\EDD_License\Core;

use EDD_SL_Plugin_Updater;

// Exit if accessed directly
if (!defined('PUBLISHPRESS_EDD_LICENSE_INTEGRATION_LOADED'))
{
    exit;
}

/**
 * The services for the dependency injection container.
 *
 * @since      1.2.0
 * @package    WordPress-EDD-License-Integration
 * @author     PublishPress
 */
class Services implements \Pimple\ServiceProviderInterface
{
    /**
     * An instance of the ServicesConfig class.
     *
     * @since      1.2.0
     * @var ServicesConfig
     */
    protected $config;

    /**
     * The constructor.
     *
     * @since      1.2.0
     * @param ServicesConfig $config
     * @throws Exception\InvalidParams
     */
    public function __construct(ServicesConfig $config)
    {
        $config->validate();

        $this->config = $config;
    }

    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param \Pimple\Container $container An Container instance
     */
    public function register(\Pimple\Container $pimple)
    {
        /*
         *
         * Define the constants.
         */
        $pimple['API_URL'] = function (Container $c)
        {
            return $this->config->apiUrl;
        };

        $pimple['LICENSE_KEY'] = function (Container $c)
        {
            return $this->config->licenseKey;
        };

        $pimple['LICENSE_STATUS'] = function (Container $c)
        {
            return $this->config->licenseStatus;
        };

        $pimple['PLUGIN_VERSION'] = function (Container $c)
        {
            return $this->config->pluginVersion;
        };

        $pimple['EDD_ITEM_ID'] = function (Container $c)
        {
            return $this->config->eddItemId;
        };

        $pimple['PLUGIN_AUTHOR'] = function (Container $c)
        {
            return $this->config->pluginAuthor;
        };

        $pimple['PLUGIN_FILE'] = function (Container $c)
        {
            return $this->config->pluginFile;
        };

        /*
         * Define the updater.
         */
        $pimple['updater'] = function (Container $c)
        {
            return new EDD_SL_Plugin_Updater(
                $c['API_URL'],
                $c['PLUGIN_FILE'],
                [
                    'version'        => $c['PLUGIN_VERSION'],
                    'license'        => $c['LICENSE_KEY'],
                    'license_status' => $c['LICENSE_STATUS'],
                    'item_id'        => $c['EDD_IREM_ID'],
                    'author'         => $c['PLUGIN_AUTHOR'],
                ]
            );
        };
    }
}