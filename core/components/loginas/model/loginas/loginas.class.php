<?php
/**
 * This file is part of the LoginAs extension
 *
 * Copyright (c) 2017 Andrey Panyush
 */

class LoginAs {
    /**
     * @var modX
     */
    private $modx;
    /**
     * @var array
     */
    public $config;
    /**
     * @var
     */
    private $_registry;

    /**
     * LoginAs constructor.
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = array()) {
        $this->modx = &$modx;
        $core_path = $this->modx->getOption('loginas.core_path', $config, $this->modx->getOption('core_path') . 'components/loginas/');
        $assets_url = $this->modx->getOption('loginas.assets_url', $config, $this->modx->getOption('assets_url') . 'components/loginas/');

        $this->modx->lexicon->load('loginas:default');

        $redirect = $this->modx->getOption('loginas.redirect', null, '');
        if($redirect == '') $redirect = $this->modx->getOption('site_start', null, 0);
        $this->config = array_merge(array(
            'corePath'          => $core_path,
            'assetsUrl'         => $assets_url,
            'modelPath'         => $core_path . 'model/',
            'processorsPath'    => $core_path . 'processors/',
            'jsUrl'             => $assets_url . 'js/',
            'connectorUrl'      => $assets_url . 'connector.php',

            'topic'             => '/loginas/tokens/',
            'ttl'               => $this->modx->getOption('loginas.ttl', null, 300),
            'remove_read'       => $this->modx->getOption('loginas.remove_read', null, true),
            'check_ip'          => $this->modx->getOption('loginas.check_ip', null, true),
            'redirect'          => $redirect
        ), $config);

        $this->modx->addPackage('loginas', $this->config['modelPath']);

        $registry = $this->modx->getService('registry', 'registry.modRegistry');
        $this->_registry = $registry->getRegister('loginas', 'registry.modDbRegister');
        $this->_registry->connect();
        $this->_topic = '/tokens/';
    }

    /**
     * Read record from modRegistry
     *
     * @param $token
     * @return bool
     */
    public function read($token) {
        if(!$token) return false;

        // subscribe to the registry
        $this->_registry->subscribe($this->config['topic'] . $token);

        // try to read item with token
        $res = $this->_registry->read(array(
            'poll_limit'    => 1,
            'remove_read'   => $this->config['remove_read']
        ));

        return $res;

    }

    /**
     * Read record to modRegistry
     *
     * @param $username
     * @param $context
     * @param $ip
     * @return string
     */
    public function write($username, $context, $ip) {
        // generate unique token
        $key = md5(uniqid('', true) . $username);

        $this->_registry->subscribe($this->config['topic']);
        $this->_registry->send(
            $this->config['topic'],
            // Сообщение с ключом и значением true
            array($key => array(
                'username'  => $username,
                'context'   => $context,
                'ip'        => $ip  // write user's ip for additional security
            )
            ),
            // Самое главное - время жизни сообщения
            array('ttl' => $this->config['ttl'])
        );

        return $key;
    }

    /**
     * Get real user IP
     *
     * @return mixed|string
     */
    public function getUserIP() {
        $client  = $this->modx->getOption(HTTP_CLIENT_IP, $_SERVER);
        $forward = $this->modx->getOption(HTTP_X_FORWARDED_FOR, $_SERVER);
        if(strpos($forward, ',') > 0) {
            $addr = explode(',', $forward);
            $forward = trim($addr[0]);
        }
        $remote  = $this->modx->getOption(REMOTE_ADDR, $_SERVER);

        $ip = '';
        if(filter_var($client, FILTER_VALIDATE_IP)) $ip = $client;
        elseif(filter_var($forward, FILTER_VALIDATE_IP)) $ip = $forward;
        else $ip = $remote;

        return $ip;
    }

}