<?php use App\Models\System\Component; ?>
<div
  class='flex flex-col justify-start items-center overflow-y-auto'
  style='min-height: 100%; min-width: 100%'>
  <?php for($i = 0; $i < count($games); $i++): ?>

    <div
      class='w-full p-2 m-2 max-w-sm flex flex-col justify-start items-center my-4 border-4 border-sky-200 rounded-lg'>

      <div
        class='w-full flex flex-row justify-center items-center m-2 border-b border-black'>
        <div
          class='w-32 m-2 flex justify-center items-center'>
          White
        </div>

        <div
          class='w-32 m-2 flex justify-center items-center'>
        </div>

        <div
          class='w-32 m-2 flex justify-center items-center'>
          Black
        </div>
      </div>

      <div
        class='w-full flex flex-row justify-center items-center m-2'>
        <div
          class='w-32 mx-2 flex justify-center items-center'>
          <?php 
            if((int)$games[$i]['whiteID'] > 0) echo $games[$i]['user_alias'];
            else echo '?';
          ?>
        </div>

        <div
          class='w-32 mx-2 flex justify-center items-center'>
          vs
        </div>

        <div
          class='w-32 mx-2 flex justify-center items-center'>
          <?php 
            if((int)$games[$i]['blackID'] > 0) echo $games[$i]['user_alias'];
            else echo '?';
          ?>
        </div>

      </div>

      <div
        class='w-full mx-2 flex justify-center items-center'>
        <div
          class='w-32 h-8 p-2 m-2 flex justify-center items-center'>
          <form
            method='POST'
            action='lobby/accept'
            class='w-full h-full'>
            <input type='number' name='uuid' value='<?=$games[$i]['uniqueIndex']?>' hidden>
            <?=Component::make('input',['version'=>'submit','uuid'=>'','nom'=>'','place'=>'','text'=>'Accept','auto'=>'','check'=>false])?>
          </form>
        </div>
      </div>

    </div>

  <?php endfor; ?>
</div>