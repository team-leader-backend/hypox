<?php

class Controller_Main extends Controller
{

	function action_index()
	{
        $data = [
            'title'=>'Typox8.2',
            'h1'=>'Typox for php 8.2',
            'h2'=>'For php version 5.6+',
            'breadcrumbs'=>[
                '#'=>'First step',
                '#'=>'Second step'
            ]
        ];
		$this->view->generate('main_view.php', 'template_view.php', $data);
	}
}