"use strict";

// Login

const generic_loginUsername = document.getElementById("generic_loginUsername");
const generic_loginPassword = document.getElementById("generic_loginPassword");
const generic_loginLogin = document.getElementById("generic_loginLogin");
const generic_loginStay = document.getElementById("generic_loginStay");

const generic_loginRegister = document.getElementById("generic_loginRegister");
const generic_loginHome = document.getElementById("generic_loginHome");

// Register Account

const generic_register = document.getElementById("generic_register");

const generic_registerUsername = document.getElementById("generic_registerUsername");
const generic_loginEmail = document.getElementById("generic_loginEmail");
const generic_registerPassword = document.getElementById("generic_registerPassword");
const generic_registerConfirmPassword = document.getElementById("generic_registerConfirmPassword");

const generic_registerRegister = document.getElementById("generic_registerRegister");
const generic_registerClose = document.getElementById("generic_registerClose");

// Message Box

const messageBox = document.getElementById("messageBox");

// Assignments

generic_loginLogin.onclick = function(){ Post("Login"); };
generic_loginRegister.onclick = function(){ TogglePanel(generic_register); generic_registerUsername.focus() };

generic_registerRegister.onclick = function(){ Post("Register"); };
generic_registerClose.onclick = function(){ TogglePanel(generic_register); };

generic_loginHome.onclick = function(){ Home(); };

let toggleTheme = true;
if(typeof(Storage) !== "undefined")
{
  let storedValue = localStorage.getItem("siteTheme");
  if(storedValue === "false") toggleTheme = false;
}

UpdateTheme(toggleTheme);

TogglePanel(generic_register);
TogglePanel(messageBox);

function TogglePanel(panel)
{
  if(panel.style.display == "none") panel.style.display = "";
  else panel.style.display = "none";
}

function Home()
{
  window.open("https://www.calypsogrammar.com", "_self");
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
  }
  else
  {
    r.style.setProperty('--background', 'var(--backgroundDark)');
    r.style.setProperty('--foreground', 'var(--foregroundDark)');
    r.style.setProperty('--buttonBackground', 'var(--buttonBackgroundDark)');
    r.style.setProperty('--buttonBorder', 'var(--buttonBorderDark)');
    r.style.setProperty('--hyperlink', 'var(--hyperlinkDark)');
  }
}

function MessageBox(message)
{
  messageBox.innerHTML = message;
  if(messageBox.style.display === "none") TogglePanel(messageBox);
  AnimatePop(messageBox);
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
  });
}

function Post(trigger)
{
  let data = null;

  if(trigger === "Login")
  {
    data = [
      generic_loginUsername.value,
      generic_loginPassword.value,
      generic_loginStay.checked
    ];
  }

  if(trigger === "Register")
  {
    data = [
      generic_registerUsername.value,
      generic_loginEmail.value,
      generic_registerPassword.value,
      generic_registerConfirmPassword.value
    ];
  }

  $.ajax({
    method: "POST",
    url: 'php/controller/Controller.php',
    data:
    {
      action:trigger,
      data:data
    },
    success:function(result)
    {
      console.log(result);
      let tempArray = JSON.parse(result);
      console.log(tempArray);
      if(trigger === "Login" || trigger === "Logout")
      {
        window.location.reload();
      }
      if(trigger === "Register")
      {
        if(tempArray[0] === "Registered")
        {
          window.location.reload();
        }
      }
    }
  });
}