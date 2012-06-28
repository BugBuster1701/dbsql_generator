<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package Dbsql_generator
 * @link    http://www.contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'BugBuster\DatabaseGenerator',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Modules
	'BugBuster\DatabaseGenerator\DBSQLGenerator' => 'system/modules/dbsql_generator/modules/DBSQLGenerator.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_dbsql_gen_be' => 'system/modules/dbsql_generator/templates',
));
