<div
  x-data="{ login: true }"
  class='w-full flex flex-col justify-center items-center'>

  <h1
    class='my-4 p-4 font-bold text-sky-300'>
    Chress
  </h1>

  <form
    x-show="login"
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
        autocomplete='email'>
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
        autocomplete='current-password'>
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

  <form
    x-show="!login"
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
        autocomplete='name'>
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
        autocomplete='email'>
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
    </div>

    <div
      class='w-screen flex justify-center items-center my-4'>
      <div
        class='flex flex-row justify-center items-center'>
        <input
          type='submit'
          value='Register'
          class='w-32 mx-4 p-2 m-2 rounded-lg bg-sky-50 hover:bg-sky-100 active:bg-sky-200'>
      </div>
    </div>

  </form>

  <nav
    class='w-screen flex justify-center items-center my-4'>
    <div
      class='flex flex-row justify-center items-center'>
      <button
        class='w-32 mx-4 underline p-2 m-2 rounded-lg hover:bg-sky-100'
        @click="login = true"
        :class="login ? 'hidden' : ''">
        Log in
      </button>
      <button
        class='w-32 mx-4 underline p-2 m-2 rounded-lg hover:bg-sky-100'
        @click="login = false"
        :class="login ? '' : 'hidden'">
        Register
      </button>
    </div>
  </nav>

</div>