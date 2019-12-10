<?php 

	function lang($phrase){
		static $lang = array(

			'HOME_ADMIN' => 'Home' ,
			'CATEGORIES' => 'Categories' ,
			'ITEMS'      => 'Items' ,
			'MEMBERS'    => 'Members' ,
            'COMMENTS'   => 'Comments' ,
            'LOGIN'      => 'LogIn'
		);
		return $lang[$phrase];
	}