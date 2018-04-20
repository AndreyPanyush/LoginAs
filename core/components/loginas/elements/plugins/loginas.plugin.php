<?php
/**
 * This file is part of LoginAs extension
 *
 * Copyright (c) 2017 Andrey Panyush
 */

if (!$modx->loadClass('loginas', $modx->getOption('loginas.core_path', null, $modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/loginas/') . 'model/loginas/', false, true)) {
    return;
}

/** @var modX $modx */
switch ($modx->event->name) {
    case 'OnWebAuthentication':
        // check $GLOBALS['LOGINAS_ACCESS_GRANTED']. sets in processor web/login
        if(isset($GLOBALS['LOGINAS_ACCESS_GRANTED']) && $GLOBALS['LOGINAS_ACCESS_GRANTED'] === true) $modx->event->_output = true;
        else $modx->event->_output = false;

        break;


    case 'OnUserFormPrerender':
        /** @var modUser $user */
        if (!isset($user) || $user->get('id') < 1) {
            return;
        }
        // init loginas
        $LoginAs = new LoginAs($modx);
        $modx->controller->addJavascript($LoginAs->config['jsUrl'] . 'mgr/loginas.js');
        $modx->controller->addJavascript($LoginAs->config['jsUrl'] . 'mgr/misc/buttons.js');
        $modx->controller->addJavascript($LoginAs->config['jsUrl'] . 'mgr/widgets/generate.window.js');
        $modx->controller->addLexiconTopic('loginas:default');

        $modx->controller->addHtml('
		<script type="text/javascript">
			LoginAs.config = ' . $modx->toJSON($LoginAs->config) . ';
			
			Ext.ComponentMgr.onAvailable("modx-action-buttons", function() {
			    this.on("beforerender", function() {
			        if(MODx.page.UpdateUser) {
                        this.add({
                            xtype: \'loginas-button-modal\',
                           /* handler: function(){
                                console.log(3);
                                return false;
                            },*/  
                            params: {
                                user: ' . intval($user->get('id')) . '
                            },
                            id: \'loginas-modal-btn\'
                        });
					}
			    });
			});
			
			
		</script>'
        );
        break;
}