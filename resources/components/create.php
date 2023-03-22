<?php use App\Models\System\Component; ?>
<div>

  <form
    class='w-full flex flex-col justify-start items-center my-4'
    method='POST'
    action='games/create'>

    <div
      class='w-full my-2 flex justify-center items-center'>
      Choose Side:
    </div>

    <div
      class='w-full my-2 flex flex-row justify-center items-center'>
      <div
        class='m-2 w-32 flex flex-col justify-center items-center'>
        <?=Component::make('input',['version'=>'radio','uuid'=>'white','nom'=>'colour','place'=>'','text'=>'white','auto'=>'','check'=>true])?>
        <label
          class='m-2'
          for='white'>
          White
        </label>
      </div>
      <div
        class='m-2 w-32 flex flex-col justify-center items-center'>
        <?=Component::make('input',['version'=>'radio','uuid'=>'black','nom'=>'colour','place'=>'','text'=>'black','auto'=>'','check'=>false])?>
        <label
          class='m-2'
          for='black'>
          Black
        </label>
      </div>
      <div
        class='m-2 w-32 flex flex-col justify-center items-center'>
        <?=Component::make('input',['version'=>'radio','uuid'=>'random','nom'=>'colour','place'=>'','text'=>'random','auto'=>'','check'=>false])?>
        <label
          class='m-2'
          for='random'>
          Random
        </label>
      </div>
    </div>

    <div
      class='w-full my-2 flex justify-center items-center'>
      Choose Opponent:
    </div>

    <div
      class='w-full my-2 flex flex-row justify-center items-center'>
      <div
        class='m-2 w-32 flex flex-col justify-center items-center'>
        <?=Component::make('input',['version'=>'radio','uuid'=>'self','nom'=>'opponent','place'=>'','text'=>'self','auto'=>'','check'=>true])?>
        <label
          class='m-2'
          for='self'>
          Self
        </label>
      </div>
      <div
        class='m-2 w-32 flex flex-col justify-center items-center'>
        <?=Component::make('input',['version'=>'radio','uuid'=>'computer','nom'=>'opponent','place'=>'','text'=>'computer','auto'=>'','check'=>false])?>
        <label
          class='m-2'
          for='computer'>
          Computer
        </label>
      </div>
      <div
        class='m-2 w-32 flex flex-col justify-center items-center'>
        <?=Component::make('input',['version'=>'radio','uuid'=>'player','nom'=>'opponent','place'=>'','text'=>'player','auto'=>'','check'=>false])?>
        <label
          class='m-2'
          for='player'>
          Player
        </label>
      </div>
    </div>

    <div
      class='w-full my-2 flex justify-center items-center'>
      Choose Turn Time (Days):
    </div>

    <div
      class='w-full my-2 flex flex-row justify-center items-center'>
      <div
        class='m-2 w-32 flex flex-col justify-center items-center'>
        <?=Component::make('input',['version'=>'radio','uuid'=>'one','nom'=>'turn','place'=>'','text'=>'one','auto'=>'','check'=>true])?>
        <label
          class='m-2'
          for='one'>
          One
        </label>
      </div>
      <div
        class='m-2 w-32 flex flex-col justify-center items-center'>
        <?=Component::make('input',['version'=>'radio','uuid'=>'three','nom'=>'turn','place'=>'','text'=>'three','auto'=>'','check'=>false])?>
        <label
          class='m-2'
          for='three'>
          Three
        </label>
      </div>
      <div
        class='m-2 w-32 flex flex-col justify-center items-center'>
        <?=Component::make('input',['version'=>'radio','uuid'=>'seven','nom'=>'turn','place'=>'','text'=>'seven','auto'=>'','check'=>false])?>
        <label
          class='m-2'
          for='seven'>
          Seven
        </label>
      </div>
    </div>

    <div
      class='w-40 h-10 flex justify-center items-center my-2'>
      <?=Component::make('input',['version'=>'submit','uuid'=>'','nom'=>'','place'=>'','text'=>'Submit','auto'=>'','check'=>false])?>
    </div>

  </form>
  
</div>