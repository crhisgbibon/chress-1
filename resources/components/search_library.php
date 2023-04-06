<?php use App\Models\System\Component; ?>
<div
  class='w-full flex flex-col justify-start items-center my-4'>

    <div
      class='w-full my-2 flex flex-col justify-center items-center'>

      <div
        class='max-w-xs my-2'>
        <?=Component::make('input',['version'=>'text','uuid'=>'event','nom'=>'event','place'=>'Event...','text'=>'','auto'=>'','check'=>false])?>
      </div>

      <div
        class='max-w-xs my-2'>
        <?=Component::make('input',['version'=>'text','uuid'=>'site','nom'=>'site','place'=>'Site...','text'=>'','auto'=>'','check'=>false])?>
      </div>

      <div
        class='max-w-xs my-2'>
        <?=Component::make('input',['version'=>'text','uuid'=>'date','nom'=>'date','place'=>'Date...','text'=>'','auto'=>'','check'=>false])?>
      </div>

      <div
        class='max-w-xs my-2'>
        <?=Component::make('input',['version'=>'text','uuid'=>'round','nom'=>'round','place'=>'Round...','text'=>'','auto'=>'','check'=>false])?>
      </div>

      <div
        class='max-w-xs my-2'>
        <?=Component::make('input',['version'=>'text','uuid'=>'white','nom'=>'white','place'=>'White...','text'=>'','auto'=>'','check'=>false])?>
      </div>

      <div
        class='max-w-xs my-2'>
        <?=Component::make('input',['version'=>'text','uuid'=>'black','nom'=>'black','place'=>'Black...','text'=>'','auto'=>'','check'=>false])?>
      </div>

      <div
        class='max-w-xs my-2'>
        <?=Component::make('input',['version'=>'text','uuid'=>'result','nom'=>'result','place'=>'Result...','text'=>'','auto'=>'','check'=>false])?>
      </div>

    </div>


    <div
      class='w-40 h-10 flex justify-center items-center my-2'>
      <button
        class='rounded-lg flex justify-center items-center
              hover:scale-105 active:scale-95'
        style='min-height: 100%; min-width: 100%;background-color:var(--low);'
        onclick=''
        >
        Submit
      </button>
    </div>
  
</div>