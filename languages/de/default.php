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
$GLOBALS['TL_LANG']['BackendDBGenerator']['tables']     = 'Tabelle';
$GLOBALS['TL_LANG']['BackendDBGenerator']['table_help'] = 'Bitte wählen Sie die Quelltabelle.';
$GLOBALS['TL_LANG']['BackendDBGenerator']['tables_pf']  = 'Tabellen Präfix';
$GLOBALS['TL_LANG']['BackendDBGenerator']['table_pf_help'] = 'Hier können Sie einen Tabellen Präfix eingeben z.B. "tl_cal", es wird dann für alle Tabellen mit diesem Präfix die jeweiligen Create Statements generiert.';
$GLOBALS['TL_LANG']['BackendDBGenerator']['table_pf_not_found'] = 'Kein Tabelle gefunden mit Präfix:';

$GLOBALS['TL_LANG']['MSC']['backBT']                = 'Zurück';

$GLOBALS['TL_LANG']['BackendDBGenerator']['warning'] = 'ERROR: Ab Version 1.3.0 benötigt der database.sql Generator mindestens Contao 2.10';
$GLOBALS['TL_LANG']['BackendDBGenerator']['hint']    = 'Mit einem Doppelklick auf die Code-Ansicht, wird diese mit einer vorgewählten Sicht ersetzt. Es kann nun mit Ctrl/Strg/Cmd-C der Code kopiert werden. Ein Klick anderswo stellt den ursprünglichen Zustand wieder her.'

?>