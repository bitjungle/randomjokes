export default class JokeAPI {

    constructor(baseURL) {
        this.DB_API_URL_JOKE = `${baseURL}/randomjoke.php`;
        this.DB_API_URL_CAT = `${baseURL}/categories.php`;
    }

    /**
     * Fetch Json data from the specified url, 
     * verbose output to console for educational purposes
     * 
     * @param {URL} url 
     * @param {Object} params 
     * @returns Json data
     */
    async fetchStuff(url, params=undefined) {
        console.log(`JokeAPI.fetchStuff(${url}, ${params})`);
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
    async getCategories() {
        console.log('JokeAPI.getCategories()');
        const url = new URL(this.DB_API_URL_CAT);
        const categories = await this.fetchStuff(url);
        return categories;
    }

    /**
     * Fetch new joke and write to html
     */
    async getJoke() {
        console.log('JokeAPI.getJoke()');
        const url = new URL(this.DB_API_URL_JOKE);
        let params;
        if (document.querySelector("#category").value) {
            params = {
                'category': document.querySelector("#category").value
            };
        }
        const joke = await this.fetchStuff(url, params);
        return joke.value.replace('\n', '<br>');
    }
}