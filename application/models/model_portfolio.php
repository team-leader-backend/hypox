<?php

class Model_Portfolio extends Model
{
	
	public function get_data()
	{	
       $result = $this->get('users',['user_id=6']);
       return $result;
	}

}
