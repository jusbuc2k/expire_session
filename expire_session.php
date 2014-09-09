<?php

class expire_session extends rcube_plugin 
{
	private $session_ttl = 0;

    function init() 
    {
		$rcmail = rcmail::get_instance();
		
		$plugins = $rcmail->config->get('plugins');
		$plugins = array_flip($plugins);
		if (!isset($plugins['global_config'])) {
			$this->load_config();
		}
		
		$this->session_ttl = $rcmail->config->get('session_ttl', 60 * 11);
		
    	$this->add_hook('ready', array($this, 'ready'));
		$this->add_hook('login_after', array($this, 'login_after'));
		$this->add_hook('template_object_loginform', array($this,'expire_session_loginform'));
    }
    
    function ready($args)
    {	
		$rcmail = rcmail::get_instance();
		$now = time();
		
		$session_length = $now - $_SESSION["renewed"];
		
		rcube::write_log('session', 'Session time since last renewal is ' . $session_length . ' and ttl is ' . $this->session_ttl );
		
		if ( isset($_SESSION["expire_session"]) && $_SESSION["expire_session"] == true && $session_length > $this->session_ttl ){		
			rcube::write_log('session', 'Session is expired.');
			$rcmail->kill_session();
			header('Location: ?_task=logout');
			exit;
		}
		
		// Ignore the AJAX auto refresh activity
		// $args['task'] === 'mail' &&
		if ($args['action'] === 'refresh'){
			return $args;
		}
		
		$_SESSION["renewed"] = $now;
		
		$this->include_script('expire_session.js');
		//rcube::write_log('session', 'Renewed session for task ' . $args['task'] . ' and action ' . $args['action']);		
    }
	
	function expire_session_loginform($content)
	{
		$rcmail = rcmail::get_instance();
		if ($rcmail->task == 'login' && ($rcmail->action == 'login' || $rcmail->action == "")) 
		{
			$this->add_texts('localization', true);		
			$this->include_script('expire_session_login.js');		
		}
		return $content;
	}
	
	function login_after($args)
	{
		$rcmail = rcmail::get_instance();
		$_SESSION["renewed"] = time();
		$_SESSION["expire_session"] = true;
		if (get_input_value('_keep_session', RCUBE_INPUT_POST) == "yes") {			
			$_SESSION["expire_session"] = false;
		}
		return $args;
	}
	
}
