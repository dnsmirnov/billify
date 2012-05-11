<?php

// auto-generated by sfPropelCrud
// date: 2006/08/16 01:08:07
?>
<?php

/**
 * impostazione actions.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage impostazione
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 1415 2006-06-11 08:33:51Z fabien $
 */
class impostazioneActions extends sfActions
{

  public function executeIndex()
  {
    return $this->forward('impostazione', 'edit');
  }

  public function executeCreate()
  {
    $this->impostazione = new Impostazione();
    $this->impostazione_form = new ImpostazioneForm($this->impostazione);
    $this->setTemplate('edit');
  }

  public function executeEdit()
  {
    $this->impostazione = ImpostazionePeer::retrieveByIdUtente($this->getUser()->getAttribute('id_utente'));
   
    if (!$this->impostazione)
    {
      $this->forward('impostazione', 'create'); 
    }
    
    $this->impostazione_form = new ImpostazioneForm($this->impostazione);
    
  }

  public function executeUpdate()
  {
    $impostazione = $this->request->getParameter('impostazione', 0);
    $id_utente = $impostazione['id_utente'];
    
    $this->forward404Unless($this->getUser()->getAttribute('id_utente') == $id_utente, $this->getUser()->getAttribute('id_utente'). '<>'. $id_utente);
    
    if (!$id_utente)
    {
      $impostazione = new Impostazione();
    } 
    else
    {
      $impostazione = ImpostazionePeer::retrieveByIdUtente($id_utente);
      $this->forward404Unless($impostazione);
    }
    
    $impostazioni_results = $this->getRequestParameter('impostazione', array());
    $impostazioni_results['ritenuta_acconto'] = $impostazioni_results['percentuale_ra'] . '/' . $impostazioni_results['percentuale_imponibile_ra'];
    unset($impostazioni_results['percentuale_ra'], $impostazioni_results['percentuale_imponibile_ra']);
    
    $impostazione->setIdUtente($this->getUser()->getAttribute('id_utente'));
    $impostazione->setNumClienti($impostazioni_results['num_clienti']);
    $impostazione->setNumFatture($impostazioni_results['num_fatture']);
    $impostazione->setRigheDettagli($impostazioni_results['righe_dettagli']);
    $impostazione->setRitenutaAcconto($impostazioni_results['ritenuta_acconto']);
    $impostazione->setTipoRitenuta($impostazioni_results['tipo_ritenuta']);
    $impostazione->setConsegnaCommercialista($impostazioni_results['consegna_commercialista']);
    $impostazione->setFatturaAutomatica($impostazioni_results['fattura_automatica']);
    $impostazione->setInvoiceDecoratorType($impostazioni_results['invoice_decorator_type']);
    $impostazione->setLabelImponibile($impostazioni_results['label_imponibile']);
    $impostazione->setLabelSpese($impostazioni_results['label_spese']);
    $impostazione->setLabelImponibileIva($impostazioni_results['label_imponibile_iva']);
    $impostazione->setLabelIva($impostazioni_results['label_iva']);
    $impostazione->setLabelTotaleFattura($impostazioni_results['label_totale_fattura']);
    $impostazione->setLabelRitenutaAcconto($impostazioni_results['label_ritenuta_acconto']);
    $impostazione->setLabelNettoLiquidare($impostazioni_results['label_netto_liquidare']);
    $impostazione->setLabelQuantita($impostazioni_results['label_quantita']);
    $impostazione->setLabelDescrizione($impostazioni_results['label_descrizione']);
    $impostazione->setLabelPrezzoSingolo($impostazioni_results['label_prezzo_singolo']);
    $impostazione->setLabelPrezzoTotale($impostazioni_results['label_prezzo_totale']);
    $impostazione->setLabelSconto($impostazioni_results['label_sconto']);
    $impostazione->save();
   
    
    $this->getRequest()->setParameter('success', 'Impostazioni modificate con successo.');
    $this->getUser()->setAttribute('impostazioni', $impostazione);
    
    return $this->forward('impostazione', 'edit');
  }

  
  public function handleErrorUpdate()
  {
    $impostazione = $this->request->getParameter('impostazione', 0);
    $impostazionebyId = $impostazione['id_utente'];
    
    if (!$impostazionebyId)
    {
      $this->forward('impostazione', 'create');
    } 
    else
    {
      $this->forward('impostazione', 'edit');
    }
  }

}
