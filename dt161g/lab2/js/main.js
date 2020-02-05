/*******************************************************************************
 * Laboration 2, Kurs: DT161G
 * File: main.js
 * Desc: main JavaScript file for Laboration 2
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/

var xhr; // Variabel att lagra XMLHttpRequestobjektet

/*******************************************************************************
 * Util functions
 ******************************************************************************/
function byId(id) {
  return document.getElementById(id);
}
/******************************************************************************/

/*******************************************************************************
 * Main function
 ******************************************************************************/
function main() {
  byId('loginButton').addEventListener('click', doLogin, false);
  byId('logoutButton').addEventListener('click', doLogout, false);

  // Stöd för IE7+, Firefox, Chrome, Opera, Safari
  try {
    if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      xhr = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
      // code for IE6, IE5
      xhr = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
      throw new Error('Cannot create XMLHttpRequest object');
    }
  } catch (e) {
    alert('"XMLHttpRequest failed!' + e.message);
  }
}
window.addEventListener('load', main, false); // Connect the main function to window load event

/*******************************************************************************
 * Function doLogin
 ******************************************************************************/
function doLogin() {
  const UNAME = byId('uname').value;
  const PSW = byId('psw').value;

  if ((byId('uname').value != '') & (byId('psw').value != '')) {
    xhr.addEventListener('readystatechange', processLogin, false);
    xhr.open('GET', `login.php?name=${UNAME}&password=${PSW}`, true);
    xhr.send(null);
  }
}

/*******************************************************************************
 * Function doLogout
 ******************************************************************************/
function doLogout() {
  xhr.addEventListener('readystatechange', processLogout, false);
  xhr.open('GET', 'logout.php', true);
  xhr.send(null);
}

/*******************************************************************************
 * Function processLogin
 ******************************************************************************/
function processLogin() {
  if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
    //First we must remove the registered event since we use the same xhr object for login and logout
    xhr.removeEventListener('readystatechange', processLogin, false);
    var myResponse = JSON.parse(this.responseText);
    let myLinks = myResponse['links'];

    addLinks(myLinks);

    byId('count').innerHTML = myResponse['msg'];
    byId('logout').style.display = 'block';
    byId('login').style.display = 'none';
  }
}
/*******************************************************************************
 * Function addLinks
 ******************************************************************************/
function addLinks(myLinks) {
  let linkString = '';
  for (const key in myLinks) {
    linkString += `<li><a href='${myLinks[key]}'>${key}</a</li>`;
  }
  byId('ul').innerHTML = linkString;
}

/*******************************************************************************
 * Function processLogout
 ******************************************************************************/
function processLogout() {
  if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
    //First we most remove the registered event since we use the same xhr object for login and logout
    xhr.removeEventListener('readystatechange', processLogout, false);
    var myResponse = JSON.parse(this.responseText);
    let myLinks = myResponse['links'];
    addLinks(myLinks);

    byId('count').innerHTML = myResponse['msg'];
    byId('login').style.display = 'block';
    byId('logout').style.display = 'none';
  }
}
