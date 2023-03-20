<?php use App\Models\System\Component; ?>
<?php if(!isset($board) && isset($gameid)): ?>
  <div
    class='flex flex-col justify-start items-center w-full'>
    Game data not found.
  </div>
<?php else: ?>
  <div
    x-data="{
      moveData: '',
      flipstate: 'rotate-180',
      info: false,
      flip: <?php if($iswhite) echo 'false'; else echo 'true';?>,
    }" 
    class='flex flex-col justify-start items-center w-full'>

    <div
      class='flex flex-row justify-center items-center w-full my-2'
      style='height: calc(var(--vh) * 7.5);'>
      <div
        class='w-20 mx-2'
        style='height: calc(var(--vh) * 5);'>
          <button 
          class='h-full w-20 rounded-lg bg-sky-50 hover:bg-sky-100 active:bg-sky-200 hover:scale-105 active:scale-95 flex justify-center items-center'
          @click="flip = !flip;">
          <img src='assets/svg/flip.svg'></img>
        </button>
      </div>
      <div
        class='w-20 mx-2'
        style='height: calc(var(--vh) * 5);'>
        <?=Component::make('fetch_button',['fetch'=>'/game/lastmove','output'=>'output','text'=>'<','body'=>''])?>
      </div>
      <div
        class='flex justify-center items-center w-20 mx-2'
        style='height: calc(var(--vh) * 5);'>
        0
      </div>
      <div
        class='w-20 mx-2'
        style='height: calc(var(--vh) * 5);'>
        <?=Component::make('fetch_button',['fetch'=>'/game/nextmove','output'=>'output','text'=>'>','body'=>''])?>
      </div>
      <div
        class='w-20 mx-2'
        style='height: calc(var(--vh) * 5);'>
        <button 
          class='h-full w-20 rounded-lg bg-sky-50 hover:bg-sky-100 active:bg-sky-200 hover:scale-105 active:scale-95 flex justify-center items-center'
          @click="info = !info">
          <img src='assets/svg/info.svg'></img>
        </button>
      </div>
    </div>

    <div
      class='flex flex-col justify-start items-center w-screen fixed'
      style='min-height: calc(var(--vh) * 85); top: calc(var(--vh) * 15); z-index: 10; background-color: rgba(255,255,255,1);'
      x-show="info">
      <?=Component::make('info',[])?>
    </div>

    <div
      id='board'
      class='flex flex-col justify-start items-center w-full'
      style='min-height: calc(var(--vh) * 75);'>
      <div
        class='my-4'>
        <?=Component::make('board',['board'=>$board])?>
      </div>
    </div>

    <div
      x-init='Square();'>
      <button onclick="PromotePawn('Q');"><img id="pPromoteQ" src=""></img></button>
      <button onclick="PromotePawn('B');"><img id="pPromoteB" src=""></img></button>
      <button onclick="PromotePawn('K');"><img id="pPromoteK" src=""></img></button>
      <button onclick="PromotePawn('R');"><img id="pPromoteR" src=""></img></button>
    </div>

  </div>
<?php endif; ?>