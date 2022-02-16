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
    if (id >= 0) {
        jokeToForm(id);
        document.querySelector("#heading").innerHTML = 'Edit joke';
    }
}

async function jokeToForm(id) {
    const joke = await jokeapi.getJoke(id);
    document.querySelector("#newJokeText").innerHTML = joke.value;
    document.querySelector("#jokeId").setAttribute('value', id);
}

async function saveJoke() {
    console.log('saveJoke()');
    let formData = new FormData();
    formData.append('joke', document.querySelector("#newJokeText").value);
    formData.append('pwd', document.querySelector("#pwd").value);
    const id = parseInt(document.querySelector("#jokeId").value);
    if (id >= 0) {
        formData.append('id', id);
    }
    const response = await jokeapi.writeJoke(formData);
    console.log(response);
}

