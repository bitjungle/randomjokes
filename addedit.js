/** 
 * Javascript frontend for the Random Joke App
 * 
 * Copyright (C) 2022 BITJUNGLE Rune Mathisen
 * This code is licensed under a GPLv3 license 
 * See http://www.gnu.org/licenses/gpl-3.0.html 
 */

import JokeAPI from './jokeapi.js';
const jokeapi = new JokeAPI('https://it.vgs.no/demo/randomjokes');

window.addEventListener('load', init);

/**
 * Run at app startup
 * 
 */
function init() {
    console.log('init()');
    document.querySelector("#saveJokeButton").addEventListener('click', saveJoke);
    const params = (new URL(document.location)).searchParams;
    const id = params.get('id') === null ? -1 : parseInt(params.get('id'));
    if (id > 0) {
        jokeToTextarea(id);
        document.querySelector("#heading").innerHTML = 'Edit joke';
        document.querySelector('title').innerHTML = 'Edit joke';
    }
}

async function jokeToTextarea(id) {
    console.log(`jokeToTextarea(${id})`);
    const joke = await jokeapi.getJoke(id);
    document.querySelector("#newJokeText").innerHTML = joke.value;
    document.querySelector("#jokeId").setAttribute('value', id);
    categoriesToCheckboxes(joke.categories);
}

async function categoriesToCheckboxes(assignedCategories = []) {
    console.log('categoriesToCheckboxes(...)');
    const categories = await jokeapi.getCategories();
    const catDOM = document.querySelector("#categories");
    categories.forEach(category => {
        const check = document.createElement("input");
        check.setAttribute("type", "checkbox");
        check.setAttribute("name", "categories[]");
        check.setAttribute("value", category);
        if (assignedCategories.includes(category)) {
            check.setAttribute("checked", "checked");
        }
        const label = document.createElement("label");
        label.setAttribute("for", category);
        label.innerHTML = category;
        catDOM.appendChild(check);
        catDOM.appendChild(label);
    });
}

async function saveJoke() {
    console.log('saveJoke()');
    const formData = new FormData();
    formData.append('joke', document.querySelector("#newJokeText").value);
    formData.append('pwd', document.querySelector("#pwd").value);
    const id = parseInt(document.querySelector("#jokeId").value);
    if (id > 0) {
        formData.append('id', id);
    }
    const list = document.querySelectorAll('input[type=checkbox]');
    let cats = [];
    for (let checkbox of list) {
      if (checkbox.checked) {
        cats.push(checkbox.value);
      }
    }
    formData.append('categories', cats);
    const response = await jokeapi.writeJoke(formData);
    document.querySelector('#postResponse').innerHTML = response.status;
}

