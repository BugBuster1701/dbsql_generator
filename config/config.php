<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * @link http://www.contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 *
 * PHP version 5
 * @copyright  Glen Langer 2010..2012 
 * @author     BugBuster 
 * @package    DatabaseGenerator 
 * @license    LGPL 
 */

/**
 * Back end module
 */
$GLOBALS['BE_MOD']['devtools']['dbsql_generator'] = array
(
	'callback'   => 'DatabaseGenerator\DBSQLGenerator',
	'icon'       => 'system/modules/dbsql_generator/assets/dbsqlgen.png',
);

