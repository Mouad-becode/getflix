<?php
 

$pseudo = '';
$password = '';
$password_confirm = '';


// isset to check whether the variables $pseudo and $message contain anything, it will return FALSE if the value is NULL
if(isset($_POST['submit'])){ 

    $pseudo = htmlspecialchars($_POST['pseudo']); 
    $date_subscribed = "";
    $_SESSION[''] = $pseudo;

    if ($_POST['password'] === $_POST['password_confirm']) {

      $pass_hashe = password_hash($_POST['password'], PASSWORD_BCRYPT);
    }

    else {
      echo 'the passwords need to match!';
    }

  }


?>
<form class="form-horizontal" action='' method="POST">
  <fieldset>

    <div id="legend">
      <legend class="">Register</legend>
    </div>
    <div class="control-group">
      <!-- Username -->
      <label class="control-label"  for="pseudo">Pseudo</label>
      <div class="controls">
        <input type="text" id="pseudo" name="pseudo" placeholder="" class="input-xlarge">
        <p class="help-block">Username can contain any letters or numbers, without spaces</p>
      </div>
    </div>
    <div class="control-group">
      <!-- Password-->
      <label class="control-label" for="password">Password</label>
      <div class="controls">
        <input type="password" id="password" name="password" placeholder="" class="input-xlarge">
        <p class="help-block">Password should be at least 4 characters</p>
      </div>
    </div>
 
    <div class="control-group">
      <!-- Password -->
      <label class="control-label"  for="password_confirm">Password (Confirm)</label>
      <div class="controls">
        <input type="password" id="password_confirm" name="password_confirm" placeholder="" class="input-xlarge">
        <p class="help-block">Please confirm password</p>
      </div>
    </div>
 
    <div class="control-group">
      <!-- Button -->
      <div class="controls">
  <input type="submit" name="submit" value="submit">
      </div>
    </div>
  </fieldset>
</form>



<?php





// connect to the server and display errors.
try{
  $db = new PDO('mysql:host=localhost;dbname=getflix', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}

// display errors
catch (Exception $e) {
  die('Error : ' . $e->getMessage());
}


// insert the input into the database
$req = $db->prepare('INSERT INTO members(pseudo, password, date_subscribed) VALUES (:pseudo, :pass_hashe, curdate())');
$req->execute(array(
'pseudo' => $pseudo, 
'pass_hashe' => $pass_hashe
  ));

// get all data from minichat table, and most recent at the top, and set a limit of 10 lines
$response = $db->query('SELECT * FROM members ORDER BY ID DESC LIMIT 0,1');

$isPasswordCorrect = password_verify(password, $pass_hashe);

if (isset($_SESSION['ID']) AND isset($_SESSION['pseudo'])) {

  echo 'Bonjour' . $_SESSION['pseudo'];
}

// get the data and display it on the page
while ($db = $response->fetch()){
  echo '<p> Hello ' . $db['pseudo'] . '</p>';
  }

// frees up the connection to the server so that other SQL statements may be issued, but leaves the statement in a state that enables it to be executed again.
  $response->closeCursor();



// if ( $isPasswordCorrect = FALSE ) {

//   echo 'Wrong password';

// }

// else {

//   if ($isPasswordCorrect) {
//     session_start();
//     $_SESSION['ID'] = $response['ID'];
//     $_SESSION['pseudo'] = $pseudo;
//     echo 'you are connected!';
//   }
//     else {
//       echo 'Wrong password!';
//     }

//   }

//   ?>