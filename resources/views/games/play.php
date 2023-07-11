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
    
    <style>
      :root {
        --square: 0px;
      }
    </style>
    <script>
      "use strict";

      function square() {
        let board = document.getElementById('board');
        if (board === null) return;
        let screenWidth = parseInt(board.scrollWidth);
        let screenHeight = parseInt(board.scrollHeight);
        let squareSize;

        if (screenWidth >= screenHeight) squareSize = screenHeight;
        else squareSize = screenWidth;

        squareSize *= 0.9;
        squareSize /= 8;
        squareSize = parseInt(squareSize);

        document.documentElement.style.setProperty('--square', squareSize + 'px');
      }

      window.addEventListener('DOMContentLoaded', square);
      window.addEventListener('resize', square);
      window.addEventListener('orientationchange', square);

      let timeOut = undefined;
      const d = 10000;

      function Poll()
      {
        let data = document.getElementById('boardholder').dataset.gameid;
        let jsonData = JSON.stringify(data);
        if(debug) console.log(data);
        if(debug) console.log(jsonData);
        $.ajax(
        {
          method: "POST",
          url: '/games/poll',
          data:
          {
            data:jsonData
          },
          timeout: 10000,
          success:function(json)
          {
            if(debug) console.log(json);
            let result = JSON.parse(json);
            if(debug) console.log(result);
            Print(result);

            clearTimeout(timeOut);
            timeOut = setTimeout(Poll, d);
          },
          error:function(json)
          {
            if(debug) console.log(json);
            let result = JSON.parse(json);
            if(debug) console.log(result);
            Print(result);

            clearTimeout(timeOut);
            timeOut = setTimeout(Poll, d);
          }
        });
      }

      function Post(trigger, data)
      {
        data.push(document.querySelector('input[name="promote"]:checked').id);
        let jsonData = JSON.stringify(data);
        if(debug) console.log(trigger);
        if(debug) console.log(data);
        $.ajax(
        {
          method: "POST",
          url: '/games/' + trigger,
          data:
          {
            data:jsonData
          },
          timeout: 10000,
          success:function(json)
          {
            if(debug) console.log(json);
            let result = JSON.parse(json);
            if(debug) console.log(result);
            Print(result);
          },
          error:function(json)
          {
            if(debug) console.log(json);
            let result = JSON.parse(json);
            if(debug) console.log(result);
            Print(result);
          }
        });
      }

      function Print(response)
      {
        let moves = response.currentMoves;
        if(debug) console.log(moves);
        for(let i = 0; i < 64; i++)
        {
          let bb = document.getElementById('b' + i);
          if(moves.includes(i)) bb.dataset.move = 'yes';
          else bb.dataset.move = 'no';
        }

        moves = response.lastmove;
        if(debug) console.log(moves);
        for(let i = 0; i < 64; i++)
        {
          let bb = document.getElementById('b' + i);
          if(moves.includes(i)) bb.dataset.last = 'yes';
          else bb.dataset.last = 'no';
        }

        let board = response.board;
        for(let i = 0; i < 64; i++)
        {
          let boardImg = document.getElementById('i' + i);
          if(board[i][1] === 'WP') boardImg.src = '../assets/png/whitePawn.png';
          else if(board[i][1] === 'WR') boardImg.src = '../assets/png/whiteRook.png';
          else if(board[i][1] === 'WK') boardImg.src = '../assets/png/whiteKnight.png';
          else if(board[i][1] === 'WB') boardImg.src = '../assets/png/whiteBishop.png';
          else if(board[i][1] === 'WQ') boardImg.src = '../assets/png/whiteQueen.png';
          else if(board[i][1] === 'WX') boardImg.src = '../assets/png/whiteKing.png';
          else if(board[i][1] === '-') boardImg.src = '';
          else if(board[i][1] === 'BP') boardImg.src = '../assets/png/blackPawn.png';
          else if(board[i][1] === 'BR') boardImg.src = '../assets/png/blackRook.png';
          else if(board[i][1] === 'BK') boardImg.src = '../assets/png/blackKnight.png';
          else if(board[i][1] === 'BB') boardImg.src = '../assets/png/blackBishop.png';
          else if(board[i][1] === 'BQ') boardImg.src = '../assets/png/blackQueen.png';
          else if(board[i][1] === 'BX') boardImg.src = '../assets/png/blackKing.png';
          else boardImg.src = '';
        }

        moves = document.getElementById('moves');
        moves.innerHTML = response.pgn;

        let info = document.getElementById('info');
        info.innerHTML = '';
        Object.entries(response.meta).forEach(
          ([key, value]) => {
            info.innerHTML += `<div class='rounded-lg m-2 p-2'>` + key + ` : ` + value + `</div>`;
            if(debug) console.log(key, value);
          }
        );

        if(response.moveNum)
        {
          let counter = document.getElementById('counter');
          if(counter !== null) counter.innerHTML = response.moveNum[0] + ' / ' + (response.moveNum[1] - 1);
        }

        let screenHalf = document.getElementById('bar').scrollWidth / 2;
        let bar_range = document.getElementById('bar_range');
        let perCent = 0;

        perCent = ( 100 / screenHalf ) * Math.abs(response.score);

        if(response.score > 0) bar_range.style.width = ( screenHalf + perCent ) + "px";
        else bar_range.style.width = ( screenHalf - perCent ) + "px";

        if(debug) console.log(perCent);
        if(debug) console.log(bar_range.style.width);
      }

      document.addEventListener('DOMContentLoaded', Poll);
    </script>

  </div>
<?php endif; ?>