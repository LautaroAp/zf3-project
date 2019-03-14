<?php
namespace Presupuesto\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Presupuesto\Controller\PresupuestoController;
use Presupuesto\Service\PresupuestoManager;
use Moneda\Service\MonedaManager;
use Persona\Service\PersonaManager;

// use Transaccion\Service\TransaccionManager;

/**
 * Description of PresupuestoControllerFactory
 *
 * @author SoftHuella
 */
class PresupuestoControllerFactory implements FactoryInterface {
    

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
       
        $pedidoManager = $container->get(PresupuestoManager::class);
        $monedaManager = $container->get(MonedaManager::class);  
        $personaManager = $container->get(PersonaManager::class);            
          
        // $transaccionManager = $container->get(TransaccionManager::class);            


        // Instantiate the service and inject dependencies
        return new PresupuestoController($pedidoManager, $monedaManager);
    }    
}
