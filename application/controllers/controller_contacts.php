<?php

class Controller_Contacts extends Controller
{
	
	function action_index()
	{
		$this->view->generate('contacts.view.php', 'template_view.php');
	}
    function action_go(){
        $this->view->generate('go/contacts.go.view.php', 'template_view.php');
    }
}
