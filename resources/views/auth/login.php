<form
  method='POST'
  action='/login'
  class='w-screen flex flex-col justify-start items-center'>

  <div
    class='w-screen flex flex-col justify-start items-center my-4'>
    <label
      class='w-48'
      for='email'>
      Email:
    </label>
    <input
      class='w-48 border border-black p-2 m-2 rounded-lg outline-transparent 
        hover:outline hover:outline-offset-2 hover:outline-sky-100
        focus:outline focus:outline-offset-2 focus:outline-sky-200
        active:outline active:outline-offset-2 active:outline-sky-300'
      type='email'
      id='email'
      name='email'
      autofocus
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
      for='password'>
      Password:
    </label>
    <input
      class='w-48 border border-black p-2 m-2 rounded-lg outline-transparent 
        hover:outline hover:outline-offset-2 hover:outline-sky-100
        focus:outline focus:outline-offset-2 focus:outline-sky-200
        active:outline active:outline-offset-2 active:outline-sky-300'
      type='password'
      id='password'
      name='password'
      placeholder='...'
      value='<?php if(isset($password)) echo $password ?>'
      autocomplete='current-password'>
    <span
      class='text-sky-300'>
      <?php if(isset($password_err)) echo $password_err ?>
    </span>
  </div>

  <div
    class='w-screen flex flex-row justify-center items-center my-4'>
    <label
      class='mx-4'
      for='remember'>Remember:</label>
    <input
      class='mx-4'
      id='remember'
      type='checkbox'
      checked>
  </div>

  <div
    class='w-screen flex justify-center items-center my-4'>
    <div
      class='flex flex-row justify-center items-center'>
      <input
        type='submit'
        value='Log In'
        class='w-32 mx-4 p-2 m-2 rounded-lg cursor-pointer bg-sky-50 hover:bg-sky-100 active:bg-sky-200'>
    </div>
  </div>

</form>