<?php use App\Models\System\Component; ?>
<?php if($loggedin): ?>
<div
  class='w-screen flex flex-row justify-center items-center my-4'>
  You are already registered.
</div>
<?php else: ?>
<form
  method='POST'
  action='/register'
  class='w-screen flex flex-col justify-start items-center'>

  <div
    class='w-screen flex flex-col justify-start items-center my-4'>
    <label
      class='w-48'
      for='register_username'>
      Username:
    </label>
    <div
      class='w-48 m-2'>
      <?=Component::make('input',['version'=>'text','uuid'=>'register_username','nom'=>'register_username','place'=>'...','text'=>$username,'auto'=>'name','check'=>false])?>
    </div>
    <span
      class='text-sky-300'>
      <?=$username_err?>
    </span>
  </div>

  <div
    class='w-screen flex flex-col justify-start items-center my-4'>
    <label
      class='w-48'
      for='register_email'>
      Email:
    </label>
    <div
      class='w-48 m-2'>
      <?=Component::make('input',['version'=>'email','uuid'=>'register_email','nom'=>'register_email','place'=>'...','text'=>$email,'auto'=>'email','check'=>false])?>
    </div>
    <span
      class='text-sky-300'>
      <?=$email_err?>
    </span>
  </div>

  <div
    class='w-screen flex flex-col justify-start items-center my-4'>
    <label
      class='w-48'
      for='register_password'>
      Password:
    </label>
    <div
      class='w-48 m-2'>
      <?=Component::make('input',['version'=>'password','uuid'=>'register_password','nom'=>'register_password','place'=>'...','text'=>'','auto'=>'new-password','check'=>false])?>
    </div>
    <span
      class='text-sky-300'>
      <?=$password_err?>
    </span>
  </div>

  <div
    class='w-screen flex flex-col justify-start items-center my-4'>
    <label
      class='w-48'
      for='register_confirm_password'>
      Confirm password:
    </label>
    <div
      class='w-48 m-2'>
      <?=Component::make('input',['version'=>'password','uuid'=>'register_confirm_password','nom'=>'register_confirm_password','place'=>'...','text'=>'','auto'=>'new-password','check'=>false])?>
    </div>
    <span
      class='text-sky-300'>
      <?=$confirm_password_err?>
    </span>
  </div>

  <div
    class='w-screen flex flex-col justify-center items-center my-4'>
    <div
      class='w-48 m-2'>
      <?=Component::make('input',['version'=>'submit','uuid'=>'','nom'=>'','place'=>'','text'=>'Register','auto'=>'','check'=>false])?>
    </div>
    <span
      class='text-sky-300'>
      <?=$success?>
    </span>
  </div>

</form>
<?php endif; ?>