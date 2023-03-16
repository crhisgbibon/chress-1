<div
  x-data="{
    output: 'Awaiting validation attempt.',

    async validate()
    {
      this.output = await (await fetch('/validate', {
        method: 'POST',
        body: JSON.stringify({
          email:'<?php if(isset($email)) echo $email ?>',
          code:'<?php if(isset($code)) echo $code ?>',
        }),
        headers: {
          'Content-type': 'application/json; charset=UTF-8',
        },
      })
      .then(res => res.json())
      .catch(err => console.log(err)));
    }
  }"
  class='w-screen flex flex-col justify-start items-center m-4 p-4'>
  <button
    x-on:click="validate"
    class='m-4 p-4 rounded-lg bg-sky-50 hover:bg-sky-100 active:bg-sky-200'>
    Validate Account
  </button>
  <div
    x-text="output"
    class='m-4 p-4'></div>
</div>