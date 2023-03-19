<?php use App\Models\System\Component; ?>
<div
  x-data="{ 
    moves: false,
    moveData: '',
    info: false,
  }" 
  class='flex flex-col justify-start items-center w-full'>

  <div
    class='flex flex-row justify-center items-center w-full my-2'
    style='height: calc(var(--vh) * 5);'>
    <div
      class='w-20 mx-2'>
      <?=Component::make('fetch_button',['fetch'=>'/play/mode','output'=>'output','text'=>'Mode','body'=>''])?>
    </div>
    <div
      class='w-20 mx-2'>
      <?=Component::make('fetch_button',['fetch'=>'/play/lastgame','output'=>'output','text'=>'<','body'=>''])?>
    </div>
    <div
      class='flex justify-center items-center w-20 mx-2'>
      0
    </div>
    <div
      class='w-20 mx-2'>
      <?=Component::make('fetch_button',['fetch'=>'/play/nextgame','output'=>'output','text'=>'>','body'=>''])?>
    </div>
    <button 
      class='mx-2 w-20 rounded-lg bg-sky-50 hover:bg-sky-100 active:bg-sky-200 hover:scale-105 active:scale-95'
      @click="moves = !moves">
      Moves
    </button>

  </div>

  <div
    class='flex flex-row justify-center items-center w-full my-2'
    style='height: calc(var(--vh) * 5);'>
    <div
      class='w-20 mx-2'>
      <?=Component::make('fetch_button',['fetch'=>'/play/flip','output'=>'output','text'=>'Flip','body'=>''])?>
    </div>
    <div
      class='w-20 mx-2'>
      <?=Component::make('fetch_button',['fetch'=>'/play/lastmove','output'=>'output','text'=>'<','body'=>''])?>
    </div>
    <div
      class='flex justify-center items-center w-20 mx-2'>
      0
    </div>
    <div
      class='w-20 mx-2'>
      <?=Component::make('fetch_button',['fetch'=>'/play/nextmove','output'=>'output','text'=>'>','body'=>''])?>
    </div>
    <button 
      class='mx-2 w-20 rounded-lg bg-sky-50 hover:bg-sky-100 active:bg-sky-200 hover:scale-105 active:scale-95'
      @click="info = !info">
      Info
    </button>
  </div>

  <div
    x-show="moves">
    Moves
  </div>

  <div
    x-show="info">
    <?=Component::make('info',[])?>
  </div>

  <div
    class='flex flex-col justify-start items-center'
    style='min-height: calc(var(--vh) * 75);'>
    <div
      class='my-4'>
      <?=Component::make('board',[])?>
    </div>
  </div>

  <div>
    <button onclick="PromotePawn('Q');"><img id="pPromoteQ" src=""></img></button>
    <button onclick="PromotePawn('B');"><img id="pPromoteB" src=""></img></button>
    <button onclick="PromotePawn('K');"><img id="pPromoteK" src=""></img></button>
    <button onclick="PromotePawn('R');"><img id="pPromoteR" src=""></img></button>
  </div>

</div>