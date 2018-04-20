<?php
/**
 * This file is part of the LoginAs extension
 *
 * Copyright (c) 2017 Andrey Panyush
 */

require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';
$core_path = $modx->getOption('loginas.core_path',null,$modx->getOption('core_path') . 'components/loginas/');
require_once $core_path . 'model/loginas/loginas.class.php';

$modx->loginas = new LoginAs($modx);

$path = $modx->getOption('processorsPath', $modx->loginas->config,$core_path . 'processors/');

$ctx = $modx->getOption('ctx', $_REQUEST);
if($ctx && isset($modx->user) && $modx->user) $modx->user->addSessionContext($ctx);
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));

