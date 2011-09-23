<?php use_helper('Pdf');?>
<?php ob_start()?>
<?php $fattura->getTemaFattura()->setFattura($fattura)?>
<?php echo $fattura->getTemaFattura()->getViewHeader()?>
<?php ob_end_flush()?>
<?php $html = ob_get_contents();?>
<?php ob_end_clean()?>
<?php if ($sf_request->getParameter('html')):?>
<?php echo $html?>
<?php else: ?>
<?php pdf($html,'a4','portrait','fattura-'.$fattura->getNumberDecorated().'-'.$fattura->getData('dmy'));?>
<?php endif?>