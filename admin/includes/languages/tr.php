<?php 

	
	function lang($phrase){
		static $lang = array(

			'HOME_ADMIN' => 'Ana Sayfa' ,
			'CATEGORIES' => 'Kategoriler' ,
			'ITEMS'      => 'Urunler' ,
			'MEMBERS'    => 'Uyuler' ,
            'COMMENTS'   => 'Yorumlar' ,
            'LOGIN'      => 'Oturum AÇ'

		);
		return $lang[$phrase];
	}