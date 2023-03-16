<?php

class Controller_Empty extends Controller
{

	function action_index()
	{
        $data['title'] = "Chief Pharmaceuticals";
        $data['h1'] = "Главная";
        $data['h2'] = "Справочник врача";
        $data['breadcrumbs'] = [
            '#'=>'Главная'
        ];
		$this->view->generate('empty.view.php', 'layout/template.main.view.php', $data);
	}
}