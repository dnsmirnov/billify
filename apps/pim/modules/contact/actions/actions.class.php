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

    $this->contacts = ContattoPeer::doSelect($criteria);
  }

  public function executeEdit($request)
  {
    $factory = new ContactFactoryForm();
    $this->form = $factory->build($request->getParameter('contatto[class_key]', $request->getParameter('type')), ContattoPeer::retrieveByPk($request->getParameter('contatto[id]', $request->getParameter('id'))));
    
    if($request->isMethod('post')) {
      $contact = $this->update($request);
      if($contact) {
        $this->redirect('contact/edit?id='.$contact->getId());
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
