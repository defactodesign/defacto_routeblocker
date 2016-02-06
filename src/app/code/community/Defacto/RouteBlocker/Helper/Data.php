<?php

/**
 * @category    Defacto
 * @package     Defacto_RouteBlocker
 * @author      De Facto Design <developers@de-facto.com>
 * @license     GPL-3.0
 */
class Defacto_RouteBlocker_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_ROUTE_BLOCKER_ENABLED = 'admin/defacto_routeblocker/enabled';
    const XML_PATH_ROUTE_BLOCKER_ROUTES = 'admin/defacto_routeblocker/routes';

    /**
     * Should we process the blocked route blacklist?
     *
     * @return boolean
     */
    public function isBlockingEnabled()
    {
        return (bool)Mage::getStoreConfig(self::XML_PATH_ROUTE_BLOCKER_ENABLED);
    }

    /**
     * Return all blocked routes
     *
     * @return boolean
     */
    public function getBlockedRoutes()
    {
        $routes = explode("\n", Mage::getStoreConfig(self::XML_PATH_ROUTE_BLOCKER_ROUTES));
        $routes = array_map('trim', $routes);

        return array_filter($routes);
    }


    /**
     * Check if a route is is the route blacklist
     *
     * @param $route
     * @return bool
     */
    public function isRouteBlocked($route)
    {
        if (!$this->isBlockingEnabled()) {
            return false;
        }

        return in_array($route, $this->getBlockedRoutes());
    }
}
