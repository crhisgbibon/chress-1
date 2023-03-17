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
    <input
      class='w-48 border border-black p-2 m-2 rounded-lg outline-transparent 
        hover:outline hover:outline-offset-2 hover:outline-sky-100
        focus:outline focus:outline-offset-2 focus:outline-sky-200
        active:outline active:outline-offset-2 active:outline-sky-300'
      type='text'
      id='register_username'
      name='register_username'
      placeholder='...'
      value='<?php if(isset($username)) echo $username ?>'
      autocomplete='name'>
      <span
        class='text-sky-300'>
        <?php if(isset($username_err)) echo $username_err ?>
      </span>
  </div>

  <div
    class='w-screen flex flex-col justify-start items-center my-4'>
    <label
      class='w-48'
      for='register_email'>
      Email:
    </label>
    <input
      class='w-48 border border-black p-2 m-2 rounded-lg outline-transparent 
        hover:outline hover:outline-offset-2 hover:outline-sky-100
        focus:outline focus:outline-offset-2 focus:outline-sky-200
        active:outline active:outline-offset-2 active:outline-sky-300'
      type='email'
      id='register_email'
      name='register_email'
      placeholder='...'
      value='<?php if(isset($email)) echo $email ?>'
      autocomplete='email'>
      <span
        class='text-sky-300'>
        <?php if(isset($email_err)) echo $email_err ?>
      </span>
  </div>

  <div
    class='w-screen flex flex-col justify-start items-center my-4'>
    <label
      class='w-48'
      for='register_password'>
      Password:
    </label>
    <input
      class='w-48 border border-black p-2 m-2 rounded-lg outline-transparent 
        hover:outline hover:outline-offset-2 hover:outline-sky-100
        focus:outline focus:outline-offset-2 focus:outline-sky-200
        active:outline active:outline-offset-2 active:outline-sky-300'
      type='password'
      id='register_password'
      name='register_password'
      placeholder='...'
      autocomplete='new-password'>
      <span
        class='text-sky-300'>
        <?php if(isset($password_err)) echo $password_err ?>
      </span>
  </div>

  <div
    class='w-screen flex flex-col justify-start items-center my-4'>
    <label
      class='w-48'
      for='register_confirm_password'>
      Confirm password:
    </label>
    <input
      class='w-48 border border-black p-2 m-2 rounded-lg outline-transparent 
        hover:outline hover:outline-offset-2 hover:outline-sky-100
        focus:outline focus:outline-offset-2 focus:outline-sky-200
        active:outline active:outline-offset-2 active:outline-sky-300'
      type='password'
      id='register_confirm_password'
      name='register_confirm_password'
      placeholder='...'
      autocomplete='new-password'>
      <span
        class='text-sky-300'>
        <?php if(isset($confirm_password_err)) echo $confirm_password_err ?>
      </span>
  </div>

  <div
    class='w-screen flex flex-col justify-center items-center my-4'>
    <div
      class='flex justify-center items-center'>
      <input
        type='submit'
        value='Register'
        class='w-32 mx-4 p-2 m-2 rounded-lg bg-sky-50 hover:bg-sky-100 active:bg-sky-200'>
    </div>
    <span
      class='text-sky-300'>
      <?php if(isset($success)) echo $success ?>
    </span>
  </div>

</form>