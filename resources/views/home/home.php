<div
  class='w-full flex flex-col justify-start items-center'>

  <div
    class='my-8'>
    Chress is a chess application built in PHP.
  </div>

  <div
    class='w-full max-w-sm flex flex-col justify-start items-center'>

    <div
      class='flex w-32 p-2 justify-center items-center'>
      <?=\App\Models\System\Component::make('hyperlink',['href'=>'/games','text'=>'Games'])?>
    </div>

    <div
      class='flex w-32 p-2 justify-center items-center'>
      <?=\App\Models\System\Component::make('hyperlink',['href'=>'/history','text'=>'History'])?>
    </div>

    <div
      class='flex w-32 p-2 justify-center items-center'>
      <?=\App\Models\System\Component::make('hyperlink',['href'=>'/library','text' =>'Library'])?>
    </div>

    <div
      class='flex w-32 p-2 justify-center items-center'>
      <?=\App\Models\System\Component::make('hyperlink',['href'=>'/lobby','text'=>'Lobby'])?>
    </div>

  </div>

</div>