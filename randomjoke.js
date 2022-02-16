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
    document.querySelector("#newJoke").addEventListener('click', jokeToPage);
    categoriesToPage();
    jokeToPage();
}

async function jokeToPage() {
    const joke = await jokeapi.getJoke();
    document.querySelector("#randomJoke").innerHTML = joke.value.replace('\n', '<br>');
    document.querySelector("#edit").setAttribute('href', `addedit.html?id=${joke.id}`);
}

async function categoriesToPage() {
    const categories = await jokeapi.getCategories();
    categories.forEach(category => {
        let opt = document.createElement("option");
        opt.innerHTML = category;
        document.querySelector("#category").appendChild(opt);
    });
}