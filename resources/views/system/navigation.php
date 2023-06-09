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
        class='flex justify-center items-center hover:scale-105 active:scale-95 rounded-lg'
        style='height: calc(var(--vh) * 7.5);'>
        <div
          class='rounded-lg p-2'
          :style="nav ? 'background-color: var(--mid); color: var(--text);' : 'color: var(--text);'">
          <?php include('assets/svg/menu.svg');?>
        </div>
      </button>
      <a
        href='/'
        class='font-bold flex justify-center items-center w-32 md:w-48 rounded-lg'
        style='height: calc(var(--vh) * 7.5);'>
        Chress
      </a>
      <button
        @click='profile = !profile; if(nav) nav = false'
        class='flex justify-center items-center hover:scale-105 active:scale-95 rounded-lg'
        style='height: calc(var(--vh) * 7.5);'>
        <div
          class='rounded-lg p-2'
          :style="profile ? 'background-color: var(--mid); color: var(--text);' : 'color: var(--text);'">
          <?php include('assets/svg/profile.svg');?>
        </div>
      </button>
    </div>
  </nav>

  <div
    x-show='nav'
    class='flex flex-col justify-start items-center w-screen fixed'
    style='min-height: calc(var(--vh) * 92.5); top: calc(var(--vh) * 7.5); z-index: 100; background-color: var(--back);'>

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
      <?=Component::make('hyperlink',['href'=>'/users','text'=>'Users'])?>
    </div>

  </div>

  <div
    x-show='profile'
    class='flex flex-col justify-start items-center w-screen fixed'
    style='min-height: calc(var(--vh) * 92.5); top: calc(var(--vh) * 7.5); z-index: 100; background-color: var(--back);'>
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