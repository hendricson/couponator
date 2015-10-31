<?php

class Ctrl_Security_Dispatch
{  
	public $mAdmp;
	public $mType;
    public $mModule;
    public $mWhat;
    
    public function __construct( &$LangAr = array() )
    {
        $std = $_SERVER['REQUEST_URI'];
                
        /** make standart dispatch */
        $this -> Dispatch( $std );  
    }

    
    public function __get( $name )
    {
         
        if ( isset($this -> $name) )
        {
            return  $this -> $name;
        }
        else
        {
            $r = 0;
            return $r;
        }
    }/** __get */
    
    
    /**
     * make path from some url, ex: /security/users/showlist/
     *
     * @param string $std
     * @return bool true
     */
	public function Dispatch( $std )
	{
		$s = '';
		if (!empty($std))
		{
			$std = str_replace('&', '?', $std);
			if (0 < strpos('_'.$std, '?'))
			{
			    $std = substr($std, 0, strpos($std, '?'));
			}

			$ul  = explode('/', $std);
			$k   = 0;
			for ($i = 0; $i < count($ul); $i++)
			{
				if ( $ul[$i]== 'siteadmin')
				{
					$this -> mAdmp = 1; 
					continue;
				}
				elseif (!empty($ul[$i]) && preg_match('/^[0-9a-z]+$/i', $ul[$i])) 
				{
					switch ($k)
					{
						case 0: 
							$ul[$i][0] = strtoupper($ul[$i][0]);   
							$this -> mType   = $ul[$i];   
					    break;
					    
						case 1: 
							$ul[$i][0] = strtoupper($ul[$i][0]);   
							$this -> mModule = $ul[$i];   
					    break;

						case 2:
							$ul[$i][0] = strtoupper($ul[$i][0]);  
							$this -> mWhat   = $ul[$i];							    
						break;	
					}
				}
				if (2 < $k)
				{
					break;
				}
				$k++;
			}
		}
		
		if (!empty($_REQUEST['type']) && preg_match('/^[0-9a-z]+$/i', $_REQUEST['type']))
		{
			$_REQUEST['type'][0] = strtoupper($_REQUEST['type'][0]);
			$this -> mType = $_REQUEST['type'];
		    
			if (!empty($_REQUEST['mod']) && preg_match('/^[0-9a-z]+$/i', $_REQUEST['mod']))
		    {
			    $_REQUEST['mod'][0] = strtoupper($_REQUEST['mod'][0]);
			   
			    $this -> mModule = $_REQUEST['mod'];
		        if (!empty($_REQUEST['what']) && preg_match('/^[0-9a-z]+$/i', $_REQUEST['what']))
		        {
			        $_REQUEST['what'][0] = strtoupper($_REQUEST['what'][0]);
			        $this -> mWhat = $_REQUEST['what'];
		        }
		    }
		}
				
		return $s;
	}/** Dispatch */

	
	public function Start( &$glObj, $itAdmin = 0 )
	{
		
			if (!SEF) {
				$_REQUEST['ptype'] = strtolower($_GET['type']);
				$_REQUEST['pmod'] = strtolower($_GET['mod']);
				$_REQUEST['pwhat'] = strtolower($_GET['what']);
			} else {
				$_REQUEST['ptype'] = strtolower($this->mType);
				$_REQUEST['pmod'] = strtolower($this->mModule);
				$_REQUEST['pwhat'] = strtolower($this->mWhat);
			}

			if (!empty($_REQUEST['limit'])) $_SESSION[$_REQUEST['ptype'].'.'.$_REQUEST['pmod'].'.limit'] = intval($_REQUEST['limit']);
		    if (empty ($_SESSION[$_REQUEST['ptype'].'.'.$_REQUEST['pmod'].'.limit'])) $_SESSION[$_REQUEST['ptype'].'.'.$_REQUEST['pmod'].'.limit'] = 50;
		    
		    $allowed = array('comby', 'gallery', 'list');	 
		    if (!empty($_REQUEST['view'])) $_SESSION[$_REQUEST['ptype'].'.'.$_REQUEST['pmod'].'.view'] = in_array($_REQUEST['view'], $allowed) ? $_REQUEST['view'] : 'comby';
		    if (empty ($_SESSION[$_REQUEST['ptype'].'.'.$_REQUEST['pmod'].'.view'])) $_SESSION[$_REQUEST['ptype'].'.'.$_REQUEST['pmod'].'.view'] = 'comby';

		    $allowed = array('date', 'popularity', 'age', 'price_asc', 'price_desc');	 
		    if (!empty($_REQUEST['orderby'])) $_SESSION[$_REQUEST['ptype'].'.'.$_REQUEST['pmod'].'.orderby'] = in_array($_REQUEST['orderby'], $allowed) ? $_REQUEST['orderby'] : 'date';
		    if (empty ($_SESSION[$_REQUEST['ptype'].'.'.$_REQUEST['pmod'].'.orderby'])) $_SESSION[$_REQUEST['ptype'].'.'.$_REQUEST['pmod'].'.orderby'] = 'date';

		    	     
		/**
		 * Show module
		 */
		if ( $this -> mType && $this -> mModule )
		{
			if (file_exists( BPATH . 'siteadmin' . CLASS_PATH . 'Ctrl/' . $this -> mType . '/' . $this -> mModule . '.class.php' ))
			{
                /** init module - if exits */
                include_once 'Ctrl/' . $this -> mType . '/' . $this -> mModule . '.class.php';
                if (file_exists( BPATH . 'siteadmin' . CLASS_PATH . 'Model/' . $this -> mType . '/' . $this -> mModule . '.class.php' ))
			{
                           include_once 'Model/' . $this -> mType . '/' . $this -> mModule . '.class.php';         
			}
                $v = 'Ctrl_'.$this -> mType.'_'. $this -> mModule;
                $moCur = new $v( $glObj, $this -> mType . '/' . $this -> mModule );
                
                            if ( !$this -> mWhat ||  !method_exists( $moCur, $this -> mWhat ) )
                            {
                                    $what = $this -> mAdmp ? 'Indexadmin' : 'Index';

                                    if ( !method_exists( $moCur, $what ) )
                                    {
                                        $what = '';
                                    }
                                    
                            }
                            else
                            {
                                    $what = $this -> mWhat;
                            }

                            if ($what)
                            {
                                    $moCur -> $what();
                                    
                            }
                            
                            return true;
			}
		}
				
            include_once 'Ctrl/Base/Index.class.php';
            $moCur = new Ctrl_Base_Index( $glObj );

            $what = $this -> mAdmp ? 'Indexadmin' : 'Index';
		    if ( !method_exists( $moCur, $what ) )
		    {
		        $what = '';		
		    }
		    if ($what)
                    {
                        $moCur -> $what( );
                    }
        return false;
	}/** Start */
	
	
}