<?php
/**
 * systemSettings transport file for LoginAs extra
 *
 * Copyright 2017 by Andrey Panyush <andreypanyush@gmail.com>
 * Created on 01-09-2018
 *
 * @package loginas
 * @subpackage build
 */

if (! function_exists('stripPhpTags')) {
    function stripPhpTags($filename) {
        $o = file_get_contents($filename);
        $o = str_replace('<' . '?' . 'php', '', $o);
        $o = str_replace('?>', '', $o);
        $o = trim($o);
        return $o;
    }
}
/* @var $modx modX */
/* @var $sources array */
/* @var xPDOObject[] $systemSettings */


$systemSettings = array();

$systemSettings[1] = $modx->newObject('modSystemSetting');
$systemSettings[1]->fromArray(array (
  'key' => 'loginas.token_ttl',
  'name' => 'loginas.setting_ttl',
  'description' => 'loginas.setting_ttl_description',
  'namespace' => 'loginas',
  'xtype' => 'textfield',
  'value' => '300',
  'area' => 'loginas.main',
), '', true, true);
$systemSettings[2] = $modx->newObject('modSystemSetting');
$systemSettings[2]->fromArray(array (
  'key' => 'loginas.remove_read',
  'name' => 'loginas.setting_remove_read',
  'description' => 'loginas.setting_remove_read_description',
  'namespace' => 'loginas',
  'xtype' => 'combo-boolean',
  'value' => true,
  'area' => 'loginas.main',
), '', true, true);
$systemSettings[3] = $modx->newObject('modSystemSetting');
$systemSettings[3]->fromArray(array (
  'key' => 'loginas.check_ip',
  'name' => 'loginas.setting_check_ip',
  'description' => 'loginas.setting_check_ip_description',
  'namespace' => 'loginas',
  'xtype' => 'combo-boolean',
  'value' => true,
  'area' => 'loginas.main',
), '', true, true);
$systemSettings[4] = $modx->newObject('modSystemSetting');
$systemSettings[4]->fromArray(array (
  'key' => 'loginas.redirect',
  'name' => 'loginas.setting_redirect',
  'description' => 'loginas.setting_redirect_description',
  'namespace' => 'loginas',
  'xtype' => 'textfield',
  'value' => '',
  'area' => 'loginas.main',
), '', true, true);
return $systemSettings;
