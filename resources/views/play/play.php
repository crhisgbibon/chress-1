<div
  x-data="{ 
    moves: false,
    moveData: '',
    info: false,
  }" 
  class='flex flex-col justify-start items-center w-full'>

  <div
    class='flex flex-row justify-center items-center w-full'
    style='min-height: calc(var(--vh) * 5);'>
    <button 
      class='mx-4 px-4 rounded-lg bg-sky-50 hover:bg-sky-100 active:bg-sky-200 hover:scale-105 active:scale-95'
      style='height: 90%;'
      x-data="
      {
        output: '',

        async post()
        {
          this.output = await (await fetch('/play/swap', {
            method: 'POST',
            body: JSON.stringify({

            }),
            headers: {
              'Content-type': 'application/json; charset=UTF-8',
            },
          })
          .then(res => res.json())
          .then(data => console.log(data))
          .catch(err => console.log(err)));
        }
      }"
      x-on:click="post">
      Mode
    </button>
    <button 
      class='mx-4 px-4 rounded-lg bg-sky-50 hover:bg-sky-100 active:bg-sky-200 hover:scale-105 active:scale-95'
      style='height: 90%'
      x-data="
      {
        output: '',

        async post()
        {
          this.output = await (await fetch('/play/lastgame', {
            method: 'POST',
            body: JSON.stringify({

            }),
            headers: {
              'Content-type': 'application/json; charset=UTF-8',
            },
          })
          .then(res => res.json())
          .then(data => console.log(data))
          .catch(err => console.log(err)));
        }
      }"
      x-on:click="post">
      <
    </button>

    <div
      class='flex justify-center items-center w-8'
      style='height: 90%;'>
      0
    </div>
    <button 
      class='mx-4 px-4 rounded-lg bg-sky-50 hover:bg-sky-100 active:bg-sky-200 hover:scale-105 active:scale-95'
      style='height: 90%;'
      x-data="
      {
        output: '',

        async post()
        {
          this.output = await (await fetch('/play/nextgame', {
            method: 'POST',
            body: JSON.stringify({

            }),
            headers: {
              'Content-type': 'application/json; charset=UTF-8',
            },
          })
          .then(res => res.json())
          .then(data => console.log(data))
          .catch(err => console.log(err)));
        }
      }"
      x-on:click="post">
      >
    </button>

    <button 
      class='mx-4 px-4 rounded-lg bg-sky-50 hover:bg-sky-100 active:bg-sky-200 hover:scale-105 active:scale-95'
      style='height: 90%;'
      @click="moves = !moves">
      Moves
    </button>

  </div>

  <div
    class='flex flex-row justify-center items-center w-full'
    style='min-height: calc(var(--vh) * 5);'>

    <button 
      class='mx-4 px-4 rounded-lg bg-sky-50 hover:bg-sky-100 active:bg-sky-200 hover:scale-105 active:scale-95'
      style='height: 90%;'
      x-data="
      {
        output: '',

        async post()
        {
          this.output = await (await fetch('/play/flip', {
            method: 'POST',
            body: JSON.stringify({

            }),
            headers: {
              'Content-type': 'application/json; charset=UTF-8',
            },
          })
          .then(res => res.json())
          .then(data => console.log(data))
          .catch(err => console.log(err)));
        }
      }"
      x-on:click="post">
      Flip
    </button>

    <button 
      class='mx-4 px-4 rounded-lg bg-sky-50 hover:bg-sky-100 active:bg-sky-200 hover:scale-105 active:scale-95'
      style='height: 90%;'
      x-data="
      {
        output: '',

        async post()
        {
          this.output = await (await fetch('/play/lastmove', {
            method: 'POST',
            body: JSON.stringify({

            }),
            headers: {
              'Content-type': 'application/json; charset=UTF-8',
            },
          })
          .then(res => res.json())
          .then(data => console.log(data))
          .catch(err => console.log(err)));
        }
      }"
      x-on:click="post">
      <
    </button>

    <div
      class='flex justify-center items-center w-8'
      style='height: 90%;'>
      0
    </div>

    <button 
      class='mx-4 px-4 rounded-lg bg-sky-50 hover:bg-sky-100 active:bg-sky-200 hover:scale-105 active:scale-95'
      style='height: 90%;'
      x-data="
      {
        output: '',

        async post()
        {
          this.output = await (await fetch('/play/nextmove', {
            method: 'POST',
            body: JSON.stringify({

            }),
            headers: {
              'Content-type': 'application/json; charset=UTF-8',
            },
          })
          .then(res => res.json())
          .then(data => console.log(data))
          .catch(err => console.log(err)));
        }
      }"
      x-on:click="post">
      >
    </button>

    <button 
      class='mx-4 px-4 rounded-lg bg-sky-50 hover:bg-sky-100 active:bg-sky-200 hover:scale-105 active:scale-95'
      style='height: 90%;'
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
    <div>Event:</div>
    <div></div>

    <div>Site:</div>
    <div></div>

    <div>Date:</div>
    <div></div>

    <div>Round:</div>
    <div></div>

    <div>White:</div>
    <div></div>

    <div>Black:</div>
    <div></div>

    <div>Result:</div>
    <div></div>
  </div>

  <div
    class='flex flex-col justify-start items-center'
    style='min-height: calc(var(--vh) * 77.5);'>
    <div
      class='my-4'>
      <div
        style='width: 320px; min-height: 320px;'
        x-data="{

        }">
        <?php 
          $alternate = false;
          $counter = 0;
          $rowCounter = 7;
          $colCounter = 0;
        ?>
        <?php for($x = 0; $x < 8; $x++): ?>
          <?php
            $alternate = !$alternate;
          ?>
          <?php for($y = 0; $y < 8; $y++): ?>
            <?php
              $alternate = !$alternate;
              $i = ($rowCounter * 8) + $colCounter;
            ?>
            <div id='s<?=$i?>'>
              <button id='b<?=$i?>'
              <?php
                $class = '';
                $colour = 'white';
                if($alternate)
                {
                  $class = 'bg-sky-200';
                  $colour = 'black';
                }
                else $class = 'bg-sky-50';
              ?>
              class='<?=$class?>'
              style='padding: 0; margin: 0; width: 40px; min-height: 40px; float: left;'
              data-index='<?=$i?>'
              data-color='<?=$colour?>'>
                <img id='i<?=$i?>'
                src='assets/png/blank.png'>
                </img>
              </button>
            </div>
            <?php
              $colCounter++;
              $counter++;
            ?>
          <?php endfor; ?>
          <?php
            $rowCounter--;
            $colCounter = 0;
          ?>
        <?php endfor; ?>
      </div>
    </div>
  </div>

  <div>
    <button onclick="PromotePawn('Q');"><img id="pPromoteQ" src=""></img></button>
    <button onclick="PromotePawn('B');"><img id="pPromoteB" src=""></img></button>
    <button onclick="PromotePawn('K');"><img id="pPromoteK" src=""></img></button>
    <button onclick="PromotePawn('R');"><img id="pPromoteR" src=""></img></button>
  </div>

</div>