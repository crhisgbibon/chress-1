<?php use App\Models\System\Component; ?>
<div
  class='w-full flex flex-col justify-start items-center'>

  <div
    class='my-8'>
    Chress is a chess application built in PHP.
  </div>

  <div
    class='w-full flex-none max-w-sm block'>

    <div
      class='flex w-32 p-2 justify-center items-center float-left'>
      <?=Component::make('hyperlink',['href'=>'/create','text'=>'Create'])?>
    </div>

    <div
      class='flex w-32 p-2 justify-center items-center float-left'>
      <?=Component::make('hyperlink',['href'=>'/games','text'=>'Games'])?>
    </div>

    <div
      class='flex w-32 p-2 justify-center items-center float-left'>
      <?=Component::make('hyperlink',['href'=>'/history','text'=>'History'])?>
    </div>

    <div
      class='flex w-32 p-2 justify-center items-center float-left'>
      <?=Component::make('hyperlink',['href'=>'/library','text' =>'Library'])?>
    </div>

    <div
      class='flex w-32 p-2 justify-center items-center float-left'>
      <?=Component::make('hyperlink',['href'=>'/lobby','text'=>'Lobby'])?>
    </div>

    <div
      class='flex w-32 p-2 justify-center items-center float-left'>
      <?=Component::make('hyperlink',['href'=>'/play','text'=>'Play'])?>
    </div>

  </div>

</div>