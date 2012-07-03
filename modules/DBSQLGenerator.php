<?php 

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * @link http://www.contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 *
 * PHP version 5
 * @copyright  Glen Langer 2011..2012 
 * @author     BugBuster 
 * @package    DatabaseGenerator 
 * @license    LGPL 
 */


/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace BugBuster\DatabaseGenerator;

/**
 * Class DBSQLGenerator
 * 
 * @copyright  Glen Langer 2011..2012 
 * @author     BugBuster 
 * @package    DatabaseGenerator
 */
class DBSQLGenerator extends \BackendModule
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_dbsql_gen_be';
	
	/**
	 * Tables from DB
	 *
	 * @var array
	 * @access private
	 */
	private $_arrTables = array();
	
	/**
	 * Selected Table(s)
	 *
	 * @var array
	 * @access private
	 */
	private $_arrTable  = array();
	
	/**
	 * Selected Table to view
	 *
	 * @var string
	 * @access private
	 */
	private $_table     = '';
	
	/**
	 * Table prefix
	 *
	 * @var string
	 * @access private
	 */
	private $_table_pf  = '';
	
	/**
	 * Backend Theme name
	 *
	 * @var string
	 * @access private
	 */
	private $_beTheme   = '';
	
	/**
	 * Table saved in session
	 *
	 * @var string
	 * @access private
	 */
	private $_session   = '';
	
	/**
	 * Request Token
	 *
	 * @var string
	 * @access private
	 */
	private $_token = 'c0n740';
	
	/**
	 * Current version of the class.
	 */
	const DBSQLGEN_VERSION = '3.0.0';
	
	/**
	 * Name of session name
	 */
	const DBSQLGEN_SESSION = 'dbsqlgentable';

	/**
	 * Compile the current element
	 */
	protected function compile()
	{
		if (version_compare(VERSION, '2.99', '>'))
		{
		   // Code für Versionen ab 3.0 beta
		   $this->_token = REQUEST_TOKEN;
		   $this->Template->warning = false;
		} 
		else 
		{
			// Code für Versionen < 3.0 beta
		   $this->Template->warning = $GLOBALS['TL_LANG']['BackendDBGenerator']['warning'];
		}
			
		$this->Template->referer     = $this->getReferer(ENCODE_AMPERSANDS);
		$this->Template->backTitle   = specialchars($GLOBALS['TL_LANG']['MSC']['backBT']);
		$this->Template->Title       = $GLOBALS['TL_LANG']['BackendDBGenerator']['title'];
		$this->Template->CTitle      = $GLOBALS['TL_LANG']['BackendDBGenerator']['ctitle'];
		$this->Template->collapsed   = ' collapsed';
		$this->Template->DatabaseSQL = '';
		$this->Template->shinit      = '';
		$this->Template->hint		 = false;

		$this->_arrTables = $this->getFromDB();
		$this->setBeTheme();
		$this->getSession(); // table aus session

		if (\Input::post('generate_sql') ==1)
		{
		    $this->_table = \Input::post('list_table');
		    $this->setSession(); // table in session
			$this->Template->DatabaseSQL = $this->getDatabaseSQL();
			$this->Template->collapsed   = '';
			$this->Template->hint        = $GLOBALS['TL_LANG']['BackendDBGenerator']['hint'];
			// Add CSS
			$GLOBALS['TL_CSS'][] = 'plugins/highlighter/'.HIGHLIGHTER.'/shCore.css?'. HIGHLIGHTER .'|screen';
			$GLOBALS['TL_CSS'][] = 'system/modules/dbsql_generator/themes/'.$this->_beTheme.'/shThemeContao.css?' . self::DBSQLGEN_VERSION .'|screen';
			// Add scripts
			$GLOBALS['TL_JAVASCRIPT'][] = 'plugins/highlighter/'.HIGHLIGHTER.'/XRegExp.js?' . HIGHLIGHTER;
			$GLOBALS['TL_JAVASCRIPT'][] = 'plugins/highlighter/'.HIGHLIGHTER.'/shCore.js?' . HIGHLIGHTER;
			$GLOBALS['TL_JAVASCRIPT'][] = 'plugins/highlighter/'.HIGHLIGHTER.'/shBrushPlain.js?' . HIGHLIGHTER;
			// Add Init
			$strInit  = '<script>' . "\n";
			$strInit .= 'SyntaxHighlighter.defaults.toolbar = false;' . "\n";
			$strInit .= 'SyntaxHighlighter.all();' . "\n";
			$strInit .= '</script>';
			$this->Template->shinit = $strInit;
		}
		if (\Input::post('generate_sql_pf') ==1)
		{
		    $this->_table_pf = trim(\Input::post('table_prefix'));
		    $this->setSession(); // table prefix in session
			$this->Template->DatabaseSQL = $this->getDatabaseSQLpf();
			$this->Template->collapsed   = '';
			$this->Template->hint        = $GLOBALS['TL_LANG']['BackendDBGenerator']['hint'];
			// Add CSS
			$GLOBALS['TL_CSS'][] = 'plugins/highlighter/'.HIGHLIGHTER.'/shCore.css?'. HIGHLIGHTER .'|screen';
			$GLOBALS['TL_CSS'][] = 'system/modules/dbsql_generator/themes/'.$this->_beTheme.'/shThemeContao.css?' . self::DBSQLGEN_VERSION .'|screen';
			// Add scripts
			$GLOBALS['TL_JAVASCRIPT'][] = 'plugins/highlighter/'.HIGHLIGHTER.'/XRegExp.js?' . HIGHLIGHTER;
			$GLOBALS['TL_JAVASCRIPT'][] = 'plugins/highlighter/'.HIGHLIGHTER.'/shCore.js?' . HIGHLIGHTER;
			$GLOBALS['TL_JAVASCRIPT'][] = 'plugins/highlighter/'.HIGHLIGHTER.'/shBrushPlain.js?' . HIGHLIGHTER;
			// Add Init
			$strInit  = '<script>' . "\n";
			$strInit .= 'SyntaxHighlighter.defaults.toolbar = false;' . "\n";
			$strInit .= 'SyntaxHighlighter.all();' . "\n";
			$strInit .= '</script>';
			$this->Template->shinit = $strInit;
		}
		$this->Template->TableList  = $this->getTableList();
		$this->Template->TableInput = $this->getTableInput();
	} // compile
	
	/**
	 * Get Table List and generate html form
	 *
	 * @return string	HTML form element
	 * @access protected
	 */
	protected function getTableList()
	{
		return '
        <form action="'.ampersand($this->Environment->request).'" id="dbsqlgen1" name="tl_select_tables" class="tl_form" method="post">
	        <div class="tl_formbody_edit">
	        	<div class="tl_tbox">
	          		<h3><label for="ctrl_original">'.$GLOBALS['TL_LANG']['BackendDBGenerator']['tables'].'</label></h3>
	        	  	'.$this->getAllTables().'
	        		<br>
	        		<p class="tl_help tl_tip">'.$GLOBALS['TL_LANG']['BackendDBGenerator']['table_help'].'</p>
	        		<input name="generate_sql" id="generate_sql" type="hidden" value="1">
	        		<input type="hidden" name="REQUEST_TOKEN" value="'.$this->_token.'">
	        		<br>
	        		<input type="submit" name="create" id="create1" class="tl_submit" alt="create a new database.sql" accesskey="s" value="'.specialchars($GLOBALS['TL_LANG']['MSC']['showOnly']).'" /> 
	        	</div>
	        </div>
        </form>
        ';
	}
	
	/**
	 * Generate table prefix input html form
	 *
	 * @return string	HTML form element
	 * @access protected
	 */
	protected function getTableInput()
	{
		return '
        <form action="'.ampersand($this->Environment->request).'" id="dbsqlgen2" name="tl_select_tables" class="tl_form" method="post">
	        <div class="tl_formbody_edit">
	        	<div class="tl_tbox">
				  	<h3><label for="ctrl_feTables">'.$GLOBALS['TL_LANG']['BackendDBGenerator']['tables_pf'].'</label></h3>
				  	<input type="text" onfocus="Backend.getScrollOffset();" maxlength="255" value="'.$this->_table_pf.'" class="tl_text" id="ctrl_feTables" name="table_prefix">
				  	<p class="tl_help tl_tip">'.$GLOBALS['TL_LANG']['BackendDBGenerator']['table_pf_help'].'</p>
				  	<input name="generate_sql_pf" id="generate_sql_pf" type="hidden" value="1">
				  	<input type="hidden" name="REQUEST_TOKEN" value="'.$this->_token.'">
				  	<br>
					<input type="submit" name="create" id="create2" class="tl_submit" alt="create a new database.sql" accesskey="p" value="'.specialchars($GLOBALS['TL_LANG']['MSC']['showOnly']).'" /> 
				</div>
	        </div>
        </form>
        ';
	}
	
	/**
	 * Generate select list from all tables for form element
	 *
	 * @return string
	 * @access protected
	 */
	protected function getAllTables()
	{
		$r1 = '<select class="tl_select" name="list_table">';
		$r2 = "\n";
		foreach (array_keys($this->_arrTables) as $key => $table)
		{
		    if ($table != $this->_table) 
		    {
		    	$r2 .= '<option value="'.$table.'">'.$table.'</option>';
		    	$r2 .= "\n";
		    }
		    else 
		    {
		        $r2 .= '<option selected="selected" value="'.$table.'">'.$table.'</option>';
		        $r2 .= "\n";
		    }
		}
		$r3 = "</select>\n";
		return $r1 . $r2 . $r3;
	}
	
	/**
	 * Generate create statement for table
	 *
	 * @return string
	 * @access protected
	 */
	protected function getDatabaseSQL()
	{
	    if ($this->Database->tableExists($this->_table) === false) 
	    {
	    	return "Wrong Selection, Table not found";
	    }
	    //$arrTables = $this->getFromDB();
		$this->_arrTable = $this->_arrTables[$this->_table];
		
		$r1 = "-- --------------------------------------------------------\n\n-- \n-- Table `".$this->_table."`\n-- \n\n";
        $this->_arrTable['TABLE_OPTIONS'] = ' ENGINE=MyISAM DEFAULT CHARSET=utf8';
		$r2 = "CREATE TABLE `" . $this->_table . "` (\n  " . implode(",\n  ", $this->_arrTable['TABLE_FIELDS']) . (count($this->_arrTable['TABLE_CREATE_DEFINITIONS']) ? ',' : '') . "\n  " . implode(",\n  ", $this->_arrTable['TABLE_CREATE_DEFINITIONS']) . "\n)".$this->_arrTable['TABLE_OPTIONS'].";\n";
		
		return $r1.$r2;
	}
	
	/**
	 * Generate create statement for tables with prefix
	 *
	 * @return string
	 * @access protected
	 */
	protected function getDatabaseSQLpf()
	{
	    // über Präfix alle Tabellen holen
	    // über getDatabaseSQL die Statements
	    $r1 = '';
	    foreach (array_keys($this->_arrTables) as $key => $table)
	    {
	    	if (substr($table,0,strlen($this->_table_pf)) == $this->_table_pf)
	    	{
	    		$this->_table = $table;
	    		$r1 .= $this->getDatabaseSQL();
	    		$r1 .= "\n";
	    	}
	    }
	    if ($r1 == '') 
	    {
	    	$r1 = "-- --------------------------------------------------------\n\n-- \n-- ".$GLOBALS['TL_LANG']['BackendDBGenerator']['table_pf_not_found']." ".$this->_table_pf."\n-- \n\n";
	    }
	    return $r1;
	}
	
	/**
	 * Compile a table array from the database and return it
	 * 
	 * @return array
	 * @access protected
	 */
	protected function getFromDB()
	{
		//$this->import('Database');
		//$tables = preg_grep('/^tl_/i', $this->Database->listTables());
		$tables = $this->Database->listTables();

		if (empty($tables))
		{
			return array();
		}

		$return = array();

		foreach ($tables as $table)
		{
			$fields = $this->Database->listFields($table, true);

			foreach ($fields as $field)
			{
				$name = $field['name'];
				$field['name'] = '`'.$field['name'].'`';

				if ($field['type'] != 'index')
				{
					unset($field['index']);

					// Field type
					if (strlen($field['length']))
					{
						$field['type'] .= '(' . $field['length'] . (($field['precision'] != '') ? ',' . $field['precision'] : '') . ')';

						unset($field['length']);
						unset($field['precision']);
					}

					// Default values
				    if (in_array(strtolower($field['type']), array('text', 'tinytext', 'mediumtext', 'longtext', 'blob', 'tinyblob', 'mediumblob', 'longblob')) || stristr($field['extra'], 'auto_increment') || $field['default'] === null || strtolower($field['default']) == 'null')
					{
						unset($field['default']);
					}
					else
					{
						$field['default'] = "default '" . $field['default'] . "'";
					}

					$return[$table]['TABLE_FIELDS'][$name] = trim(implode(' ', $field));
				}

				// Indices
				if (strlen($field['index']) && $field['index_fields'])
				{
					$index_fields = implode('`, `', $field['index_fields']);

					switch ($field['index'])
					{
						case 'UNIQUE':
							if ($name == 'PRIMARY')
							{
								$return[$table]['TABLE_CREATE_DEFINITIONS'][$name] = 'PRIMARY KEY  (`'.$index_fields.'`)';
							}
							else
							{
								$return[$table]['TABLE_CREATE_DEFINITIONS'][$name] = 'UNIQUE KEY `'.$name.'` (`'.$index_fields.'`)';
							}
							break;

						case 'FULLTEXT':
							$return[$table]['TABLE_CREATE_DEFINITIONS'][$name] = 'FULLTEXT KEY `'.$name.'` (`'.$index_fields.'`)';
							break;

						default:
							$return[$table]['TABLE_CREATE_DEFINITIONS'][$name] = 'KEY `'.$name.'` (`'.$index_fields.'`)';
							break;
					}

					unset($field['index_fields']);
					unset($field['index']);
				}
			}
		}

		return $return;
	}
	
	/**
	 * Set backend theme variable
	 *
	 * @return void
	 * @access protected
	 */
	protected function setBeTheme()
	{
		$this->_beTheme = $this->getTheme();
		if ($this->_beTheme != 'default' && $this->_beTheme != 'dark_but_nice') 
		{
			$this->_beTheme = 'default';
		}
	}
	
	/**
	 * Get session and set _table and _table_pf
	 *
	 * @return void
	 * @access protected
	 */
	protected function getSession()
	{
		$this->_session = $this->Session->get( self::DBSQLGEN_SESSION );
		$arrSession = '';
		
		if(!empty($this->_session))
		{
			$arrSession = $this->_session;
			$this->_table    = $arrSession[0];
			$this->_table_pf = $arrSession[1];
		} 
	}
	
	/**
	 * Set session with _table and _table_pf content
	 *
	 * @return void
	 * @access protected
	 */
	protected function setSession()
	{
		$this->Session->set( self::DBSQLGEN_SESSION , array($this->_table,$this->_table_pf) );
	}
	
}

