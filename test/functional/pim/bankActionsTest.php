<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new paTestFunctional(new sfBrowser());
$browser->loadData(sfConfig::get('sf_test_dir').'/fixtures/fixtures.yml');

$browser->
  login()->
  info('1. bank list')->
  click('Banche')->
  
  with('request')->begin()->
    isParameter('module', 'bank')->
    isParameter('action', 'index')->
  end()->
  
  with('response')->begin()->
    isStatusCode(200)->
    checkElement('h2', 'Lista banche')->
    checkElement('table.fatture', 1)->
    checkElement('table th', 4)->
    checkElement('table th', 'banca', array('position' => 0))->
    checkElement('table th', 'n. conto', array('position' => 1))->
    checkElement('table th', 'iban', array('position' => 2))->
    checkElement('table th', '', array('position' => 3))->
    checkElement('table td', 'Credito di PIM', array('position' => 0))->
    checkElement('table td a[title="Credito di PIM"]', 1)->
    checkElement('table td', '4752', array('position' => 1))->
    checkElement('table td', 'IT00 O011 7777 9999 0000 0001 111', array('position' => 2))->
    checkElement('table td img[alt="delete"]')->
  end()->
  
  info('2. delete bank')->
  click('delete')->
  
  with('request')->begin()->
    isParameter('module', 'bank')->
    isParameter('action', 'delete')->
  end()->
  followRedirect()->
  isForwardedTo('bank', 'index')->
  
  with('response')->begin()->
    isStatusCode(200)->
    checkElement('table', 0)->
    checkElement('#content p', 'Nessuna banca disponibile, inserisci i dati della tua banca.')->
    checkElement('#content p a[title="create"]', 'inserisci i dati della tua banca')->
  end()->
  
  info('3. new bank')->
  get('bank/new')->
  
  with('response')->begin()->
    isStatusCode(200)->
    checkElement('h2', 'Modifica banca')->
    checkElement('table.banca', 1)->
    checkElement('table th', 'Nome banca', array('position' => 0))->
    checkElement('table th', 'Abi', array('position' => 1))->
    checkElement('table th', 'Cab', array('position' => 2))->
    checkElement('table th', 'Cin', array('position' => 4))->
    checkElement('table th', 'Iban', array('position' => 5))->
    checkElement('table th', 'N. conto', array('position' => 6))->
  end()->
  
  with('form')->begin()->
  
  end();
  $browser->test()->todo('3. new bank');
  
  $browser->info('4. edit bank');
  $browser->test()->todo('4. edit bank');