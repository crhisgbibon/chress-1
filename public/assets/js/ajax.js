"use strict";

function Post(trigger, data)
{
  let jsonData = JSON.stringify(data);
  console.log(trigger);
  console.log(data);
  $.ajax(
  {
    method: "POST",
    url: '/game/' + trigger,
    data:
    {
      data:jsonData
    },
    timeout: 10000,
    success:function(json)
    {
      let result = JSON.parse(json);
      console.log(result);
    },
    error:function(json)
    {
      let result = JSON.parse(json);
      console.log(result);
    }
  });
}