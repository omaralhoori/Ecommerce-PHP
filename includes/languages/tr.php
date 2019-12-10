<?php 

	function lang($phrase){
		static $lang = array(

			'MESSAGE' => 'Merhaba' ,
			'ADMIN'   => 'Yoniteci',
            'LOGIN'   => 'Oturum Aç',
            'country'	 => 'Ülke',
            'language'	 =>	'Dil',
            'support_center' => 'Destek Merkezi',
            'cont_site'  => 'Ülke Sitesi',
            'all_cat'	 => 'Tüm Kategoriler',
		);
		return $lang[$phrase];
	}