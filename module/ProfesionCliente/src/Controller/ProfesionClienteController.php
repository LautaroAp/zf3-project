<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ProfesionCliente\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProfesionClienteController extends AbstractActionController {

    /**
     * @var DoctrineORMEntityManager
     */
    protected $entityManager;

    /**
     * ProfesionCliente manager.
     * @var User\Service\ProfesionClienteManager 
     */
    protected $profesionclienteManager;

    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    protected $clientesManager;
    
    /* public function __construct($entityManager, $profesionclienteManager)
      {
      $this->entityManager = $entityManager;
      $this->profesionclienteManager = $profesionclienteManager;
      }
     */

    public function __construct($entityManager, $profesionclienteManager, $clientesManager) {
        $this->entityManager = $entityManager;
        $this->profesionclienteManager = $profesionclienteManager;
        $this->clientesManager = $clientesManager;
    }

    public function indexAction() {
        $view = $this->procesarIndexAction();
        return $view;
    }

    private function procesarIndexAction() {
        $profesionclientes = $this->profesionclienteManager->getProfesionClientes();
        return new ViewModel([
            'profesionclientes' => $profesionclientes
        ]);
    }

    public function addAction() {
        $view = $this->procesarAddAction();
        return $view;
    }

    private function procesarAddAction() {
        $form = $this->profesionclienteManager->createForm();
        $profesionclientes = $this->profesionclienteManager->getProfesionClientes();
        
        $paginator = $this->profesionclienteManager->getTabla();
        $mensaje = "";

        $page = 1;
        if ($this->params()->fromRoute('id')) {
            $page = $this->params()->fromRoute('id');
        }
        $paginator->setCurrentPageNumber((int) $page)
                ->setItemCountPerPage(10);
        
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $this->profesionclienteManager->getProfesionClienteFromForm($form, $data);
            return $this->redirect()->toRoute('profesioncliente');
        }
        return new ViewModel([
            'form' => $form,
            'profesionclientes' => $profesionclientes,
            'profesiones_pag' => $paginator,
            'mensaje' => $mensaje
        ]);
    }

    public function editAction() {
        $view = $this->procesarEditAction();
        return $view;
    }

    public function procesarEditAction() {
        $id = (int) $this->params()->fromRoute('id', -1);
        $profesioncliente = $this->profesionclienteManager->getProfesionClienteId($id);
        $form = $this->profesionclienteManager->getFormForProfesionCliente($profesioncliente);
        if ($form == null) {
            $this->reportarError();
        } else {
            if ($this->getRequest()->isPost()) {
                $data = $this->params()->fromPost();
                if ($this->profesionclienteManager->formValid($form, $data)) {
                    $this->profesionclienteManager->updateProfesionCliente($profesioncliente, $form);
                    return $this->redirect()->toRoute('profesioncliente');
                }
            } else {
                $this->profesionclienteManager->getFormEdited($form, $profesioncliente);
            }
            return new ViewModel(array(
                'profesioncliente' => $profesioncliente,
                'form' => $form
            ));
        }
    }

    public function removeAction() {
        $view = $this->procesarRemoveAction();
        return $view;
    }

    public function procesarRemoveAction() {
        $id = (int) $this->params()->fromRoute('id', -1);
        $profesioncliente = $this->profesionclienteManager->getProfesionClienteId($id);
        if ($profesioncliente == null) {
            $this->reportarError();
        } else {
            $this->clientesManager->eliminarProfesionClientes($id);
            $this->profesionclienteManager->removeProfesionCliente($profesioncliente);
            return $this->redirect()->toRoute('profesioncliente');
        }
    }

    public function viewAction() {
        return new ViewModel();
    }

    private function reportarError() {
        $this->getResponse()->setStatusCode(404);
        return;
    }
}
