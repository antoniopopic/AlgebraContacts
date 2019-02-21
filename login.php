<?php

require_once 'core/init.php';

Helper::getHeader('Algebra Contacts', 'main-header');

require 'notifications.php'; 

$user = new User();
$validation = new Validation();

if(Input::exists()){
    if(Token::factory()->check(Input::get('token'))){ 
        $validate = $validation->check([                   
            'username'          => [
                'required'          => true
            ],

            'password'          =>[
                'required'          => true
            ]
        ]);
        }
        if($validation->passed()){
            $uName = $_POST['username'];
            $pWord = $_POST['password'];

            $salt = Hash::salt(32);
            $password = Hash::make(Input::get('password'), $salt);
        
            /* if (empty($uName) || empty($pWord)) {
                echo 'All fields are required!';
            }  if {*/
                $login = $user->logIn($uName, $pWord);
                
                if (!$login) {
                    echo '<div class="alert alert-danger">Your username and/or password are incorrect. Please try again.</div>';
                    
                } else {
                    /* echo '<pre>';
                    var_dump($login); */
                    Redirect::to('dashboard');
                    exit();
                }
            /* } */
        }
        
        // $username = (isset($_POST['username']))? $_POST['username'] : false;
        // $password = (isset($_POST['password']))? $_POST['password'] : false;

         
        /* $get = $db->get('*', 'users',[
            'password' => $password
        ]);  */

        /* try {
            $user -> User::logIn(Input::get('username'), Input::get('password'));
        } catch (Exception $e) {
            Session::flash('danger', $e-getMessage());
            Redirect::to('login');
            return false;
        } */
        

        /* $username = $user->find(Input::get('username'));
        if(Input::get('username') == $username && Input::get('password') == $username){
            header('Location: dashboard.php');   
        }     
    }*/
}
?>

<div class="row">
    <div class="col-xs-12 col-md-8 col-lg-6 col-md-offset-2 col-lg-offset-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Sign In</h3>
            </div>
            <div class="panel-body">
                <form method="post">
                <input type="hidden" name="token" value="<?php echo Token::factory()::generate(); ?>">
                    <div class="form-group <?php echo ($validation->hasError('username')) ? 'has-error':''; ?>">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" autofocus value="<?php echo Input::get('username') ?>">
                        <?php echo ($validation->hasError('username')) ? '<p class="text-danger">'.$validation->hasError('username').'</p>' :''; ?>
                    </div>
                    <div class="form-group <?php echo ($validation->hasError('password')) ? 'has-error':''; ?>">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        <?php echo ($validation->hasError('password')) ? '<p class="text-danger">'.$validation->hasError('password').'</p>' :''; ?>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Sign In</button>
                    </div>
                    <p>If you don't have an account, please <a href="register.php">Register</a></p>
                </form>
            </div>
        </div>
    </div>
</div>

<?php

Helper::getFooter();

?>