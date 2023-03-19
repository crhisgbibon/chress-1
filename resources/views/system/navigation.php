<?php use App\Models\System\Component; ?>
<div
  x-data='{
    nav: false,
    profile: false,
  }'>

  <nav
    class='w-full flex justify-center items-center'
    style='height: calc(var(--vh) * 7.5); top: 0'>
    <div
      class='flex flex-row justify-around items-center max-w-xl'
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
        class='font-bold text-sky-300 flex justify-center items-center w-32 md:w-48'
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
      class='flex justify-center items-center my-2 w-32'
      style='height: calc(var(--vh) * 7.5);'>
      <?=Component::make('hyperlink',['href'=>'/create','text'=>'Create'])?>
    </div>
    <div
      class='flex justify-center items-center my-2 w-32'
      style='height: calc(var(--vh) * 7.5);'>
      <?=Component::make('hyperlink',['href'=>'/games','text'=>'Games'])?>
    </div>
    <div
      class='flex justify-center items-center my-2 w-32'
      style='height: calc(var(--vh) * 7.5);'>
      <?=Component::make('hyperlink',['href'=>'/history','text'=>'History'])?>
    </div>
    <div
      class='flex justify-center items-center my-2 w-32'
      style='height: calc(var(--vh) * 7.5);'>
      <?=Component::make('hyperlink',['href'=>'/library','text'=>'Library'])?>
    </div>
    <div
      class='flex justify-center items-center my-2 w-32'
      style='height: calc(var(--vh) * 7.5);'>
      <?=Component::make('hyperlink',['href'=>'/lobby','text'=>'Lobby'])?>
    </div>
    <div
      class='flex justify-center items-center my-2 w-32'
      style='height: calc(var(--vh) * 7.5);'>
      <?=Component::make('hyperlink',['href'=>'/play','text'=>'Play'])?>
    </div>
  </div>

  <div
    x-show='profile'
    class='flex flex-col justify-start items-center w-screen z-10 fixed'
    style='min-height: calc(var(--vh) * 92.5); top: calc(var(--vh) * 7.5); z-index: 100; background-color: rgba(255,255,255,1);'>
    <?php if($loggedin): ?>
      <div
        class='max-w-sm p-2 rounded-lg my-2 w-full flex justify-center items-center'>
        Logged in as: <?php if(isset($name)) echo $name?>
      </div>
      <div
        class='flex justify-center items-center my-2 w-32'
        style='height: calc(var(--vh) * 7.5);'>
        <?=Component::make('hyperlink',['href'=>'/profile','text'=>'Profile'])?>
      </div>
      <div
        class='flex justify-center items-center my-2 w-32'
        style='height: calc(var(--vh) * 7.5);'>
        <?=Component::make('hyperlink',['href'=>'/logout','text'=>'Log Out'])?>
      </div>
    <?php else: ?>
      <div
        class='flex justify-center items-center my-2 w-32'
        style='height: calc(var(--vh) * 7.5);'>
        <?=Component::make('hyperlink',['href'=>'/login','text'=>'Log In'])?>
      </div>
      <div
        class='flex justify-center items-center my-2 w-32'
        style='height: calc(var(--vh) * 7.5);'>
        <?=Component::make('hyperlink',['href'=>'/register','text'=>'Register'])?>
      </div>
      <div
        class='flex justify-center items-center my-2 w-32'
        style='height: calc(var(--vh) * 7.5);'>
        <?=Component::make('hyperlink',['href'=>'/recover','text'=>'Recover'])?>
      </div>
    <?php endif; ?>
  </div>

</div>