<div
  x-data="{ 
    moves: false,
    moveData: '',
    info: false,
  }" 
  class='flex flex-col justify-start items-center w-screen'>

  <div
    class='flex flex-row justify-center items-center w-screen'
    style='min-height: calc(var(--vh) * 5);'>

    <div
      class=''
      style='min-height: calc(var(--vh) * 5);'
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
      }">
      <button 
        class='mx-4 px-4 rounded-lg bg-sky-50 hover:bg-sky-100 active:bg-sky-200 hover:scale-105 active:scale-95'
        style='min-height: calc(var(--vh) * 5);'
        x-on:click="post">
        Mode
      </button>
    </div>

    <div
      class='my-2'
      style='min-height: calc(var(--vh) * 5);'
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
      }">
      <button 
        class='mx-4 px-4 rounded-lg bg-sky-50 hover:bg-sky-100 active:bg-sky-200 hover:scale-105 active:scale-95'
        style='min-height: calc(var(--vh) * 5);'
        x-on:click="post">
        <
      </button>
    </div>

    <div
      class='flex justify-center items-center w-8'
      style='min-height: calc(var(--vh) * 5);'>
      0
    </div>

    <div
      class='my-2'
      style='min-height: calc(var(--vh) * 5);'
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
      }">
      <button 
        class='mx-4 px-4  rounded-lg bg-sky-50 hover:bg-sky-100 active:bg-sky-200 hover:scale-105 active:scale-95'
        style='min-height: calc(var(--vh) * 5);'
        x-on:click="post">
        >
      </button>
    </div>

    <div
      class='my-2'
      style='min-height: calc(var(--vh) * 5);'>
      <button 
        class='mx-4 px-4 rounded-lg bg-sky-50 hover:bg-sky-100 active:bg-sky-200 hover:scale-105 active:scale-95'
        style='min-height: calc(var(--vh) * 5);'
        @click="moves = !moves">
        Moves
      </button>
    </div>

  </div>

  <div
    class='flex flex-row justify-center items-center w-screen'
    style='min-height: calc(var(--vh) * 5);'>

    <div
      class='my-2'
      style='min-height: calc(var(--vh) * 5);'
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
      }">
      <button 
        class='mx-4 px-4 rounded-lg bg-sky-50 hover:bg-sky-100 active:bg-sky-200 hover:scale-105 active:scale-95'
        style='min-height: calc(var(--vh) * 5);'
        x-on:click="post">
        Flip
      </button>
    </div>

    <div
      class='my-2'
      style='min-height: calc(var(--vh) * 5);'
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
      }">
      <button 
        class='mx-4 px-4 rounded-lg bg-sky-50 hover:bg-sky-100 active:bg-sky-200 hover:scale-105 active:scale-95'
        style='min-height: calc(var(--vh) * 5);'
        x-on:click="post">
        <
      </button>
    </div>

    <div
      class='flex justify-center items-center w-8'
      style='min-height: calc(var(--vh) * 5);'>
      0
    </div>

    <div
      class='my-2'
      style='min-height: calc(var(--vh) * 5);'
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
      }">
      <button 
        class='mx-4 px-4 rounded-lg bg-sky-50 hover:bg-sky-100 active:bg-sky-200 hover:scale-105 active:scale-95'
        style='min-height: calc(var(--vh) * 5);'
        x-on:click="post">
        >
      </button>
    </div>

    <div
      class='my-2'
      style='min-height: calc(var(--vh) * 5);'>
      <button 
        class='mx-4 px-4 rounded-lg bg-sky-50 hover:bg-sky-100 active:bg-sky-200 hover:scale-105 active:scale-95'
        style='min-height: calc(var(--vh) * 5);'
        @click="info = !info">
        Info
      </button>
    </div>

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
    class='my-4'>
    <div>
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
                src='chress/blank.png'>
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
        <?php
          $counter = 0;
          $rowCounter = 7;
          $colCounter = 0;
          $alternate = false;

          $output = "";
        
          for($x = 0; $x < 8; $x++)
          {
            $alternate = !$alternate;
            for($y = 0; $y < 8; $y++)
            {
              $alternate = !$alternate;

              $index = ($rowCounter * 8) + $colCounter;

              $newSquareId = "s" . $index;
              $newButtonId = "b" . $index;
              $newImgId = "i" . $index;

              $color = "white";
              if($alternate === false) $color = "black";

              echo "
                <div class='boardSquare' id='{$newSquareId}'>
                  <button class='boardButtton' id='{$newButtonId}' 
                  data-index='{$index}' data-color='{$color}'
                  onclick='QuerySquare(`$index`)'>
                    <img class='boardImg'  id='{$newImgId}'
                    src='chress/blank.png'>
                    </img>
                  </button>
                </div>
              ";
              
              $colCounter++;
              $counter++;
            }
            $rowCounter--;
            $colCounter = 0;
          }
        ?>
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