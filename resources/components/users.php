<?php use App\Models\System\Component; ?>

<?php 
  $c = count($users);
  if($c === 0):
?>

  <div
    class='flex flex-col justify-start items-center overflow-y-auto'
    style='min-height: 100%; min-width: 100%'>
    No users found.
  </div>

<?php else: ?>

  <style>
    .container:hover input ~ .checkmark {
      background-color: var(--low);
    }

    .container input:checked ~ .checkmark {
      background-color: var(--mid);
    }
  </style>

  <div
    class='flex flex-col justify-start items-center overflow-y-auto'
    id='USERS_OUTPUT'
    style='min-height: 100%; min-width: 100%'>
    <?php for($i = 0; $i < count($users); $i++): ?>

      <?php

        $uuid = $users[$i]['uniqueIndex'];
        $name = $users[$i]["user_alias"];

        $href = "/users/{$uuid}";

      ?>

      <div
        style='border-color: var(--high);'
        class='p-2 my-2 w-full max-w-xs flex flex-col justify-around items-center border rounded-lg box-border'
        x-data='{
          show: false,
        }'
        >

        <div class='flex justify-center items-center w-full truncate'>
          <?=$name?>
        </div>

        <div
          class='my-2 flex justify-center items-center w-full truncate'>
          <?=Component::make('hyperlink',['text'=>'View','href'=>"/users/".$uuid])?>
        </div>

        <div
          class='my-2 flex justify-center items-center w-full truncate'>
          <button 
            style='background-color: var(--low);'
            class='h-full w-full rounded-lg hover:scale-105 active:scale-95 flex justify-center items-center p-2'
            @click="show = !show">
            Challenge
          </button>
        </div>

        <form
          class='w-full flex flex-col justify-start items-center my-4'
          x-show="show"
          method='POST'
          action='/users/challenge'
          >

          <input hidden type="number" id='opponent' name='opponent' value='<?=$uuid?>'>

          <div
            class='w-full my-2 flex justify-center items-center'>
            Colour:
          </div>

          <div
            class='w-full my-2 flex flex-row justify-center items-center'>
            
            <label
            class="container relative m-2 w-20 flex flex-col justify-center items-center"
            style='height: calc(var(--vh) * 7.5);'>
              <input type="radio" id='white' name='colour' value='white' checked class='absolute w-0 h-0'>
              <span 
                class="checkmark absolute cursor-pointer w-20 top-0 left-0 rounded-lg"
                style='height: calc(var(--vh) * 7.5); opacity: 0.5;'></span>
              <div
              class="absolute w-20 h-full top-0 left-0 flex justify-center items-center">
              White</div>
            </label>

            <label 
              class="container relative m-2 w-20 flex flex-col justify-center items-center"
              style='height: calc(var(--vh) * 7.5);'>
              <input type="radio" id='black' name='colour' value='black' class='absolute w-0 h-0'>
              <span
                class="checkmark absolute cursor-pointer w-20 top-0 left-0 rounded-lg"
                style='height: calc(var(--vh) * 7.5); opacity: 0.5;'></span>
              <div
              class="absolute w-20 h-full top-0 left-0 flex justify-center items-center">
              Black</div>
            </label>

            <label
              class="container relative m-2 w-20 flex flex-col justify-center items-center"
              style='height: calc(var(--vh) * 7.5);'>
              <input type="radio" id='random' name='colour' value='random' class='absolute w-0 h-0'>
              <span
                class="checkmark absolute cursor-pointer w-20 top-0 left-0 rounded-lg"
                style='height: calc(var(--vh) * 7.5); opacity: 0.5;'></span>
              <div
              class="absolute w-20 h-full top-0 left-0 flex justify-center items-center">
              Random</div>
            </label>
          </div>

          <div
            class='w-full my-2 flex justify-center items-center'>
            Turn Time (Days):
          </div>

          <div
            class='w-full my-2 flex flex-row justify-center items-center'>

            <label
              class="container relative m-2 w-20 flex flex-col justify-center items-center"
              style='height: calc(var(--vh) * 7.5);'>
              <input type="radio" id='one' name='turn' value='one' checked class='absolute w-0 h-0'>
              <span
                class="checkmark absolute cursor-pointer w-20 top-0 left-0 rounded-lg"
                style='height: calc(var(--vh) * 7.5); opacity: 0.5;'></span>
              <div
              class="absolute w-20 h-full top-0 left-0 flex justify-center items-center">
              1</div>
            </label>

            <label
              class="container relative m-2 w-20 flex flex-col justify-center items-center"
              style='height: calc(var(--vh) * 7.5);'>
              <input type="radio" id='three' name='turn' value='three' class='absolute w-0 h-0'>
              <span
                class="checkmark absolute cursor-pointer w-20 top-0 left-0 rounded-lg"
                style='height: calc(var(--vh) * 7.5); opacity: 0.5;'></span>
              <div
              class="absolute w-20 h-full top-0 left-0 flex justify-center items-center">
              3</div>
            </label>

            <label
              class="container relative m-2 w-20 flex flex-col justify-center items-center"
              style='height: calc(var(--vh) * 7.5);'>
              <input type="radio" id='seven' name='turn' value='seven' class='absolute w-0 h-0'>
              <span
                class="checkmark absolute cursor-pointer w-20 top-0 left-0 rounded-lg"
                style='height: calc(var(--vh) * 7.5); opacity: 0.5;'></span>
              <div
              class="absolute w-20 h-full top-0 left-0 flex justify-center items-center">
              7</div>
            </label>

          </div>

          <input
          type='submit'
          value='Send'
          style='background-color: var(--low);'
          class='w-32 mx-4 p-2 m-2 rounded-lg cursor-pointer'>

        </form>

      </div>

    <?php endfor; ?>

  </div>

<?php endif; ?>