<?php if(isset($email) && isset($code) && $email !== '' && $code !== ''): ?>
<div
  x-data="{
    output: 'Awaiting validation attempt.',

    async validate()
    {
      this.output = await (await fetch('/validate', {
        method: 'POST',
        body: JSON.stringify({
          email:'<?= $email ?>',
          code:'<?= $code ?>',
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
  <?php if(isset($email)) echo $email; else echo 'missing'; ?>
  <button
    x-on:click="validate"
    class='m-4 p-4 rounded-lg bg-sky-50 hover:bg-sky-100 active:bg-sky-200'>
    Validate Account
  </button>
  <div
    x-text="output"
    class='m-4 p-4'></div>
</div>
<?php else: ?>
  <div
    class='w-screen flex flex-col justify-start items-center m-4 p-4'>
    You can only validate your account from the link sent to your email address.
  </div>
<?php endif; ?>