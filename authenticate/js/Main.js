"use strict";

const messageBox = document.getElementById("messageBox");
const HomeButton = document.getElementById("HomeButton");
const i_controlHome = document.getElementById("i_controlHome");
const responseBox = document.getElementById("responseBox");

HomeButton.onclick = function() { Home(); };
messageBox.onclick = function() { TogglePanel(messageBox); };

let toggleTheme = true;
if(typeof(Storage) !== "undefined")
{
  let storedValue = localStorage.getItem("siteTheme");
  if(storedValue === "false") toggleTheme = false;
}

let timeOut = undefined;

UpdateTheme(toggleTheme);
ReSize();
TogglePanel(messageBox);

function ToggleTheme()
{
  toggleTheme = !toggleTheme;
  UpdateTheme(toggleTheme);
}

function UpdateTheme(state)
{
  let r = document.querySelector(':root');
  if(typeof(Storage) !== "undefined") localStorage.setItem("siteTheme", state);
  if(state)
  {
    r.style.setProperty('--background', 'var(--backgroundLight)');
    r.style.setProperty('--foreground', 'var(--foregroundLight)');
    r.style.setProperty('--buttonBackground', 'var(--buttonBackgroundLight)');
    r.style.setProperty('--buttonBorder', 'var(--buttonBorderLight)');
    r.style.setProperty('--hyperlink', 'var(--hyperlinkLight)');

    i_controlHome.src = "../../generic/assets/homeLight.svg";
  }
  else
  {
    r.style.setProperty('--background', 'var(--backgroundDark)');
    r.style.setProperty('--foreground', 'var(--foregroundDark)');
    r.style.setProperty('--buttonBackground', 'var(--buttonBackgroundDark)');
    r.style.setProperty('--buttonBorder', 'var(--buttonBorderDark)');
    r.style.setProperty('--hyperlink', 'var(--hyperlinkDark)');

    i_controlHome.src = "../../generic/assets/homeDark.svg";
  }
}

function ReSize()
{
  let vh = window.innerHeight * 0.01;
  document.documentElement.style.setProperty('--vh', vh + 'px');
}

function Home()
{
  window.open("https://www.calypsogrammar.com", "_self");
}

function TogglePanel(panel)
{
  if(panel.style.display == "none") panel.style.display = "";
  else panel.style.display = "none";
}

const views = [];
const viewsB = [];

function SwitchView(array, aIndex, buttons, bIndex)
{
  let aLen = array.length;
  let bLen = buttons.length;
  if(aIndex > aLen) return;
  if(bIndex > bLen) return;
  if(aLen > 0)
  {
    for(let i = 0; i < aLen; i++)
    {
      if(i === aIndex) array[i].style.display = "";
      else array[i].style.display = "none";
    }
  }
  if(bLen > 0)
  {
    for(let i = 0; i < bLen; i++)
    {
      if(i === bIndex) buttons[i].dataset.state = "selected";
      else buttons[i].dataset.state = "";
    }
  }
}

function MessageBox(message)
{
  messageBox.innerHTML = message;
  if(messageBox.style.display === "none") TogglePanel(messageBox);
  AnimatePop(messageBox);
  if(timeOut != null) clearTimeout(timeOut);
  timeOut = setTimeout(AutoOff, 2500);
}

function AnimatePop(panel)
{
  panel.animate([
    { transform: 'scale(110%, 110%)'},
    { transform: 'scale(109%, 109%)'},
    { transform: 'scale(108%, 108%)'},
    { transform: 'scale(107%, 107%)'},
    { transform: 'scale(106%, 106%)'},
    { transform: 'scale(105%, 105%)'},
    { transform: 'scale(104%, 104%)'},
    { transform: 'scale(103%, 103%)'},
    { transform: 'scale(102%, 102%)'},
    { transform: 'scale(101%, 101%)'},
    { transform: 'scale(100%, 100%)'}],
    {
      duration: 100,
    }
  );
}

function AutoOff()
{
  messageBox.style.display = "none";
}

function Filter(dataset, inputFilter)
{
  let filter, li, len, a, i;
  filter = inputFilter.value.toUpperCase();
  if(filter === "378462SDJKFHDSDBS8743247832") filter = "";
  li = document.getElementsByClassName(dataset);
  len = li.length;
  for (i = 0; i < len; i++)
  {
    if(filter === "")
    {
      li[i].style.display = "";
      continue;
    }
    a = li[i].dataset.search.toString();
    if (a.toUpperCase().indexOf(filter) > -1)
    {
      li[i].style.display = "";
    }
    else
    {
      li[i].style.display = "none";
    }
  }
}

window.addEventListener('resize', ReSize);

function Post(trigger)
{
  let data = [];

  $.ajax(
  {
    method: "POST",
    url: 'php/controller/Controller.php',
    data:
    {
      action:trigger,
      data:data
    },
    timeout: 10000,
    success:function(result)
    {
      let tempArray = JSON.parse(result);
    }
  });
}

function Validate(email, code)
{
  let data = [
    email,
    code
  ];

  $.ajax(
  {
    method: "POST",
    url: 'php/controller/Controller.php',
    data:
    {
      action:"VALIDATE",
      data:data
    },
    timeout: 10000,
    success:function(result)
    {
      let tempArray = JSON.parse(result);
      responseBox.innerHTML = tempArray;
    }
  });
}

function Poll()
{
  let data = [
    updateContent.innerHTML
  ];
  $.ajax(
  {
    method: "POST",
    url: 'php/controller/Poll.php',
    data:
    {
      data:data
    },
    success:function(result)
    {
      if(result === "" || result === null || result === undefined) return;
      let tempArray = JSON.parse(result);
      clearTimeout(timeOut);
      timeOut = setTimeout(Poll, 1000);
      updateContent.innerHTML = tempArray[0] + " <br><br><br> " + tempArray[1] + " seconds since last update";
      RandomColour(updateContent);
    }
  });
}