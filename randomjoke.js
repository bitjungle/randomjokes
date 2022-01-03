/** 
 * Javascript frontend for the Random Joke App
 * 
 * Copyright (C) 2022 BITJUNGLE Rune Mathisen
 * This code is licensed under a GPLv3 license 
 * See http://www.gnu.org/licenses/gpl-3.0.html 
 */

const DB_API_URL_JOKE = 'http://it.vgs.no/demo/randomjokes/randomjoke.php';
const DB_API_URL_CAT = 'http://it.vgs.no/demo/randomjokes/categories.php';

window.addEventListener('load', init);

/**
 * Run at app startup
 * 
 */
function init() {
    console.log('init()');
    document.querySelector("#newJoke").addEventListener('click', newJoke);
    getCategories();
    newJoke();
}

/**
 * Fetch Json data from the specified url, 
 * verbose output to console for educational purposes
 * 
 * @param {URL} url 
 * @param {Object} params 
 * @returns Json data
 */
async function fetchStuff(url, params=undefined) {
    console.log(`fetchStuff(${url}, ${params})`);
    if (typeof params === 'object') {
         for (let k in params) {
            url.searchParams.append(k, params[k]);
        }
    }
    console.log(url);
    const response = await fetch(url);
    console.log(response);
    const jsonData = await response.json();
    console.log(jsonData);
    return jsonData;
}

/**
 * Make category select menu with values from api
 */
async function getCategories() {
    console.log('getCategories()');
    const categorySelect = document.querySelector("#category");
    const url = new URL(DB_API_URL_CAT);
    const categories = await fetchStuff(url);
    categories.forEach(category => {
        let opt = document.createElement("option");
        opt.innerHTML = category;
        categorySelect.appendChild(opt);
    });
}

/**
 * Fetch new joke and write to html
 */
 async function newJoke() {
    console.log('newJoke()');
    const url = new URL(DB_API_URL_JOKE);
    let params;
    if (document.querySelector("#category").value) {
        params = {
            'category': document.querySelector("#category").value
        };
    }
    const joke = await fetchStuff(url, params);
    document.querySelector("#randomJoke").innerHTML = joke.value.replace('\n', '<br>');
}
