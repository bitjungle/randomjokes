export default class JokeAPI {

    constructor(baseURL) {
        this.DB_API_URL_JOKE = new URL(`${baseURL}/randomjoke.php`);
        this.DB_API_URL_JOKE_ID = new URL(`${baseURL}/getjoke.php`);
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
        //console.log(params);
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
    async getJoke(id = 0) {
        console.log('JokeAPI.getJoke()');
        let params = {};
        if (id > 0) {
            params.id = id;
            return await this.fetchStuff(this.DB_API_URL_JOKE_ID, params);
        } else {
            if (document.querySelector("#category").value) {
                params.category = document.querySelector("#category").value;
            }
            return await this.fetchStuff(this.DB_API_URL_JOKE, params);
        }
    }

    /**
     * Write joke to database
     * 
     * @param {FormData}
     * @returns string
     */
     async writeJoke(formData) {
        console.log('JokeAPI.writeJoke()');
        console.log(formData);
        const response = await fetch(this.DB_API_URL_POST, { method: "POST", body: formData });
        const jsonData = await response.json();
        console.log(jsonData);
        return jsonData;
    }
}