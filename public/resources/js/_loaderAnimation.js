// on load spinner
//------------- Loading animation start ---------- //
(() => {
  let loader, hero, header, footer, nav, main, items;
  loader = document.querySelector("#loader");
  if (!loader) return;

  hero = document.querySelector("#hero");
  header = document.querySelector("#topNav");
  footer = document.querySelector("footer");
  nav = document.querySelector("nav");
  main = document.querySelector("main");
  items = [hero, header, footer, nav, main];

  document.onreadystatechange = function () {

    const pageLoading = document.readyState !== "complete";

    if (pageLoading) {
      for (let item of items) {
        if (item == null) {
          continue;
        }
        item.style = "opacity:0;visibility:none;";
      }
      loader.style = "visibility:visible;display:block;opacity:1;z-index:999999999999;position:absolute";
    } 
    
    if (!pageLoading) {

      for (let item of items) {
        if (item == null) {
          continue;
        }
        
        item.style = "opacity:1;visibility:visible;";
      }

      loader.style.display = "none";
    }
  }

})();