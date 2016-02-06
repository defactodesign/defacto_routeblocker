<?php

/**
 * Intercept request at pre-dispatch stage and determine whether to block.
 *
 * @category    Defacto
 * @package     Defacto_RouteBlocker
 * @author      De Facto Design <developers@de-facto.com>
 * @license     GPL-3.0
 */
class Defacto_RouteBlocker_Model_Observer extends Mage_Admin_Model_Observer
{
    const XML_PATH_ROUTE_BLOCKER_ENABLE_EMAIL_TEMPLATE = 'admin/defacto_routeblocker/email_template';

    /**
     * Determine whether to allow the request to reach controller action.
     *
     * @event controller_action_predispatch
     * @param Varien_Event_Observer $observer
     * @return boolean
     */
    public function actionPreDispatch($observer)
    {
        Varien_Profiler::start('route_blocker_validation');

        $controller = $observer->getEvent()->getData('controller_action');
        if (Mage::helper('defacto_routeblocker')->isRouteBlocked($controller->getFullActionName())) {
            $controller->setFlag('', Mage_Core_Controller_Varien_Action::FLAG_NO_DISPATCH, true);            $controller->getResponse();
            $response = Mage::app()->getResponse();
            if (!$response->getBody(true)) {
                $response->setHttpResponseCode(403);
                $response->setBody("<html>
                        <head>
                            <title>403 - Forbidden</title>
                        </head>
                        <body>
                            <h1>Forbidden</h1>
                            <p>You do not have access to view this resource</p>
                        </body>
                    </html>");
            }
        }

        Varien_Profiler::stop('route_blocker_validation');
    }
}
