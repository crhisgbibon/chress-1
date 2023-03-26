<button
  class='p-2 rounded-lg flex justify-center items-center
        bg-sky-50 hover:bg-sky-100 active:bg-sky-200
        hover:scale-105 active:scale-95'
  style='min-height: 100%; min-width: 100%'
  onclick='Post(`<?=$route?>`,[<?=$data?>])'
  >
  <?=$text?>
</button>