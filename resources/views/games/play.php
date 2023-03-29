<?php use App\Models\System\Component; ?>
<?php if(!isset($board) && isset($gameid) && isset($currentmoves)): ?>
  <div
    class='flex flex-col justify-start items-center w-full'>
    Game data not found.
  </div>
<?php else: ?>
  <div
    x-data="{
      moveData: '',
      flipstate: 'rotate-180',
      promote : false,
      info: false,
      moves: false,
      flip: <?php if($iswhite) echo 'false'; else echo 'true';?>,
    }" 
    class='flex flex-col justify-start items-center w-full'>

    <div
      class='flex flex-row justify-center items-center w-full'
      style='height: calc(var(--vh) * 7.5);'>
      <div
        class='w-20 mx-2'
        style='height: calc(var(--vh) * 5);'>
        <button 
          style='background-color: var(--low);'
          class='h-full w-20 rounded-lg hover:scale-105 active:scale-95 flex justify-center items-center'
          @click="flip = !flip;">
          <?php include('assets/svg/flip.svg');?>
        </button>
      </div>
      <div
        class='w-20 mx-2'
        style='height: calc(var(--vh) * 5);'>
        <button 
          style='background-color: var(--low);'
          class='h-full w-20 rounded-lg hover:scale-105 active:scale-95 flex justify-center items-center'
          @click="info = !info">
          <?php include('assets/svg/info.svg');?>
        </button>
      </div>
      <div
        class='w-20 mx-2'
        style='height: calc(var(--vh) * 5);'>
        <button 
          style='background-color: var(--low);'
          class='h-full w-20 rounded-lg hover:scale-105 active:scale-95 flex justify-center items-center'
          @click="moves = !moves">
          <?php include('assets/svg/list.svg');?>
        </button>
      </div>
    </div>

    <div
      class='flex flex-col justify-start items-center w-full fixed overflow-y-auto'
      style='min-height: calc(var(--vh) * 85); max-height: calc(var(--vh) * 85); top: calc(var(--vh) * 15); z-index: 10; background-color: var(--back);'
      x-show="info">
      <?=Component::make('info',[])?>
    </div>

    <div
      class='flex flex-col justify-start items-center w-full fixed overflow-y-auto'
      style='min-height: calc(var(--vh) * 85); max-height: calc(var(--vh) * 85); top: calc(var(--vh) * 15); z-index: 10; background-color: var(--back);'
      x-show="moves">
      <?=Component::make('moves',[])?>
    </div>

    <div
      id='board'
      class='flex flex-col justify-center items-center w-full h-fit'
      style='height: calc(var(--vh) * 75);'>
      <div>
        <?=Component::make('board',['layer'=>$layer,'gameid'=>$gameid,'board'=>$board,'currentmoves'=>$currentmoves])?>
      </div>
    </div>

    <div
      id='bar'
      class='flex flex-row justify-start items-center p-0 m-0 b-0 outline-0 rounded-none mx-auto'
      style='height: calc(var(--vh) * 2.5); width: 100%; max-width: 600px; background-color: var(--high);'>
      <div
        id='bar_range'
        class='p-0 m-0 b-0 outline-0 rounded-none'
        style='height: calc(var(--vh) * 2.5); width: 50%; background-color: var(--low);'>
      </div>
    </div>

    <div
      class='flex flex-row justify-center items-center w-full'
      style='height: calc(var(--vh) * 7.5);'>
      <div
        style='background-color: var(--back);'
        class='w-20 mx-2'
        style='height: calc(var(--vh) * 5);'>
        <?=Component::make('post_button',[ 'text' => '<', 'route' => 'lastmove', 'data' => $gameid ])?>
      </div>
      <div
        id='counter'
        class='flex justify-center items-center w-20 mx-2'
        style='height: calc(var(--vh) * 5);'>
        <?=$score?>
      </div>
      <div
        style='background-color: var(--back);'
        class='w-20 mx-2'
        style='height: calc(var(--vh) * 5);'>
        <?=Component::make('post_button',[ 'text' => '>', 'route' => 'nextmove', 'data' => $gameid ])?>
      </div>
    </div>

    <div
      style='background-color: var(--low);'
      class='flex flex-row justify-center items-center rounded-lg m-2 z-10'
      x-show='promote'
      x-init='Square();'>
      <div
        class='flex flex-col justify-start items-center m-2 p-2'>
        <label for='Q'>Q</label>
        <input
          type='radio'
          name='promote'
          id='Q'
          text='Q'
          checked>
      </div>
      <div
        class='flex flex-col justify-start items-center m-2 p-2'>
        <label for='B'>B</label>
        <input
          type='radio'
          name='promote'
          id='B'
          text='B'>
      </div>
      <div
        class='flex flex-col justify-start items-center m-2 p-2'>
        <label for='K'>K</label>  
        <input
          type='radio'
          name='promote'
          id='K'
          text='K'>
      </div>
      <div
        class='flex flex-col justify-start items-center m-2 p-2'>
        <label for='R'>R</label>
        <input
          type='radio'
          name='promote'
          id='R'
          text='R'>
      </div>
    </div>

    <script src='<?=$layer?>assets/js/poll.js'></script>

  </div>
<?php endif; ?>