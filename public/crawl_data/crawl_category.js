function string_to_slug (str) {
    str = str.replace(/^\s+|\s+$/g, ''); // trim
    str = str.toLowerCase();

    // remove accents, swap ñ for n, etc
    var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
    var to   = "aaaaeeeeiiiioooouuuunc------";
    for (var i=0, l=from.length ; i<l ; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
        .replace(/\s+/g, '-') // collapse whitespace and replace by -
        .replace(/-+/g, '-'); // collapse dashes

    return str;
}

var ul = document.querySelector('.image-carousel__item-list');
var lis = ul.querySelectorAll('.image-carousel__item');
var arr = [];
[...lis].forEach(li => {
    let as = li.querySelectorAll('a');
    //console.log(as)
    as.forEach(a => {
        let href = /cat\.(\d+)/.exec(a.href);
        let image = a.querySelector('div > div > div > div');
        let name = a.innerText;
        let file = string_to_slug(name)+ ".json";
        //const obj = /url\("(https:\/\/.+)"\);/.exec(image);
        arr.push({
            match_id: href[1],
            name,
            file,
            image: image.style.backgroundImage
        })
    })
    /*
    as.querySelectorAll(a => {
        console.log(image)
    });*/
})

console.log(JSON.stringify(arr))


