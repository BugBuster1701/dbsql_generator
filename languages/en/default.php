<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Glen Langer 2010 
 * @author     BugBuster 
 * @package    DatabaseGeneratorLanguage
 * @license    LGPL
 * @filesource
 */

/**
 * Back end module
 */
$GLOBALS['TL_LANG']['BackendDBGenerator']['ctitle']     = 'database.sql - Create Statement';
$GLOBALS['TL_LANG']['BackendDBGenerator']['title']      = 'database.sql - Create Statement Generator';
$GLOBALS['TL_LANG']['BackendDBGenerator']['tables']     = 'Table';
$GLOBALS['TL_LANG']['BackendDBGenerator']['table_help'] = 'Please choose the source table.';
$GLOBALS['TL_LANG']['BackendDBGenerator']['tables_pf']  = 'Table Prefix';
$GLOBALS['TL_LANG']['BackendDBGenerator']['table_pf_help'] = 'Here you can enter a table prefix, example: "tl_cal. Then it generates the respective create statements for all tables with this prefix.';
$GLOBALS['TL_LANG']['BackendDBGenerator']['table_pf_not_found'] = 'No tables found with prefix:';

$GLOBALS['TL_LANG']['MSC']['backBT']                = 'Go back';

$GLOBALS['TL_LANG']['BackendDBGenerator']['warning'] = 'ERROR: From version 1.3.0, database.sql Generator requires at least Contao 2.10';
$GLOBALS['TL_LANG']['BackendDBGenerator']['hint']    = 'If you double click anywhere on the code, the entire code view is replaces with a pre-selected view from which you can copy with a simple Ctrl/Cmd-C. Clicking anywhere else returns the view to the original state.'

?>