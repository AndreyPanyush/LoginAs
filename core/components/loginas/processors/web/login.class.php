<?php
/**
 * This file is part of the LoginAs extension
 *
 * Copyright (c) 2017 Andrey Panyush
 */

class LoginAsLoginProcessor extends modProcessor {
    /**
     * @var LoginAs
     */
    private $_loginas;

    /**
     * Returns true if LoginAs successfully loaded
     *
     * @return boolean
     */
    public function initialize() {
        if (!$this->modx->loadClass('loginas', $this->modx->getOption('loginas.core_path', null, $this->modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/loginas/') . 'model/loginas/', false, true)) {
            return false;
        }

        $this->_loginas = new LoginAs($this->modx);

        return true;
    }

    /**
     * Does user auth
     *
     * @return string
     */
    public function process() {
        $GLOBALS['LOGINAS_ACCESS_GRANTED'] = false;
        // load registry by token
        $token = $this->modx->getOption('token', $_REQUEST);
        if(!$token) return $this->failure($this->modx->lexicon('loginas.err_login_token'));
        $record = $this->_loginas->read($token);
        if(!$record) return $this->failure($this->modx->lexicon('loginas.err_login_record'));
        $record = $record[0];

        // check ip
        if($this->_loginas->config['check_ip']) {
            if($this->_loginas->getUserIP() != $this->modx->getOption('ip', $record)) return $this->failure($this->modx->lexicon('loginas.err_login_ip'));
        }

        // set global variable for plugin
        $GLOBALS['LOGINAS_ACCESS_GRANTED'] = true;

        /* send to login processor and handle response */
        $c = array(
            'login_context' => $this->modx->getOption('context', $record),
            'add_contexts' => '',
            'username' => $this->modx->getOption('username', $record),
            'password' => '1',
            'returnUrl' => '',
            'rememberme' => false,
        );
        $response = $this->modx->runProcessor('security/login', $c);
        if (!empty($response) && !$response->isError()) {
            return $this->success();
        }
        return $this->failure($this->modx->lexicon('loginas.err_login'));
    }

    /**
     * Return a success message from the processor.
     * @param string $msg
     * @param mixed $object
     * @return string
     */
    public function success($msg = '', $object = null) {
        $this->modx->sendRedirect($this->modx->makeUrl($this->_loginas->config['redirect']));

        return $msg;
    }

    /**
     * Return a failure message from the processor.
     * @param string $msg
     * @param mixed $object
     * @return string
     */
    public function failure($msg = '', $object = null) {
        $this->modx->sendError('unavailable', array(
            'error_message' => $msg
        ));

        return $msg;
    }
}

return 'LoginAsLoginProcessor';