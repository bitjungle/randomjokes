export default class JokeAPI {

    constructor(baseURL) {
        this.DB_API_URL_JOKE = new URL(`${baseURL}/randomjoke.php`);
        this.DB_API_URL_CAT = new URL(`${baseURL}/categories.php`);
        this.DB_API_URL_POST = new URL(`${baseURL}/postjoke.php`);
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
     * Get all joke categories from database
     */
    async getCategories() {
        console.log('JokeAPI.getCategories()');
        const categories = await this.fetchStuff(this.DB_API_URL_CAT);
        return categories;
    }

    /**
     * Fetch new joke
     * 
     * @returns string
     */
    async getJoke() {
        console.log('JokeAPI.getJoke()');
        let params;
        if (document.querySelector("#category").value) {
            params = {
                'category': document.querySelector("#category").value
            };
        }
        const joke = await this.fetchStuff(this.DB_API_URL_JOKE, params);
        return joke.value.replace('\n', '<br>');
    }

    /**
     * Write joke to database
     * 
     * @param {FormData}
     * @returns string
     */
     async writeJoke(formData) {
        console.log('JokeAPI.writeJoke()');
        const response = await fetch(this.DB_API_URL_POST, { method: "POST", body: formData });
        return response;
    }
}