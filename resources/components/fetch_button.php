<button 
  class='rounded-lg hover:scale-105 active:scale-95'
  style='min-width: 100%; min-height: 100%;background-color:var(--low);'
  x-data="
  {
    <?=$output?>: '',

    async post()
    {
      this.<?=$output?> = await (await fetch('<?=$fetch?>',{
        method: 'POST',
        body: JSON.stringify({<?=$body?>}),
        headers:{'Content-type': 'application/json; charset=UTF-8',},
      })
      .then(res => res.json())
      .then(data => console.log(data))
      .catch(err => console.log(err)));
    }
  }"
  x-on:click="post">
  <?=$text?>
</button>