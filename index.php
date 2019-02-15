<?php
require_once 'core/init.php';
Helper::getHeader('Algebra Contacts', 'main-header');

?>  
   
   <div class="row">
		<div class="col-xs-12 col-md-8 col-lg-6 col-md-offset-2 col-lg-offset-3">
			<div class="jumbotron">
				<div class="container">
					<h1><?php echo Config::get('app')['name'] ?></h1>
					<p>Lorem ipsum dolor sit amet!</p>
					<p><?php Config::get('app') ?></p>
					<p>
						<a class="btn btn-primary btn-lg" href="login.php" role="button">Sign In</a>
						or
						<a class="btn btn-primary btn-lg" href="register.php" role="button">Create an account</a> 
					</p>
				</div>
			</div>
		</div>
	</div> 
   
<?php

/* $db = DB::getInstance();

$get = $db->get('*','users'); */

//$find = $db->find(2, 'users');
//$delete = $db->get('users', ['id', '=', 2]);

/* $update = $db->update('users', 2,[
	'username' => 'markina',
	'name'	   => 'Ivan'
]); */

/* $insert = $db->insert('users',[
	'name'	   => 'Iva',
	'username' => 'iva',
	'password' => '123456',
	'salt'	   => '654654',
	'role_id'  => '1'
]); */


/* echo '<pre>';
var_dump($update); */

Helper::getFooter();
?>
