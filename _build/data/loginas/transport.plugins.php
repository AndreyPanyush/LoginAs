<?php
/**
 * plugins transport file for LoginAs extra
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
/* @var xPDOObject[] $plugins */


$plugins = array();

$plugins[1] = $modx->newObject('modPlugin');
$plugins[1]->fromArray(array (
  'id' => 1,
  'description' => '',
  'name' => 'LoginAs',
), '', true, true);
$plugins[1]->setContent(file_get_contents($sources['source_core'] . '/elements/plugins/loginas.plugin.php'));

return $plugins;
