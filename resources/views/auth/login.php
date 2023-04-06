<?php if(isset($loggedin)) if(!$loggedin): ?>
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
          hover:outline hover:outline-offset-2
          focus:outline focus:outline-offset-2
          active:outline active:outline-offset-2'
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
          hover:outline hover:outline-offset-2
          focus:outline focus:outline-offset-2
          active:outline active:outline-offset-2'
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
        name='remember'
        type='checkbox'
        checked>
    </div>

    <div
      class='w-screen flex justify-center items-center my-4'>
      <div
        class='flex flex-col justify-center items-center'>
        <input
          type='submit'
          value='Log In'
          style='background-color: var(--low);'
          class='w-32 mx-4 p-2 m-2 rounded-lg cursor-pointer'>
        <span
          class='text-sky-300'>
          <?php if(isset($login_err)) echo $login_err ?>
        </span>
        <?php if(isset($login_err)) if($login_err === 'This account has not yet been confirmed.'): ?>
          <div
          class='w-screen flex justify-center items-center'
          style='height: calc(var(--vh) * 7.5);'>
          <a
            style='background-color: var(--low);'
            class='max-w-sm my-4 underline m-2 p-2 rounded-lg hover:scale-105 active:scale-95'
            href='/confirm'>
            Confirm
          </a>
        </div>
        <?php endif; ?>
      </div>
    </div>

  </form>
<?php else: ?>
  <div
    class='w-screen flex flex-row justify-center items-center my-4'>
    <div>
      You are logged in.
    </div>
  </div>
<?php endif; ?>