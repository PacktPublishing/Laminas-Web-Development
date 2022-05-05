<?php
namespace Store\Controller;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Laminas\Session\Container;

class OrderAPIControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $productBasket = $container->get('ProductBasket');
        $purchaseOrderTable = $container->get('PurchaseOrderTable');
        $orderItemTable = $container->get('OrderItemTable');        
        return new OrderAPIController($productBasket, $purchaseOrderTable, $orderItemTable);
    }
}