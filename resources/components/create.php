<?php use App\Models\System\Component; ?>
<div
  class='w-full flex flex-col justify-start items-center my-4'>

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
      Opponent:
    </div>


    <div
      class='w-full my-2 flex flex-row justify-center items-center'>

      <label
        class="container relative m-2 w-20 flex flex-col justify-center items-center"
        style='height: calc(var(--vh) * 7.5);'>
        <input type="radio" id='self' name='opponent' value='self' checked class='absolute w-0 h-0'>
        <span
          class="checkmark absolute cursor-pointer w-20 top-0 left-0 rounded-lg"
          style='height: calc(var(--vh) * 7.5); opacity: 0.5;'></span>
        <div
        class="absolute w-20 h-full top-0 left-0 flex justify-center items-center">
        Self</div>
      </label>

      <label
        class="container relative m-2 w-20 flex flex-col justify-center items-center"
        style='height: calc(var(--vh) * 7.5);'>
        <input type="radio" id='computer' name='opponent' value='computer' class='absolute w-0 h-0'>
        <span
          class="checkmark absolute cursor-pointer w-20 top-0 left-0 rounded-lg"
          style='height: calc(var(--vh) * 7.5); opacity: 0.5;'></span>
        <div
        class="absolute w-20 h-full top-0 left-0 flex justify-center items-center">
        AI</div>
      </label>

      <label
        class="container relative m-2 w-20  flex flex-col justify-center items-center"
        style='height: calc(var(--vh) * 7.5);'>
        <input type="radio" id='player' name='opponent' value='player' class='absolute w-0 h-0'>
        <span
          class="checkmark absolute cursor-pointer w-20 top-0 left-0 rounded-lg"
          style='height: calc(var(--vh) * 7.5); opacity: 0.5;'></span>
        <div
        class="absolute w-20 h-full top-0 left-0 flex justify-center items-center">
        Player</div>
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

    <div
      class='w-40 h-10 flex justify-center items-center my-2'>
      <button
        class='rounded-lg flex justify-center items-center
              hover:scale-105 active:scale-95'
        style='min-height: 100%; min-width: 100%;background-color:var(--low);'
        onclick='Post2()'
        >
        Submit
      </button>
    </div>
  
</div>