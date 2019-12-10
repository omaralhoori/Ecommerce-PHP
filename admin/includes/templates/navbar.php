<nav class="navbar_Si">
	<div class="konteyner">
		<div class="brand_nav">
			<a href="dashboard.php"><?php echo lang('HOME_ADMIN'); ?></a>
		</div>
 		<div class="konteyner_menu">
 			<ul>
 				<li><a href="categories.php"><?php echo lang('CATEGORIES'); ?></a></li>
 				<li><a href="items.php"><?php echo lang('ITEMS'); ?></a></li>
 				<li><a href="members.php"><?php echo lang('MEMBERS'); ?></a></li>
                <li><a href="comments.php"><?php echo lang('COMMENTS'); ?></a></li>
 			</ul>
 		</div>
 	</div>
 	<div class="small_screen_btn">
 	<button onclick=slideNav()>
 			<i class="fas fa-bars"></i>
 	</button>
 	</div>
 	<div class="hesap">
 		<div class="hesap_isim">
 			<span>Omar </span><i class="fa fa-angle-down"></i>
 		</div>
 		<div class="drop_menu">
 			<ul>
 				<li><a href="members.php?do=Edit&userid=<?php echo $_SESSION['ID']?>">Edit Profile</a></li>
                <li><a href="../index.php">Visit Shop</a></li>
 				<li><a href="#">Settings</a></li>
 				<li><a href="logout.php">Log Out</a></li>
 			</ul>

 		</div>
 	</div>		
</nav>
