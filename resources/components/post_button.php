<button
  class='rounded-lg flex justify-center items-center
        hover:scale-105 active:scale-95'
  style='min-height: 100%; min-width: 100%; background-color: var(--low);'
  onclick='Post(`<?=$route?>`,[<?=$data?>])'
  >
  <?=$text?>
</button>