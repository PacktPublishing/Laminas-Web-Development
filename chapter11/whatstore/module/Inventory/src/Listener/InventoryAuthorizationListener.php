<?php
namespace Inventory\Listener;

use Laminas\Mvc\MvcEvent;
use Laminas\Authentication\AuthenticationService;
use Laminas\Http\PhpEnvironment\Request;
use Laminas\Session\Container;

class InventoryAuthorizationListener
{
    public static function verifyPermission(MvcEvent $event)
    {
        $routeName = $event->getRouteMatch()->getMatchedRouteName();
        if ($routeName !== 'inventory'){
            return;
        }
        $authenticationService = new AuthenticationService();
        if ($authenticationService->hasIdentity()){
            $params = $event->getRouteMatch()->getParams();
            $controller = $params['controller'];
            $action = $params['action'] ?? 'rest';            
            
            if ($controller == 'menu' || $action == 'logout'){
                return;
            }
            
            $method = $event->getRequest()->getMethod();
            $action = ($action == 'rest' ? $method : $action);
            $action = ($action == 'POST' ? 'create' : $action);
            $action = ($action == 'PUT' ? 'update': $action);
            $permission = $controller . '.' . $action . ':' . $method;
            
            $container = new Container();
            $rbac = $container->rbac;
            
            $role = $authenticationService->getIdentity();
            if (!$rbac->isGranted($role,$permission)){
                $event->getRouteMatch()->setParam('controller', 'menu');
                $event->getRouteMatch()->setParam('action', 'no-permission');
                error_log("$role has not permission to $permission");
            }            
        }
    }
}