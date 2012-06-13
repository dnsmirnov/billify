<?php use_helper('jQuery');?>

<table class="dettagli_fattura" width="100%">
  <tr>
    <th><?php echo stripcslashes(UtentePeer::getImpostazione()->getLabelQuantita());?></th>
    <th><?php echo stripcslashes(UtentePeer::getImpostazione()->getLabelDescrizione());?></th>
    <th><?php echo stripcslashes(UtentePeer::getImpostazione()->getLabelPrezzoSingolo());?></th>
    <?php if($viewSconto):?>
      <th><?php echo stripcslashes(UtentePeer::getImpostazione()->getLabelSconto());?></th>
    <?php endif?>
    <?php if($fattura->getIncludiTasse() == 's' && $fattura->getCalcolaTasse() == 's'):?>
      <th>Prezzo Tot. Lordo</th>
    <?php endif?>
    <th><?php echo stripcslashes(UtentePeer::getImpostazione()->getLabelPrezzoTotale());?></th>
    <th><?php echo stripcslashes(UtentePeer::getImpostazione()->getLabelIva());?></th>
    <th></th>
  </tr>
  <?php if (count($dettagli_fattura)>0) : ?>
    <?php foreach ($dettagli_fattura as $dettaglio) : ?>
      <tr>
        <td><?php echo $dettaglio->getQty()?></td>
        <td class="align-left"><?php echo jq_link_to_remote(stripcslashes($dettaglio->getDescrizione()),array('url'=>'dettagliFattura/edit?id='.$dettaglio->getID().'&fattura_id='.$dettaglio->getFatturaID(),
      										   'update' => 'dettaglio_edit',
      										   'loading' => "$('#indicator').fadeIn();",
      								 		   'complete' => jq_visual_effect('fadeOut', '#indicator', array('duration' => 0)).jq_visual_effect('highlight', 'tabella_dettagli')),array('title'=>'Modifica dettaglio fattura'))?></td>

        <td><?php echo $fattura->getIncludiTasse() == 's'  && $fattura->getCalcolaTasse() == 's'?format_currency(fattura::calcDettaglioScorporato($dettaglio->getPrezzo(),$fattura->getCalcolaTasse() == 's',$fattura->getTasseUlterioriArray()),'EUR'):format_currency($dettaglio->getPrezzo(),'EUR')?></td>
        <?php if($viewSconto):?>
          <td><?php echo $dettaglio->getSconto()?>%</td>
        <?php endif?>
        <?php if($dettaglio->getFattura()->getIncludiTasse() == 's'  && $fattura->getCalcolaTasse() == 's'):?><td><?php echo format_currency($dettaglio->getTotale(),'EUR')?></td><?php endif?>
        <td><?php echo $dettaglio->getFattura()->getIncludiTasse() == 's' && $fattura->getCalcolaTasse() == 's'?format_currency(fattura::calcDettaglioScorporato($dettaglio->getTotale(),$fattura->getCalcolaTasse() == 's',$fattura->getTasseUlterioriArray()),'EUR'):format_currency($dettaglio->getTotale(),'EUR')?></td>
        <td><?php echo $dettaglio->getIva()?>%</td>
        <td>
                <?php if ($fattura->isEditable()) : ?>
                    <?php echo jq_link_to_remote(
                                    image_tag('/images/icons/page_delete.gif', array('alt'=>'Rimuovi Dettaglio', 'class' => 'delete')),
                                    array(
                                        'url'=>'dettagliFattura/delete?id='.$dettaglio->getID().'&fattura_id='.$dettaglio->getFatturaID(),
                                        'update' => 'dettaglio_edit',
                                        'loading' => "$('#indicator').fadeIn();",
                                        'complete' => jq_visual_effect('fadeOut', '#indicator', array('duration' => 0)).jq_visual_effect('highlight', 'tabella_dettagli')
                                    )); ?>
                <?php endif; ?>
        </td>
      </tr>
    <?php endforeach;?>
  <?php else: ?>
    <tr><td colspan="6">Nessun dettaglio per questa fattura</td></tr>
  <?php endif ?>
</table>
<div id="indicator" style="display: none;"></div>
