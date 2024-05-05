// query selector
function qSelect(item) {
    return document.querySelector(item);
}
// query selector all
function qSelectAll(item) {
    return document.querySelectorAll(item);
}
function gID(item) {
    return document.getElementById(item);
}
// console log
function log(...itens) {
    // console.log(itens.join(' '));
    for (let item of itens) {
        console.log(item);
    }
}

export { qSelect, qSelectAll, gID, log };