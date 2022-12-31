const abbbb = () => {
    let a = 1
}
const doAjax = (method, url, data, callback) => {
    var xhr = new XMLHttpRequest();
    // method, file, async
    xhr.onreadystatechange = function() {
        callback(this, xhr)
    };
    xhr.open(method, url, true);
    xhr.send(data);
}