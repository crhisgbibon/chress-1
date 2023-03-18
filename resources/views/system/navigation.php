<div
  x-data='{
    nav: false,
    profile: false,
  }'>

  <nav
    class='w-screen flex justify-center items-center'
    style='height: calc(var(--vh) * 7.5); top: 0'>
    <div
      class='flex flex-row justify-between items-center max-w-xl'
      style='height: calc(var(--vh) * 7.5);'>
      <button
        @click='nav = !nav; if(profile) profile = false'
        class='flex justify-center items-center hover:scale-105 active:scale-95'
        style='height: calc(var(--vh) * 7.5);'>
        <img
          src='assets/svg/menu.svg'
          class='rounded-lg p-2'
          :class="nav ? 'bg-sky-200' : ''"></img>
      </button>
      <a
        href='/'
        class='font-bold text-sky-300 flex justify-center items-center w-32 md:w-48 mx-4'
        style='height: calc(var(--vh) * 7.5);'>
        Chress
      </a>
      <button
        @click='profile = !profile; if(nav) nav = false'
        class='flex justify-center items-center hover:scale-105 active:scale-95'
        style='height: calc(var(--vh) * 7.5);'>
        <img
          src='assets/svg/profile.svg'
          class='rounded-lg p-2'
          :class="profile ? 'bg-sky-200' : ''"></img>
      </button>
    </div>
  </nav>

  <div
    x-show='nav'
    class='flex flex-col justify-start items-center w-screen fixed'
    style='min-height: calc(var(--vh) * 92.5); top: calc(var(--vh) * 7.5); z-index: 100; background-color: rgba(255,255,255,1);'>
    <div
      class='w-screen flex justify-center items-center'
      style='height: calc(var(--vh) * 7.5);'>
      <a
        class='max-w-sm my-4 underline m-2 p-2 rounded-lg hover:bg-sky-100 hover:scale-105 active:scale-95'
        href='/'>
        Home
      </a>
    </div>
    <div
      class='w-screen flex justify-center items-center'
      style='height: calc(var(--vh) * 7.5);'>
      <a
        class='max-w-sm my-4 underline m-2 p-2 rounded-lg hover:bg-sky-100 hover:scale-105 active:scale-95'
        href='/play'>
        Play
      </a>
    </div>
    <div
      class='w-screen flex justify-center items-center h-full'
      style='height: calc(var(--vh) * 7.5);'>
      <a
        class='max-w-sm my-4 underline m-2 p-2 rounded-lg hover:bg-sky-100 hover:scale-105 active:scale-95'
        href='/lobby'>
        Lobby
      </a>
    </div>
    <div
      class='w-screen flex justify-center items-center h-full'
      style='height: calc(var(--vh) * 7.5);'>
      <a
        class='max-w-sm my-4 underline m-2 p-2 rounded-lg hover:bg-sky-100 hover:scale-105 active:scale-95'
        href='/library'>
        Library
      </a>
    </div>
  </div>

  <div
    x-show='profile'
    class='flex flex-col justify-start items-center w-screen z-10 fixed'
    style='min-height: calc(var(--vh) * 92.5); top: calc(var(--vh) * 7.5); z-index: 100; background-color: rgba(255,255,255,1);'>
    <?php if($loggedin): ?>
      <div
        class='max-w-sm my-4 m-2 p-2 rounded-lg'>
        Logged in as: <?php if(isset($name)) echo $name?>
      </div>
      <div
        class='w-screen flex justify-center items-center'
        style='height: calc(var(--vh) * 7.5);'>
        <a
          class='max-w-sm my-4 underline m-2 p-2 rounded-lg hover:bg-sky-100 hover:scale-105 active:scale-95'
          href='/profile'>
          Profile
        </a>
      </div>
      <div
        class='w-screen flex justify-center items-center'
        style='height: calc(var(--vh) * 7.5);'>
        <a
          class='max-w-sm my-4 underline m-2 p-2 rounded-lg hover:bg-sky-100 hover:scale-105 active:scale-95'
          href='/logout'>
          Log Out
        </a>
      </div>
    <?php else: ?>
      <div
        class='w-screen flex justify-center items-center'
        style='height: calc(var(--vh) * 7.5);'>
        <a
          class='max-w-sm my-4 underline m-2 p-2 rounded-lg hover:bg-sky-100 hover:scale-105 active:scale-95'
          href='/login'>
          Log in
        </a>
      </div>
      <div
        class='w-screen flex justify-center items-center'
        style='height: calc(var(--vh) * 7.5);'>
        <a
          class='max-w-sm my-4 underline m-2 p-2 rounded-lg hover:bg-sky-100 hover:scale-105 active:scale-95'
          href='/register'>
          Register
        </a>
      </div>
      <div
        class='w-screen flex justify-center items-center'
        style='height: calc(var(--vh) * 7.5);'>
        <a
          class='max-w-sm my-4 underline m-2 p-2 rounded-lg hover:bg-sky-100 hover:scale-105 active:scale-95'
          href='/recover'>
          Recover
        </a>
      </div>
    <?php endif; ?>
  </div>

</div>