<?php

/**
 * contatto actions.
 *
 * @package    sf_sandbox
 * @subpackage contatto
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class contactActions extends sfActions
{
  private function update($request)
  {
    $this->form->bind($request->getParameter('contatto'));
    if ($this->form->isValid()) {
      $contact = $this->form->save();
      $contact->setIdUtente($this->getUser()->getAttribute('id_utente'));
      $contact->save();

      return $contact;
    }

    return false;

  }

  public function executeIndex($request)
  {
    $criteria = new Criteria();
    $criteria->add(ContattoPeer::CLASS_KEY, $request->getParameter('type', ContattoPeer::CLASSKEY_CLIENTE));
    $criteria->addAscendingOrderByColumn(ContattoPeer::RAGIONE_SOCIALE );

    $this->pager = new sfPropelPager('Contatto', $this->getUser()->getSettings()->getNumClienti());
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->setCriteria($criteria);
    $this->pager->init();

    if(!$this->pager->getNbResults())
    {
      return 'NoResults';
    }

  }

  public function executeShow($request)
  {
    $this->contact = ContattoPeer::retrieveByPK($request->getParameter('id'));

    $this->year = $request->getParameter('year', date('Y'));
    $this->invoices = FatturaPeer::getInvoicesForContactByYear( $this->contact, $this->year );
        
    $this->totale = FatturaPeer::calculateTotalFromInvoices( $this->invoices );
    $this->totale_proforma = FatturaPeer::calculateTotalFromInvoices( $this->invoices, false );
    
  }

  public function executeEdit($request)
  {
    $factory = new ContactFactoryForm();
    
    $paramsbyClass = $request->getParameter('contatto', $request->getParameter('type'));
    $contattobyClass = $paramsbyClass['class_key'];
    
    $paramsbyId = $request->getParameter('contatto', $request->getParameter('id'));
    $contattobyId= $paramsbyId['id'];
    
    $this->form = $factory->build($contattobyClass, ContattoPeer::retrieveByPk($contattobyId));

    if($request->isMethod('post')) {
      $contact = $this->update($request);
      if($contact) {
        $this->redirect('@contact_show?id='.$contact->getId());
      }
    }
  }

  public function executeCreate($request)
  {
    $this->forward('contact', 'edit');
  }

  public function executeDelete($request)
  {
   $this->forward404Unless($contact = ContattoPeer::retrieveByPK($request->getParameter('id')));

   $contact->delete();

   $this->redirect('contact/index?type='.$contact->getClassKey());
  }
}
