<?php
/**
 * This file is part of the LoginAs extension
 *
 * Copyright (c) 2017 Andrey Panyush
 */

class LoginAsGenerateProcessor extends modProcessor {
    /**
     * Generate user token and write into modRegistry
     *
     * @return array|string
     */
    public function process() {
        $scriptProperties = $this->getProperties();
        $username = null;
        // load user
        if(isset($scriptProperties['user'])) {
            $user = $this->modx->getObject('modUser', $scriptProperties['user']);
            if(!$user) return $this->failure($this->modx->lexicon('loginas.err_generate_not_found'));
            $username = $user->get('username');
            // check sudo
            if($user->get('sudo')) {
                return $this->failure($this->modx->lexicon('loginas.err_generate_sudo'));
            }
        }

        // init loginas
        if (!$this->modx->loadClass('loginas', $this->modx->getOption('loginas.core_path', null, $this->modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/loginas/') . 'model/loginas/', false, true)) {
            return $this->failure($this->modx->lexicon('loginas.err_generate'));
        }
        $loginas = new LoginAs($this->modx);

        // write registry
        $context = $this->modx->getOption('default_context', null, $scriptProperties['context']);
        $key = $loginas->write($username, $context, $loginas->getUserIP());
        if($key) {
            $url = MODX_URL_SCHEME . MODX_HTTP_HOST . $loginas->config['connectorUrl'] . '?ctx=' . $context . '&action=login&token=' . $key;
            return $this->success($url);
        }
        else return $this->failure($this->modx->lexicon('loginas.err_generate'));
    }
}

return 'LoginAsGenerateProcessor';