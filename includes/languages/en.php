<?php 

	function lang($phrase){
		static $lang = array(

			'HOME_ADMIN' => 'Home' ,
			'CATEGORIES' => 'Categories' ,
			'ITEMS'      => 'Items' ,
			'MEMBERS'    => 'Members' ,
            'COMMENTS'   => 'Comments' ,
            'LOGIN'      => 'LogIn',
            'country'	 => 'Country',
            'language'	 =>	'Language',
            'support_center' => 'Support Center',
            'cont_site'  => 'Country Website',
            'all_cat'	 => 'All Categories',
		);
		return $lang[$phrase];
	}