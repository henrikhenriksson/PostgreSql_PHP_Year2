/*******************************************************************************
 * Laboration 4, Kurs: DT161G
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
    const CURRENT_PAGE = window.location.pathname;

    // check wether the login was valid. Only change login/logout button settings if true.
    if (myResponse['valid']) {
      // create an array of links based on the links provided in the response.
      let myLinks = myResponse['links'];
      addLinks(myLinks);
      byId('logout').style.display = 'block';
      byId('login').style.display = 'none';
      if (CURRENT_PAGE.includes('guestbook.php')) {
        byId('form').style.display = 'none';
      }
    }
    // print the message
    byId('count').innerHTML = myResponse['msg'];
  }
}
/*******************************************************************************
 * Function addLinks
 ******************************************************************************/
function addLinks(myLinks) {
  // Loop through the array and add new tags for each element in the myLinks array.
  let linkString = '';
  for (const key in myLinks) {
    linkString += `<li><a href='${myLinks[key]}'>${key.toUpperCase()}</a</li>`;
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

    // find current open page.
    const CURRENT_PAGE = window.location.pathname;

    byId('count').innerHTML = myResponse['msg'];
    byId('login').style.display = 'block';
    byId('logout').style.display = 'none';
    if (CURRENT_PAGE.includes('guestbook.php')) {
      byId('form').style.display = 'none';
    }

    // if the user is on the members page and logged out - redirect to index.
    if (
      CURRENT_PAGE.includes('members.php') ||
      CURRENT_PAGE.includes('admin.php')
    ) {
      location.replace('index.php');
    }
  }
}
