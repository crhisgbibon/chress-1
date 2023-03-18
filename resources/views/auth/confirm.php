<form
  method='POST'
  action='/confirm'
  class='w-screen flex flex-col justify-start items-center'>

  <div
    class='text-sky-300'>
    <?php if(isset($loggedin)) if($loggedin): ?>
      <?php if(isset($verified)) if($verified): ?>
        Your account has already been verified.
      <?php else: ?>
        Your account is not yet verified. If you have not received a verfication email, please click the below to send another.
      <?php endif; ?>
    <?php else: ?>
      <?php if(isset($name)) if($name): ?>
        Your account is not yet verified. If you have not received a verfication email, please click the below to send another.
      <?php else: ?>
        Please clear your cookies and login again to confirm your account.
      <?php endif; ?>
    <?php endif; ?>
  </div>

  <div
    class='w-screen flex justify-center items-center my-4'>
    <div
      class='flex flex-col justify-center items-center'>
      <?php if(isset($name)) if($name): ?>
        <input
        type='submit'
        value='Confirm'
        class='w-32 mx-4 p-2 m-2 rounded-lg cursor-pointer bg-sky-50 hover:bg-sky-100 active:bg-sky-200'>
      <?php endif; ?>
      <span
        class='text-sky-300'>
        <?php if(isset($response)) echo $response ?>
      </span>
    </div>
  </div>

</form>