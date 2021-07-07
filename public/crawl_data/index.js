const axios = require('axios')
const fs = require('fs')
let axiosInstance = axios.create({
    baseURL: 'https://shopee.vn/api',
    headers: {
        'authority': 'shopee.vn',
        'pragma': 'no-cache',
        'cache-control': 'no-cache',
        'sec-ch-ua': '" Not;A Brand";v="99", "Google Chrome";v="91", "Chromium";v="91"',
        'x-shopee-language': 'vi',
        'x-requested-with': 'XMLHttpRequest',
        'if-none-match-': '55b03-c6f8add7348a454520305be93d1d9d00',
        'sec-ch-ua-mobile': '?0',
        'user-agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
        'x-api-source': 'pc',
        'accept': '*/*',
        'sec-fetch-site': 'same-origin',
        'sec-fetch-mode': 'cors',
        'sec-fetch-dest': 'empty',
        'referer': 'https://shopee.vn/Qu%E1%BA%A7n-%C4%91%C3%B9i-qu%E1%BA%A7n-sooc-nam-th%E1%BB%83-thao-v%E1%BA%A3i-gi%C3%B3-m%E1%BB%81m-m%E1%BB%8Bn-i.169421857.7837824027',
        'accept-language': 'en-US,en;q=0.9,vi;q=0.8',
        'cookie': 'REC_T_ID=dcea7e4f-8f47-11eb-9df3-c4ff1ff42aa6; SPC_F=lqEwEMMdTl7ObPaEtHlYj2WwdoKCO2Zc; G_ENABLED_IDPS=google; SPC_CLIENTID=bHFFd0VNTWRUbDdPsfdahlhlmkpvhygy; next-i18next=en; csrftoken=MlfizIu0NM07ksQYQWP5RPkoTjKn77Xd; SC_DFP=j8FbgfTb27uGNFzFbVyH60uijWmhdaHe; SPC_U=44824483; SPC_EC=yEL8EqX7JvpZdm2fLt83bgEIC8ezWfFYFDEnjK6E6s5FcJ9Be8If23hAESsjX4MAkusJjqoM08Q3lKXYYMSlZqnoBq0Ci1nV3ESV3qULYNxQYe8aPu52sRUfmIrdRSXOBdP9bN1rN9Y0Xje69UO/zw==; _gcl_au=1.1.289362740.1624853289; SPC_SI=bfftocsg6.YuoXr3n7awAEVIYO0yo1x0yJL33BC1eW; SPC_SSN=o; SPC_WSS=o; SPC_PC_HYBRID_ID=57; SPC_IA=1; welcomePkgShown=true; SPC_R_T_ID="YdtBfP8oR9BQ4+CRu3G851CdhY22um/hWa3VMm4Umo3aQCNhgIGb8BAlCzEacd/Ywq08OiPhM5NrTtn9UoPkY5FZ8QyiJls9UrUj45k88H4="; SPC_T_IV="5gYrvifxfAvxUbua60/AiA=="; SPC_R_T_IV="5gYrvifxfAvxUbua60/AiA=="; SPC_T_ID="YdtBfP8oR9BQ4+CRu3G851CdhY22um/hWa3VMm4Umo3aQCNhgIGb8BAlCzEacd/Ywq08OiPhM5NrTtn9UoPkY5FZ8QyiJls9UrUj45k88H4="; SPC_R_T_ID="EkI5t2gSE4XAmwiaziUgPKDqBbQNa55vjk9mzcP83amf7uILacVxmg0Jw+NPoQ2b7B3hK2VtqklRrXhn24W1YarVsD7ThIK5gaddZa8NOQg="; SPC_R_T_IV="MIuYZgK2n2Ly7tkPIOkTYw=="; SPC_SI=bfftocsg6.YuoXr3n7awAEVIYO0yo1x0yJL33BC1eW; SPC_T_ID="EkI5t2gSE4XAmwiaziUgPKDqBbQNa55vjk9mzcP83amf7uILacVxmg0Jw+NPoQ2b7B3hK2VtqklRrXhn24W1YarVsD7ThIK5gaddZa8NOQg="; SPC_T_IV="MIuYZgK2n2Ly7tkPIOkTYw=="'
    }
});

const API = {
    get(url) {
        return axiosInstance.get(url).then(({data}) => {
            return data;
        }).catch(err => {
            console.log("err" + err)
        });
    }
}

async function getRating(type = 0, limit = 59, shop_id = 112548649, item_id = 1973236465) {

    try {
        let data = await API.get(`/v2/item/get_ratings?filter=0&flag=1&itemid=${item_id}&limit=${limit}&offset=0&shopid=${shop_id}&type=${type}`);
        const {data: {ratings}} = data;
        return ratings.map(({rating_star, comment}) => {
            return {rating_star, comment};
        })
    } catch (e) {
        throw e;
    }
}

async function getBrands(match_id, limit = 3) {
    if ([11035567].includes(match_id)) {
        limit = 5;
    }

    try {
        let data = await API.get(`/v4/search/search_facet?match_id=${match_id}&page_type=search`);
        const {brands} = data;
        return brands.map((brand) => {
            return brand.name;
        }).slice(0, limit);
    } catch (e) {
        throw e;
    }
}

async function getList(match_id) {

    try {
        let data = await API.get(`/v4/search/search_items?by=relevancy&limit=60&match_id=${match_id}&newest=120&order=desc&page_type=search&scenario=PAGE_OTHERS&version=2`);
        const {items} = data;
        return items.map(({item_basic}) => {
            const {itemid, shopid, name, images, price_max, price_max_before_discount} = item_basic;
            return {
                itemid,
                shopid,
                name,
                images,
                price_max: price_max / 100000,
                price_max_before_discount: price_max_before_discount / 100000
            };
        })
    } catch (e) {
        throw e;
    }
}

async function getDetailProduct(item = {}) {
    //console.log(p)
    const {itemid, shopid, price_max_before_discount, price_max, images, name} = item;
    try {
        let data = await API.get(`/v2/item/get?itemid=${itemid}&shopid=${shopid}`);
        // console.log(data);
        const {item: {description}} = data;
        return {name, images, description, price_min: price_max, price_max_before_discount};
    } catch (e) {
        throw e;
    }
}


function shuffle(array) {
    var currentIndex = array.length, randomIndex;

    // While there remain elements to shuffle...
    while (0 !== currentIndex) {

        // Pick a remaining element...
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex--;

        // And swap it with the current element.
        [array[currentIndex], array[randomIndex]] = [
            array[randomIndex], array[currentIndex]];
    }

    return array;
}


async function logRatings() {
    let ratings = [];
    for (let i = 1; i <= 5; i++) {
        let limit = 20;
        if (i === 5) limit = 59;
        let temp_ratings = await getRating(i, limit);
        ratings = ratings.concat(temp_ratings);
    }
    fs.writeFileSync('data/ratings.json', JSON.stringify(shuffle(ratings)), {flag: 'w+'});
    console.log('done ratings');
}

async function run() {
    const rawData = fs.readFileSync('categories.json')
    const categories = JSON.parse(rawData);
    let brands = [];
    for (let category of categories) {
        const {file, match_id} = category;
        let arr = [];
        //let listProducts = await getList(match_id);
        let tempBrands = [];
        if (![11035639].includes(match_id)) {
            tempBrands = await getBrands(match_id);
        }

        //console.log(tempBrands);
        brands = brands.concat(tempBrands);
        /*for (let p of listProducts) {
            try {
                let detail = await getDetailProduct(p);
                arr.push(detail)
            } catch (e) {
                console.log(e)
            }
        }
        fs.writeFile('data/' + file, JSON.stringify(arr), function (err) {
            if (err) return console.log(err);
            console.log('Done' + file);
        });*/


    }
    fs.writeFileSync('data/brands.json', JSON.stringify(brands), {flag: 'w+'});
    console.log('done brands');
}

//run()

logRatings();